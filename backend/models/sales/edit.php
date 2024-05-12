<?php
if(isset($_POST['datakey']) && $_POST['datakey'] == "edit-sales" && isset($_POST['data-id']))
{
    $sessionChecker = sessionChecker();
    if(!$sessionChecker)
    {
        echo returnJsonObject(-1, "Session Expired"); 
        die;
    }
    $validations = array(
        isRequired($_POST['clients']),
        positiveNumber($_POST['amount_paid']),
        positiveNumberNotRequired($_POST['discount_amount']),
        isRequired($_POST['products']),
    );
    $valid = executeValidationFunctions($validations);
    if ($valid['status'] === -1) {

        echo returnJsonObject($valid['status'], $valid);
        die;
    }
    $saleid = $_POST['data-id'];
    $products = explode(',', $_POST['products']);
    $totalAmount = 0;
    $connection = connectDB();
    // calculate invoice total amount
    for ($i = 0; $i < count($products); $i++) {
        $splitter = explode('_', $products[$i]);
        $batchid = $splitter[0];
        $count = $splitter[1];
        $stmt_details = $connection->prepare("select products_batch.*, products.name as `pname` from products_batch, products where products_batch.id = ? and products_batch.prodid = products.id and products.accid = ?");
        $stmt_details->bind_param("ii", $batchid, $_SESSION['user']['accid']);
        $stmt_details->execute();
        $result = $stmt_details->get_result();
        if ($result->num_rows === 0) {
            echo returnJsonObject(0, "Error in products batch data");
            close_connection($connection, $stmt_details);
        }
        $res = $result->fetch_all(MYSQLI_ASSOC);
        $bid = $res[0]['id'];
        $pname = $res[0]["pname"];
        $batchname = $res[0]["name"];
        $batchcount = $res[0]["count"];
        // old details
        $stmt_details = $connection->prepare("select * from sales_details where saleid = ? and batchid = ?");
        $stmt_details->bind_param("ii", $saleid, $batchid);
        $stmt_details->execute();
        $oldResult = $stmt_details->get_result();
        if ($oldResult->num_rows > 0) {
            $resold = $oldResult->fetch_all(MYSQLI_ASSOC);
            $oldCount = $resold[0]['count'];
            $batchcount = $batchcount + $oldCount; 
        }
        if($count > $batchcount)
        {
            echo returnJsonObject(0, "product: $pname of batch: $batchname have count: $batchcount");
            close_connection($connection, $stmt_details);
        }
        $totalAmount = $totalAmount + ($res[0]['price'] * (int) $count);
        // Check if the insertion was successful
    }
    $totalAmountAfterDiscount = $totalAmount - ($totalAmount * (float) $_POST['discount_amount'] / 100);
    $amountPaid = $_POST['amount_paid'];

    if($amountPaid > $totalAmountAfterDiscount)
    {
        echo returnJsonObject(0, "Amount paid $amountPaid is more than the amount of invoice $totalAmountAfterDiscount");
        close_connection($connection, $stmt_details);
    }

    // 
    $accid = $_SESSION['user']['accid'];
    $values = array();
    $clientId[] = $_POST['clients'];
    $discountAmount[] = $_POST['discount_amount'];
    // check if product related to current account
    $stmt = $connection->prepare("select * from clients where id = ? and accid = ?");
    $stmt->bind_param("si", $_POST['clients'], $_SESSION['user']['accid']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        echo returnJsonObject(0, "Error in clients data");
        close_connection($connection, $stmt);
    }

    $stmt = $connection->prepare("update sales SET 
    `clientid`= ? ,
    `amount_paid`= ?,
    `total_amount`= ?,
    `discount_amount`= ?,
    `amount_after_discount`= ? 
    where id = ?
    ");
    $stmt->bind_param("iddddi", $clientId, $amountPaid, $totalAmount, $discountAmount, $totalAmountAfterDiscount, $saleid);
    $connection->autocommit(FALSE);

    try {
        $connection->begin_transaction();
        $stmt->execute();

        if ($stmt->errno === 0) {
            
            // delete and return old data
            $stmt_details = $connection->prepare("select * from sales_details where saleid = ?");
            $stmt_details->bind_param("i", $saleid);
            $stmt_details->execute();
            $oldResult = $stmt_details->get_result();
            if ($oldResult->num_rows > 0) {
                $resold = $oldResult->fetch_all(MYSQLI_ASSOC);
                for($i = 0; $i < count($resold); $i++)
                {
                    $stmt_details = $connection->prepare("update products_batch set count = count + ? where id = ?");
                    $stmt_details->bind_param("ii", $resold[$i]['count'], $resold[$i]['batchid']);
                    $stmt_details->execute();
                }
                $stmt_details = $connection->prepare("delete from sales_details where saleid = ?");
                $stmt_details->bind_param("i", $saleid);
                $stmt_details->execute();
            }
            // insert the new data
            for ($i = 0; $i < count($products); $i++) {
                $splitter = explode('_', $products[$i]);
                $batchid = $splitter[0];
                $count = $splitter[1];
                $stmt_details = $connection->prepare("insert into sales_details (saleid, batchid, count) VALUES (?, ?, ?)");
                $stmt_details->bind_param("iii", $saleid, $batchid, $count);
                // Execute the statement
                $stmt_details->execute();

                // Check if the insertion was successful
                if ($stmt_details->affected_rows <= 0) {
                    throw new Exception("Error: Unable to insert sales details error: 1001.");
                }

                $stmt_update = $connection->prepare("update products_batch set count = count - ? where id = ?");
                $stmt_update->bind_param("ii", $count, $batchid);
                // Execute the statement
                $stmt_update->execute();

                // Check if the update was successful
                if ($stmt_update->affected_rows <= 0) {
                    throw new Exception("Error: Unable to insert sales details error: 1002.");
                }
            }
            $connection->commit();
            echo returnJsonObject(1, "Sale Updated");
        } else {
            $connection->rollback();
            echo returnJsonObject(0, "Error: " . $connection->error . " -11");
        }
        close_connection($connection, $stmt);
    } catch (Exception $e) {
        echo returnJsonObject(-1, "Error: " . $e);
        close_connection($connection, $stmt);
    }

}

if (isset($_GET['action-edit']) && isset($_GET['id'])) {
    $sessionChecker = sessionChecker();
    if (!$sessionChecker) {
        echo returnJsonObject(-1, "Session Expired");
        die;
    }
    $id = $_GET['id'];
    $connection = connectDB();
    // 1
    $stmt1 = $connection->prepare("
        SELECT 
            sales.id AS `sid`, 
            clients.name AS 'clientName', 
            sales.clientid, 
            amount_paid, 
            discount_amount, 
            total_amount, 
            amount_after_discount
        FROM 
            sales, clients
        WHERE
            sales.clientid = clients.id 
            AND sales.id = ? 
            AND sales.accid = ?
    ");
    $stmt1->bind_param("ii", $id, $_SESSION['user']['accid']);
    $stmt1->execute();
    $result = $stmt1->get_result();
    $res1 = $result->fetch_all(MYSQLI_ASSOC);

    // 2
    $stmt2 = $connection->prepare("
    SELECT 
        sales_details.batchid AS `batchid`, 
        sales_details.count AS `count`, 
        products.id AS `product_id`, 
        products.name AS `product_name`, 
        products_batch.price AS `price`, 
        products_batch.name AS `batchname`
    FROM 
        sales_details, products, products_batch
    WHERE
        sales_details.batchid = products_batch.id 
        AND products.id = products_batch.prodid
        AND sales_details.saleid = ?
");

    $stmt2->bind_param("i", $id);
    $stmt2->execute();
    $result = $stmt2->get_result();
    $res2 = $result->fetch_all(MYSQLI_ASSOC);
    $res = array(
        "saleInfo" => $res1, "productsDetails" => $res2
    );
    echo returnJsonObject(1, $res);
    mysqli_close($connection);
    $stmt1->close();
    $stmt2->close();
    die;
}
?>