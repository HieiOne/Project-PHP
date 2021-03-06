<!DOCTYPE html>

<?php
    session_start();
    if ($_SESSION['permisos'] != 'admin') { // Si no es admin redirecciona
        header("Location: ../panel_control.php");
    }
    //Connecting to the database
    $db = mysqli_connect("127.0.0.1", "root", "toor", "proyectophp");
    
    if (!$db) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
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

        <!-- Start of Books -->
        
        <div class="AgregarDiv">
            <button class="AgregarLibros" onclick=location.href="agregar_libros.php">Agregar Libros</button>
            <button class="AgregarLibros" onclick=location.href="../panel_control.php">Regresar</button>
        </div>

        <?php
            
            //$query = "SELECT id,nombre,editorial,autor,isbn,precio,oferta,categ FROM libros";
            $query = "SELECT * FROM libros";
            $result = mysqli_query($db,$query);

            $row_cnt = mysqli_num_rows($result);
            $results_page = 10;
            $number_of_pages = ceil($row_cnt/$results_page);

            // Pagina actual
            if (!isset($_GET['page'])) {
                $page = 1;
            } 
            else {
                $page = $_GET['page'];
            }

            $first_result = ($page-1)*$results_page;
            $query_limit = "SELECT id,nombre,editorial,autor,isbn,precio,oferta,categorias FROM libros LIMIT "."$first_result,"."$results_page";
            $res = mysqli_query($db,$query_limit);
        ?>

        <div class="tabla">
            <form action="#" method="post">
                <table align=center border=1>
                    <tr>
                        <th>NOMBRE</th>
                        <th>EDITORIAL</th>
                        <th>AUTOR</th>
                        <th>ISBN</th>
                        <th>CATEGORIAS</th>
                        <th>PRECIO</th>
                        <th>OFERTA</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <?php
                        while ($array = mysqli_fetch_array($res)) {
                            echo '<tr><td>'.$array["nombre"].'</td>';
                            echo '<td>'.$array["editorial"].'</td>';
                            echo '<td>'.$array["autor"].'</td>';
                            echo '<td>'.$array["isbn"].'</td>';
                            echo '<td>'.$array["categorias"].'</td>';
                            echo '<td>'.$array["precio"].'</td>';
                            echo '<td>'.$array["oferta"].'</td>';
                            echo '<td><a href=borrar_libros.php?id='.$array["id"].'><img class="images" src="../../img/remove.png" alt="remove_img"></td>';
                            echo '<td><a href=actualizar_libros.php?id='.$array["id"].'><img class="images" src="../../img/edit.png" alt="edit_img"></td></tr>';
                        }
                        $result = NULL;
                    ?>
                </table>
            </form>
            <br>
        </div>

        <div class="pages">
            <?php
                for ($page=1;$page<=$number_of_pages;$page++) { 
                    echo '<a class="pagesbuttons" href="libros.php?page='.$page.'">'.$page.'</a>  ';
                }
                mysqli_close($db);
            ?>
        </div>
        <!-- End of Books -->

    </body>
</html>
