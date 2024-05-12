<?php
if (isset($_POST['datakey']) && $_POST['datakey'] == "add-sales") {
    $sessionChecker = sessionChecker();
    if (!$sessionChecker) {
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
    $connection = connectDB();
    $products = explode(',', $_POST['products']);
    $totalAmount = 0;
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
        $pname = $res[0]["pname"];
        $batchname = $res[0]["name"];
        $batchcount = $res[0]["count"];
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
    $columns = isAdmin() ? 'clientid, accid, amount_paid, total_amount, discount_amount, amount_after_discount' : 'clientid, accid, employeeid, amount_paid, total_amount, discount_amount, amount_after_discount';
    $types = isAdmin() ? 'iidddd' : 'iiidddd';
    $toFill = "?, ?, ?, ?, ?, ?";
    $values = array();
    $values[] = $_POST['clients'];
    $values[] = $accid;
    if(!isAdmin())
    {
        $values[] = $_SESSION['user']['id'];

    }
    $values[] = $amountPaid;
    $values[] = $totalAmount;
    $values[] = $_POST['discount_amount'];
    $values[] = $totalAmountAfterDiscount;
    // check if product related to current account
    $stmt = $connection->prepare("select * from clients where id = ? and accid = ?");
    $stmt->bind_param("si", $_POST['clients'], $_SESSION['user']['accid']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        echo returnJsonObject(0, "Error in clients data");
        close_connection($connection, $stmt);
    }

    $stmt = $connection->prepare("insert into sales ($columns) VALUES ($toFill)");
    $stmt->bind_param("$types", ...$values);
    $connection->autocommit(FALSE);



    try {
        $connection->begin_transaction();
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $saleid = $connection->insert_id;
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
            echo returnJsonObject(1, "Sales Added");
        } else {
            $connection->rollback();
            echo returnJsonObject(0, "Error: " . $connection->error);
        }
        close_connection($connection, $stmt);
    } catch (Exception $e) {
        echo returnJsonObject(-1, "Error: " . $e);
        close_connection($connection, $stmt);
    }
}
?>