<?php
if(isset($_POST['datakey']) && $_POST['datakey'] == "add-client")
{
    $sessionChecker = sessionChecker();
    if(!$sessionChecker)
    {
        echo returnJsonObject(-1, "Session Expired"); 
        die;
    }
    $validations = array(
        isRequired($_POST['name'])
    );
    $valid = executeValidationFunctions($validations);
    if($valid['status'] === -1)
    {
        echo returnJsonObject($valid['status'], $valid);
        die;
    }
    unset($_POST["datakey"]);
    $values = array_values($_POST);
    $values[] = $_SESSION['user']['accid'];
    $connection = connectDB();
    $stmt = $connection->prepare("insert into clients (name, phone, location, accid) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", ...$values);
    $connection->autocommit(FALSE);
    try{
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $connection->commit();
            echo returnJsonObject(1, "Client Added");
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