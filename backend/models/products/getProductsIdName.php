<?php
if (isset($_GET['productsIdName'])) {
    $sessionChecker = sessionChecker();
    if(!$sessionChecker)
    {
        echo returnJsonObject(-1, "Session Expired"); 
        die;
    }
    $connection = connectDB();
    $stmt = $connection->prepare("select products.id, products.name, products_batch.name as `batchname` from products, products_batch where 
    products.id = products_batch.prodid and products.accid = ? group by products.id");
    $stmt->bind_param("i", $_SESSION['user']['accid']);
    $stmt->execute();
    $result = $stmt->get_result();
    $res = $result->fetch_all(MYSQLI_ASSOC);
    echo returnJsonObject(1, $res);
    close_connection($connection, $stmt);
}
?>