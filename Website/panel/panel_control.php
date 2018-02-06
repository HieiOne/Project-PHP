<!DOCTYPE html>

<?php
    session_start();
    if ($_SESSION['id'] == NULL) {
        header("Location: ../login/login.php");
    }
?>


<html>
    <link rel="stylesheet" href="panel_control.css">
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

        <!-- Start of Control Panel -->
            <div class="panel-top-bar">
                <a href="#"> <!-- Profile -->
                    <div class="panel-top-bar-buttons">
                        <img class="images-position" src="../img/control_panel/profile.png" alt="Profile">
                        <p class="text-position">Profile</p>
                    </div>
                </a>

                <a href="#"> <!-- Security -->
                    <div class="panel-top-bar-buttons">
                        <img class="images-position" src="../img/control_panel/security.png" alt="Security">
                        <p class="text-position">Security</p>
                    </div>
                </a>

                <a href="#"> <!-- Support -->
                    <div class="panel-top-bar-buttons">
                        <img class="images-position" src="../img/control_panel/support.png" alt="Support">
                        <p class="text-position">Support</p>
                    </div>
                </a>
            </div>
        <!-- End of Control Panel -->

        <!-- Control Panel Cart -->

            <div class="control-panel-cart">
            
            </div>

        <!-- End of Control Panel Cart -->

        <?php
            //Si es admin muestra
            if ($_SESSION['permisos'] != 'admin') {
                exit;
            }
        ?>
        <!-- Start of ADMIN panel -->
        <div class="admin-bar">
            <div class="panel-top-bar">
                <a href="#"> <!-- Users -->
                    <div class="panel-top-bar-buttons">
                        <img class="images-position" src="../img/control_panel/users.png" alt="Users">
                        <p class="text-position">Users</p>
                    </div>
                </a>

                <a href="#"> <!-- Libros -->
                    <div class="panel-top-bar-buttons">
                        <img class="images-position" src="../img/control_panel/books.png" alt="Books">
                        <p class="text-position">Books</p>
                    </div>
                </a>
            </div>
        </div>
        <!-- End of ADMIN panel -->

    </body>
</html>
