<?php
session_start();
function sessionChecker()
{
    return isset($_SESSION['user']);

}
function connectDB(){
    try{
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