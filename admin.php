<<<<<<< HEAD
<?php
session_start();

// 1. COMPROBACIÓN: Si NO existe la sesión, al login.
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// 2. CONEXIÓN A LA BASE DE DATOS
$conexion = mysqli_connect("localhost", "root", "", "peluqueria_db");
mysqli_set_charset($conexion, "utf8");

// LÓGICA DE LIMPIEZA AUTOMÁTICA
$fecha_hoy = date("Y-m-d");
$hora_ahora = date("H:i:s");

// Borra citas de días anteriores O citas de hoy que ya hayan terminado (hora_fin_estimada pasada)
$sql_limpieza = "DELETE FROM citas 
                 WHERE (fecha < '$fecha_hoy') 
                 OR (fecha = '$fecha_hoy' AND hora_fin_estimada < '$hora_ahora')";
mysqli_query($conexion, $sql_limpieza);
// ---------------------------------------------------------------------

// LÓGICA DE CANJE DE PUNTOS
if (isset($_GET['canjear']) && isset($_GET['tel'])) {
    $tel = mysqli_real_escape_string($conexion, $_GET['tel']);
    // Restamos 100 puntos si tiene suficientes
    mysqli_query($conexion, "UPDATE clientes SET puntos = puntos - 100 WHERE telefono = '$tel' AND puntos >= 100");
    header("Location: admin.php?mensaje=canjeado");
    exit();
}

// 3. CONSULTA DE CITAS
$resultado = mysqli_query($conexion, "SELECT * FROM citas ORDER BY fecha ASC, hora ASC");

// 4. CONSULTA DE CLIENTES 
$resultado_clientes = mysqli_query($conexion, "SELECT * FROM clientes ORDER BY puntos DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control - Peluquería Asier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { 
            background: linear-gradient(135deg, #1a1d20 0%, #212529 100%);
            min-height: 100vh;
            color: white;
            padding-bottom: 80px;
        }
        .admin-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .table { color: white !important; }
        .table-dark { --bs-table-bg: rgba(0,0,0,0.3); }
        .section-title { 
            border-left: 5px solid #ffc107; 
            padding-left: 15px; 
            margin-top: 40px; 
            margin-bottom: 25px;
            font-weight: bold;
        }
        .btn-icon { display: inline-flex; align-items: center; gap: 5px; }
        .badge-points { background: #ffc107; color: black; font-weight: bold; }
        
        .table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.05) !important;
            transition: 0.3s;
        }
        
        .alert { border: none; border-radius: 10px; }

        .footer-nav {
            margin-top: 20px;
            margin-bottom: 50px;
        }

        .search-container {
            max-width: 400px;
            margin-bottom: 20px;
        }
        .search-input {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            color: white !important;
        }
        .search-input::placeholder { color: rgba(255,255,255,0.5); }
    </style>
</head>
<body class="container mt-5">

    <?php if(isset($_GET['mensaje'])): ?>
        <div class="alert <?php echo $_GET['mensaje'] == 'borrado' ? 'alert-danger' : 'alert-info'; ?> alert-dismissible fade show shadow" role="alert">
            <?php if($_GET['mensaje'] == 'borrado'): ?>
                <i class="fas fa-trash-alt"></i> Cita eliminada correctamente.
            <?php else: ?>
                <i class="fas fa-gift"></i> ¡Puntos canjeados! Regalo entregado al cliente.
            <?php endif; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-0 text-warning"><i class="fas fa-user-shield"></i> Panel Admin</h1>
            <p class="text-white-50">Bienvenido al centro de gestión de Peluquería Asier</p>
        </div>
        <div class="btn-group shadow">
            <a href="logout.php" class="btn btn-danger btn-icon">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </a>
        </div>
    </div>

    <div class="search-container">
        <div class="input-group shadow-sm">
            <span class="input-group-text bg-warning border-0"><i class="fas fa-search"></i></span>
            <input type="text" id="buscadorInput" class="form-control search-input" placeholder="Buscar cliente por nombre..." onkeyup="filtrarTablas()">
        </div>
    </div>
    <h2 class="section-title">Próximas Citas</h2>
    <div class="admin-card shadow">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" id="tablaCitas">
                <thead class="text-warning">
                    <tr>
                        <th>Cliente</th>
                        <th>Teléfono</th>
                        <th>Servicio</th>
                        <th>Peluquero/a</th>
                        <th>Fecha</th>
                        <th class="text-center">Hora</th>
                        <th class="text-center">Ticket</th> 
                        <th class="text-center">Acción</th>
                    </tr>
                </thead>
                <tbody>
            <?php 
            if ($resultado && mysqli_num_rows($resultado) > 0) {
                while($fila = mysqli_fetch_assoc($resultado)): 
                    $id_actual = $fila['id'] ?? null;
                    $nombre_mostrar = !empty($fila['nombre_cliente']) ? $fila['nombre_cliente'] : ($fila['nombre'] ?? 'Desconocido');
                    $fecha_formateada = date("d/m/Y", strtotime($fila['fecha']));
                    $hora_exacta = date("H:i", strtotime($fila['hora']));
                ?>
                <tr>
                    <td class="fw-bold nombre-cliente"><?php echo htmlspecialchars($nombre_mostrar); ?></td>
                    <td><small class="text-white-50"><?php echo $fila['telefono'] ?? '---'; ?></small></td>
                    <td><span class="badge rounded-pill bg-warning text-dark"><?php echo htmlspecialchars($fila['servicio']); ?></span></td>
                    <td><i class="fas fa-user-tie text-white-50 me-1"></i> <?php echo htmlspecialchars($fila['peluquero']); ?></td>
                    <td><?php echo $fecha_formateada; ?></td>
                    <td class="text-center fw-bold text-warning"><?php echo $hora_exacta; ?></td>
                    <td class="text-center">
                        <?php if($id_actual): ?>
                            <a href="ticket.php?id=<?php echo $id_actual; ?>" class="btn btn-outline-info btn-sm" target="_blank">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <?php if($id_actual): ?>
                            <a href="borrar.php?id=<?php echo $id_actual; ?>" 
                               class="btn btn-outline-danger btn-sm" 
                               onclick="return confirm('¿Eliminar cita de <?php echo addslashes($nombre_mostrar); ?>?')">
                               <i class="fas fa-times"></i>
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; 
            } else {
                echo "<tr><td colspan='8' class='text-center py-4 text-white-50 italic'>No hay citas programadas.</td></tr>";
            }
            ?>
                </tbody>
            </table>
        </div>
    </div>

    <h2 class="section-title">Gestión de Clientes y Puntos</h2>
    <div class="admin-card shadow">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" id="tablaClientes">
                <thead class="text-warning">
                    <tr>
                        <th>Nombre Cliente</th>
                        <th>Teléfono</th>
                        <th class="text-center">Puntos Actuales</th>
                        <th class="text-center">Fidelización</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                if ($resultado_clientes && mysqli_num_rows($resultado_clientes) > 0) {
                    while($cliente = mysqli_fetch_assoc($resultado_clientes)): ?>
                    <tr>
                        <td class="nombre-cliente"><?php echo htmlspecialchars($cliente['nombre']); ?></td>
                        <td><?php echo $cliente['telefono']; ?></td>
                        <td class="text-center">
                            <span class="badge badge-points px-3 py-2"><?php echo $cliente['puntos']; ?> PTS</span>
                        </td>
                        <td class="text-center">
                            <?php if($cliente['puntos'] >= 100): ?>
                                <a href="admin.php?canjear=true&tel=<?php echo $cliente['telefono']; ?>" 
                                   class="btn btn-warning btn-sm fw-bold text-dark shadow-sm"
                                   onclick="return confirm('¿Canjear 100 puntos para <?php echo $cliente['nombre']; ?>?')">
                                    <i class="fas fa-gift"></i> CANJEAR REGALO
                                </a>
                            <?php else: ?>
                                <div class="progress" style="height: 10px; width: 120px; margin: 0 auto; background: rgba(255,255,255,0.1);">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $cliente['puntos']; ?>%;"></div>
                                </div>
                                <small class="text-white-50" style="font-size: 0.7rem;">Faltan <?php echo (100 - $cliente['puntos']); ?> para regalo</small>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; 
                } else {
                    echo "<tr><td colspan='4' class='text-center py-4 text-white-50'>Sin clientes registrados aún.</td></tr>";
                } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="footer-nav">
        <a href="index.php" class="btn btn-outline-warning btn-icon">
            <i class="fas fa-arrow-left"></i> Volver a la web
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    function filtrarTablas() {
        let input = document.getElementById("buscadorInput");
        let filter = input.value.toLowerCase();

        let tablas = ["tablaCitas", "tablaClientes"];
        
        tablas.forEach(function(idTabla) {
            let table = document.getElementById(idTabla);
            let tr = table.getElementsByTagName("tr");

            for (let i = 1; i < tr.length; i++) {
                let td = tr[i].getElementsByClassName("nombre-cliente")[0];
                if (td) {
                    let txtValue = td.textContent || td.innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        });
    }
    </script>
    </body>
=======
<?php
session_start();

// 1. COMPROBACIÓN: Si NO existe la sesión, al login.
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// 2. CONEXIÓN A LA BASE DE DATOS
$conexion = mysqli_connect("localhost", "root", "", "peluqueria_db");
mysqli_set_charset($conexion, "utf8");

// LÓGICA DE LIMPIEZA AUTOMÁTICA
$fecha_hoy = date("Y-m-d");
$hora_ahora = date("H:i:s");

// Borra citas de días anteriores O citas de hoy que ya hayan terminado (hora_fin_estimada pasada)
$sql_limpieza = "DELETE FROM citas 
                 WHERE (fecha < '$fecha_hoy') 
                 OR (fecha = '$fecha_hoy' AND hora_fin_estimada < '$hora_ahora')";
mysqli_query($conexion, $sql_limpieza);
// ---------------------------------------------------------------------

// LÓGICA DE CANJE DE PUNTOS
if (isset($_GET['canjear']) && isset($_GET['tel'])) {
    $tel = mysqli_real_escape_string($conexion, $_GET['tel']);
    // Restamos 100 puntos si tiene suficientes
    mysqli_query($conexion, "UPDATE clientes SET puntos = puntos - 100 WHERE telefono = '$tel' AND puntos >= 100");
    header("Location: admin.php?mensaje=canjeado");
    exit();
}

// 3. CONSULTA DE CITAS
$resultado = mysqli_query($conexion, "SELECT * FROM citas ORDER BY fecha ASC, hora ASC");

// 4. CONSULTA DE CLIENTES 
$resultado_clientes = mysqli_query($conexion, "SELECT * FROM clientes ORDER BY puntos DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control - Peluquería Asier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { 
            background: linear-gradient(135deg, #1a1d20 0%, #212529 100%);
            min-height: 100vh;
            color: white;
            padding-bottom: 80px;
        }
        .admin-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .table { color: white !important; }
        .table-dark { --bs-table-bg: rgba(0,0,0,0.3); }
        .section-title { 
            border-left: 5px solid #ffc107; 
            padding-left: 15px; 
            margin-top: 40px; 
            margin-bottom: 25px;
            font-weight: bold;
        }
        .btn-icon { display: inline-flex; align-items: center; gap: 5px; }
        .badge-points { background: #ffc107; color: black; font-weight: bold; }
        
        .table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.05) !important;
            transition: 0.3s;
        }
        
        .alert { border: none; border-radius: 10px; }

        .footer-nav {
            margin-top: 20px;
            margin-bottom: 50px;
        }

        .search-container {
            max-width: 400px;
            margin-bottom: 20px;
        }
        .search-input {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            color: white !important;
        }
        .search-input::placeholder { color: rgba(255,255,255,0.5); }
    </style>
</head>
<body class="container mt-5">

    <?php if(isset($_GET['mensaje'])): ?>
        <div class="alert <?php echo $_GET['mensaje'] == 'borrado' ? 'alert-danger' : 'alert-info'; ?> alert-dismissible fade show shadow" role="alert">
            <?php if($_GET['mensaje'] == 'borrado'): ?>
                <i class="fas fa-trash-alt"></i> Cita eliminada correctamente.
            <?php else: ?>
                <i class="fas fa-gift"></i> ¡Puntos canjeados! Regalo entregado al cliente.
            <?php endif; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-0 text-warning"><i class="fas fa-user-shield"></i> Panel Admin</h1>
            <p class="text-white-50">Bienvenido al centro de gestión de Peluquería Asier</p>
        </div>
        <div class="btn-group shadow">
            <a href="logout.php" class="btn btn-danger btn-icon">
                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
            </a>
        </div>
    </div>

    <div class="search-container">
        <div class="input-group shadow-sm">
            <span class="input-group-text bg-warning border-0"><i class="fas fa-search"></i></span>
            <input type="text" id="buscadorInput" class="form-control search-input" placeholder="Buscar cliente por nombre..." onkeyup="filtrarTablas()">
        </div>
    </div>
    <h2 class="section-title">Próximas Citas</h2>
    <div class="admin-card shadow">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" id="tablaCitas">
                <thead class="text-warning">
                    <tr>
                        <th>Cliente</th>
                        <th>Teléfono</th>
                        <th>Servicio</th>
                        <th>Peluquero/a</th>
                        <th>Fecha</th>
                        <th class="text-center">Hora</th>
                        <th class="text-center">Ticket</th> 
                        <th class="text-center">Acción</th>
                    </tr>
                </thead>
                <tbody>
            <?php 
            if ($resultado && mysqli_num_rows($resultado) > 0) {
                while($fila = mysqli_fetch_assoc($resultado)): 
                    $id_actual = $fila['id'] ?? null;
                    $nombre_mostrar = !empty($fila['nombre_cliente']) ? $fila['nombre_cliente'] : ($fila['nombre'] ?? 'Desconocido');
                    $fecha_formateada = date("d/m/Y", strtotime($fila['fecha']));
                    $hora_exacta = date("H:i", strtotime($fila['hora']));
                ?>
                <tr>
                    <td class="fw-bold nombre-cliente"><?php echo htmlspecialchars($nombre_mostrar); ?></td>
                    <td><small class="text-white-50"><?php echo $fila['telefono'] ?? '---'; ?></small></td>
                    <td><span class="badge rounded-pill bg-warning text-dark"><?php echo htmlspecialchars($fila['servicio']); ?></span></td>
                    <td><i class="fas fa-user-tie text-white-50 me-1"></i> <?php echo htmlspecialchars($fila['peluquero']); ?></td>
                    <td><?php echo $fecha_formateada; ?></td>
                    <td class="text-center fw-bold text-warning"><?php echo $hora_exacta; ?></td>
                    <td class="text-center">
                        <?php if($id_actual): ?>
                            <a href="ticket.php?id=<?php echo $id_actual; ?>" class="btn btn-outline-info btn-sm" target="_blank">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <?php if($id_actual): ?>
                            <a href="borrar.php?id=<?php echo $id_actual; ?>" 
                               class="btn btn-outline-danger btn-sm" 
                               onclick="return confirm('¿Eliminar cita de <?php echo addslashes($nombre_mostrar); ?>?')">
                               <i class="fas fa-times"></i>
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; 
            } else {
                echo "<tr><td colspan='8' class='text-center py-4 text-white-50 italic'>No hay citas programadas.</td></tr>";
            }
            ?>
                </tbody>
            </table>
        </div>
    </div>

    <h2 class="section-title">Gestión de Clientes y Puntos</h2>
    <div class="admin-card shadow">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0" id="tablaClientes">
                <thead class="text-warning">
                    <tr>
                        <th>Nombre Cliente</th>
                        <th>Teléfono</th>
                        <th class="text-center">Puntos Actuales</th>
                        <th class="text-center">Fidelización</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                if ($resultado_clientes && mysqli_num_rows($resultado_clientes) > 0) {
                    while($cliente = mysqli_fetch_assoc($resultado_clientes)): ?>
                    <tr>
                        <td class="nombre-cliente"><?php echo htmlspecialchars($cliente['nombre']); ?></td>
                        <td><?php echo $cliente['telefono']; ?></td>
                        <td class="text-center">
                            <span class="badge badge-points px-3 py-2"><?php echo $cliente['puntos']; ?> PTS</span>
                        </td>
                        <td class="text-center">
                            <?php if($cliente['puntos'] >= 100): ?>
                                <a href="admin.php?canjear=true&tel=<?php echo $cliente['telefono']; ?>" 
                                   class="btn btn-warning btn-sm fw-bold text-dark shadow-sm"
                                   onclick="return confirm('¿Canjear 100 puntos para <?php echo $cliente['nombre']; ?>?')">
                                    <i class="fas fa-gift"></i> CANJEAR REGALO
                                </a>
                            <?php else: ?>
                                <div class="progress" style="height: 10px; width: 120px; margin: 0 auto; background: rgba(255,255,255,0.1);">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $cliente['puntos']; ?>%;"></div>
                                </div>
                                <small class="text-white-50" style="font-size: 0.7rem;">Faltan <?php echo (100 - $cliente['puntos']); ?> para regalo</small>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; 
                } else {
                    echo "<tr><td colspan='4' class='text-center py-4 text-white-50'>Sin clientes registrados aún.</td></tr>";
                } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="footer-nav">
        <a href="index.php" class="btn btn-outline-warning btn-icon">
            <i class="fas fa-arrow-left"></i> Volver a la web
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    function filtrarTablas() {
        let input = document.getElementById("buscadorInput");
        let filter = input.value.toLowerCase();

        let tablas = ["tablaCitas", "tablaClientes"];
        
        tablas.forEach(function(idTabla) {
            let table = document.getElementById(idTabla);
            let tr = table.getElementsByTagName("tr");

            for (let i = 1; i < tr.length; i++) {
                let td = tr[i].getElementsByClassName("nombre-cliente")[0];
                if (td) {
                    let txtValue = td.textContent || td.innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        });
    }
    </script>
    </body>
>>>>>>> 6d5ea9f0426fc98fdb6b4d482b1e0b3dd734b675
</html>