<?php
session_start();
require "functions.php";
function sessionChecker()
{
    return isset($_SESSION['user']);

}
function connectDB(){
$pass = 'ah%&8.--RU$'."n";
    try{
        // $connection = mysqli_connect('localhost', 'mobatxik_generaluser', $pass, 'mobatxik_system');
        $connection = mysqli_connect("localhost","root","","mobation_system");
        return $connection;
      }
      catch(Exception $e){
          die("failed to connect to Database");
  
      }
}

function close_connection($connection, $stmt, $stop = true){
    mysqli_close($connection);
    $stmt->close();
    if($stop)
        die;
}
?>