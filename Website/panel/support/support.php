<!DOCTYPE html>

<?php
    session_start();
    if ($_SESSION['id'] == NULL) { //Si no esta logeado, logeate
        header("Location: ../../login/login.php");
    }
?>


<html>
    <link rel="stylesheet" href="support.css">
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

                <a href="#"><img class="top-bar-buttons-cart" src="../../img/Cart1.png" alt="Cart"></a>                                   
            </div>
        </div>

        <!-- End of Top bar -->
        <!-- Start of Support -->

        <div class="ticket">
            <form action="#" method="post">
                <div class="correo">
                    <input type="email" name="email" placeholder="Email...*" required><br>
                </div>
                <span>Máximo 380 carácteres</span>
                <div class="mensaje">
                    <textarea id="textareaChars" name="problema" maxlenght="380" placeholder="Problema...*" required></textarea>
                </div>
                <input class="ButtonInsert" type="submit" name="Insertar" value="Insertar">
            </form>
            <button class="ButtonInsert" onclick=location.href="../panel_control.php">Regresar</button>
        </div>

        <!-- End of Support -->

        <!-- Generating ticket -->
        <?php
            $email = $_POST['email'];
            $problema = $_POST['problema'];

            $db = mysqli_connect("127.0.0.1", "root", "toor", "proyectophp");

            if (!$db) {
                echo "Error: Unable to connect to MySQL." . PHP_EOL;
                echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                exit;
            }

            if (isset($_POST['Insertar'])) {
                $numero_caracteres = strlen($problema);
                if ($numero_caracteres <= 255) {
                    $query = "INSERT INTO problemas (email,problema) VALUES ('$email','$problema')";
                    mysqli_query($db,$query);
                    echo "<p class='TicketEnviado'> Su ticket ha sido generado, te informaremos pronto mediante correo</p>";
                }
                else {
                    echo "<p class='TicketError'> Error en el ticket, has superado la cantidad de caracteres máximos: 380</p>";
                }
            }
            
            mysqli_close($db);
        ?>

    </body>
</html>
