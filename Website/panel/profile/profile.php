<!DOCTYPE html>

<?php
    session_start();
    if ($_SESSION['id'] == NULL) { //Si no esta logeado, logeate
        header("Location: ../../login/login.php");
    }
?>


<html>
    <link rel="stylesheet" href="profile.css">
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

        <!-- Start of Profile -->
        <?php // Recogiendo info del usuario
            $id = $_SESSION['id'];

            $db = mysqli_connect("127.0.0.1", "root", "toor", "proyectophp");

            if (!$db) {
                echo "Error: Unable to connect to MySQL." . PHP_EOL;
                echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                exit;
            }

            $query = "SELECT email,usuario,password,direccion,pais,cp,provincia FROM clientes WHERE id='$id'";
            $result = mysqli_fetch_array(mysqli_query($db,$query));
        ?>

        <form action="#" method="post">
        <div class="usuario">
            <span class="text-profile">Usuario</span><br>
            <div class="infousuario">
            <?php
                echo '<label for=usuario>Usuario: ';
                echo '<input type="info" name="usuario" value="'.$result["usuario"].'"><br>';
                echo '</label>';
                echo '<label for=email>Email: ';
                echo '<input type="email" name="email" value="'.$result["email"].'"><br>';
                echo '</label>';
            ?>
            </div>
            <div class="infosecurity">
            <?php
                echo '<label for=password>Password: ';
                echo '<input type="password" name="password"><br>';
                echo '</label>';
                echo '<label for=password>Repetir Password: ';
                echo '<input type="password" name="rep_password"><br>';
                echo '</label>';
            ?>
            </div>
        </div>
        
        <div class="facturacion">
            <span class="text-profile">Facturacion</span><br>
            <div class="infousuario">
            <?php
                echo '<label for=direccion>Direccion: ';
                echo '<input type="info" name="direccion" value="'.$result["direccion"].'"><br>';
                echo '</label>';
                echo '<label for=pais>Pais: ';
                echo '<input type="info" name="pais" value="'.$result["pais"].'"><br>';
                echo '</label>';
                echo '<label for=cp>CP: ';
                echo '<input type="info" name="cp" value="'.$result["cp"].'"><br>';
                echo '</label>';
                echo '<label for=provincia>Provincia: ';
                echo '<input type="info" name="provincia" value="'.$result["provincia"].'"><br>';
                echo '</label>';
            ?>
            </div>
        </div>
        <input class="ButtonInsert" type="submit" name="Insertar" value="Actualizar">
        </form>
        <button class="ButtonInsert" onclick=location.href="../panel_control.php">Regresar</button>
            
        <!-- End of Profile -->

        <!-- PHP Insert -->

        <?php
            $usuario = $_POST['usuario'];
            $email = $_POST['email'];
            $direccion = $_POST['direccion'];
            $pais = $_POST['pais'];
            $cp = $_POST['cp'];

            $provincia = $_POST['provincia'];

            if ($_POST['password'] != NULL && $_POST['password'] == $_POST['rep_password']) {
                $password = $_POST['password'];
                $password = password_hash($password, PASSWORD_DEFAULT);
            }
            else {
                $password = $result['password'];
            }

            if (isset($_POST['Insertar'])) {
                if($_POST['cp'] != NULL) {
                    $query_update = "UPDATE clientes SET usuario='$usuario',email='$email',password='$password',direccion='$direccion',pais='$pais',cp=$cp,provincia='$provincia' WHERE id='$id'";
                }
                else {
                    $query_update = "UPDATE clientes SET usuario='$usuario',email='$email',password='$password',direccion='$direccion',pais='$pais',cp=NULL,provincia='$provincia' WHERE id='$id'";
                }
                mysqli_query($db,$query_update);
                header("refresh: 0.1;url=profile.php");
            }

            mysqli_close($db);
        ?>

    </body>
</html>
