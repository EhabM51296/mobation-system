<?php
if (isset($_POST['action-delete']) && isset($_POST['id'])) {
    $sessionChecker = sessionChecker();
    if (!$sessionChecker) {
        echo returnJsonObject(-1, "Session Expired");
        die;
    }
    $id = $_POST['id'];
    $connection = connectDB();
    try {
        $connection->begin_transaction();

        $stmt_details = $connection->prepare("select sales_details.* from sales, sales_details where sales.id = sales_details.saleid and sales.id = ? and sales.accid = ?");
        $stmt_details->bind_param("ii", $id, $_SESSION['user']['accid']);
        $stmt_details->execute();
        $result = $stmt_details->get_result();
        if ($result->num_rows === 0) {
            echo returnJsonObject(0, "sales details not found");
            close_connection($connection, $stmt_details);
        } else {
            $res = $result->fetch_all(MYSQLI_ASSOC);
            foreach ($res as $row) {
                $returnedCount = $row["count"];
                $returnToBatchId = $row["batchid"];
                $stmt = $connection->prepare("update products_batch set count = count + ? where id = ?");
                $stmt->bind_param("ii", $returnedCount, $returnToBatchId);
                $stmt->execute();
                // Check if update was successful
                if ($stmt->affected_rows !== 1) {
                    echo returnJsonObject(0, "Failed to update batch count");
                    close_connection($connection, $stmt_details);
                }
            }
            $stmt = $connection->prepare("delete from sales where id = ? and accid = ?");
            $stmt->bind_param("ii", $id, $_SESSION['user']['accid']);
            if ($stmt->execute()) {
                $connection->commit();
                echo returnJsonObject(1, "Record deleted successfully");
            } else {
                echo returnJsonObject(0, "Failed to delete record");
            }
            close_connection($connection, $stmt);
        }
    } catch (Exception $e) {
        echo returnJsonObject(0, "Failed when trying to delete data");
        die();
    }
}
?>