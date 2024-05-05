<?php
session_start();

// Conexión a la base de datos (modifica con tus propios datos)
$servername = "localhost";
$username = "tekhmos";
$password = "Tekhmos12";
$dbname = "BadDays";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

function generarCodigoSala($conn) {
    // Generar un código de sala aleatorio
    $room_code = rand(0, 9999);
    
    // Asegurarse de que el código generado sea único
    $sql_check_room = "SELECT * FROM salas WHERE room_code = '$room_code'";
    $result = $conn->query($sql_check_room);
    
    // Si el código ya existe, generar uno nuevo
    if ($result->num_rows > 0) {
        return generarCodigoSala($conn);
    } else {
        return $room_code;
    }
}

// Manejar la solicitud para crear la sala
if (isset($_POST['create_room'])) {
    // Generar un código de sala aleatorio
    $room_code = generarCodigoSala($conn);
    // comprueba que no exista una sala con este codigo
    
    // Obtener el nombre de usuario del formulario
    $_SESSION['username'] = $_POST['username'];

    // Insertar la sala en la base de datos
    $sql_insert_sala = "INSERT INTO salas (room_code) VALUES ('$room_code')";

    if ($conn->query($sql_insert_sala) === TRUE) {
        // Insertar usuario asociado a la sala en la tabla de usuarios
        $sql_insert_usuario = "INSERT INTO usuarios (nombre, room_code) VALUES ('" . $_SESSION['username'] . "', '$room_code')";
        
        if ($conn->query($sql_insert_usuario) === TRUE) {
            // Redirigir al usuario a pedidos.php con el código de sala y nombre de usuario mediante un formulario POST
            echo '<form id="redirectForm" action="./pedidos.php" method="POST">';
            echo '<input type="hidden" name="room_code" value="' . $room_code . '">';
            echo '<input type="hidden" name="username" value="' . urlencode($_SESSION['username']) . '">';
            echo '</form>';
            echo '<script>document.getElementById("redirectForm").submit();</script>';
            exit;
        } else {
            echo "Error al insertar usuario en la sala: " . $conn->error;
        }
    } else {
        echo "Error al crear la sala: " . $conn->error;
    }
}

// Crear la tabla de salas en la base de datos
$sql_create_salas_table = "CREATE TABLE IF NOT EXISTS salas (
    room_code INT(6) PRIMARY KEY
)";

if ($conn->query($sql_create_salas_table) === TRUE) {
    echo "Tabla de salas creada exitosamente.";
} else {
    echo "Error al crear la tabla de salas: " . $conn->error;
}

// Crear la tabla de usuarios en la base de datos
$sql_create_usuarios_table = "CREATE TABLE IF NOT EXISTS usuarios (
    usuario_id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255),
    room_code INT(6),
    FOREIGN KEY (room_code) REFERENCES salas(room_code)
)";

if ($conn->query($sql_create_usuarios_table) === TRUE) {
    echo "Tabla de usuarios creada exitosamente.";
} else {
    echo "Error al crear la tabla de usuarios: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>