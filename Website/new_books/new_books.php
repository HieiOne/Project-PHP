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
    <link rel="stylesheet" href="new_books.css">
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

        <!-- Start of Showing new books -->
        <p class="newbooks-headtitle">New Books</p>
        <div class="new-books">

            <!-- <div class="book"> EXAMPLE
                <img class="images-books" src="../img/libros/origen.jpg">
                <span class="names-books">LOS MITOS DE CTHULHU</span>
                <span class="price-books">20€</span>
                <button class="buy-books" name="add" type="submit" value="8">BUY</button>
            </div> -->

            <?php
                $query = "SELECT nombre,isbn,precio,oferta FROM libros ORDER BY add_date DESC LIMIT 0,11";
                $result = mysqli_query($db,$query);
                
                while ($array = mysqli_fetch_array($result)) {
                    echo '<div class="book">';
                        echo '<img class="images-books" src='."../img/libros/$array[isbn].jpg".'>';
                        echo '<span class="names-books">'.$array[nombre].'</span>';
                        echo '<span class="price-books">'.$array[precio].' €</span>';
                        echo '<button class="buy-books" name="add" type="submit" value="'.$array[isbn].'">BUY</button>';
                    echo '</div>';
                }
                
                mysqli_close($db);
            ?>
        </div>
        <!-- End of showing new books -->


    </body>
</html>
