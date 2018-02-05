<?php
    $db = mysqli_connect("127.0.0.1", "root", "toor", "proyectophp");

    if (!$db) { //Checks if we can connect to MySQL
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }

    session_start();

    if(empty($_SESSION['cart'])) { // Para evitar que reinicie la variable cada p*** vez
        $_SESSION['cart']=array();
    }

    if(isset($_POST['Remove'])) { // Borrar elemento del carrito, BUGGED: Parece que no encuentra el valor
        $val = $_POST['Remove'];
        foreach($_SESSION['cart'] as $key => $value) { // Busca por la key del valor
            if (in_array($val, $value)) {
                unset($_SESSION['cart'][$key]);
            }
        }
    }

    if(isset($_POST['Add'])) { // Añadir elemento
        $val = $_POST['Add'];
        $newarray = array($val,1); //ID y la cantidad
        if (($key = array_search($val, array_column($_SESSION['cart'], 0))) !== false) { // Busca a ver si existe
            //Si existe Incrementar el valor
            $_SESSION['cart'][$key][1]++;
        }
        else { // Si no exite la añade
            array_push($_SESSION['cart'], $newarray);
        }
    }

    if(isset($_POST['AddQuantity'])) { // Añadir 1 a la cantidad
        $val = $_POST['AddQuantity'];
        foreach($_SESSION['cart'] as $key => $value) { // Busca por la key del valor
            if (in_array($val, $value)) {
                $_SESSION['cart'][$key][1]++;
            }
        }
    }

    if(isset($_POST['RemoveQuantity'])) { // Quitar 1 a la cantidad
        $val = $_POST['RemoveQuantity'];
        foreach($_SESSION['cart'] as $key => $value) { // Busca por la key del valor
            if (in_array($val, $value)) {
                if ($_SESSION['cart'][$key][1] != 1){
                    $_SESSION['cart'][$key][1]--;
                }
                else {
                unset($_SESSION['cart'][$key]);
                }
            }
        }
    }

    foreach ($_SESSION['cart'] as $valor) { // Muestra el carrito
        $cantidad = $valor[1];
        $query = "SELECT * from libros WHERE id='$valor[0]'";
        $result = mysqli_fetch_array(mysqli_query($db,$query));
        echo "<p> Nombre:".$result['nombre']."Editorial:".$result['nombre']." Autor:".$result['autor']."ISBN:".$result['isbn']." Precio:".$result['precio']." Cantidad: ".$cantidad."</p>";
        echo '<form action="" method="post">';
        echo '<button name="RemoveQuantity" type="submit" value='.$result['id'].'>-</button>';
        echo '<button name="AddQuantity" type="submit" value='.$result['id'].'>+</button>';
        echo '<button name="Remove" type="submit" value='.$result['id'].'>Remove</button>';
        echo '</form>';
        for ($i=1; $i <= $cantidad ; $i++) { 
            $precio_total += $result['precio'];
        }
    }

    echo "<br>Precio total: $precio_total".'<br>';
    echo '<form action="" method="post">';
    echo '<button name="Add" type="submit" value="10">Add 10</button>';
    echo '<button name="Add" type="submit" value="8">Add 8</button>';
    echo '<button name="Add" type="submit" value="9">Add 9</button>';
    echo '</form>';
?>