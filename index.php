<?php
    session_start();
    if($_SESSION["auth"]) {
        echo "MUDAK";
    } else {
        header("Location: login.php");
    }
?>