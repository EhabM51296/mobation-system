<?php
require("../../connect.php");
require("../../validation/validation.php");
if(isset($_POST['datakey']) && $_POST['datakey'] == "edit-profile")
{
    $sessionChecker = sessionChecker();
    if(!$sessionChecker)
    {
        echo returnJsonObject(-1, "Session Expired"); 
        die;
    }
    $validations = array(
        isRequired($_POST['name']),
        isRequired($_POST['email']),
        isValidEmail($_POST['email']),
    );
    $valid = executeValidationFunctions($validations);
    if($valid['status'] === -1)
    {
        echo returnJsonObject($valid['status'], $valid);
        die;
    }
    unset($_POST["datakey"]);
    $values = array_values($_POST);
    $values[] = $_SESSION['user']['id'];
    $connection = connectDB();
    // check if email exists
    $stmt = $connection->prepare("select * from accounts where email = ? and id != ?");
    $stmt->bind_param("si", $_POST['email'], $_SESSION['user']['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
        echo returnJsonObject(0, "Email Already Exists");
        close_connection($connection, $stmt);
    }
    // Email dont exists
    $stmt = $connection->prepare("update accounts set name = ?, email = ? where id = ?");
    $stmt->bind_param("ssi", ...$values);
    $connection->autocommit(FALSE);
    try{
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $connection->commit();
            echo returnJsonObject(10, $values);
        } else {
            $connection->rollback();
            echo returnJsonObject(0, "Nothing To Update");
        }
    close_connection($connection, $stmt);
    }
    catch(Exception $e)
    {
        echo returnJsonObject(-1, "Error: " . $e);
        close_connection($connection, $stmt);
    }
}
// Change Password
if(isset($_POST['datakey']) && $_POST['datakey'] == "change-password")
{
    $sessionChecker = sessionChecker();
    if(!$sessionChecker)
    {
        echo returnJsonObject(-1, "Session Expired"); 
        die;
    }
    $validations = array(
        isRequiredAllowSpaces($_POST['currentPassword']),
        isValidPassword($_POST['newPassword']),
    );
    $valid = executeValidationFunctions($validations);
    if($valid['status'] === -1)
    {
        echo returnJsonObject($valid['status'], $valid);
        die;
    }
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];

    $connection = connectDB();
    // check if email exists
    $stmt = $connection->prepare("select password from accounts where id = ?");
    $stmt->bind_param("i", $_SESSION['user']['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $hashedPasswordFromDatabase = $row['password'];
    if(!password_verify($currentPassword, $hashedPasswordFromDatabase)){
        echo returnJsonObject(0, "Please write the correct old password");
        close_connection($connection, $stmt);
    }
    $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    // Email dont exists
    $stmt = $connection->prepare("update accounts set password = ? where id = ?");
    $stmt->bind_param("si", $newHashedPassword, $_SESSION['user']['id']);
    $connection->autocommit(FALSE);
    try{
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $connection->commit();
            echo returnJsonObject(1, "Password Updated Successfully");
        } else {
            $connection->rollback();
            echo returnJsonObject(0, "Nothing To Update");
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