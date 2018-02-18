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
    <link rel="stylesheet" href="book.css">
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

        <!-- Start of Showing Book -->

        <?php
            $book = $_GET['isbn'];
        ?>

        <div class="book">
            <div class="book-image">
                <?php
                    $query = "SELECT id,nombre,editorial,autor,precio,oferta FROM libros WHERE isbn=$book";
                    $result = mysqli_fetch_array(mysqli_query($db,$query));
                    echo '<img class="image-book" src='."../img/libros/$book.jpg".'>';
                    if ($result[oferta] != 0) {
                        echo '<span class="discount-books">-'.$result[oferta].'%</span>';
                    }
                ?>
            </div>
            <div class="book-info">
                <?php
                    echo "<p class='book-name'>$result[nombre]</p>";
                    echo "<p class='book-rest'>Author: $result[autor]<br><br>Publisher: $result[editorial]<br><br>ISBN: $book</p>";
                ?>
            </div>
            <div class="book-price">
                <div class="price">
                    <?php
                        if ($result[oferta] == 0) {
                            echo '<span class="price-books-discount">'.$result[precio].' €</span>';
                        }
                        else {
                            $descuento = $result[oferta]*$result[precio]/100;
                            $precio = $result[precio] - $descuento;
                            echo '<span class="price-books-discount-before">'.$result[precio].' €</span>';
                            echo '<span class="price-books-discount">'.$precio.' €</span>';
                        }
                    ?>
                </div>
                <div class="buy">
                    <?php
                        echo '<form action="../panel/panel_control.php" method="post">';
                            echo '<button class="buy-books" name="Add" type="submit" value="'.$result[id].'">BUY</button>';
                        echo '</form>';
                    ?>
                </div>
            </div>
        </div>
        <div class="book-description">
            <p class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec tincidunt enim id metus luctus,
             at hendrerit mi suscipit. Donec euismod eros ipsum, at varius nunc dignissim eu. In et eros id eros
              feugiat porttitor. Quisque rhoncus lectus ut facilisis tristique. Proin interdum elit vitae 
              fringilla laoreet. Nullam blandit nisl vitae eleifend vestibulum. Vivamus at tellus vestibulum, 
              luctus velit eu, eleifend elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices 
              posuere cubilia Curae; Nulla bibendum nec neque non suscipit. Curabitur ut felis vel mi scelerisque 
              sollicitudin. Etiam vitae dolor magna. Vivamus aliquam scelerisque libero, in posuere augue sollicitudin 
              vitae. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras ornare eros vel augue tempor, 
              a gravida metus gravida.</p>
        </div>
        

        <!-- End of showing Book -->


    </body>
</html>
