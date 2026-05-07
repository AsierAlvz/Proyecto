<<<<<<< HEAD
<?php
session_start();
$conexion = mysqli_connect("localhost", "root", "", "peluqueria_db");

if (isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action']; 

    if ($action == "login") {
        $user = mysqli_real_escape_string($conexion, $_POST['usuario']);
        $pass = mysqli_real_escape_string($conexion, $_POST['password']);

        $sql = "SELECT * FROM usuarios WHERE usuario = '$user' AND password = '$pass'";
        $resultado = mysqli_query($conexion, $sql);

        if (mysqli_num_rows($resultado) > 0) {
            $datos = mysqli_fetch_assoc($resultado);
            
            $_SESSION['user_id'] = $datos['id'];

            if ($user === "admin" || $user === "Asier") {
                $_SESSION['admin'] = "Administrador"; 
                $_SESSION['usuario'] = $user; 
                header("Location: admin.php");
            } else {
                $_SESSION['usuario'] = $user; 
                header("Location: index.php"); 
            }
            // ----------------------------------------------
            exit();
        } else {
            $error = "Usuario o contraseña incorrectos.";
        }
    } 
    
    else if ($action == "register") {
        $user = mysqli_real_escape_string($conexion, $_POST['usuario']);
        $pass = mysqli_real_escape_string($conexion, $_POST['password']);
        
        $check = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario = '$user'");
        if (mysqli_num_rows($check) > 0) {
            $error = "El nombre de usuario ya está pillado.";
        } else {
            $sql = "INSERT INTO usuarios (usuario, password) VALUES ('$user', '$pass')";
            if (mysqli_query($conexion, $sql)) {
                $success = "¡Cuenta creada! Ya puedes iniciar sesión.";
            } else {
                $error = "Error al registrarse.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso - Peluquería Asier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #1a1d20; height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Segoe UI', sans-serif; }
        .login-card { background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 20px; padding: 40px; width: 100%; max-width: 400px; box-shadow: 0 15px 35px rgba(0,0,0,0.5); color: white; }
        .nav-pills .nav-link { color: white; border-radius: 10px; margin-bottom: 20px; }
        .nav-pills .nav-link.active { background-color: #ffc107 !important; color: black !important; font-weight: bold; }
        .form-control { background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); color: white; border-radius: 10px; }
        .form-control:focus { background: rgba(255, 255, 255, 0.15); color: white; border-color: #ffc107; box-shadow: none; }
        .btn-admin { background-color: #ffc107; color: #000; font-weight: bold; padding: 12px; border-radius: 10px; transition: 0.3s; margin-top: 10px; border: none; }
        .btn-admin:hover { background-color: #e5ac00; transform: translateY(-2px); }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="text-center mb-4">
            <i class="fas fa-user-circle fa-3x text-warning"></i>
            <h2 class="fw-bold mt-2">Mi Cuenta</h2>
        </div>

        <ul class="nav nav-pills nav-justified mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#pills-login">Entrar</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-register">Registro</button>
            </li>
        </ul>

        <?php if($error): ?> <div class="alert alert-danger py-2 small text-center"><?= $error ?></div> <?php endif; ?>
        <?php if($success): ?> <div class="alert alert-success py-2 small text-center"><?= $success ?></div> <?php endif; ?>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="pills-login">
                <form method="POST">
                    <input type="hidden" name="action" value="login">
                    <div class="mb-3">
                        <label class="small fw-bold">Usuario</label>
                        <input type="text" name="usuario" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-admin w-100">INICIAR SESIÓN</button>
                </form>
            </div>
            <div class="tab-pane fade" id="pills-register">
                <form method="POST">
                    <input type="hidden" name="action" value="register">
                    <div class="mb-3">
                        <label class="small fw-bold">Nuevo Usuario</label>
                        <input type="text" name="usuario" class="form-control" placeholder="Usuario" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Contraseña</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                    <button type="submit" class="btn btn-admin w-100">CREAR CUENTA</button>
                </form>
            </div>
        </div>
        <a href="index.php" class="d-block text-center mt-3 text-white-50 text-decoration-none small">Volver a la web</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
=======
<?php
session_start();
$conexion = mysqli_connect("localhost", "root", "", "peluqueria_db");

if (isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action']; 

    if ($action == "login") {
        $user = mysqli_real_escape_string($conexion, $_POST['usuario']);
        $pass = mysqli_real_escape_string($conexion, $_POST['password']);

        $sql = "SELECT * FROM usuarios WHERE usuario = '$user' AND password = '$pass'";
        $resultado = mysqli_query($conexion, $sql);

        if (mysqli_num_rows($resultado) > 0) {
            $datos = mysqli_fetch_assoc($resultado);
            
            $_SESSION['user_id'] = $datos['id'];

            if ($user === "admin" || $user === "Asier") {
                $_SESSION['admin'] = "Administrador"; 
                $_SESSION['usuario'] = $user; 
                header("Location: admin.php");
            } else {
                $_SESSION['usuario'] = $user; 
                header("Location: index.php"); 
            }
            // ----------------------------------------------
            exit();
        } else {
            $error = "Usuario o contraseña incorrectos.";
        }
    } 
    
    else if ($action == "register") {
        $user = mysqli_real_escape_string($conexion, $_POST['usuario']);
        $pass = mysqli_real_escape_string($conexion, $_POST['password']);
        
        $check = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario = '$user'");
        if (mysqli_num_rows($check) > 0) {
            $error = "El nombre de usuario ya está pillado.";
        } else {
            $sql = "INSERT INTO usuarios (usuario, password) VALUES ('$user', '$pass')";
            if (mysqli_query($conexion, $sql)) {
                $success = "¡Cuenta creada! Ya puedes iniciar sesión.";
            } else {
                $error = "Error al registrarse.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso - Peluquería Asier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #1a1d20; height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Segoe UI', sans-serif; }
        .login-card { background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 20px; padding: 40px; width: 100%; max-width: 400px; box-shadow: 0 15px 35px rgba(0,0,0,0.5); color: white; }
        .nav-pills .nav-link { color: white; border-radius: 10px; margin-bottom: 20px; }
        .nav-pills .nav-link.active { background-color: #ffc107 !important; color: black !important; font-weight: bold; }
        .form-control { background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); color: white; border-radius: 10px; }
        .form-control:focus { background: rgba(255, 255, 255, 0.15); color: white; border-color: #ffc107; box-shadow: none; }
        .btn-admin { background-color: #ffc107; color: #000; font-weight: bold; padding: 12px; border-radius: 10px; transition: 0.3s; margin-top: 10px; border: none; }
        .btn-admin:hover { background-color: #e5ac00; transform: translateY(-2px); }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="text-center mb-4">
            <i class="fas fa-user-circle fa-3x text-warning"></i>
            <h2 class="fw-bold mt-2">Mi Cuenta</h2>
        </div>

        <ul class="nav nav-pills nav-justified mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#pills-login">Entrar</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-register">Registro</button>
            </li>
        </ul>

        <?php if($error): ?> <div class="alert alert-danger py-2 small text-center"><?= $error ?></div> <?php endif; ?>
        <?php if($success): ?> <div class="alert alert-success py-2 small text-center"><?= $success ?></div> <?php endif; ?>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="pills-login">
                <form method="POST">
                    <input type="hidden" name="action" value="login">
                    <div class="mb-3">
                        <label class="small fw-bold">Usuario</label>
                        <input type="text" name="usuario" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-admin w-100">INICIAR SESIÓN</button>
                </form>
            </div>
            <div class="tab-pane fade" id="pills-register">
                <form method="POST">
                    <input type="hidden" name="action" value="register">
                    <div class="mb-3">
                        <label class="small fw-bold">Nuevo Usuario</label>
                        <input type="text" name="usuario" class="form-control" placeholder="Usuario" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Contraseña</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                    <button type="submit" class="btn btn-admin w-100">CREAR CUENTA</button>
                </form>
            </div>
        </div>
        <a href="index.php" class="d-block text-center mt-3 text-white-50 text-decoration-none small">Volver a la web</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
>>>>>>> 6d5ea9f0426fc98fdb6b4d482b1e0b3dd734b675
</html>