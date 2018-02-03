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
    $rep_password = $_POST['rep_passwd'];
    $password_h = password_hash($password, PASSWORD_DEFAULT); //Hash password
    $query_insert = "INSERT INTO clientes (usuario,password) VALUES ('$usuario','$password_h')";
    $query_usernames = "SELECT usuario FROM clientes WHERE usuario='$usuario'";
    $result = mysqli_fetch_array(mysqli_query($db,$query_usernames));
    
    session_start();
    if ($password == $rep_password) { //Checks if passwords are the same
        if ($result['usuario'] == NULL) { //Checks if the username doesn't exist
            mysqli_query($db,$query_insert);
            $_SESSION['error_register'] = 3;
            header("Location: login.php");
        }
        else {
            $_SESSION['error_register'] = 2;
            header("Location: login.php");
        }
    }
    else {
        $_SESSION['error_register'] = 1;
        header("Location: login.php");
    }
    mysqli_close($db);

    //header("Location: formulario_registro.html");
?>