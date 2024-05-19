<?php
if(isset($_POST['datakey']) && $_POST['datakey'] == "edit-employee" && isset($_POST['data-id']))
{
    $sessionChecker = sessionChecker();
    if(!$sessionChecker)
    {
        echo returnJsonObject(-1, "Session Expired"); 
        die;
    }
    $validations = array(
        isRequired($_POST['name']),
        isValidPassword($_POST['password']),
        positiveNumber($_POST['salary']),
    );
    $valid = executeValidationFunctions($validations);
    if($valid['status'] === -1)
    {
        echo returnJsonObject($valid['status'], $valid);
        die;
    }
    unset($_POST["datakey"]);
    unset($_POST["picture"]);
    $editId = $_POST['data-id'];
    unset($_POST["data-id"]);
    $values = array_values($_POST);
    $uploaded = false;
    // Handle file upload
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['picture']['tmp_name'];
        $fileName = $_FILES['picture']['name'];
        $fileSize = $_FILES['picture']['size'];
        $fileType = $_FILES['picture']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $uploadFileDir = '../../../assets/images/';
        $dest_path = $uploadFileDir . $newFileName;
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $uploaded = true;
            $values[] = $newFileName;
        }
    }
    $values[] = $editId;
    $values[] = $_SESSION['user']['accid'];
    $connection = connectDB();
    if($uploaded === true)
    {
        $stmt = $connection->prepare("update employees set name = ?, password = ?, dob = ?, location = ?, salary = ?, picture = ? where id = ? and accid = ?");
        $stmt->bind_param("ssssdsii", ...$values);
    }
    else{
        $stmt = $connection->prepare("update employees set name = ?, password = ?, dob = ?, location = ?, salary = ? where id = ? and accid = ?");
        $stmt->bind_param("ssssdii", ...$values);
    }
    
    $connection->autocommit(FALSE);
    try{
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $connection->commit();
            echo returnJsonObject(1, "Employee Updated");
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
    $stmt = $connection->prepare("select * from employees where id = ? and accid = ?");
    $stmt->bind_param("ii", $id, $_SESSION['user']['accid']);
    $stmt->execute();
    $result = $stmt->get_result();
    $res = $result->fetch_all(MYSQLI_ASSOC);
    echo returnJsonObject(1, $res);
    close_connection($connection, $stmt);
}
?>