<!DOCTYPE html>

<?php
    session_start();
    if ($_SESSION['permisos'] != 'admin') { // Si no es admin redirecciona
        header("Location: ../panel_control.php");
    }
?>


<html>
    <link rel="stylesheet" href="libros.css">
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

        <!-- Start of Books -->
        
        <div class="AgregarDiv">
            <button class="AgregarLibros" onclick=location.href="agregar_libros.php">Agregar Libros</button>
        </div>

        <?php
            //Connecting to the database
            $db = mysqli_connect("127.0.0.1", "root", "toor", "proyectophp");
            
            if (!$db) {
                echo "Error: Unable to connect to MySQL." . PHP_EOL;
                echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                exit;
            }
            
            $query = "SELECT id,nombre,editorial,autor,isbn,precio,oferta,imagen FROM libros";
            $result = mysqli_query($db,$query);
        ?>

        <div class="tabla">
            <form action="#" method="post">
                <table align=center border=1>
                    <tr>
                        <th>NOMBRE</th>
                        <th>EDITORIAL</th>
                        <th>AUTOR</th>
                        <th>ISBN</th>
                        <th>PRECIO</th>
                        <th>OFERTA</th>
                        <th>IMAGEN</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <?php
                        while ($array = mysqli_fetch_array($result)) {
                            echo '<tr><td>'.$array["nombre"].'</td>';
                            echo '<td>'.$array["editorial"].'</td>';
                            echo '<td>'.$array["autor"].'</td>';
                            echo '<td>'.$array["isbn"].'</td>';
                            echo '<td>'.$array["precio"].'</td>';
                            echo '<td>'.$array["oferta"].'</td>';
                            echo '<td>'.$array["imagen"].'</td>';
                            echo '<td><a href=borrar_libros.php?id='.$array["id"].'><img class="images" src="../../img/remove.png" alt="remove_img"></td>';
                            echo '<td><a href=actualizar_libros.php?id='.$array["id"].'><img class="images" src="../../img/edit.png" alt="edit_img"></td></tr>';
                        }
                        $result = NULL;
                    ?>
                </table>
            </form>
        </div>

        <!-- End of Books -->

    </body>
</html>
