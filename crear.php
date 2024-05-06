<?php
session_start();


$servername = "localhost";
$username = "tekhmos";
$password = "Tekhmos12";
$dbname = "BadDays";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection error with DBMS: " . $conn->connect_error);
}

function generarCodigoSala($conn) {
    
    $room_code = rand(0, 9999);
    
   
    $sql_check_room = "SELECT * FROM salas WHERE room_code = '$room_code'";
    $result = $conn->query($sql_check_room);
    
    if ($result->num_rows > 0) {
        return generarCodigoSala($conn);
    } else {
        return $room_code;
    }
}


if (isset($_POST['create_room'])) {
   
    $room_code = generarCodigoSala($conn);
    
    
    
    $_SESSION['username'] = $_POST['username'];

    
    $sql_insert_sala = "INSERT INTO salas (room_code) VALUES ('$room_code')";

    if ($conn->query($sql_insert_sala) === TRUE) {
      
        $sql_insert_usuario = "INSERT INTO usuarios (nombre, room_code) VALUES ('" . $_SESSION['username'] . "', '$room_code')";
        
        if ($conn->query($sql_insert_usuario) === TRUE) {
         
            echo '<form id="redirectForm" action="./pedidos.php" method="POST">';
            echo '<input type="hidden" name="room_code" value="' . $room_code . '">';
            echo '<input type="hidden" name="username" value="' . urlencode($_SESSION['username']) . '">';
            echo '</form>';
            echo '<script>document.getElementById("redirectForm").submit();</script>';
            exit;
        } else {
            echo "Error joining session. " . $conn->error;
        }
    } else {
        echo "Error creating room: " . $conn->error;
    }
}


$sql_create_salas_table = "CREATE TABLE IF NOT EXISTS salas (
    room_code INT(6) PRIMARY KEY
)";


// Crear la tabla de usuarios en la base de datos
$sql_create_usuarios_table = "CREATE TABLE IF NOT EXISTS usuarios (
    usuario_id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255),
    room_code INT(6),
    FOREIGN KEY (room_code) REFERENCES salas(room_code)
)";

echo "Wrong data received.";
// Cerrar la conexión
$conn->close();
?>
