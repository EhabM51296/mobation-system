<?php
if (isset($_POST['datakey']) && $_POST['datakey'] == "add-employee") {
    $sessionChecker = sessionChecker();
    if (!$sessionChecker) {
        echo returnJsonObject(-1, "Session Expired");
        die;
    }
    $validations = array(
        isRequired($_POST['name']),
        isValidPassword($_POST['password']),
        positiveNumber($_POST['salary']),
    );
    $valid = executeValidationFunctions($validations);
    if ($valid['status'] === -1) {
        echo returnJsonObject($valid['status'], $valid);
        die;
    }
    unset($_POST["datakey"]);
    unset($_POST["picture"]);
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
    
    $token = random_bytes(32);
    $values[] = bin2hex($token);
    $values[] = $_SESSION['user']['accid'];
    $connection = connectDB();
    if($uploaded === true)
    {
        $stmt = $connection->prepare("insert into employees (name, password, dob, location, salary, picture, token_key, accid) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssdssi", ...$values);
    }
    else{
        $stmt = $connection->prepare("insert into employees (name, password, dob, location, salary, token_key, accid) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssdsi", ...$values);
    }
    
    $connection->autocommit(FALSE);
    try {
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $connection->commit();
            echo returnJsonObject(1, "Employee Added");
        } else {
            $connection->rollback();
            echo returnJsonObject(0, "Error: " . $connection->error);
        }
        close_connection($connection, $stmt);
    } catch (Exception $e) {
        echo returnJsonObject(0, "Employee already exists, choose a different name");
        close_connection($connection, $stmt);
    }
}
?>