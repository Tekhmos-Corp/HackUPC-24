<?php
// Realiza la conexión a la base de datos y obtiene los datos actualizados de la tabla de pedidos
// Reemplaza este código con la consulta SQL adecuada para obtener los datos actualizados

$servername = "localhost";
$username = "tekhmos";
$password = "Tekhmos12";
$dbname = "BadDays";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}

$room_code = isset($_GET['room_code']) ? $_GET['room_code'] : '';

$sql = "SELECT pl.numero_plato, pl.comentario, u.nombre AS nombre_usuario, p.cantidad_pedido
        FROM platos pl
        INNER JOIN pedidos p ON pl.plato_id = p.plato_id
        INNER JOIN usuarios u ON p.usuario_id = u.usuario_id
        WHERE pl.room_code = '$room_code'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo "<tr><th>Item</th><th>Info</th><th>User</th><th>Quantity</th></tr>";
  while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>".$row["numero_plato"]."</td>";
    echo "<td>".$row["comentario"]."</td>";
    echo "<td>".$row["nombre_usuario"]."</td>";
    echo "<td>".$row["cantidad_pedido"]."</td>";
    echo "</tr>";
  }
} else {
  echo "<tr><td colspan='4'>No orders found yet.</td></tr>";
}

$conn->close();
?>
