<!DOCTYPE html>

<?php
    session_start();
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
            <div class="book">
                <img class="images-books" src="../img/libros/origen.jpg">
                <span class="names-books">LOS MITOS DE CTHULHU</span>
                <span class="price-books">20€</span>
                <button class="buy-books" name="add" type="submit" value="8">BUY</button>
            </div>
            <div class="book">
            </div>
            <div class="book">
            </div>
            <div class="book">
            </div>
            <div class="book">
            </div>
            <div class="book">
            </div>
            <div class="book">
            </div>
            <div class="book">
            </div>
            <div class="book">
            </div>
            <div class="book">
            </div>
            <div class="book">
            </div>
            <div class="book">
            </div>
            <div class="book">
            </div>

        </div>
        <!-- End of showing new books -->


    </body>
</html>
