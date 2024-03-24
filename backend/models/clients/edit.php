<?php
if(isset($_POST['datakey']) && $_POST['datakey'] == "edit-client" && isset($_POST['data-id']))
{
    $sessionChecker = sessionChecker();
    if(!$sessionChecker)
    {
        echo returnJsonObject(-1, "Session Expired"); 
        die;
    }
    $validations = array(
        isRequired($_POST['name'])
    );
    $valid = executeValidationFunctions($validations);
    if($valid['status'] === -1)
    {
        echo returnJsonObject($valid['status'], $valid);
        die;
    }
    unset($_POST["datakey"]);
    $values = array_values($_POST);
    $values[] = $_SESSION['user']['accid'];
    $connection = connectDB();
    $stmt = $connection->prepare("update clients set name = ?, phone = ?, location = ? where id = ? and accid = ?");
    $stmt->bind_param("sssii", ...$values);
    $connection->autocommit(FALSE);
    try{
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $connection->commit();
            echo returnJsonObject(1, "Client Updated");
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

if(isset($_GET['action-edit']) && isset($_GET['id']))
{
    $sessionChecker = sessionChecker();
    if(!$sessionChecker)
    {
        echo returnJsonObject(-1, "Session Expired"); 
        die;
    }
    $id = $_GET['id'];
    $connection = connectDB();
    $stmt = $connection->prepare("select * from clients where id = ? and accid = ?");
    $stmt->bind_param("ii", $id, $_SESSION['user']['accid']);
    $stmt->execute();
    $result = $stmt->get_result();
    $res = $result->fetch_all(MYSQLI_ASSOC);
    echo returnJsonObject(1, $res);
    close_connection($connection, $stmt);
}
?>