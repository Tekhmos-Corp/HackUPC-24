<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Información de una Tabla MySQL</title>
</head>
<body>

<?php
// Conexión a la base de datos
$servername = "localhost"; // Cambia esto si tu servidor de MySQL no está en localhost
$username = "tekhmos"; // Cambia esto al nombre de usuario de tu base de datos
$password = "Tekhmos12"; // Cambia esto a tu contraseña de la base de datos
$dbname = "BadDays"; // Cambia esto al nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Revisar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL para obtener la información de la tabla
$sql = "SELECT usuario_id, nombre, room_code FROM usuarios";
$result = $conn->query($sql);

// Verificar si hay resultados y mostrarlos en una tabla HTML
if ($result->num_rows > 0) {
    echo "<table border='1'>
    <tr>
    <th>Columna1</th>
    <th>Columna2</th>
    <th>Columna3</th>
    </tr>";
    // Mostrar los datos de cada fila
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["usuario_id"] . "</td>";
        echo "<td>" . $row["nombre"] . "</td>";
        echo "<td>" . $row["room_code"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron resultados";
}

// Cerrar la conexión
$conn->close();
?>

</body>
</html>
