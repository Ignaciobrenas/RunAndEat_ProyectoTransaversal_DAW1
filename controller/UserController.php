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
            $this->redirectWithError("../view/login.php", "Por favor, rellena todos los campos.");
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

            header("Location: ../index.php");
            exit();
        } else {
            $this->redirectWithError("../view/login.php", "Email o contraseña incorrectos.");
        }
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();

        header("Location: ../index.php");
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
            $this->redirectWithError("../view/registro.php", "Por favor, rellena todos los campos.");
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->redirectWithError("../view/registro.php", "El formato del correo electrónico no es válido.");
            return;
        }

        if ($password !== $confirm_password) {
            $this->redirectWithError("../view/registro.php", "Las contraseñas no coinciden.");
            return;
        }

        if (!in_array($tipo_usuario, ["cliente", "organizador"])) {
            $this->redirectWithError("../view/registro.php", "Tipo de usuario no válido.");
            return;
        }

        // Comprobar si el email ya existe
        $stmt_check = $this->conexion->prepare("SELECT id_usuario FROM USUARIOS WHERE email = ? LIMIT 1");
        $stmt_check->execute([$email]);

        if ($stmt_check->rowCount() > 0) {
            $this->redirectWithError("../view/registro.php", "Este correo electrónico ya está registrado.");
            return;
        }

        // Insertar usuario con contraseña en texto plano
        $stmt_insert = $this->conexion->prepare(
            "INSERT INTO USUARIOS (nombre_completo, email, contrasena, tipo_usuario) VALUES (?, ?, ?, ?)"
        );

        if ($stmt_insert->execute([$nombre, $email, $password, $tipo_usuario])) {
            header("Location: ../view/login.php?registered=1");
            exit();
        } else {
            $this->redirectWithError("../view/registro.php", "Error al crear la cuenta. Inténtalo de nuevo.");
        }
    }

    public function updateInfo(): void
    {
        if (!isset($_SESSION["id_usuario"])) {
            $this->redirectWithError("../view/login.php", "Debes iniciar sesión.");
            return;
        }

        $id_usuario = $_SESSION["id_usuario"];
        $nombre     = trim($_POST["nombre"] ?? "");
        $email      = trim($_POST["email"]  ?? "");

        if (empty($nombre) || empty($email)) {
            $this->redirectWithError("../view/perfil.php", "Por favor, rellena todos los campos.");
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->redirectWithError("../view/perfil.php", "El formato del correo electrónico no es válido.");
            return;
        }

        // Comprobar si el email ya está en uso por otro usuario
        $stmt_check = $this->conexion->prepare(
            "SELECT id_usuario FROM USUARIOS WHERE email = ? AND id_usuario != ? LIMIT 1"
        );
        $stmt_check->execute([$email, $id_usuario]);

        if ($stmt_check->rowCount() > 0) {
            $this->redirectWithError("../view/perfil.php", "Ese correo ya está en uso por otra cuenta.");
            return;
        }

        // Actualizar información
        $stmt_up = $this->conexion->prepare(
            "UPDATE USUARIOS SET nombre_completo = ?, email = ? WHERE id_usuario = ?"
        );

        if ($stmt_up->execute([$nombre, $email, $id_usuario])) {
            $_SESSION["nombre_completo"] = $nombre;
            $this->redirectWithSuccess("../view/perfil.php", "Información actualizada correctamente.");
        } else {
            $this->redirectWithError("../view/perfil.php", "Error al actualizar. Inténtalo de nuevo.");
        }
    }

    public function updatePhoto(): void
    {
        if (!isset($_SESSION["id_usuario"])) {
            $this->redirectWithError("../view/login.php", "Debes iniciar sesión.");
            return;
        }

        $id_usuario = $_SESSION["id_usuario"];

        if (!isset($_FILES["foto_perfil"]) || $_FILES["foto_perfil"]["error"] !== UPLOAD_ERR_OK) {
            $this->redirectWithError("../view/perfil.php", "No se ha podido subir la imagen. Inténtalo de nuevo.");
            return;
        }

        $archivo   = $_FILES["foto_perfil"];
        $tamano    = $archivo["size"];
        $tmp       = $archivo["tmp_name"];
        $extension = strtolower(pathinfo($archivo["name"], PATHINFO_EXTENSION));

        $extensiones_permitidas = ["jpg", "jpeg", "png", "webp", "gif"];
        $mimes_permitidos       = ["image/jpeg", "image/png", "image/webp", "image/gif"];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_file($finfo, $tmp);
        finfo_close($finfo);

        if (!in_array($extension, $extensiones_permitidas) || !in_array($mime, $mimes_permitidos)) {
            $this->redirectWithError("../view/perfil.php", "Formato no permitido. Usa JPG, PNG, WEBP o GIF.");
            return;
        }

        if ($tamano > 2 * 1024 * 1024) {
            $this->redirectWithError("../view/perfil.php", "La imagen no puede superar los 2 MB.");
            return;
        }

        $directorio = __DIR__ . "/../public/img/user-photos/";
        if (!is_dir($directorio)) {
            mkdir($directorio, 0755, true);
        }

        $nombre_archivo = "user_" . $id_usuario . "_" . time() . "." . $extension;
        $ruta_destino   = $directorio . $nombre_archivo;

        if (move_uploaded_file($tmp, $ruta_destino)) {
            $ruta_bd = "public/img/user-photos/" . $nombre_archivo;
            $stmt = $this->conexion->prepare("UPDATE USUARIOS SET foto_perfil = ? WHERE id_usuario = ?");
            if ($stmt->execute([$ruta_bd, $id_usuario])) {
                $_SESSION["foto_perfil"] = $ruta_bd;
                $this->redirectWithSuccess("../view/perfil.php", "Foto de perfil actualizada correctamente.");
            } else {
                $this->redirectWithError("../view/perfil.php", "Error al guardar la foto en la base de datos.");
            }
        } else {
            $this->redirectWithError("../view/perfil.php", "Error al mover el archivo. Comprueba los permisos del directorio.");
        }
    }

    public function updatePassword(): void
    {
        if (!isset($_SESSION["id_usuario"])) {
            $this->redirectWithError("../view/login.php", "Debes iniciar sesión.");
            return;
        }

        $id_usuario = $_SESSION["id_usuario"];
        $current    = $_POST["current-password"]    ?? "";
        $nueva      = $_POST["new-password"]         ?? "";
        $confirma   = $_POST["confirm-new-password"] ?? "";

        if (empty($current) || empty($nueva) || empty($confirma)) {
            $this->redirectWithError("../view/perfil.php", "Rellena todos los campos de contraseña.");
            return;
        }

        if (strlen($nueva) < 8) {
            $this->redirectWithError("../view/perfil.php", "La nueva contraseña debe tener al menos 8 caracteres.");
            return;
        }

        if ($nueva !== $confirma) {
            $this->redirectWithError("../view/perfil.php", "Las contraseñas nuevas no coinciden.");
            return;
        }

        $stmt = $this->conexion->prepare("SELECT contrasena FROM USUARIOS WHERE id_usuario = ? LIMIT 1");
        $stmt->execute([$id_usuario]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($current !== ($row["contrasena"] ?? "")) {
            $this->redirectWithError("../view/perfil.php", "La contraseña actual no es correcta.");
            return;
        }

        $stmt_up = $this->conexion->prepare("UPDATE USUARIOS SET contrasena = ? WHERE id_usuario = ?");
        if ($stmt_up->execute([$nueva, $id_usuario])) {
            $this->redirectWithSuccess("../view/perfil.php", "Contraseña actualizada correctamente.");
        } else {
            $this->redirectWithError("../view/perfil.php", "Error al cambiar la contraseña.");
        }
    }

    public function deleteAccount(): void
    {
        if (!isset($_SESSION["id_usuario"])) {
            $this->redirectWithError("../view/login.php", "Debes iniciar sesión.");
            return;
        }

        $id_usuario = $_SESSION["id_usuario"];
        $password   = $_POST["password"] ?? "";

        if (empty($password)) {
            $this->redirectWithError("../view/perfil.php", "Por favor, introduce tu contraseña para confirmar.");
            return;
        }

        // Verificar contraseña (en este proyecto se comparan en texto plano según login/registro)
        $stmt = $this->conexion->prepare("SELECT contrasena FROM USUARIOS WHERE id_usuario = ? LIMIT 1");
        $stmt->execute([$id_usuario]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($password !== ($row["contrasena"] ?? "")) {
            $this->redirectWithError("../view/perfil.php", "La contraseña es incorrecta.");
            return;
        }

        // Eliminar usuario
        $stmt_del = $this->conexion->prepare("DELETE FROM USUARIOS WHERE id_usuario = ?");
        if ($stmt_del->execute([$id_usuario])) {
            session_unset();
            session_destroy();
            header("Location: ../index.php?deleted=1");
            exit();
        } else {
            $this->redirectWithError("../view/perfil.php", "Error al intentar eliminar la cuenta.");
        }
    }

    public function getProfileData(): array
    {
        if (!isset($_SESSION["id_usuario"])) {
            header("Location: ../view/login.php");
            exit();
        }

        $id_usuario = $_SESSION["id_usuario"];

        $stmt = $this->conexion->prepare(
            "SELECT nombre_completo, email, tipo_usuario, fecha_registro, foto_perfil
             FROM USUARIOS WHERE id_usuario = ? LIMIT 1"
        );
        $stmt->execute([$id_usuario]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            session_destroy();
            header("Location: ../view/login.php");
            exit();
        }

        $stmt_ev = $this->conexion->prepare(
            "SELECT e.id_evento, e.titulo, e.fecha, e.ciudad AS ubicacion
             FROM EVENTOS e
             INNER JOIN INSCRIPCIONES i ON i.id_evento = e.id_evento
             WHERE i.id_usuario = ?
             ORDER BY e.fecha DESC"
        );
        $stmt_ev->execute([$id_usuario]);
        $eventos_usuario = $stmt_ev->fetchAll(PDO::FETCH_ASSOC);

        $fecha_registro = "";
        if (!empty($usuario["fecha_registro"])) {
            $meses = ["Enero","Febrero","Marzo","Abril","Mayo","Junio",
                      "Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
            $ts = strtotime($usuario["fecha_registro"]);
            $fecha_registro = $meses[(int)date("n", $ts) - 1] . " " . date("Y", $ts);
        }

        $foto_src = !empty($usuario["foto_perfil"])
            ? "../" . htmlspecialchars($usuario["foto_perfil"])
            : "../public/img/user.png";

        return [
            "usuario"         => $usuario,
            "eventos_usuario" => $eventos_usuario,
            "foto_src"        => $foto_src,
            "fecha_registro"  => $fecha_registro
        ];
    }

    // Redirige a una página pasando el error por sesión
    private function redirectWithError(string $page, string $message): void
    {
        $_SESSION["error"] = $message;
        header("Location: " . $page);
        exit();
    }

    // Redirige a una página pasando el éxito por sesión
    private function redirectWithSuccess(string $page, string $message): void
    {
        $_SESSION["success"] = $message;
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
    } elseif (isset($_POST["update_info"])) {
        $user->updateInfo();
    } elseif (isset($_POST["update_photo"])) {
        $user->updatePhoto();
    } elseif (isset($_POST["update_password"])) {
        $user->updatePassword();
    } elseif (isset($_POST["delete_account"])) {
        $user->deleteAccount();
    }
}