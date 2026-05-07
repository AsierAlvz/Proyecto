<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$conexion = mysqli_connect("localhost", "root", "", "peluqueria_db");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
mysqli_set_charset($conexion, "utf8");

$user_id = $_SESSION['user_id'];
$usuario_nombre = $_SESSION['usuario'];

$sql_cliente = "SELECT * FROM clientes WHERE user_id = '$user_id' LIMIT 1";
$res_cliente = mysqli_query($conexion, $sql_cliente);
$datos_cliente = mysqli_fetch_assoc($res_cliente);

$sql_cita = "SELECT id, fecha, hora, servicio, peluquero FROM citas WHERE user_id = '$user_id' AND fecha >= CURDATE() ORDER BY fecha ASC, hora ASC LIMIT 1";
$res_cita = mysqli_query($conexion, $sql_cita);
$proxima_cita = mysqli_fetch_assoc($res_cita);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Peluquería Asier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #1a1d20; color: white; font-family: 'Segoe UI', sans-serif; min-height: 100vh; }
        .perfil-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 40px;
            margin-top: 50px;
        }
        .avatar-circle {
            width: 80px; height: 80px;
            background: #ffc107;
            color: #000;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 20px;
        }
        .info-box {
            background: rgba(0, 0, 0, 0.2);
            padding: 20px;
            border-radius: 15px;
            height: 100%;
        }
        .text-gold { color: #ffc107; }
        .btn-cancelar {
            font-size: 0.8rem;
            padding: 5px 10px;
            transition: 0.3s;
        }
    </style>
</head>
<body>

    <?php 
    if(file_exists('navbar.php')) {
        include 'navbar.php';
    } else {
        echo "<div class='alert alert-danger m-3'>Error: No se encuentra navbar.php</div>";
    }
    ?>

    <div class="container">
        <?php if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'cancelada'): ?>
            <div class="alert alert-success alert-dismissible fade show mt-4 border-0 bg-success text-white" role="alert">
                <i class="fas fa-check-circle me-2"></i> Tu cita ha sido cancelada correctamente.
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="perfil-card shadow-lg">
            <div class="text-center mb-5">
                <div class="avatar-circle">
                    <i class="fas fa-user"></i>
                </div>
                <h2 class="fw-bold">Hola, <span class="text-gold"><?php echo htmlspecialchars($usuario_nombre); ?></span></h2>
                <p class="text-white-50">Gestiona tus datos y citas desde aquí</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="info-box border-top border-warning border-4">
                        <h5 class="text-gold mb-4"><i class="fas fa-id-card me-2"></i>Mis Datos</h5>
                        
                        <p class="mb-1 text-white-50 small">Nombre en reservas</p>
                        <p class="fw-bold fs-5"><?php echo $datos_cliente ? htmlspecialchars($datos_cliente['nombre']) : 'No registrado'; ?></p>

                        <p class="mb-1 text-white-50 small">Teléfono</p>
                        <p class="fw-bold fs-5"><?php echo $datos_cliente ? $datos_cliente['telefono'] : 'Sin vincular'; ?></p>

                        <p class="mb-1 text-white-50 small">Puntos acumulados</p>
                        <p class="fw-bold"><span class="badge bg-warning text-dark fs-6"><?php echo $datos_cliente ? $datos_cliente['puntos'] : 0; ?> PUNTOS</span></p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="info-box border-top border-info border-4">
                        <h5 class="text-info mb-4"><i class="fas fa-calendar-check me-2"></i>Próxima Cita</h5>

                        <?php if($proxima_cita): ?>
                            <div class="bg-dark p-3 rounded border border-secondary">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge bg-info text-dark">Confirmada</span>
                                    <span class="text-white-50 small"><?php echo date("d/m/Y", strtotime($proxima_cita['fecha'])); ?></span>
                                </div>
                                <h4 class="fw-bold mb-1"><?php echo substr($proxima_cita['hora'], 0, 5); ?> hs</h4>
                                <p class="text-info mb-3"><?php echo $proxima_cita['servicio']; ?></p>
                                <p class="mb-3 small"><i class="fas fa-user-tie me-2"></i>Barbero: <?php echo $proxima_cita['peluquero']; ?></p>
                                
                                <hr class="border-secondary opacity-25">
                                
                                <div class="text-end">
                                    <a href="cancelar_cita.php?id=<?php echo $proxima_cita['id']; ?>" 
                                       class="btn btn-outline-danger btn-cancelar"
                                       onclick="return confirm('¿Estás seguro de que deseas cancelar esta cita? Esta acción no se puede deshacer.')">
                                        <i class="fas fa-trash-alt me-1"></i> Cancelar Reserva
                                    </a>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-calendar-times fa-2x text-white-50 mb-3"></i>
                                <p class="text-white-50">No tienes ninguna cita pendiente.</p>
                                <a href="reservar.php" class="btn btn-outline-info btn-sm">Reservar ahora</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <hr class="opacity-10 mb-4">
                <a href="logout.php" class="btn btn-danger px-4 fw-bold shadow-sm">
                    <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>