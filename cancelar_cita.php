<?php
session_start();
if (!isset($_SESSION['usuario'])) { exit; }

$conexion = mysqli_connect("localhost", "root", "", "peluqueria_db");

if (isset($_GET['id'])) {
    $id_cita = mysqli_real_escape_string($conexion, $_GET['id']);
    $user_id = $_SESSION['user_id'];

    // 1. Consultamos el servicio de la cita antes de borrarla
    $sql_cita = "SELECT servicio FROM citas WHERE id = '$id_cita' AND user_id = '$user_id'";
    $res_cita = mysqli_query($conexion, $sql_cita);
    $datos_cita = mysqli_fetch_assoc($res_cita);

    if ($datos_cita) {
        // Limpiamos el nombre del servicio
        $servicio = strtolower(trim($datos_cita['servicio']));
        $puntos_a_quitar = 0;

        // 2. Lógica de puntos
        switch ($servicio) {
            case 'corte':
                $puntos_a_quitar = 15;
                break;
            case 'barba':
                $puntos_a_quitar = 10;
                break;
            case 'corte y barba':
                $puntos_a_quitar = 22;
                break;
            case 'tinte':
                $puntos_a_quitar = 30;
                break;
            default:
                // Si sigue fallando, es que el nombre en la DB es muy distinto
                $puntos_a_quitar = 10; 
                break;
        }

        // 3. Restamos los puntos asegurándonos de no tener puntos negativos
        $sql_restar = "UPDATE clientes SET puntos = GREATEST(0, puntos - $puntos_a_quitar) WHERE user_id = '$user_id'";
        mysqli_query($conexion, $sql_restar);

        // 4. Borramos la reserva
        $sql_borrar = "DELETE FROM citas WHERE id = '$id_cita' AND user_id = '$user_id'";
        
        if (mysqli_query($conexion, $sql_borrar)) {
            header("Location: perfil.php?mensaje=cancelada");
        } else {
            header("Location: perfil.php?mensaje=error");
        }
    } else {
        header("Location: perfil.php");
    }
}
?>