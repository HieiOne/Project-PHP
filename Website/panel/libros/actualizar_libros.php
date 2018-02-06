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

    $id = $_GET['id'];

    //Query
    $query = "SELECT nombre,editorial,autor,isbn,imagen,precio,oferta FROM libros WHERE id='$id'"; //Change the id to get it dynamically
    $result = mysqli_query($db,$query);
    $array = mysqli_fetch_array($result);
?>

<HTML>
    <HEAD>
    <TITLE>Actualizar</TITLE>
    </HEAD>
    <BODY>
    <div align="center">
    <h1>Actualizar</h1>
    <br>
    <form action="#" method="post">
        <?php
            echo 'Nombre:';
            echo '<INPUT TYPE="TEXT" NAME="nombre" value='.$array["nombre"].'><br>';
            echo 'Editorial:';
            echo '<INPUT TYPE="TEXT" NAME="editorial" value='.$array["editorial"].'><br>';
            echo 'Autor:';
            echo '<INPUT TYPE="TEXT" NAME="autor" value='.$array["autor"].'><br>';
            echo 'ISBN:';
            echo '<INPUT TYPE="TEXT" NAME="isbn" minlength="10" maxlength="13" pattern="[0-9]+" title="Solo numeros" value='.$array["isbn"].'><br>';
            echo 'Precio: ';
            echo '<INPUT TYPE="TEXT" NAME="precio" pattern="[0-9]+" title="Solo numeros E.G: 15" value='.$array["precio"].'><br>';
            echo 'Ruta Imagen:';
            echo '<INPUT TYPE="TEXT" NAME="imagen" value='.$array["imagen"].'><br>';
            echo 'Oferta:';
            echo '<INPUT TYPE="TEXT" NAME="oferta" pattern="[0-9]+" title="Solo numeros E.G: 15" value='.$array["oferta"].'><br>';
        ?>
        <INPUT TYPE="SUBMIT" name="Insertar" value="Insertar">
    </FORM>
    </div>
    </BODY>
</HTML>

<?php
    //Checking information gathered
    $nombre = $_POST['nombre'];
    $editorial = $_POST['editorial'];
    $autor = $_POST['autor'];
    $isbn = $_POST['isbn'];
    $precio = $_POST['precio'];
    $imagen = $_POST['imagen'];
    $oferta = $_POST['oferta'];
    
    //Update query
    $query_update = "UPDATE libros SET nombre='$nombre',editorial='$editorial',autor='$autor',isbn='$isbn',precio='$precio',imagen='$imagen',oferta='$oferta' WHERE id='$id'";
    mysqli_query($db,$query_update);
    mysqli_close($db);
    if (isset($_POST['Insertar'])) {
        header("Location: libros.php");
    }
?>
    <button onclick=location.href="libros.php">Regresar</button>