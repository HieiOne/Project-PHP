<!DOCTYPE html>

<?php
    session_start();
    if ($_SESSION['permisos'] != 'admin') { // Si no es admin redirecciona
        header("Location: ../panel_control.php");
    }
?>


<html>
    <link rel="stylesheet" href="usuarios.css">
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

        <!-- Start of Users -->
        
        <div class="AgregarDiv">
            <button class="AgregarUsuarios" onclick=location.href="agregar_usuarios.php">Agregar Usuarios</button>
        </div>

        <?php
            //Connecting to the database
            $db = mysqli_connect("127.0.0.1", "root", "toor", "proyectophp");
            
            if (!$db) {
                echo "Error: Unable to connect to MySQL." . PHP_EOL;
                echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
                echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
                exit;
            }
            
            $query = "SELECT * FROM clientes";
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
            $query_limit = "SELECT id,email,usuario,permisos FROM clientes LIMIT "."$first_result,"."$results_page";
            $res = mysqli_query($db,$query_limit);
        ?>

        <div class="tabla">
            <form action="#" method="post">
                <table align=center border=1>
                    <tr>
                        <th>USUARIO</th>
                        <th>EMAIL</th>
                        <th>PERMISOS</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <?php
                        while ($array = mysqli_fetch_array($res)) {
                            echo '<tr><td>'.$array["usuario"].'</td>';
                            echo '<td>'.$array["email"].'</td>';
                            echo '<td>'.$array["permisos"].'</td>';
                            echo '<td><a href=borrar_usuarios.php?id='.$array["id"].'><img class="images" src="../../img/remove.png" alt="remove_img"></td>';
                            echo '<td><a href=actualizar_usuarios.php?id='.$array["id"].'><img class="images" src="../../img/edit.png" alt="edit_img"></td></tr>';
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
                    echo '<a class="pagesbuttons" href="usuarios.php?page='.$page.'">'.$page.'</a>  ';
                }
            ?>
        </div>
        <!-- End of Users -->

    </body>
</html>
