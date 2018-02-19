<!DOCTYPE html>

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
?>


<html>
    <link rel="stylesheet" href="panel_control.css">
    <head>
        <title>Library of Nalanda</title>
        <link rel="icon" href="../img/Logo.png">
    </head>
    <body>

		<!-- Background (left and right) -->
		<div class="background-left"></div>
		<div class="background-right"></div>
	
        <!-- Top bar -->
        
        <div class="top-bar">
            <a href="../index.php">
                <div class="top-bar-logo">
                    <img class="top-bar-logo-position" src="../img/Logo.png" alt="Logo">
                    <p class="top-bar-logo-text">Library of Nalanda</p>
                </div>
            </a>

            <div class="top-bar-search">
                <form>
                        <input type="text" name="search" placeholder="Search by title, author...">
                </form>
            </div>

            <?php //Welcome Message
                if ($_SESSION['id'] != NULL) {
                    echo '<span class="welcome-message"> Bienvenido '.$_SESSION['usuario'].'</span>';
                }
            ?>

            <div class="top-bar-buttons">
                <div class="login-dropdown">
                    <a href="../login/login.php"><img class="top-bar-buttons-login" src="../img/Login1.png" alt="Login"></a>
                    <?php
                        if ($_SESSION['id'] != NULL) {
                                echo '<div class="login-dropdown-content">';
                                echo '<a class="login-drop-content-links" href="../login/login.php">Panel de Control</a>';
                                echo '<a class="login-drop-content-links" href="../login/sessiondestroy.php">Logout</a>';
                                echo '</div>';
                            }
                        ?>
                </div>

                <a href="#"><img class="top-bar-buttons-cart" src="../img/Cart1.png" alt="Cart"></a>                                   
            </div>
        </div>

        <!-- End of Top bar -->

        <!-- Start of Control Panel -->
            <div class="panel-top-bar">
                <a href="profile/profile.php"> <!-- Profile and Security -->
                    <div class="panel-top-bar-buttons-ps">
                        <img class="images-position-ps" src="../img/control_panel/profile.png" alt="Profile">
                        <img class="images-position-ps" src="../img/control_panel/security.png" alt="Security">
                        <p class="text-position-ps">Profile and Security</p>
                    </div>
                </a>

                <a href="support/support.php"> <!-- Support -->
                    <div class="panel-top-bar-buttons">
                        <img class="images-position" src="../img/control_panel/support.png" alt="Support">
                        <p class="text-position">Support</p>
                    </div>
                </a>
            </div>
        <!-- End of Control Panel -->

        <!-- Control Panel Cart -->

            <div class="control-panel-cart">
                <?php
                    if(empty($_SESSION['cart'])) { // Para evitar que reinicie la variable cada p*** vez
                        $_SESSION['cart']=array();
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

                    if(isset($_POST['Remove'])) {
                        $val = $_POST['Remove'];
                        foreach($_SESSION['cart'] as $key => $value) { // Busca por la key del valor
                            if (in_array($val, $value)) {
                                unset($_SESSION['cart'][$key]);
                            }
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
                        echo '<div class="item">';
                            echo '<div class="item-image">';
                                echo '<img class="category-image" src="../img/libros/'.$result[isbn].'.jpg" onerror='.'this.src="../img/nodisponible.png";'.'>';
                            echo '</div>';
                            echo '<div class="item-text">';
                                echo "<p>$result[nombre]</p>";
                            echo '</div>';

                            echo '<form action="" method="post">';
                                echo '<div class="item-buttons">';
                                    echo '<button class="item-minus" name="RemoveQuantity" type="submit" value='.$result['id'].'>-</button>';
                                    echo "<p class='item-quantity'>$cantidad</p>";
                                    echo '<button class="item-plus" name="AddQuantity" type="submit" value='.$result['id'].'>+</button>';
                                    echo "<p class='item-price'>$result[precio] €</p>";
                                    echo '<button class="item-remove" name="Remove" type="submit" value='.$result['id'].'>DELETE</button>';
                                echo '</div>';
                            echo '</form>';

                        echo '</div>';
                        for ($i=1; $i <= $cantidad ; $i++) { 
                            $precio_total += $result['precio'];
                        }
                    }

                    ?>                
            </div>
                <?php
                    echo '<br> <form action="buy_code.php" method="post">';
                        echo '<button class="buy-books" name="Add" type="submit" value="'.$array[id].'">BUY</button>';
                    echo '</form>';
                    echo "<p class='total-price'>Precio total: $precio_total €</p>";
                ?>

        <!-- End of Control Panel Cart -->

        <?php
            //If admin keep going
            if ($_SESSION['permisos'] != 'admin') {
                exit;
            }
        ?>
        <!-- Start of ADMIN panel -->
        <div class="admin-bar">
            <div class="panel-top-bar">
                <a href="usuarios/usuarios.php"> <!-- Users -->
                    <div class="panel-top-bar-buttons">
                        <img class="images-position" src="../img/control_panel/users.png" alt="Users">
                        <p class="text-position">Users</p>
                    </div>
                </a>

                <a href="libros/libros.php"> <!-- Libros -->
                    <div class="panel-top-bar-buttons">
                        <img class="images-position" src="../img/control_panel/books.png" alt="Books">
                        <p class="text-position">Books</p>
                    </div>
                </a>
            </div>
        </div>
        <!-- End of ADMIN panel -->

    </body>
</html>
