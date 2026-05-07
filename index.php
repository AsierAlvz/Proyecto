<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Peluquería Asier - Estilo y Elegancia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #fcfcfc;
        }
        
        .navbar { margin-bottom: 0 !important; }

        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1560066984-138dadb4c035?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
            padding: 160px 0;
            text-align: center;
            margin-top: 0;
        }

        .hero-section h1 {
            letter-spacing: 2px;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.5);
        }

        /* CARDS DE SERVICIOS */
        .service-card { 
            transition: all 0.4s ease; 
            border: none; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.05); 
            border-radius: 15px;
            background: #fff;
        }
        .service-card:hover { 
            transform: translateY(-15px); 
            box-shadow: 0 15px 45px rgba(0,0,0,0.15);
            background: #212529;
            color: white;
        }
        .service-card:hover .text-muted { color: #aaa !important; }
        .service-card:hover .text-primary { color: #ffc107 !important; }

        .features {
            background-color: #212529;
            color: white;
            padding: 80px 0;
        }

        .team-icon-container {
            width: 80px;
            height: 80px;
            background: #f8f9fa;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            transition: 0.3s;
        }
        .service-card:hover .team-icon-container {
            background: #343a40;
        }

        footer {
            border-top: 3px solid #ffc107;
        }

        .product-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 193, 7, 0.1) !important;
            box-shadow: 0 10px 20px rgba(0,0,0,0.5) !important;
            border-color: #ffc107 !important;
        }
        .social-icon {
            transition: color 0.3s ease;
            text-decoration: none;
        }
        .social-icon:hover {
            color: #ffc107 !important; /* El amarillo de tu marca */
        }
    </style>
</head>
<body>

<?php 
session_start(); 
include 'navbar.php'; 
?>

    <header class="hero-section">
        <div class="container">
            <h1 class="display-2 fw-bold mb-3">Tu mejor estilo comienza aquí</h1>
            <p class="lead fs-4 mb-5">Expertos en cortes modernos, degradados y el cuidado más exclusivo para tu barba.</p>
            
            <a href="reservar.php" class="btn btn-warning btn-lg px-5 py-3 fw-bold shadow">RESERVAR CITA AHORA</a>
        </div>
    </header>

    <section class="features text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <i class="fas fa-certificate fa-3x mb-3 text-warning"></i>
                    <h4>Calidad Garantizada</h4>
                    <p class="text-muted">Productos de primera línea para tu cabello.</p>
                </div>
                <div class="col-md-4">
                    <i class="fas fa-clock fa-3x mb-3 text-warning"></i>
                    <h4>Sin Esperas</h4>
                    <p class="text-muted">Reserva online y te atenderemos puntual.</p>
                </div>
                <div class="col-md-4">
                    <i class="fas fa-medal fa-3x mb-3 text-warning"></i>
                    <h4>Puntos VIP</h4>
                    <p class="text-muted">Cada visita te acerca a un servicio gratis.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="container my-5 pt-5">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">Nuestros Servicios</h2>
            <div class="mx-auto" style="width: 80px; height: 4px; background: #ffc107;"></div>
        </div>
        <div class="row text-center">
            <div class="col-md-3 mb-4">
                <div class="card service-card p-4 h-100">
                    <i class="fas fa-cut fa-2x mb-3 text-primary"></i>
                    <h3>Corte</h3>
                    <p class="text-muted">Estilo personalizado para ti.</p>
                    <span class="h4 text-primary">15€</span>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card service-card p-4 h-100">
                    <i class="fas fa-fill-drip fa-2x mb-3 text-primary"></i>
                    <h3>Tinte</h3>
                    <p class="text-muted">Coloración profesional.</p>
                    <span class="h4 text-primary">30€</span>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card service-card p-4 h-100">
                    <i class="fas fa-razor fa-2x mb-3 text-primary"></i>
                    <h3>Barba</h3>
                    <p class="text-muted">Perfilado y cuidado VIP.</p>
                    <span class="h4 text-primary">10€</span>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card service-card p-4 h-100">
                    <i class="fas fa-mustache fa-2x mb-3 text-primary"></i>
                    <h3>Pack Completo</h3>
                    <p class="text-muted">Corte + Barba</p>
                    <span class="h4 text-primary">22€</span>
                </div>
            </div>
        </div>
    </section>

   <section class="bg-light py-5">
    <div class="container my-5 pb-5">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold">Conoce a Nuestro Equipo</h2>
            <p class="text-muted">Profesionales apasionados por la barbería clásica y moderna.</p>
        </div>
        <div class="row text-center justify-content-center">
            <div class="col-md-4 mb-4">
                <div class="card service-card p-4">
                    <div class="team-icon-container shadow-sm">
                        <i class="fas fa-user-tie fa-2x text-primary"></i>
                    </div>
                    <h4>Ronie</h4>
                    <p class="text-muted small">Especialista en degradados y cortes modernos.</p>
                    <div class="social-links">
                        <a href="https://www.instagram.com" target="_blank" class="text-dark social-icon"><i class="fab fa-instagram me-2"></i></a>
                        <a href="https://www.facebook.com" target="_blank" class="text-dark social-icon"><i class="fab fa-facebook"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card service-card p-4">
                    <div class="team-icon-container shadow-sm">
                        <i class="fas fa-user-astronaut fa-2x text-primary"></i>
                    </div>
                    <h4>Ana</h4>
                    <p class="text-muted small">Experta en coloración y tratamientos de tinte.</p>
                    <div class="social-links">
                        <a href="https://www.instagram.com" target="_blank" class="text-dark social-icon"><i class="fab fa-instagram me-2"></i></a>
                        <a href="https://www.facebook.com" target="_blank" class="text-dark social-icon"><i class="fab fa-facebook"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card service-card p-4">
                    <div class="team-icon-container shadow-sm">
                        <i class="fas fa-user-ninja fa-2x text-primary"></i>
                    </div>
                    <h4>Carlos</h4>
                    <p class="text-muted small">Maestro en perfilado de barba clásica y VIP.</p>
                    <div class="social-links">
                        <a href="https://www.instagram.com" target="_blank" class="text-dark social-icon"><i class="fab fa-instagram me-2"></i></a>
                        <a href="https://www.facebook.com" target="_blank" class="text-dark social-icon"><i class="fab fa-facebook"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <section class="py-5" style="background: #1a1d20;">
        <div class="container text-center py-4">
            <div class="p-5 shadow-lg" style="background: linear-gradient(145deg, #212529, #2c3034); border-radius: 30px; border: 1px solid rgba(255,193,7,0.3);">
                <div class="row align-items-center">
                    <div class="col-lg-7 text-lg-start text-center mb-4 mb-lg-0">
                        <h2 class="display-6 fw-bold text-white">¿Buscas algun producto que usamos?</h2>
                        <p class="lead text-white-50 mb-0">Explora nuestro catálogo completo de productos que utilizamos en nuestras sesiones de estilismo.</p>
                    </div>
                    <div class="col-lg-5 text-lg-end text-center">
                        <a href="tienda.php" class="btn btn-warning btn-lg px-5 py-3 fw-bold shadow-sm">
                            <i class="fas fa-shopping-cart me-2"></i> VER PRODUCTOS 
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="position-relative text-center">

    <footer class="bg-dark text-white text-center py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-4">
                    <h5 class="text-warning mb-3">Ubicación</h5>
                    <p class="small">Calle de la Elegancia, 123<br>Madrid, España</p>
                </div>
                <div class="col-md-4">
                    <h5 class="text-warning mb-3">Horario</h5>
                    <p class="small">Lunes a Viernes: 10:00 - 20:00<br>Sábados: 09:00 - 14:00</p>
                </div>
                <div class="col-md-4">
                    <h5 class="text-warning mb-3">Contacto</h5>
                    <p class="small">Tlf: 987 654 321<br>info@peluqueriaasier.com</p>
                </div>
            </div>
            <p class="mb-0 text-muted small">© 2026 - Peluquería Asier | Estilo y Distinción</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>