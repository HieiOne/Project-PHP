<!DOCTYPE html>

<?php
    session_start();

    $db = mysqli_connect("127.0.0.1", "root", "toor", "proyectophp");
            
    if (!$db) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
?>

<html>
    <link rel="stylesheet" href="promotions.css">
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
                <form action="../search/search.php" method=post>
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

                <div class="cart-dropdown">
                    <a href="../login/login.php"><img class="top-bar-buttons-cart" src="../img/Cart1.png" alt="Cart"></a>
                    <?php
                        if ($_SESSION['cart'] != NULL) {
                            echo '<div class="cart-dropdown-content">';
                            foreach ($_SESSION['cart'] as $valor) {
                                $cantidad = $valor[1];
                                $query = "SELECT * from libros WHERE id='$valor[0]'";
                                $result = mysqli_fetch_array(mysqli_query($db,$query));
                                echo '<a href="../book/book.php?isbn='.$result["isbn"].'">';
                                    echo '<div class="image-dropdown">';
                                        echo '<img src="../img/libros/'.$result["isbn"].'.jpg">';
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

        <!-- Start of Showing Promotions -->
        <p class="newbooks-headtitle">Promotions</p>
        <!-- <div class="new-books"> -->
            <?php
                $query_count = "SELECT * FROM libros WHERE oferta > 0";
                $result_count = mysqli_query($db,$query_count);
                $row_cnt = mysqli_num_rows($result_count);
                $results_page = 8;
                $number_of_pages = ceil($row_cnt/$results_page);

                // Pagina actual
                if (!isset($_GET['page'])) {
                    $page = 1;
                } 
                else {
                    $page = $_GET['page'];
                }

                $first_result = ($page-1)*$results_page;

                $query = "SELECT id,nombre,isbn,precio,oferta FROM libros WHERE oferta > 0 LIMIT "."$first_result,"."$results_page";
                $result = mysqli_query($db,$query);
                
                while ($array = mysqli_fetch_array($result)) {
                    echo '<div class="book">';
                            $descuento = $array[oferta]*$array[precio]/100;
                            $precio = $array[precio] - $descuento;
                            echo "<a href='../book/book.php?isbn=$array[isbn]'>";
                            echo '<img class="images-books" src='."../img/libros/$array[isbn].jpg".' onerror='.'this.src="../img/nodisponible.png";'.'>';
                            echo '<span class="discount-books">-'.$array[oferta].'%</span>';
                            echo '<span class="names-books">'.$array[nombre].'</span>';
                            echo '<span class="price-books-discount-before">'.$array[precio].' €</span>';
                            echo '<span class="price-books-discount">'.$precio.' €</span>';
                            echo '</a>';
                            echo '<form action="../panel/panel_control.php" method="post">';
                                echo '<button class="buy-books" name="Add" type="submit" value="'.$array[id].'">BUY</button>';
                            echo '</form>';
                    echo '</div>';
                }
                
                
                mysqli_close($db);
            ?>
        <!-- </div> -->

        <div class="pages">
                <?php
                    for ($page=1;$page<=$number_of_pages;$page++) { 
                        echo '<a class="pagesbuttons" href="promotions.php?page='.$page.'">'.$page.'</a>  ';
                    }
                ?>
        </div>
        <br>

        <!-- End of showing Promotions -->


    </body>
</html>
