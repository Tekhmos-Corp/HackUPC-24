<?php
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

// Manejar la solicitud para crear la sala
if (isset($_POST['create_room'])) {
    // Generar un código de sala aleatorio
    $room_code = rand(1000, 9999);

    // Obtener el nombre de usuario del formulario
    $username = $_POST['username'];

    // Insertar la sala en la base de datos
    $sql = "INSERT INTO salas (room_code, username) VALUES ('$room_code', '$username')";

    if ($conn->query($sql) === TRUE) {
        echo "Sala creada exitosamente con código: " . $room_code;
    } else {
        echo "Error al crear la sala: " . $conn->error;
    }

    // Crear tablas en la base de datos (aquí debes agregar la lógica para crear las tablas según tus necesidades)
    $sql_create_table = "CREATE TABLE IF NOT EXISTS tabla_ejemplo (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(30) NOT NULL,
        apellido VARCHAR(30) NOT NULL,
        email VARCHAR(50),
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if ($conn->query($sql_create_table) === TRUE) {
        echo "Tabla creada exitosamente.";
    } else {
        echo "Error al crear la tabla: " . $conn->error;
    }
}

// Cerrar la conexión
$conn->close();
?>
