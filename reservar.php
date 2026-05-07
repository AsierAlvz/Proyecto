<?php 
session_start();
$conexion = mysqli_connect("localhost", "root", "", "peluqueria_db");

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php?msg=debes_loguearte");
    exit();
}

$user_id = $_SESSION['user_id'];
$check_cita = "SELECT * FROM citas WHERE user_id = '$user_id' LIMIT 1";
$resultado_cita = mysqli_query($conexion, $check_cita);

if (mysqli_num_rows($resultado_cita) > 0) {
    header("Location: confirmacion.php");
    exit();
}
// -----------------------------
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reserva tu Cita - Peluquería Asier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { 
            background: linear-gradient(135deg, #1a1d20 0%, #212529 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            color: white;
            padding-bottom: 50px;
            margin: 0; 
        }

        .navbar { margin-bottom: 0 !important; }
        
        .container { 
            margin-top: 30px !important; 
            max-width: 650px; 
            padding-top: 0; 
        }

        .card { 
            border-radius: 20px; 
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
            color: white;
        }

        .form-label {
            font-weight: 600;
            color: #ffc107;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 12px;
            border-radius: 10px;
        }

        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border-color: #ffc107;
            box-shadow: none;
        }

        option { background: #212529; color: white; }

        .btn-confirmar {
            background-color: #ffc107;
            border: none;
            color: #000;
            font-weight: bold;
            padding: 15px;
            border-radius: 10px;
            transition: all 0.3s;
            font-size: 1.1rem;
            letter-spacing: 1px;
        }

        .btn-confirmar:hover {
            background-color: #e5ac00;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 193, 7, 0.3);
        }

        .form-text { color: rgba(255, 255, 255, 0.5) !important; }
        .input-group-text {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffc107;
        }

        .loading-select { opacity: 0.5; cursor: wait; }
    </style>
</head>
<body>

    <div class="container">
        <div class="card p-4 shadow-lg">
            <div class="text-center mb-4">
                <i class="fas fa-calendar-check fa-3x text-warning mb-2"></i>
                <h2 class="fw-bold">Reserva tu Experiencia</h2>
                <p class="text-muted small">Cuidamos cada detalle de tu imagen.</p>
            </div>
            
            <?php if (isset($_SESSION['cita_realizada'])): ?>
                <div class="text-center py-4">
                    <div class="alert alert-dark border-secondary text-warning">
                        <i class="fas fa-info-circle me-2"></i>
                        Ya has solicitado una cita en esta sesión. ¡Te esperamos pronto!
                    </div>
                    <a href="index.php" class="btn btn-outline-light mt-2">Volver al Inicio</a>
                </div>

            <?php else: ?>
                <form action="guardar_cita.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-user"></i> Tu Nombre Completo</label>
                        <input type="text" name="nombre" class="form-control" value="<?php echo $_SESSION['usuario']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-phone"></i> Tu Teléfono Móvil</label>
                        <input type="number" name="telefono" class="form-control" placeholder="Ej: 600123456" required>
                        <div class="form-text">
                            <i class="fas fa-info-circle"></i> Acumula puntos con cada servicio. ¡100 pts = Servicio Gratis!
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-cut"></i> Servicio</label>
                            <select name="servicio" id="selectServicio" class="form-select" required>
                                <option value="" disabled selected>Selecciona...</option>
                                <option value="Corte">Corte - 15€</option>
                                <option value="Tinte">Tinte - 30€</option>
                                <option value="Barba">Barba - 10€</option>
                                <option value="Completo">Corte + Barba - 22€</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-user-tie"></i> Peluquero</label>
                            <select name="peluquero" id="selectPeluquero" class="form-select" required>
                                <option value="" disabled selected>Elige profesional...</option>
                                <option value="Ronie">Ronie (Degradados)</option>
                                <option value="Ana">Ana (Coloración)</option>
                                <option value="Carlos">Carlos (Barbería)</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-calendar-day"></i> Fecha</label>
                            <input type="date" name="fecha" id="inputFecha" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label"><i class="fas fa-clock"></i> Hora Disponible</label>
                            <select name="hora" id="selectHora" class="form-select" required disabled>
                                <option value="">Elige servicio, peluquero y fecha...</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-confirmar w-100 mb-3">
                        <i class="fas fa-check-circle"></i> CONFIRMAR MI RESERVA
                    </button>
                </form>
            <?php endif; ?>

            <div class="text-center">
                <a href="index.php" class="text-white-50 text-decoration-none small">
                    <i class="fas fa-arrow-left"></i> Volver al Inicio
                </a>
            </div>
        </div>
    </div>

    <script>
        const inputFecha = document.getElementById('inputFecha');
        const selectServicio = document.getElementById('selectServicio');
        const selectPeluquero = document.getElementById('selectPeluquero');
        const selectHora = document.getElementById('selectHora');

        const hoy = new Date().toISOString().split("T")[0];
        if(inputFecha) inputFecha.setAttribute('min', hoy);

        function cargarHorasLibres() {
            const servicio = selectServicio.value;
            const peluquero = selectPeluquero.value;
            const fechaStr = inputFecha.value;

            if (!fechaStr) return;

            const fechaObj = new Date(fechaStr);
            const diaSeleccionado = fechaObj.getUTCDay();

            if (diaSeleccionado === 0) {
                alert("Los domingos estamos cerrados. Por favor, elige un día de Lunes a Sábado.");
                inputFecha.value = "";
                selectHora.innerHTML = '<option value="">Día no disponible</option>';
                selectHora.disabled = true;
                return;
            }

            if (servicio && peluquero && fechaStr) {
                selectHora.disabled = true;
                selectHora.innerHTML = '<option>Buscando huecos libres...</option>';
                selectHora.classList.add('loading-select');

                fetch(`obtener_horas.php?fecha=${fechaStr}&peluquero=${peluquero}&servicio=${servicio}`)
                    .then(response => response.json())
                    .then(data => {
                        selectHora.innerHTML = '';
                        selectHora.classList.remove('loading-select');
                        
                        if (data.length > 0) {
                            selectHora.disabled = false;
                            data.forEach(hora => {
                                let option = document.createElement('option');
                                option.value = hora;
                                option.textContent = hora;
                                selectHora.appendChild(option);
                            });
                        } else {
                            selectHora.innerHTML = '<option value="">Sin huecos disponibles para esta duración</option>';
                            selectHora.disabled = true;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        selectHora.innerHTML = '<option value="">Error al conectar con el servidor</option>';
                    });
            }
        }

        if(selectServicio) selectServicio.addEventListener('change', cargarHorasLibres);
        if(selectPeluquero) selectPeluquero.addEventListener('change', cargarHorasLibres);
        if(inputFecha) inputFecha.addEventListener('change', cargarHorasLibres);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>