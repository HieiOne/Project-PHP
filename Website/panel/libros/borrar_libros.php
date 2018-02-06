<?php
    session_start();
    if ($_SESSION['permisos'] != 'admin') { // Si no es admin redirecciona
        header("Location: ../panel_control.php");
    }

    //Connecting to the database
    $db = mysqli_connect("127.0.0.1", "root", "toor", "proyectophp");

    if (!$db) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }

    $id = $_GET['id'];

    //Query
    $query = "DELETE FROM libros WHERE id='$id'";
    $result = mysqli_query($db,$query);
    $array = mysqli_fetch_array($result);
    header("Location: libros.php");
?>