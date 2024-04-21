<?php
if (isset($_GET['dropdown'])) {
    $sessionChecker = sessionChecker();
    if(!$sessionChecker)
    {
        echo returnJsonObject(-1, "Session Expired"); 
        die;
    }
    $connection = connectDB();
    $stmt = $connection->prepare("select id, name from clients where accid = ?");
    $stmt->bind_param("i", $_SESSION['user']['accid']);
    $stmt->execute();
    $result = $stmt->get_result();
    $res = $result->fetch_all(MYSQLI_ASSOC);
    echo returnJsonObject(1, $res);
    close_connection($connection, $stmt);
}
?>