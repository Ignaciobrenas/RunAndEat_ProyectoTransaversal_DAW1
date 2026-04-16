<?php

$host = "localhost";
$db   = "run_and_eat";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$sql = "SELECT id_usuario, nombre_completo, email, contrasena, tipo_usuario, fecha_registro, activo FROM USUARIOS";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuarios - Run And Eat</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Listado de Usuarios</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Nombre completo</th>
        <th>Email</th>
        <th>Contraseña</th>
        <th>Tipo</th>
        <th>Fecha registro</th>
        <th>Activo</th>
    </tr>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row["id_usuario"] ?></td>
                <td><?= $row["nombre_completo"] ?></td>
                <td><?= $row["email"] ?></td>
                <td><?= $row["contrasena"] ?></td>
                <td><?= $row["tipo_usuario"] ?></td>
                <td><?= $row["fecha_registro"] ?></td>
                <td><?= $row["activo"] ? "Sí" : "No" ?></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="6">No hay usuarios registrados</td>
        </tr>
    <?php endif; ?>

</table>

</body>
</html>

<?php
$conn->close();