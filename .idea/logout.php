<?php

session_start();
require_once "db1.php";


unset($_SESSION["user_id"]);
unset($_SESSION["user_name"]);


session_destroy();


if (isset($conn)) {
    $conn->close();
}


header("Location: login.php");
exit();
?>