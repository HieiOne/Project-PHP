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
    <link rel="stylesheet" href="actualizar_libros.css">
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
        
        <?php // Comprobamos conexion MySQL

            $id = $_GET['id'];

            $query = "SELECT nombre,editorial,autor,isbn,categorias,precio,oferta FROM libros WHERE id='$id'"; //Change the id to get it dynamically
            $result = mysqli_query($db,$query);
            $array = mysqli_fetch_array($result);
        ?>

        <div class="AgregarFormulario">
            <p class="AnadiendoLibro">Actualizando libro</p>
            <div class="formulario">
            <form action="#" method="post">
            <?php
                echo '<label for=nombre>Nombre:';
                echo '<input type="info" name="nombre" value="'.$array["nombre"].'"><br>';
                echo '</label>';
                echo '<label for=editorial>Editorial: ';
                echo '<input type="info" name="editorial" value="'.$array["editorial"].'"><br>';
                echo '</label>';
                echo '<label for=autor>Autor: ';
                echo '<input type="info" name="autor" value="'.$array["autor"].'"><br>';
                echo '</label>';
                echo '<label for=isbn>ISBN: ';
                echo '<input type="info" name="isbn" minlength="10" maxlength="13" pattern="[0-9]+" title="Solo numeros" value="'.$array["isbn"].'"><br>';
                echo '</label>';
                echo '<label for=precio>Precio: ';
                echo '<input type="info" name="precio" pattern="[0-9]+" title="Solo numeros E.G: 15" value="'.$array["precio"].'"><br>';
                echo '</label>';
                echo '<label for=oferta>Oferta: ';
                echo '<input type="info" name="oferta" pattern="[0-9]+" title="Solo numeros E.G: 15" value="'.$array["oferta"].'"><br>';
                echo '</label>';

                $categories = array("youth","psychology","black","horror","history","medical","children","contemporary","romance","comics","economics","historical");
                $op_default = $array['categorias'];
                echo '<label for=categorias>Categoria: ';
                    echo '<select name="categorias">';
                        foreach ($categories as $category) {
                            if($category == $op_default) {
                                echo '<option selected value="'.$category.'">'.$category.'</option>';
                            }
                            else {
                                echo '<option value="'.$category.'">'.$category.'</option>';
                            }
                        }
                    echo '</select>';
                echo '</label>';
                echo '</div>';
                echo "<br>";
            ?>
                <input class="ButtonInsert" type="submit" name="Insertar" value="Actualizar">
            </form>
            <button class="ButtonInsert" onclick=location.href="libros.php">Regresar</button>
        </div>

        <?php
            //Checking information gathered
            $nombre = $_POST['nombre'];
            $editorial = $_POST['editorial'];
            $autor = $_POST['autor'];
            $isbn = $_POST['isbn'];
            $categorias = $_POST['categorias'];
            $precio = $_POST['precio'];
            $oferta = $_POST['oferta'];
            
            //Update query
            $query_update = "UPDATE libros SET nombre='$nombre',editorial='$editorial',autor='$autor',isbn='$isbn',categorias='$categorias',precio='$precio',oferta='$oferta' WHERE id='$id'";
            mysqli_query($db,$query_update);
            mysqli_close($db);

            if (isset($_POST['Insertar'])) {
                header("Location: libros.php");
            }
        ?>

        <!-- End of Update Books -->

    </body>
</html>
