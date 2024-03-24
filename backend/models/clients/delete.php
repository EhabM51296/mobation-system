<?php
if(isset($_POST['action-delete']) && isset($_POST['id']))
{
    $sessionChecker = sessionChecker();
    if(!$sessionChecker)
    {
        echo returnJsonObject(-1, "Session Expired"); 
        die;
    }
    $id = $_POST['id'];
    $connection = connectDB();
    $stmt = $connection->prepare("delete from clients where id = ? and accid = ?");
    $stmt->bind_param("ii", $id, $_SESSION['user']['accid']);
    if ($stmt->execute()) {
        echo returnJsonObject(1, "Record deleted successfully");
    } else {
        echo returnJsonObject(0, "Failed to delete record");
    }
    close_connection($connection, $stmt);
}
?>