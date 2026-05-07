<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$conexion = mysqli_connect("localhost", "root", "", "peluqueria_db");
if (!$conexion) {
    die("Error de conexión");
}
mysqli_set_charset($conexion, "utf8");

$user_id = $_SESSION['user_id'];
$nombre_sesion = $_SESSION['usuario'];

$res_cliente = mysqli_query($conexion, "SELECT nombre, puntos, telefono FROM clientes WHERE user_id = '$user_id'");
$fila = mysqli_fetch_assoc($res_cliente);

$puntos = ($fila) ? $fila['puntos'] : 0;
$nombre_cliente = ($fila) ? $fila['nombre'] : $nombre_sesion;
$telefono_cliente = ($fila) ? $fila['telefono'] : '';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Puntos y Citas - Peluquería Asier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { 
            background: linear-gradient(135deg, #1a1d20 0%, #212529 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            color: white;
            margin: 0;
        }
        
        .card { 
            width: 100%; 
            max-width: 550px;
            border-radius: 20px; 
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
            margin: 40px auto;
            color: white;
        }

        .cita-item {
            background: rgba(255, 255, 255, 0.08) !important;
            border: none !important;
            border-left: 4px solid #ffc107 !important; 
            color: white !important;
            margin-bottom: 12px;
            border-radius: 10px !important;
            transition: 0.3s;
        }
        
        .cita-item:hover {
            transform: translateX(5px);
            background: rgba(255, 255, 255, 0.12) !important;
        }

        .progress {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            height: 25px;
        }

        .back-link {
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            transition: 0.3s;
        }

        .back-link:hover { color: #ffc107; }
    </style>
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="card p-4">
            <div class="text-center mb-4">
                <i class="fas fa-medal text-warning fa-3x mb-3"></i>
                <h2 class="fw-bold">Mis Puntos</h2>
                <p class="text-muted">Estado actual de tu cuenta</p>
            </div>

            <div class='p-4 rounded mb-4 text-center shadow-sm' style='background: rgba(255, 193, 7, 0.1); border: 1px solid rgba(255, 193, 7, 0.2);'>
                <h4 class='mb-1'>¡Hola, <?php echo htmlspecialchars($nombre_cliente); ?>!</h4>
                <div class='display-4 fw-bold text-warning mb-2'><?php echo $puntos; ?> <small style='font-size: 1.2rem;'>PTS</small></div>
                
                <?php 
                $porcentaje = min($puntos, 100); 
                ?>
                <div class="progress mb-3">
                    <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" role="progressbar" 
                         style="width: <?php echo $porcentaje; ?>%; color: black; font-weight: bold;" 
                         aria-valuenow="<?php echo $porcentaje; ?>" aria-valuemin="0" aria-valuemax="100">
                         <?php echo $porcentaje; ?>%
                    </div>
                </div>

                <?php if ($puntos >= 100): ?>
                    <div class='badge bg-success p-2 w-100'><i class='fas fa-trophy'></i> ¡REGALO LISTO PARA CANJEAR!</div>
                <?php else: ?>
                    <p class='small text-light mb-0'>Te faltan <span class='text-warning'><?php echo (100 - $puntos); ?> pts</span> para tu premio (Corte Gratis).</p>
                <?php endif; ?>
            </div>

            <div class='mt-2'>
                <h6 class='text-warning mb-3 fw-bold'><i class='fas fa-calendar-check'></i> MIS PRÓXIMAS CITAS</h6>
                <?php
                $res_citas = mysqli_query($conexion, "SELECT * FROM citas WHERE user_id = '$user_id' AND fecha >= CURDATE() ORDER BY fecha ASC, hora ASC");

                if (mysqli_num_rows($res_citas) > 0) {
                    echo "<div class='list-group'>";
                    while ($cita = mysqli_fetch_assoc($res_citas)) {
                        $f = date("d/m/Y", strtotime($cita['fecha']));
                        $h = substr($cita['hora'], 0, 5);
                        echo "<div class='list-group-item cita-item'>";
                        echo "<div class='d-flex w-100 justify-content-between'>";
                        echo "<h6 class='mb-1 text-warning fw-bold'>$f - $h</h6>";
                        echo "</div>";
                        echo "<p class='mb-0 small' style='opacity: 0.8;'><b>" . $cita['servicio'] . "</b> con <b>" . $cita['peluquero'] . "</b></p>";
                        echo "</div>";
                    }
                    echo "</div>";
                } else {
                    echo "<div class='text-center py-3'><p class='text-muted small italic'>No tienes citas pendientes.</p></div>";
                }
                ?>
            </div>

            <div class="text-center mt-4 border-top pt-3" style="border-color: rgba(255,255,255,0.1) !important;">
                <a href="index.php" class="back-link">
                    <i class="fas fa-arrow-left"></i> Volver al Inicio
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>