<?php
    session_start();
    session_destroy();
    sleep(0.2);
    header("Location: ../index.php");
?>