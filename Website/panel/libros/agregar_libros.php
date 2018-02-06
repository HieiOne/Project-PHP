<!DOCTYPE html>

<?php
    session_start();
    if ($_SESSION['permisos'] != 'admin') { // Si no es admin redirecciona
        header("Location: ../panel_control.php");
    }
?>


<html>
    <link rel="stylesheet" href="agregar_libros.css">
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

        <!-- Start of Add Books -->
        
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
            <p class="AnadiendoLibro">Añadiendo nuevo libro</p>
            <form action="#" method="post">
                <input type="info" name="nombre" required placeholder="Nombre.."><br>
                <input type="info" name="editorial" required placeholder="Editorial.."><br>
                <input type="info" name="autor" required placeholder="Autor.."><br>
                <input type="info" name="isbn" required minlength="10" maxlength="13" pattern="[0-9]+" title="Solo numeros" placeholder="ISBN.."><br>
                <input type="info" name="precio" required pattern="[0-9]+" title="Solo numeros E.G: 15" placeholder="Precio.."><br>
                <input type="info" name="imagen" required placeholder="Ruta Imagen.."><br>
                <input class="ButtonInsert" type="submit" name="Insertar" value="Insertar">
            </form>
            <button class="ButtonInsert" onclick=location.href="libros.php">Regresar</button>
        </div>

        <?php
            //Necessary information
            $nombre = $_POST['nombre'];
            $editorial = $_POST['editorial'];
            $autor = $_POST['autor'];
            $isbn = $_POST['isbn'];
            $precio = $_POST['precio'];
            $imagen = $_POST['imagen'];
        
            //Generating the query
            $query = "INSERT INTO libros (nombre,editorial,autor,isbn,precio,imagen) VALUES ('$nombre','$editorial','$autor','$isbn','$precio','$imagen')";
            mysqli_query($db,$query);

            if (isset($_POST['Insertar'])) {
                header("Location: libros.php");
            }

            mysqli_close($db);
        ?>

        <!-- End of Add Books -->

    </body>
</html>
