<!DOCTYPE html>

<?php
    session_start();
    if ($_SESSION['permisos'] != 'admin') { // Si no es admin redirecciona
        header("Location: ../panel_control.php");
    }
?>


<html>
    <link rel="stylesheet" href="agregar_usuarios.css">
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

                <a href="#"><img class="top-bar-buttons-cart" src="../../img/Cart1.png" alt="Cart"></a>                                   
            </div>
        </div>

        <!-- End of Top bar -->

        <!-- Start of Add Users -->
        
        <?php // Comprobamos conexion MySQL
            $db = mysqli_connect("127.0.0.1", "root", "toor", "proyectophp");

            if (!$db) {
                echo "Error: Unable to connect to MySQL." . PHP_EOL;
                echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                exit;
            }
        ?>

        <div class="AgregarFormulario">
            <p class="AnadiendoUsuario">Añadiendo nuevo usuario</p>
            <form action="#" method="post">
                    <input type="text" name="usuario" pattern="[A-Za-z].*" title="No puede empezar por numero y mayor de 3" minlength="3" placeholder="Usuario *" required><br>
                    <input type="email" name="email" placeholder="Email...*" required><br>
                    <input type="text" name="permisos" placeholder="Permisos..."><br>
                    <input type="password" name="passwd" required placeholder="Password *"><br>
                    <input type="password" name="rep_passwd" required placeholder="Repetir Password *"><br>
                    <input class="ButtonInsert" type="submit" name="Insertar" value="Insertar">
            </form>
            <button class="ButtonInsert" onclick=location.href="usuarios.php">Regresar</button>
        </div>

        <?php
            //Necessary information
            $usuario = $_POST['usuario'];
            $email = $_POST['email'];
            $password = $_POST['passwd'];
            $rep_password = $_POST['rep_passwd'];
            $permisos = $_POST['permisos'];
            $query_usernames = "SELECT usuario FROM clientes WHERE usuario='$usuario'";
            $result = mysqli_fetch_array(mysqli_query($db,$query_usernames));
            $password_h = password_hash($password, PASSWORD_DEFAULT); //Hash password
        
            if (isset($_POST['Insertar'])) {
                if ($password == $rep_password) { //Checks if passwords are the same
                    if ($result['usuario'] == NULL && $usuario != NULL) { //Checks if the username doesn't exist
                        $query = "INSERT INTO clientes (email,usuario,password,permisos) VALUES ('$email','$usuario','$password_h','$permisos')";
                        mysqli_query($db,$query);
                        header("Location: usuarios.php");
                    }
                    else {
                        echo "<p class='MensajeError'> Usuario ya existe </p>";
                    }
                }
                else {
                    echo "<p class='MensajeError'> Contraseñas no iguales </p>";
                }
            }

            mysqli_close($db);
        ?>

        <!-- End of Add Users -->

    </body>
</html>
