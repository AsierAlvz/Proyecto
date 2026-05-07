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
?>