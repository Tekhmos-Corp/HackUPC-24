<?php
session_start();

// Verificar si se recibieron datos del formulario
if(isset($_POST['room_code']) && isset($_POST['username'])) {
    // Obtener el código de sala y el nombre de usuario del formulario
    $room_code = $_POST['room_code'];
    $username = $_POST['username'];

    // Verificar si la sala existe en la base de datos
    $servername = "localhost";
    $db_username = "tekhmos";
    $db_password = "Tekhmos12";
    $dbname = "BadDays";

    // Crear conexión
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Comprobar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Consultar si la sala existe
    $sql_check_room = "SELECT * FROM salas WHERE room_code = ?";
    $stmt = $conn->prepare($sql_check_room);
    $stmt->bind_param("i", $room_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Si la sala existe, insertar el usuario en la tabla de usuarios
        $sql_insert_user = "INSERT INTO usuarios (nombre, room_code) VALUES (?, ?)";
        $stmt = $conn->prepare($sql_insert_user);
        $stmt->bind_param("si", $username, $room_code);
        if ($stmt->execute() === TRUE) {
            // Redirigir a pedidos.php con el código de sala y el nombre de usuario mediante un formulario POST
            echo '<form id="redirectForm" action="./pedidos.php" method="POST">';
            echo '<input type="hidden" name="room_code" value="' . $room_code . '">';
            echo '<input type="hidden" name="username" value="' . urlencode($username) . '">';
            echo '</form>';
            echo '<script>document.getElementById("redirectForm").submit();</script>';
            exit;
        } else {
            echo "Error al insertar usuario en la sala: " . $conn->error;
        }
    } else {
        echo "La sala especificada no existe.";
    }

    // Cerrar la conexión
    $conn->close();
} else {
    echo "Error: Se deben especificar el código de sala y el nombre de usuario.";
}
?>
