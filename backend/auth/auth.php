<?php
require "../connect.php";
function login($email, $password)
{
            $connection = connectDB();
            $stmt = $connection->prepare("select * from accounts where email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $loggedin = false;
            if($row && password_verify($password, $row['password']))
            {
                $user = array(
                    "id" => $row['id'],
                    "name" => $row['name'],
                    "email" => $row['email'],
                );
                $_SESSION['user'] = $user;
                $loggedin = true;
            }
            close_connection($connection);
            return $loggedin;
}
?>