<?php
session_start();

class UserController
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = mysqli_connect("localhost", "root", "", "run_and_eat");
        mysqli_set_charset($this->conexion, "utf8");

        if (!$this->conexion) {
            die("Error de conexión: " . mysqli_connect_error());
        }
    }

    public function login(): void
    {
        $email      = trim($_POST["email"]      ?? "");
        $contrasena = $_POST["contrasena"]       ?? "";

        if (empty($email) || empty($contrasena)) {
            $this->redirectWithError("login.php", "Por favor, rellena todos los campos.");
            return;
        }
        $stmt = mysqli_prepare(
            $this->conexion,
            "SELECT id_usuario, nombre_completo, email, contrasena, tipo_usuario, foto_perfil
             FROM USUARIOS
             WHERE email = ? 
             LIMIT 1"
        );
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        $usuario   = mysqli_fetch_assoc($resultado);
        mysqli_stmt_close($stmt);

        if ($usuario && $contrasena === $usuario["contrasena"]) {
            $_SESSION["id_usuario"]      = $usuario["id_usuario"];
            $_SESSION["nombre_completo"] = $usuario["nombre_completo"];
            $_SESSION["tipo_usuario"]    = $usuario["tipo_usuario"];
            $_SESSION["foto_perfil"]     = $usuario["foto_perfil"];

            header("Location: ../index.html");
            exit();
        } else {
            $this->redirectWithError("login.php", "Email o contraseña incorrectos.");
        }
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();

        header("Location: ../index.html");
        exit();
    }

    public function register(): void
    {
        $nombre           = trim($_POST["nombre"]          ?? "");
        $email            = trim($_POST["email"]           ?? "");
        $tipo_usuario     = trim($_POST["tipo-usuario"]    ?? "cliente");
        $password         = $_POST["password"]             ?? "";
        $confirm_password = $_POST["confirm-password"]     ?? "";

        if (empty($nombre) || empty($email) || empty($password) || empty($confirm_password)) {
            $this->redirectWithError("registro.php", "Por favor, rellena todos los campos.");
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->redirectWithError("registro.php", "El formato del correo electrónico no es válido.");
            return;
        }

        if ($password !== $confirm_password) {
            $this->redirectWithError("registro.php", "Las contraseñas no coinciden.");
            return;
        }

        if (!in_array($tipo_usuario, ["cliente", "organizador"])) {
            $this->redirectWithError("registro.php", "Tipo de usuario no válido.");
            return;
        }

        // Comprobar si el email ya existe
        $stmt_check = mysqli_prepare($this->conexion, "SELECT id_usuario FROM USUARIOS WHERE email = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt_check, "s", $email);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);

        if (mysqli_stmt_num_rows($stmt_check) > 0) {
            mysqli_stmt_close($stmt_check);
            $this->redirectWithError("registro.php", "Este correo electrónico ya está registrado.");
            return;
        }
        mysqli_stmt_close($stmt_check);

        // Insertar usuario con contraseña en texto plano
        $stmt_insert = mysqli_prepare(
            $this->conexion,
            "INSERT INTO USUARIOS (nombre_completo, email, contrasena, tipo_usuario) VALUES (?, ?, ?, ?)"
        );
        mysqli_stmt_bind_param($stmt_insert, "ssss", $nombre, $email, $password, $tipo_usuario);

        if (mysqli_stmt_execute($stmt_insert)) {
            mysqli_stmt_close($stmt_insert);
            header("Location: login.php?registered=1");
            exit();
        } else {
            mysqli_stmt_close($stmt_insert);
            $this->redirectWithError("registro.php", "Error al crear la cuenta. Inténtalo de nuevo.");
        }
    }

    // Redirige a una página pasando el error por sesión
    private function redirectWithError(string $page, string $message): void
    {
        $_SESSION["error"] = $message;
        header("Location: " . $page);
        exit();
    }

    public function __destruct()
    {
        if ($this->conexion) {
            mysqli_close($this->conexion);
        }
    }
}

// ── Enrutador ──────────────────────────────────────────────────────────────────
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = new UserController();

    if (isset($_POST["login"])) {
        $user->login();
    } elseif (isset($_POST["logout"])) {
        $user->logout();
    } elseif (isset($_POST["register"])) {
        $user->register();
    }
}
