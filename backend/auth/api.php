<?php
require "./auth.php";
require "../validation/validation.php";
if(isset($_POST['email']) && isset($_POST['password']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    $validationArr = array(isValidEmail($email));

    $validRes = executeValidationFunctions($validationArr);

    if($validRes['status'] == -1)
        return $validRes;
    $res = login($email, $password);
    if($res)
        return returnJsonObject(1, $res);
    else
        return returnJsonObject(0, 'Invalid Credentials');
}
?>