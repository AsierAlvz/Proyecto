<?php
$conexion = mysqli_connect("localhost", "root", "", "peluqueria_db");

$fecha = $_GET['fecha'];
$peluquero = $_GET['peluquero'];
$servicio = $_GET['servicio'];

$duraciones = ["Corte" => 20, "Tinte" => 45, "Barba" => 15, "Completo" => 60];
$duracion_actual = $duraciones[$servicio] ?? 30;

$dia_semana = date('N', strtotime($fecha)); // 1 (Lunes) a 7 (Domingo)

if ($dia_semana == 7) {
    echo json_encode([]);
    exit;
}

if ($dia_semana == 6) { 
    // Sábados: 09:00 a 14:00
    $inicio_h = "09:00";
    $fin_h = "14:00";
} else { 
    // Lunes a Viernes: 10:00 - 20:00
    $inicio_h = "10:00";
    $fin_h = "20:00";
}
// -------------------------------------------------------

$sql = "SELECT hora, hora_fin_estimada FROM citas WHERE fecha = '$fecha' AND peluquero = '$peluquero'";
$res = mysqli_query($conexion, $sql);
$ocupadas = [];
while($fila = mysqli_fetch_assoc($res)) {
    $ocupadas[] = $fila;
}

$posibles = [];
$inicio = strtotime($inicio_h);
$fin = strtotime($fin_h);

for ($i = $inicio; $i <= $fin; $i = strtotime("+15 minutes", $i)) {
    $hora_evaluar = date("H:i:s", $i);
    $hora_fin_evaluar = date("H:i:s", strtotime("+$duracion_actual minutes", $i));
    
    if (strtotime($hora_fin_evaluar) > $fin) {
        continue; 
    }

    $libre = true;
    foreach ($ocupadas as $cita) {
        if (
            ($hora_evaluar >= $cita['hora'] && $hora_evaluar < $cita['hora_fin_estimada']) ||
            ($hora_fin_evaluar > $cita['hora'] && $hora_fin_evaluar <= $cita['hora_fin_estimada']) ||
            ($hora_evaluar <= $cita['hora'] && $hora_fin_evaluar >= $cita['hora_fin_estimada'])
        ) {
            $libre = false;
            break;
        }
    }
    
    if ($libre) {
        $posibles[] = date("H:i", $i);
    }
}

echo json_encode($posibles);
?>