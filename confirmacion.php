<<<<<<< HEAD
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>¡Reserva Confirmada! - Peluquería Asier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { 
            background: linear-gradient(135deg, #1a1d20 0%, #212529 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            color: white;
        }

        .card-success { 
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 25px; 
            padding: 50px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.5); 
            max-width: 500px;
            width: 90%;
            text-align: center;
        }

        .check-icon {
            font-size: 80px;
            color: #2ecc71;
            text-shadow: 0 0 20px rgba(46, 204, 113, 0.4);
            margin-bottom: 20px;
            display: inline-block;
            animation: bounceIn 1s ease;
        }

        @keyframes bounceIn {
            0% { transform: scale(0.3); opacity: 0; }
            50% { transform: scale(1.1); }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); opacity: 1; }
        }

        .btn-ticket {
            background-color: transparent;
            border: 2px solid #e74c3c;
            color: #e74c3c;
            font-weight: bold;
            padding: 12px;
            transition: all 0.3s;
            border-radius: 10px;
        }

        .btn-ticket:hover {
            background-color: #e74c3c;
            color: white;
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
        }

        .btn-home {
            background-color: #ffc107;
            color: black;
            font-weight: bold;
            border: none;
            padding: 12px;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .btn-home:hover {
            background-color: #e5ac00;
            transform: translateY(-2px);
        }

        .divider {
            height: 1px;
            background: rgba(255,255,255,0.1);
            margin: 25px 0;
        }
    </style>
</head>
<body>

    <div class="card-success">
        <div class="check-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        
        <h2 class="fw-bold mb-3">¡Reserva Confirmada!</h2>
        <p class="text-white-50 mb-4">
            Gracias por confiar en nosotros. Tu cita ha sido registrada correctamente en nuestro sistema.
        </p>

        <div class="alert alert-dark mb-4" style="background: rgba(255,255,255,0.05); border: 1px dashed rgba(255,255,255,0.2);">
            <p class="small mb-0 text-warning">
                <i class="fas fa-star"></i> ¡No olvides que ya has sumado puntos para tu próximo servicio gratis!
            </p>
        </div>
        
        <div class="mb-3">
            <a href="ticket.php" class="btn btn-ticket w-100">
                <i class="fas fa-file-pdf"></i> DESCARGAR TICKET PDF
            </a>
        </div>

        <div class="divider"></div>

        <a href="index.php" class="btn btn-home w-100">
            <i class="fas fa-home"></i> VOLVER AL INICIO
        </a>
    </div>

</body>
=======
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>¡Reserva Confirmada! - Peluquería Asier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { 
            background: linear-gradient(135deg, #1a1d20 0%, #212529 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            color: white;
        }

        .card-success { 
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 25px; 
            padding: 50px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.5); 
            max-width: 500px;
            width: 90%;
            text-align: center;
        }

        .check-icon {
            font-size: 80px;
            color: #2ecc71;
            text-shadow: 0 0 20px rgba(46, 204, 113, 0.4);
            margin-bottom: 20px;
            display: inline-block;
            animation: bounceIn 1s ease;
        }

        @keyframes bounceIn {
            0% { transform: scale(0.3); opacity: 0; }
            50% { transform: scale(1.1); }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); opacity: 1; }
        }

        .btn-ticket {
            background-color: transparent;
            border: 2px solid #e74c3c;
            color: #e74c3c;
            font-weight: bold;
            padding: 12px;
            transition: all 0.3s;
            border-radius: 10px;
        }

        .btn-ticket:hover {
            background-color: #e74c3c;
            color: white;
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
        }

        .btn-home {
            background-color: #ffc107;
            color: black;
            font-weight: bold;
            border: none;
            padding: 12px;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .btn-home:hover {
            background-color: #e5ac00;
            transform: translateY(-2px);
        }

        .divider {
            height: 1px;
            background: rgba(255,255,255,0.1);
            margin: 25px 0;
        }
    </style>
</head>
<body>

    <div class="card-success">
        <div class="check-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        
        <h2 class="fw-bold mb-3">¡Reserva Confirmada!</h2>
        <p class="text-white-50 mb-4">
            Gracias por confiar en nosotros. Tu cita ha sido registrada correctamente en nuestro sistema.
        </p>

        <div class="alert alert-dark mb-4" style="background: rgba(255,255,255,0.05); border: 1px dashed rgba(255,255,255,0.2);">
            <p class="small mb-0 text-warning">
                <i class="fas fa-star"></i> ¡No olvides que ya has sumado puntos para tu próximo servicio gratis!
            </p>
        </div>
        
        <div class="mb-3">
            <a href="ticket.php" class="btn btn-ticket w-100">
                <i class="fas fa-file-pdf"></i> DESCARGAR TICKET PDF
            </a>
        </div>

        <div class="divider"></div>

        <a href="index.php" class="btn btn-home w-100">
            <i class="fas fa-home"></i> VOLVER AL INICIO
        </a>
    </div>

</body>
>>>>>>> 6d5ea9f0426fc98fdb6b4d482b1e0b3dd734b675
</html>