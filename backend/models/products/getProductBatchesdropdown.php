<?php
if (isset($_GET['batchdropdown'])) {
    $sessionChecker = sessionChecker();
    if(!$sessionChecker)
    {
        echo returnJsonObject(-1, "Session Expired"); 
        die;
    }
    $id = $_GET['batchdropdown'];
    $connection = connectDB();
    $stmt = $connection->prepare("select id, CONCAT('batch name: ', name, ', available: ', count, ', price: ', price) AS name,
    CONCAT('count:', count, '_price:', price) AS neededValues
    from products_batch where prodid = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $res = $result->fetch_all(MYSQLI_ASSOC);
    echo returnJsonObject(1, $res);
    close_connection($connection, $stmt);
}
?>