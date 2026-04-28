<?php
session_start();

class UserController
{
    private $conexion;

    public function __construct()
    {
        try {
            $this->conexion = new PDO(
                "mysql:host=localhost;dbname=run_and_eat;charset=utf8",
                "root",
                ""
            );
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
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
        $stmt = $this->conexion->prepare(
            "SELECT id_usuario, nombre_completo, email, contrasena, tipo_usuario, foto_perfil
             FROM USUARIOS
             WHERE email = ? 
             LIMIT 1"
        );
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && $contrasena === $usuario["contrasena"]) {
            $_SESSION["id_usuario"]      = $usuario["id_usuario"];
            $_SESSION["nombre_completo"] = $usuario["nombre_completo"];
            $_SESSION["tipo_usuario"]    = $usuario["tipo_usuario"];
            $_SESSION["foto_perfil"]     = $usuario["foto_perfil"];

            header("Location: index.php");
            exit();
        } else {
            $this->redirectWithError("login.php", "Email o contraseña incorrectos.");
        }
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();

        header("Location: index.php");
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
        $stmt_check = $this->conexion->prepare("SELECT id_usuario FROM USUARIOS WHERE email = ? LIMIT 1");
        $stmt_check->execute([$email]);

        if ($stmt_check->rowCount() > 0) {
            $this->redirectWithError("registro.php", "Este correo electrónico ya está registrado.");
            return;
        }

        // Insertar usuario con contraseña en texto plano
        $stmt_insert = $this->conexion->prepare(
            "INSERT INTO USUARIOS (nombre_completo, email, contrasena, tipo_usuario) VALUES (?, ?, ?, ?)"
        );

        if ($stmt_insert->execute([$nombre, $email, $password, $tipo_usuario])) {
            header("Location: login.php?registered=1");
            exit();
        } else {
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
            $this->conexion = null;
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