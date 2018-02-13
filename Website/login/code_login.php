<?php
    $db = mysqli_connect("127.0.0.1", "root", "toor", "proyectophp");
    
    if (!$db) { //Checks if we can connect to MySQL
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
    
    $usuario = $_POST['usuario'];
    $password = $_POST['passwd'];

    $consulta = "SELECT id,password,usuario,permisos FROM clientes WHERE usuario = '$usuario'";
    $result = mysqli_query($db,$consulta);
    $linea = mysqli_fetch_array($result);
    
    if (password_verify($password,$linea['password'])) {
        session_start();
        $_SESSION['id'] = $linea['id'];
        $_SESSION['usuario'] = $linea['usuario'];
        $_SESSION['permisos'] = $linea['permisos'];
        header("Location: ../index.php");
    }
    else {
        session_start();
        $_SESSION['error'] = 4;
        header("Location: login.php");
    }
    mysqli_close($db);
?>