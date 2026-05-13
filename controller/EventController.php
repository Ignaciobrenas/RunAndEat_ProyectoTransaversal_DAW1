<?php
session_start();

class EventController
{
    private PDO $conexion;

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


    public function inscribir(): void
    {

    }

    public function cancelarInscripcion(): void
    {

    }

    public function getCategorias(): array
    {
        try {
            $stmt = $this->conexion->query("SELECT id_categoria, nombre FROM CATEGORIAS ORDER BY nombre ASC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
        
    }

    public function crearEvento(): void
    {
        $titulo       = trim($_POST["titulo"] ?? "");
        $descripcion  = trim($_POST["descripcion"] ?? "");
        $fecha        = $_POST["fecha"] ?? "";
        $hora         = $_POST["hora"] ?? "";
        $ciudad       = trim($_POST["ubicacion"] ?? "");
        $direccion    = trim($_POST["direccion"] ?? "");
        $precio       = $_POST["precio"] ?? 0;
        $capacidad    = $_POST["participantes"] ?? 0;
        $tipo_evento  = $_POST["tipo-evento"] ?? "";
        $incluye      = trim($_POST["incluye"] ?? "");
        $que_traer    = trim($_POST["que-traer"] ?? "");
        $notas        = trim($_POST["notas"] ?? "");
        
        $distancia    = trim($_POST["distancia"] ?? "");
        $distancia    = $distancia !== "" ? (float)$distancia : null;
        
        $nivel        = trim($_POST["nivel"] ?? "");
        $nivel        = $nivel !== "" ? $nivel : null;

        $id_organizador = $_SESSION["id_usuario"] ?? null;

        if (!$id_organizador) {
            $this->redirectWithError("login.php", "Debes iniciar sesión como organizador.");
            return;
        }

        $id_categoria = (int)($_POST["tipo-evento"] ?? 1);

        $imagenPath = 'public/img/events-photos/user.png';
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../public/img/events-photos/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileExtension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            $fileName = uniqid('evento_') . '.' . $fileExtension;
            $destination = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $destination)) {
                $imagenPath = 'public/img/events-photos/' . $fileName;
            }
        }

        try {
            $stmt = $this->conexion->prepare("CALL CrearEvento(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $id_organizador,
                $id_categoria,
                $titulo,
                $descripcion,
                $imagenPath,
                $fecha,
                $hora,
                $ciudad,
                $direccion,
                $precio,
                $capacidad,
                $distancia,
                $nivel,
                $incluye,
                $que_traer,
                $notas
            ]);

            $_SESSION["success"] = "Evento : " . $titulo . " creado correctamente";
            header("Location: crear-evento.php");
            exit();
        } catch (PDOException $e) {
            $this->redirectWithError("crear-evento.php", "Error al crear el evento: " . $e->getMessage());
        }
    }

    private function redirectWithError(string $page, string $message): void
    {
        $_SESSION["error"] = $message;
        header("Location: " . $page);
        exit();
    }

    public function eliminarEvento(): void
    {

    }

    public function modificarEvento(): void
    {

    }

    public function adminCrearInscripcion(): void
    {

    }

    public function adminEliminarInscripcion(): void
    {

    }

    public function verEvento(int $idEvento): void
    {

    }

    public function listarEventos(array $filtros = []): void
    {

    }

}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $eventoController = new EventController();

    if (isset($_POST["action"]) && $_POST["action"] === "crearEvento") {
        $eventoController->crearEvento();
    }
}
