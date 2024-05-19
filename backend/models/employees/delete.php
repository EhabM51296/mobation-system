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
    $stmt = $connection->prepare("select picture from employees where id = ? and accid = ?");
    $stmt->bind_param("ii", $id, $_SESSION['user']['accid']);
    $stmt->execute();
    $result = $stmt->get_result();
    $dataToDelete = $result->fetch_all(MYSQLI_ASSOC);
    $fileSrc = "../../../assets/images/" . $dataToDelete[0]['picture'];
    if ($dataToDelete[0]['picture'] && file_exists($fileSrc)) 
        unlink($fileSrc); 
    $stmt = $connection->prepare("delete from employees where id = ? and accid = ?");
    $stmt->bind_param("ii", $id, $_SESSION['user']['accid']);
    if ($stmt->execute()) {
        echo returnJsonObject(1, "Record deleted successfully");
    } else {
        echo returnJsonObject(0, "Failed to delete record");
    }
    close_connection($connection, $stmt);
}
?>