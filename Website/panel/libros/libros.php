<?php
    session_start();
    if ($_SESSION['permisos'] != 'admin') { // Si no es admin redirecciona
        header("Location: ../panel_control.php");
    }
?>

<HTML>
    <HEAD>
        <TITLE>lectura.php</TITLE>
    </HEAD>
    <BODY>
        
    <?php
    //Connecting to the database
    $db = mysqli_connect("127.0.0.1", "root", "toor", "proyectophp");
    
    if (!$db) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
    
    $query = "SELECT id,nombre,editorial,autor,isbn FROM libros";
    $result = mysqli_query($db,$query);
    ?>


    <h1><div align="center">Lectura de la tabla</div></h1>
    <form action="#" method="post">
    <table align=center border=1>
        <tr>
            <th>NOMBRE</th>
            <th>EDITORIAL</th>
            <th>AUTOR</th>
            <th>ISBN</th>
            <th>X</th>
            <th>EDITAR</th>
        </tr>
    <?php
        while ($array = mysqli_fetch_array($result)) {
            echo '<tr><td>'.$array["nombre"].'</td>';
            echo '<td>'.$array["editorial"].'</td>';
            echo '<td>'.$array["autor"].'</td>';
            echo '<td>'.$array["isbn"].'</td>';
            //echo '<td>'."<input type='checkbox' name='id[]' value=".$array["id"].'</td>';
            echo '<td><a href=borrar_libros.php?id='.$array["id"].'>Borrar</td>';
            echo '<td><a href=actualizar_libros.php?id='.$array["id"].'>Edit</td></tr>';
        }
        $result = NULL;
        ?>
    </table>
    </form>
<button onclick=location.href="agregar_libros.php">Agregar Libros</button>

<?php
    mysqli_close($db);
?>