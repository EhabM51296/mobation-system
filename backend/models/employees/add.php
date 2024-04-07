<?php
if(isset($_POST['datakey']) && $_POST['datakey'] == "add-employee")
{
    $sessionChecker = sessionChecker();
    if(!$sessionChecker)
    {
        echo returnJsonObject(-1, "Session Expired"); 
        die;
    }
    $validations = array(
        isRequired($_POST['name']),
        isValidPassword($_POST['password']),
    );
    $valid = executeValidationFunctions($validations);
    if($valid['status'] === -1)
    {
        echo returnJsonObject($valid['status'], $valid);
        die;
    }
    unset($_POST["datakey"]);
    $values = array_values($_POST);
    $token = random_bytes(32);
    $values[] = bin2hex($token);
    $values[] = $_SESSION['user']['accid'];
    $connection = connectDB();
    $stmt = $connection->prepare("insert into employees (name, password, token_key, accid) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", ...$values);
    $connection->autocommit(FALSE);
    try{
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $connection->commit();
            echo returnJsonObject(1, "Employee Added");
        } else {
            $connection->rollback();
            echo returnJsonObject(0, "Error: " . $connection->error);
        }
    close_connection($connection, $stmt);
    }
    catch(Exception $e)
    {
        echo returnJsonObject(0, "Employee already exists, choose a different name");
        close_connection($connection, $stmt);
    }
}
?>