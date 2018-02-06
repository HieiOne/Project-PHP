<?php
    session_start();
    if ($_SESSION['permisos'] != 'admin') { // Si no es admin redirecciona
        header("Location: ../panel_control.php");
    }

    //Connecting to the database
    $db = mysqli_connect("127.0.0.1", "root", "toor", "proyectophp");

    if (!$db) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }

?>

<HTML>
    <HEAD>
    <TITLE>Insertar.html</TITLE>
    </HEAD>
    <BODY>
    <div align="center">
    <h1>Insertar Libro</h1>
    <br>
    <form action="#" method="post">
        Nombre: 
        <INPUT TYPE="TEXT" NAME="nombre" required><br>
        Editorial: 
        <INPUT TYPE="TEXT" NAME="editorial" required><br>
        Autor: 
        <INPUT TYPE="TEXT" NAME="autor" required><br>
        ISBN: 
        <INPUT TYPE="TEXT" NAME="isbn" required minlength="10" maxlength="13" pattern="[0-9]+" title="Solo numeros"><br>
        Precio: 
        <INPUT TYPE="TEXT" NAME="precio" required pattern="[0-9]+" title="Solo numeros E.G: 15"><br>
        Ruta Imagen:
        <INPUT TYPE="TEXT" NAME="imagen" required><br>
        <INPUT TYPE="SUBMIT" name="Insertar" value="Insertar">
    </FORM>
    </div>
    </BODY>
</HTML>

<?php
    //Necessary information
    $nombre = $_POST['nombre'];
    $editorial = $_POST['editorial'];
    $autor = $_POST['autor'];
    $isbn = $_POST['isbn'];
    $precio = $_POST['precio'];
    $imagen = $_POST['imagen'];
 
    //Generating the query
    $query = "INSERT INTO libros (nombre,editorial,autor,isbn,precio,imagen) VALUES ('$nombre','$editorial','$autor','$isbn','$precio','$imagen')";
    mysqli_query($db,$query);

    if (isset($_POST['Insertar'])) {
        header("Location: libros.php");
    }

    mysqli_close($db);
?>
<button onclick=location.href="libros.php">Regresar</button>