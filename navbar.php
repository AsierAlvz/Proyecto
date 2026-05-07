<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-warning" href="index.php">
            <i class="fas fa-cut me-2"></i>PELUQUERÍA ASIER
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                
                <?php 
                $pagina_actual = basename($_SERVER['PHP_SELF']); 
                ?>

                <?php if ($pagina_actual !== 'index.php'): ?>
                <li class="nav-item me-2">
                    <a class="btn btn-outline-warning btn-sm fw-bold px-3" href="index.php">
                        <i class="fas fa-home me-1"></i> INICIO
                    </a>
                </li>
                <?php endif; ?>

                <?php 
                if ($pagina_actual !== 'tienda.php'): 
                ?>

                    <?php if(isset($_SESSION['usuario']) || isset($_SESSION['admin'])): ?>
                        
                        <?php if(!isset($_SESSION['admin'])): ?>
                        <li class="nav-item me-2">
                            <a class="btn btn-outline-warning btn-sm" href="consultar_puntos.php">
                                <i class="fas fa-star me-1"></i> Mis Puntos
                            </a>
                        </li>
                        <?php endif; ?>

                        <li class="nav-item me-3">
                            <a class="btn btn-outline-light btn-sm" href="tienda.php">
                                <i class="fas fa-shopping-cart me-1"></i> Tienda
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white fw-bold" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1 text-warning"></i>
                                <?php echo isset($_SESSION['admin']) ? "Administrador" : $_SESSION['usuario']; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                                <?php if(isset($_SESSION['admin'])): ?>
                                    <li><a class="dropdown-item" href="admin.php"><i class="fas fa-tools me-2"></i>Panel Admin</a></li>
                                <?php else: ?>
                                    <li><a class="dropdown-item" href="perfil.php"><i class="fas fa-user me-2"></i>Mi Perfil</a></li>
                                    <li><a class="dropdown-item" href="reservar.php"><i class="fas fa-calendar-plus me-2"></i>Reservar Cita</a></li>
                                <?php endif; ?>
                                
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger fw-bold" href="logout.php">
                                        <i class="fas fa-sign-out-alt me-2"></i>Salir
                                    </a>
                                </li>
                            </ul>
                        </li>

                    <?php else: ?>
                        <li class="nav-item">
                            <a class="btn btn-warning btn-sm fw-bold px-3" href="login.php">
                                <i class="fas fa-sign-in-alt me-1"></i> INICIAR SESIÓN 
                            </a>
                        </li>
                    <?php endif; ?>

                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>