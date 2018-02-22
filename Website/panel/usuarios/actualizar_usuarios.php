<!DOCTYPE html>

<?php
    session_start();
    if ($_SESSION['permisos'] != 'admin') { // Si no es admin redirecciona
        header("Location: ../panel_control.php");
    }
    //Conexión MySQL
    $db = mysqli_connect("127.0.0.1", "root", "toor", "proyectophp");

    if (!$db) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
?>


<html>
    <link rel="stylesheet" href="actualizar_usuarios.css">
    <head>
        <title>Library of Nalanda</title>
        <link rel="icon" href="../../img/Logo.png">
    </head>
    <body>

		<!-- Background (left and right) -->
		<div class="background-left"></div>
		<div class="background-right"></div>
	
        <!-- Top bar -->
        
        <div class="top-bar">
            <a href="../../index.php">
                <div class="top-bar-logo">
                    <img class="top-bar-logo-position" src="../../img/Logo.png" alt="Logo">
                    <p class="top-bar-logo-text">Library of Nalanda</p>
                </div>
            </a>

            <div class="top-bar-search">
                <form action="../../search/search.php" method=post>
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
                    <a href="../../login/login.php"><img class="top-bar-buttons-login" src="../../img/Login1.png" alt="Login"></a>
                    <?php
                        if ($_SESSION['id'] != NULL) {
                                echo '<div class="login-dropdown-content">';
                                echo '<a class="login-drop-content-links" href="../../login/login.php">Panel de Control</a>';
                                echo '<a class="login-drop-content-links" href="../../login/sessiondestroy.php">Logout</a>';
                                echo '</div>';
                            }
                        ?>
                </div>

                <div class="cart-dropdown">
                    <a href="../../login/login.php"><img class="top-bar-buttons-cart" src="../../img/Cart1.png" alt="Cart"></a>
                    <?php
                        if ($_SESSION['cart'] != NULL) {
                            echo '<div class="cart-dropdown-content">';
                            foreach ($_SESSION['cart'] as $valor) {
                                $cantidad = $valor[1];
                                $query = "SELECT * from libros WHERE id='$valor[0]'";
                                $result = mysqli_fetch_array(mysqli_query($db,$query));
                                echo '<a href="../../book/book.php?isbn='.$result["isbn"].'">';
                                    echo '<div class="image-dropdown">';
                                        echo '<img src="../../img/libros/'.$result["isbn"].'.jpg">';
                                    echo '</div>';
                                    echo '<div class="text-dropdown">';
                                        echo '<p>'.$result["nombre"].'</p>';
                                    echo '</div>';
                                echo '</a>';
                            }
                            echo '</div>';
                        }
                    ?>
                </div>                                    
            </div>
        </div>

        <!-- End of Top bar -->

        <!-- Start of Update Books -->
        
        <?php
            $id = $_GET['id'];

            $query = "SELECT usuario,password,permisos,email FROM clientes WHERE id='$id'";
            $result = mysqli_query($db,$query);
            $array = mysqli_fetch_array($result);
        ?>

        <div class="AgregarFormulario">
            <p class="AnadiendoUsuario">Actualizando Usuario</p>
            <div class="formulario">
            <form action="#" method="post">
            <?php
                echo '<label for=usuario>Usuario:';
                echo '<input type="info" name="usuario" value="'.$array["usuario"].'"><br>';
                echo '</label>';
                echo '<label for=email>Email:';
                echo '<input type="email" name="email" value="'.$array["email"].'"><br>';
                echo '</label>';
                echo '<label for=password>Password:';
                echo '<input type="password" name="password"><br>';
                echo '</label>';

                $permisos = array("admin","usuario");
                $op_default = $array['permisos'];
                echo '<label for=permisos>Permisos: ';
                    echo '<select name="permisos">';
                        foreach ($permisos as $permiso) {
                            if($permiso == $op_default) {
                                echo '<option selected value="'.$permiso.'">'.$permiso.'</option>';
                            }
                            else {
                                echo '<option value="'.$permiso.'">'.$permiso.'</option>';
                            }
                        }
                    echo '</select>';
                echo '</label>';
                echo '</div>';
                echo "<br>";
            ?>
                <input class="ButtonInsert" type="submit" name="Insertar" value="Actualizar">
            </form>
            <button class="ButtonInsert" onclick=location.href="usuarios.php">Regresar</button>
        </div>

        <?php
            //Checking information gathered
            $usuario = $_POST['usuario'];
            $email = $_POST['email'];
            $permisos = $_POST['permisos'];

            if ($_POST['password'] != NULL) { // If new password is detected, change it
                $password = $_POST['password'];
                $password = password_hash($password, PASSWORD_DEFAULT);
            }
            else {
                $password = $array['password'];
            }
                        
            if (isset($_POST['Insertar'])) {
                $query_update = "UPDATE clientes SET usuario='$usuario',email='$email',password='$password',permisos='$permisos' WHERE id='$id'";
                mysqli_query($db,$query_update);
                header("Location: usuarios.php");
            }

            mysqli_close($db);
        ?>

        <!-- End of Update Books -->

    </body>
</html>
