<?php
    session_start();

    if ($_SESSION['id'] == NULL) {
        header("Location: ../login/login.php");
    }

    $db = mysqli_connect("127.0.0.1", "root", "toor", "proyectophp");

    if (!$db) { //Checks if we can connect to MySQL
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }

    $query = "SELECT id_compra FROM compras GROUP BY";
    $result = mysqli_query($db, $query);
    $query_rows = "SELECT max(id_compra) as row FROM compras";
    $result_rows = mysqli_fetch_array(mysqli_query($db, $query_rows));
    $id_compra = $result_rows[row]+1;
    $id_usuario = $_SESSION['id'];

    echo "ID_COMPRA: $id_compra";
    echo "<br>ID USUARIO: $id_usuario";
    foreach ($_SESSION['cart'] as $libro) {
        $query_precio = "SELECT precio FROM libros WHERE id='$libro[0]'";
        $precio = mysqli_fetch_array(mysqli_query($db,$query_precio));
        echo "<br>ID PRODUCTO: $libro[0] ";
        echo "CANTIDAD: $libro[1]";
        echo " PRECIO: $precio[precio]";
        $query_insert = "INSERT INTO compras (id_compra, id_usuario, libro, cantidad, precio) VALUES ($id_compra,$id_usuario,$libro[0],$libro[1],$precio[precio])";
        mysqli_query($db, $query_insert);
    }

    unset($_SESSION['cart']);
    sleep(0.2);
    header("Location: panel_control.php");
?>