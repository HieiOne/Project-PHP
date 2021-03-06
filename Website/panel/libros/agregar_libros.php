<!DOCTYPE html>

<?php
    session_start();
    if ($_SESSION['permisos'] != 'admin') { // Si no es admin redirecciona
        header("Location: ../panel_control.php");
    }
    $db = mysqli_connect("127.0.0.1", "root", "toor", "proyectophp");
    
    if (!$db) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
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

        <!-- Start of Add Books -->

        <div class="AgregarFormulario">
            <p class="AnadiendoLibro">Añadiendo nuevo libro</p>
            <form action="#" method="post">
                <input type="info" name="nombre" required placeholder="Nombre.."><br>
                <input type="info" name="editorial" required placeholder="Editorial.."><br>
                <input type="info" name="autor" required placeholder="Autor.."><br>
                <input type="info" name="isbn" required minlength="10" maxlength="13" pattern="[0-9]+" title="Solo numeros" placeholder="ISBN.."><br>
                <select name="categorias">
                    <option value="youth">Youth</option>
                    <option value="psycologhy">Psychologhy</option>
                    <option value="black">Black</option>
                    <option value="horror">Horror</option>
                    <option value="history">History</option>
                    <option value="medical">Medical</option>
                    <option value="children">Children</option>
                    <option value="contemporary">Contemporary</option>
                    <option value="romance">Romance</option>
                    <option value="comics">Comics</option>
                    <option value="economics">Economics</option>
                    <option value="historical">Historical</option>
                </select><br>
                <input type="info" name="precio" required pattern="[0-9]+" title="Solo numeros E.G: 15" placeholder="Precio.."><br>
                <input type="info" name="oferta" required pattern="[0-9]+" title="Solo numeros E.G: 15" placeholder="Oferta.."><br>
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
            $categorias = $_POST['categorias'];
            $precio = $_POST['precio'];
            $oferta = $_POST['oferta'];
        
            //Generating the query
            $query = "INSERT INTO libros (nombre,editorial,autor,isbn,categorias,precio,oferta) VALUES ('$nombre','$editorial','$autor','$isbn','$categorias','$precio','$oferta')";
            mysqli_query($db,$query);

            if (isset($_POST['Insertar'])) {
                header("Location: libros.php");
            }

            mysqli_close($db);
        ?>

        <!-- End of Add Books -->

    </body>
</html>
