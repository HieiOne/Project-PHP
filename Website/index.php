<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="index.css">
    <head>
        <title>Library of Nalanda</title>
        <link rel="icon" href="img/Logo.png">
    </head>
    <body>

		<!-- Background (left and right) -->
		<div class="background-left"></div>
		<div class="background-right"></div>
	
        <!-- Top bar -->
        
        <div class="top-bar">
            <a href="#">
                <div class="top-bar-logo">
                    <img class="top-bar-logo-position" src="img/Logo.png" alt="Logo">
                    <p class="top-bar-logo-text">Library of Nalanda</p>
                </div>
            </a>

            <div class="top-bar-search">
                <form action="search/search.php" method=post>
                        <input type="text" name="search" placeholder="Search by title, author...">
                </form>
            </div>

            <?php //Welcome Message
                session_start();
                if ($_SESSION['id'] != NULL) {
                    echo '<span class="welcome-message"> Bienvenido '.$_SESSION['usuario'].'</span>';
                }
            ?>

            <div class="top-bar-buttons">
                <div class="login-dropdown">
                    <a href="login/login.php"><img class="top-bar-buttons-login" src="img/Login1.png" alt="Login"></a>
                    <?php
                        if ($_SESSION['id'] != NULL) {
                                echo '<div class="login-dropdown-content">';
                                echo '<a class="login-drop-content-links" href="login/login.php">Panel de Control</a>';
                                echo '<a class="login-drop-content-links" href="login/sessiondestroy.php">Logout</a>';
                                echo '</div>';
                            }
                        ?>
                </div>

                <a href="#"><img class="top-bar-buttons-cart" src="img/Cart1.png" alt="Cart"></a>                                   
            </div>
        </div>

        <!-- End of Top bar -->

        <!-- Menu bar -->

        <div class="menu-bar">
		   <a href="categories/categories.php"> <!-- Categories -->
                <div class="menu-bar-categories drop-menu"> 
                    <img class="images-position" src="img/category_logo1.png" alt="Categories">
                    <p class="text-position">Categories</p>
					<div class="drop-content">
                        <?php
                            $db = mysqli_connect("127.0.0.1", "root", "toor", "proyectophp");
        
                            if (!$db) {
                                echo "Error: Unable to connect to MySQL." . PHP_EOL;
                                echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                                echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                                exit;
                            }

                            $query = "SELECT categorias FROM libros GROUP BY categorias";
                            $result = mysqli_query($db,$query);
                            
                            while ($array = mysqli_fetch_array($result)) {
                                echo '<a class="drop-content-links" href="categories/categories.php?category='.$array['categorias'].'">'.$array['categorias'].'</a>';
                            }
                        ?>
					</div>
                </div>
			</a>
				
            <a href="promotions/promotions.php"> <!-- Promotions -->
                <div class="menu-bar-categories">
                    <img class="images-position" src="img/promotion_logo1.png" alt="Promotions">
                    <p class="text-position">Promotions</p>                    
                </div>
            </a>
            
            <a href="new_books/new_books.php"> <!-- New Books -->
                <div class="menu-bar-categories">
                    <img class="images-position" src="img/newbooks_logo3.png" alt="New books">
                    <p class="text-position">New Books</p>     
                </div>
            </a>

            <a href="#"> <!-- Social Network -->
                <div class="menu-bar-categories">
                    <div class="images-position">
                        <a href="https://www.youtube.com"><img class="socialnetwork-images" src="img/logo/youtube.png" alt="Youtube"></a>
                        <a href="https://www.twitter.com"><img class="socialnetwork-images" src="img/logo/twitter.png" alt="Twitter"></a>
                        <a href="https://www.facebook.com"><img class="socialnetwork-images" src="img/logo/facebook.png" alt="Facebook"></a>
                        <a href="https://www.discordapp.com"><img class="socialnetwork-images" src="img/logo/discord.jpg" alt="Discord"></a>                        
                    </div>
                    <p class="text-position">Social Networks</p>
                </div>
            </a>

        </div>

        <!-- End of Menu bar -->

        <!-- Start of Books -->
        <br>
        <span class="books-titles">Highlights</span>
            <div class="book-rows">
                <?php // Ordered by the ones added the earliest and most sold
                    $query_highlights = "SELECT id,nombre,isbn,precio,oferta FROM libros ORDER BY add_date DESC, veces_vendido DESC LIMIT 0,9";
                    $result_highlights = mysqli_query($db,$query_highlights);

                    while($array = mysqli_fetch_array($result_highlights)) {
                        echo '<div class="book">';
                        if($array['oferta'] == 0) {
                            echo "<a href='../book/book.php?isbn=$array[isbn]'>";
                            echo '<img class="images-books" src='."../img/libros/$array[isbn].jpg".' onerror='.'this.src="img/nodisponible.png";'.'>';
                            echo '<span class="names-books">'.$array[nombre].'</span>';
                            echo '<span class="price-books">'.$array[precio].' €</span>';
                            echo '</a>';
                            echo '<form action="../panel/panel_control.php" method="post">';
                                echo '<button class="buy-books" name="Add" type="submit" value="'.$array[id].'">BUY</button>';
                            echo '</form>';
                        }
                        else {
                            $descuento = $array[oferta]*$array[precio]/100;
                            $precio = $array[precio] - $descuento;
                            echo "<a href='../book/book.php?isbn=$array[isbn]'>";
                            echo '<img class="images-books" src='."../img/libros/$array[isbn].jpg".' onerror='.'this.src="img/nodisponible.png";'.'>';
                            echo '<span class="discount-books">-'.$array[oferta].'%</span>';
                            echo '<span class="names-books">'.$array[nombre].'</span>';
                            echo '<span class="price-books-discount-before">'.$array[precio].' €</span>';
                            echo '<span class="price-books-discount">'.$precio.' €</span>';
                            echo '</a>';
                            echo '<form action="../panel/panel_control.php" method="post">';
                                echo '<button class="buy-books" name="Add" type="submit" value="'.$array[id].'">BUY</button>';
                            echo '</form>';
                        }
                        echo '</div>';
                    }
                ?>
            </div>

            <br>
            <span class="books-titles">Bestsellers</span>
            <div class="book-rows">
                <?php // Ordered by most sold
                    $query_bestsellers = "SELECT id,nombre,isbn,precio,oferta FROM libros ORDER BY veces_vendido DESC LIMIT 0,9";
                    $result_bestsellers = mysqli_query($db,$query_bestsellers);
                    while($array = mysqli_fetch_array($result_bestsellers)) {
                        echo '<div class="book">';
                        if($array['oferta'] == 0) {
                            echo "<a href='../book/book.php?isbn=$array[isbn]'>";
                            echo '<img class="images-books" src='."../img/libros/$array[isbn].jpg".' onerror='.'this.src="img/nodisponible.png";'.'>';
                            echo '<span class="names-books">'.$array[nombre].'</span>';
                            echo '<span class="price-books">'.$array[precio].' €</span>';
                            echo '</a>';
                            echo '<form action="../panel/panel_control.php" method="post">';
                                echo '<button class="buy-books" name="Add" type="submit" value="'.$array[id].'">BUY</button>';
                            echo '</form>';
                        }
                        else {
                            $descuento = $array[oferta]*$array[precio]/100;
                            $precio = $array[precio] - $descuento;
                            echo "<a href='../book/book.php?isbn=$array[isbn]'>";
                            echo '<img class="images-books" src='."../img/libros/$array[isbn].jpg".' onerror='.'this.src="img/nodisponible.png";'.'>';
                            echo '<span class="discount-books">-'.$array[oferta].'%</span>';
                            echo '<span class="names-books">'.$array[nombre].'</span>';
                            echo '<span class="price-books-discount-before">'.$array[precio].' €</span>';
                            echo '<span class="price-books-discount">'.$precio.' €</span>';
                            echo '</a>';
                            echo '<form action="../panel/panel_control.php" method="post">';
                                echo '<button class="buy-books" name="Add" type="submit" value="'.$array[id].'">BUY</button>';
                            echo '</form>';
                        }
                        echo '</div>';
                    }
                ?>
            </div>

            <br>
            <span class="books-titles">Tops of Categories</span>
            <div class="book-rows">
                <?php // Most sold ones of every category
                    $query_tops = "SELECT book.* FROM libros book INNER JOIN (SELECT categorias,MAX(veces_vendido) AS MaxVendido FROM libros GROUP BY categorias) groupedbook ON book.categorias = groupedbook.categorias AND book.veces_vendido = groupedbook.MaxVendido";
                    $result_tops = mysqli_query($db,$query_tops);

                    while($array = mysqli_fetch_array($result_tops)) {
                        echo '<div class="book">';
                        if($array['oferta'] == 0) {
                            echo "<a href='../book/book.php?isbn=$array[isbn]'>";
                            echo '<img class="images-books" src='."../img/libros/$array[isbn].jpg".' onerror='.'this.src="img/nodisponible.png";'.'>';
                            echo '<span class="names-books">'.$array[nombre].'</span>';
                            echo '<span class="price-books">'.$array[precio].' €</span>';
                            echo '</a>';
                            echo '<form action="../panel/panel_control.php" method="post">';
                                echo '<button class="buy-books" name="Add" type="submit" value="'.$array[id].'">BUY</button>';
                            echo '</form>';
                        }
                        else {
                            $descuento = $array[oferta]*$array[precio]/100;
                            $precio = $array[precio] - $descuento;
                            echo "<a href='../book/book.php?isbn=$array[isbn]'>";
                            echo '<img class="images-books" src='."../img/libros/$array[isbn].jpg".' onerror='.'this.src="img/nodisponible.png";'.'>';
                            echo '<span class="discount-books">-'.$array[oferta].'%</span>';
                            echo '<span class="names-books">'.$array[nombre].'</span>';
                            echo '<span class="price-books-discount-before">'.$array[precio].' €</span>';
                            echo '<span class="price-books-discount">'.$precio.' €</span>';
                            echo '</a>';
                            echo '<form action="../panel/panel_control.php" method="post">';
                                echo '<button class="buy-books" name="Add" type="submit" value="'.$array[id].'">BUY</button>';
                            echo '</form>';
                        }
                        echo '</div>';
                    }
                ?>
            </div>

        <!-- End of Books -->

    <div class="space"></div>
    </body>
</html>
