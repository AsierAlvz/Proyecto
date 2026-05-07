<?php
Fob_start(); 

ini_set('display_errors', 1);
error_reporting(E_ALL);

require('fpdf/fpdf.php');
$conexion = mysqli_connect("localhost", "root", "", "peluqueria_db");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

mysqli_set_charset($conexion, "utf8");

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM citas WHERE id = $id";
} else {
    $sql = "SELECT * FROM citas ORDER BY id DESC LIMIT 1";
}

$resultado = mysqli_query($conexion, $sql);

if (!$resultado || mysqli_num_rows($resultado) == 0) {
    $cita = [
        'nombre_cliente' => 'Sin datos / Prueba',
        'telefono' => '',
        'servicio' => 'Ninguno',
        'peluquero' => 'No asignado',
        'fecha' => date("Y-m-d"),
        'hora' => '00:00'
    ];
} else {
    $cita = mysqli_fetch_assoc($resultado);
}

$total_puntos = 0; 
if (!empty($cita['telefono'])) {
    $tel = $cita['telefono'];
    $res_puntos = mysqli_query($conexion, "SELECT puntos FROM clientes WHERE telefono = '$tel'");
    if ($fila_p = mysqli_fetch_assoc($res_puntos)) {
        $total_puntos = $fila_p['puntos'];
    }
}
// -----------------------------------------------

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFillColor(40, 40, 40);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(0, 20, utf8_decode('TICKET DE RESERVA - PELUQUERÍA ASIER'), 0, 1, 'C', true);

$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);

$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(230, 230, 230); 

$pdf->Cell(45, 12, utf8_decode('Cliente:'), 1, 0, 'L', true);
$pdf->SetFont('Arial', '', 12);
$nombre_a_imprimir = isset($cita['nombre_cliente']) ? $cita['nombre_cliente'] : (isset($cita['nombre']) ? $cita['nombre'] : 'Desconocido');
$pdf->Cell(0, 12, utf8_decode($nombre_a_imprimir), 1, 1, 'L');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(45, 12, utf8_decode('Servicio:'), 1, 0, 'L', true);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 12, utf8_decode($cita['servicio']), 1, 1, 'L');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(45, 12, utf8_decode('Atendido por:'), 1, 0, 'L', true);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 12, utf8_decode($cita['peluquero']), 1, 1, 'L');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(45, 12, utf8_decode('Puntos Totales:'), 1, 0, 'L', true);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 12, $total_puntos . " pts", 1, 1, 'L');

if ($total_puntos >= 100) {
    $pdf->SetTextColor(200, 0, 0);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, utf8_decode('¡TIENES UN SERVICIO GRATIS DISPONIBLE!'), 0, 1, 'C');
    $pdf->SetTextColor(0, 0, 0);
}

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(45, 12, utf8_decode('Fecha de cita:'), 1, 0, 'L', true);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 12, date("d/m/Y", strtotime($cita['fecha'])), 1, 1, 'L');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(45, 12, utf8_decode('Hora reservada:'), 1, 0, 'L', true);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 12, substr($cita['hora'], 0, 5) . " h", 1, 1, 'L');

$pdf->Ln(20);
$pdf->SetFont('Arial', 'I', 11);
$pdf->MultiCell(0, 8, utf8_decode("Por favor, acuda al establecimiento 5 minutos antes.\nSi necesita cancelar, llame con antelación al 987 654 321.\n\n¡Gracias por su confianza!"), 0, 'C');

ob_end_clean();
$pdf->Output();
?>