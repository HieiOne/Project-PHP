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
                <form>
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
		   <a href="#"> <!-- Categories -->
                <div class="menu-bar-categories drop-menu"> 
                    <img class="images-position" src="img/category_logo1.png" alt="Categories">
                    <p class="text-position">Categories</p>
					<div class="drop-content">
						<a class="drop-content-links" href="#">Link 1</a>
						<a class="drop-content-links" href="#">Link 2</a>
						<a class="drop-content-links" href="#">Link 3</a>
					</div>
                </div>
			</a>
				
            <a href="#"> <!-- Promotions -->
                <div class="menu-bar-categories">
                    <img class="images-position" src="img/promotion_logo1.png" alt="Promotions">
                    <p class="text-position">Promotions</p>                    
                </div>
            </a>
            
            <a href="#"> <!-- New Books -->
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

    </body>
</html>
