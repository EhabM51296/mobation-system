<?php
if(isset($_POST['datakey']) && $_POST['datakey'] == "add-batch")
{
    $sessionChecker = sessionChecker();
    if(!$sessionChecker)
    {
        echo returnJsonObject(-1, "Session Expired"); 
        die;
    }
    $validations = array(
        isRequired($_POST['name']),
        positiveInteger($_POST['count']),

    );
    $valid = executeValidationFunctions($validations);
    if($valid['status'] === -1)
    {
        echo returnJsonObject($valid['status'], $valid);
        die;
    }
    unset($_POST["datakey"]);
    $values = array_values($_POST);
    $accid = $_SESSION['user']['accid'];
    $connection = connectDB();
    // check if product related to current account
    $stmt = $connection->prepare("select * from products where id = ? and accid = ?");
    $stmt->bind_param("si", $_POST['prodid'], $_SESSION['user']['accid']);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows === 0){
        echo returnJsonObject(0, "Error in product data");
        close_connection($connection, $stmt);
    }
    $stmt = $connection->prepare("insert into products_batch (name, count, expiry_date, prodid) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sisi", ...$values);
    $connection->autocommit(FALSE);
    try{
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $connection->commit();
            echo returnJsonObject(1, "Product Batch Added");
        } else {
            $connection->rollback();
            echo returnJsonObject(0, "Error: " . $connection->error);
        }
    close_connection($connection, $stmt);
    }
    catch(Exception $e)
    {
        echo returnJsonObject(-1, "Error: " . $e);
        close_connection($connection, $stmt);
    }
}
?>