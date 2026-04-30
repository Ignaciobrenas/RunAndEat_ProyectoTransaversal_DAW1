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

    public function crearEvento(): void
    {

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
