<<<<<<< HEAD
<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$conexion = mysqli_connect("localhost", "root", "", "peluqueria_db");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM citas WHERE id = $id";
    
    if (mysqli_query($conexion, $sql)) {
        header("Location: admin.php?mensaje=borrado");
    } else {
        echo "Error al eliminar: " . mysqli_error($conexion);
    }
}

mysqli_close($conexion);
=======
<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$conexion = mysqli_connect("localhost", "root", "", "peluqueria_db");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM citas WHERE id = $id";
    
    if (mysqli_query($conexion, $sql)) {
        header("Location: admin.php?mensaje=borrado");
    } else {
        echo "Error al eliminar: " . mysqli_error($conexion);
    }
}

mysqli_close($conexion);
>>>>>>> 6d5ea9f0426fc98fdb6b4d482b1e0b3dd734b675
?>