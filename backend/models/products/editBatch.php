<?php
if(isset($_POST['datakey']) && $_POST['datakey'] == "edit-batch" && isset($_POST['data-id']))
{
    $sessionChecker = sessionChecker();
    if(!$sessionChecker)
    {
        echo returnJsonObject(-1, "Session Expired"); 
        die;
    }
    $validations = array(
        isRequired($_POST['name']),
        positiveInteger($_POST['count']),
        positiveNumber($_POST['price']),
    );
    $valid = executeValidationFunctions($validations);
    if($valid['status'] === -1)
    {
        echo returnJsonObject($valid['status'], $valid);
        die;
    }
    unset($_POST["datakey"]);
    $values = array_values($_POST);
    $connection = connectDB();
    $stmt = $connection->prepare("select * from products, products_batch where products_batch.id = ? and accid = ? and products.id = products_batch.prodid");
    $stmt->bind_param("si", $_POST['data-id'], $_SESSION['user']['accid']);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows === 0){
        echo returnJsonObject(0, "Error in product data");
        close_connection($connection, $stmt);
    }
    $stmt = $connection->prepare("update products_batch set name = ?, count = ?, price = ?, expiry_date = ? where id = ?");
    $stmt->bind_param("sidsi", ...$values);
    $connection->autocommit(FALSE);
    try{
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $connection->commit();
            echo returnJsonObject(1, "Product Batch Updated");
        } else {
            $connection->rollback();
            echo returnJsonObject(0, "Nothing To Update");
        }
    close_connection($connection, $stmt);
    }
    catch(Exception $e)
    {
        echo returnJsonObject(0, "Batch name already exists");
        close_connection($connection, $stmt);
    }
}

if(isset($_GET['action-edit-batch']) && isset($_GET['id']))
{
    $sessionChecker = sessionChecker();
    if(!$sessionChecker)
    {
        echo returnJsonObject(-1, "Session Expired"); 
        die;
    }
    $id = $_GET['id'];
    $connection = connectDB();
    $stmt = $connection->prepare("select products_batch.* from products, products_batch where prodid = ? and accid = ? and products.id = prodid");
    $stmt->bind_param("ii", $id, $_SESSION['user']['accid']);
    $stmt->execute();
    $result = $stmt->get_result();
    $res = $result->fetch_all(MYSQLI_ASSOC);
    echo returnJsonObject(1, $res);
    close_connection($connection, $stmt);
}
?>