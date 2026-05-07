<?php
session_start();
$conexion = mysqli_connect("localhost", "root", "", "peluqueria_db");

if (!$conexion) {
    die("Error al conectar: " . mysqli_connect_error());
}

mysqli_set_charset($conexion, "utf8");

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

$nombre    = isset($_POST['nombre']) ? mysqli_real_escape_string($conexion, $_POST['nombre']) : '';
$servicio  = isset($_POST['servicio']) ? mysqli_real_escape_string($conexion, $_POST['servicio']) : '';
$fecha     = isset($_POST['fecha']) ? mysqli_real_escape_string($conexion, $_POST['fecha']) : '';
$hora      = isset($_POST['hora']) ? mysqli_real_escape_string($conexion, $_POST['hora']) : '';
$peluquero = isset($_POST['peluquero']) ? mysqli_real_escape_string($conexion, $_POST['peluquero']) : 'No asignado';
$telefono  = isset($_POST['telefono']) ? mysqli_real_escape_string($conexion, $_POST['telefono']) : '';

if (!preg_match('/^[679][0-9]{8}$/', $telefono)) {
    echo "<script>alert('Error: El teléfono debe tener 9 dígitos y empezar por 6, 7 o 9.'); window.history.back();</script>";
    exit();
}

if (!empty($telefono)) {
    $check_tel = mysqli_query($conexion, "SELECT user_id FROM clientes WHERE telefono = '$telefono' LIMIT 1");
    $registro_existente = mysqli_fetch_assoc($check_tel);

    if ($registro_existente && $registro_existente['user_id'] != $user_id && $registro_existente['user_id'] != 0) {
        echo "<script>alert('Error: Este número de teléfono ya está vinculado a otra cuenta de usuario.'); window.history.back();</script>";
        exit();
    }
}

$duraciones = [
    "Corte" => 20,
    "Tinte" => 45,
    "Barba" => 15,
    "Completo" => 35
];
$minutos_duracion = isset($duraciones[$servicio]) ? $duraciones[$servicio] : 30;
$hora_fin_estimada = date("H:i:s", strtotime("+$minutos_duracion minutes", strtotime($hora)));

$fecha_actual = date("Y-m-d");
$dia_semana = date('N', strtotime($fecha)); 
$hora_solo = intval(substr($hora, 0, 2));

if ($fecha < $fecha_actual) {
    echo "<script>alert('Error: No puedes reservar en una fecha pasada.'); window.history.back();</script>";
    exit();
}

if ($dia_semana > 5) {
    echo "<script>alert('Error: La peluquería está cerrada los fines de semana.'); window.history.back();</script>";
    exit();
}

if ($hora_solo < 9 || $hora_solo >= 20) {
    echo "<script>alert('Error: Nuestro horario es de 09:00 a 20:00.'); window.history.back();</script>";
    exit();
}

$sql_solapamiento = "SELECT * FROM citas 
                     WHERE fecha = '$fecha' 
                     AND peluquero = '$peluquero'
                     AND (
                         ('$hora' >= hora AND '$hora' < hora_fin_estimada) OR
                         ('$hora_fin_estimada' > hora AND '$hora_fin_estimada' <= hora_fin_estimada) OR
                         (hora >= '$hora' AND hora < '$hora_fin_estimada')
                     )";

$comprobar = mysqli_query($conexion, $sql_solapamiento);

if (mysqli_num_rows($comprobar) > 0) {
    echo "<script>alert('Lo sentimos, el peluquero está ocupado en ese rango de tiempo (esta cita dura $minutos_duracion min). Elige otra hora.'); window.history.back();</script>";
    exit();
}

$puntos_a_sumar = 0;
switch ($servicio) {
    case 'Corte': $puntos_a_sumar = 15; break;
    case 'Tinte': $puntos_a_sumar = 30; break;
    case 'Barba': $puntos_a_sumar = 10; break;
    case 'Completo': $puntos_a_sumar = 22; break;
}

if (!empty($telefono)) {
    $sql_cliente = "INSERT INTO clientes (user_id, telefono, nombre, puntos) 
                    VALUES ('$user_id', '$telefono', '$nombre', '$puntos_a_sumar')
                    ON DUPLICATE KEY UPDATE 
                    puntos = puntos + $puntos_a_sumar,
                    user_id = '$user_id'";
    mysqli_query($conexion, $sql_cliente);
}

$sql = "INSERT INTO citas (user_id, nombre_cliente, telefono, servicio, peluquero, fecha, hora, hora_fin_estimada) 
        VALUES ('$user_id', '$nombre', '$telefono', '$servicio', '$peluquero', '$fecha', '$hora', '$hora_fin_estimada')";

if (mysqli_query($conexion, $sql)) {
    header("Location: confirmacion.php");
    exit();
} else {
    die("Error crítico en la base de datos: " . mysqli_error($conexion));
}

mysqli_close($conexion);
?>