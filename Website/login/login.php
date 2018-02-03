<html>
    <a href="../index.html"><div class="imagen"></div></a>
    <link rel="stylesheet" href="login.css">
    <head>
        <title>Library of Nalanda</title>
        <link rel="icon" href="../img/Logo.png">
    </head>
    <body>

    <div class="login">

    <?php //Detects if a session is loged, if it is show a message
        session_start();
        if($_SESSION['id'] != NULL) { //!=
            echo "<a href='../index.html'><p class='session'>Sesion abierta...</p></a>";
            exit;
        }

        if($_SESSION['error_login'] == 1) {
            echo '<p class="fallido">Inicio de sesion fallido</p>';
        }
        if($_SESSION['error_register'] == 3) {
            echo '<p class="success_register">Registro completo</p>';
        }
        if($_SESSION['error_register'] == 1) {
            echo '<p class="fallido_register">Las passwords deben ser iguales</p>';
        }
        if($_SESSION['error_register'] == 2) {
            echo '<p class="fallido">El usuario ya existe</p>';
        }
    ?>

        <label for="toogle" class="tab-login">Login</label>
        <label for="toogle" class="tab-register">Register</label>
        <input type="checkbox" id="toogle">

        <div class="formulario-register">
                <form action="code_register.php" method="post">
                    <INPUT TYPE="TEXT" NAME="usuario" pattern="[A-Za-z].*" title="No puede empezar por numero y mayor de 3" minlength="3" placeholder="Usuario *">
                    <INPUT TYPE="password" NAME="passwd" required placeholder="Password *"><br>
                    <INPUT TYPE="password" NAME="rep_passwd" required placeholder="Repetir Password *"><br>
                    <INPUT TYPE="SUBMIT" class="register-button" value="REGISTER">
                </form>
        </div>

        <div class="formulario-login">
            <form action="code_login.php" method="post">
                <INPUT TYPE="TEXT" NAME="usuario" pattern="[A-Za-z].*" title="No puede empezar por numero y mayor de 3" minlength="3" placeholder="Usuario *">
                <INPUT TYPE="password" NAME="passwd" required placeholder="Password *"><br>
                <INPUT TYPE="SUBMIT" class="login-button" value="LOGIN">
            </form>
        </div>

        <a href="#" name="forgottenpassword"><p class="forgottenpassword">He olvidado mi password</p></a>
    </div>

</html>