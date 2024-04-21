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
    $products = explode(',', $_POST['products']);
    $values = array();
    $values[] = $_POST['clients'];
    //$values[] = ""; // employee id incase not admin
    $values[] = $_POST['amount_paid'];
    $values[] = ""; //total amount
    $values[] = $_POST['discount_amount'];
    $values[] = ""; // amount after discount
    $accid = $_SESSION['user']['accid'];
    $connection = connectDB();
    // check if product related to current account
    $stmt = $connection->prepare("select * from clients where id = ? and accid = ?");
    $stmt->bind_param("si", $_POST['clients'], $_SESSION['user']['accid']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        echo returnJsonObject(0, "Error in clients data");
        close_connection($connection, $stmt);
    }
    $stmt = $connection->prepare("insert into sales (clientid, amount_paid, total_amount, discount_amount, amount_after_discount) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("idddd", ...$values);
    $connection->autocommit(FALSE);



    try {
        $connection->begin_transaction();
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $saleid = $connection->insert_id;
            for ($i = 0; $i < count($products); $i++) {
                $batchid = $products[$i][0];
                $count = $products[$i][1];
                $stmt_details = $connection->prepare("insert into sales_details (saleid, batchid, count) VALUES (?, ?, ?)");
                $stmt_details->bind_param("iii", $saleid, $batchid, $count);
                // Execute the statement
                $stmt_details->execute();

                // Check if the insertion was successful
                if ($stmt_details->affected_rows <= 0) {
                    throw new Exception("Error: Unable to insert sales details.");
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