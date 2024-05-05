<?php

if(isset($_POST['numero_plato']) && isset($_POST['nombre_plato']) && isset($_POST['cantidad']) && isset($_POST['room_code']) && isset($_POST['username'])) {
    
    $servername = "localhost";
    $username = "tekhmos";
    $password = "Tekhmos12";
    $dbname = "BadDays";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }


    $numero_plato = $_POST['numero_plato'];
    $nombre_plato = $_POST['nombre_plato'];
    $cantidad = $_POST['cantidad'];
    $room_code = $_POST['room_code'];
    $username = $_POST['username']; 


    $sql_check_plato = "SELECT plato_id, cantidad_total_pedidos FROM platos WHERE room_code = ? AND numero_plato = ?";
    $stmt_check_plato = $conn->prepare($sql_check_plato);
    $stmt_check_plato->bind_param("is", $room_code, $numero_plato);
    $stmt_check_plato->execute();
    $result_check_plato = $stmt_check_plato->get_result();

    if ($result_check_plato->num_rows > 0) {

        $row = $result_check_plato->fetch_assoc();
        $plato_id = $row['plato_id'];
        $cantidad_actual = $row['cantidad_total_pedidos'];
        $cantidad_nueva = $cantidad_actual + $cantidad;
        $sql_update_plato = "UPDATE platos SET cantidad_total_pedidos = ? WHERE plato_id = ?";
        $stmt_update_plato = $conn->prepare($sql_update_plato);
        $stmt_update_plato->bind_param("ii", $cantidad_nueva, $plato_id);
        if ($stmt_update_plato->execute() !== TRUE) {
            echo "Error al actualizar la cantidad total de pedidos del plato: " . $conn->error;
            exit;
        }
    } else {
      
        $sql_insert_plato = "INSERT INTO platos (room_code, numero_plato, comentario, cantidad_total_pedidos) 
                             VALUES (?, ?, ?, ?)";
        $stmt_insert_plato = $conn->prepare($sql_insert_plato);
        $stmt_insert_plato->bind_param("issi", $room_code, $numero_plato, $nombre_plato, $cantidad);
        if ($stmt_insert_plato->execute() !== TRUE) {
            echo "Error al añadir el plato: " . $conn->error;
            exit;
        }
        
        $plato_id = $conn->insert_id;
    }

   
    $sql_get_user_id = "SELECT usuario_id FROM usuarios WHERE room_code = ? AND nombre = ? LIMIT 1";
    $stmt_get_user_id = $conn->prepare($sql_get_user_id);
    $stmt_get_user_id->bind_param("is", $room_code, $username);
    $stmt_get_user_id->execute();
    $result_user_id = $stmt_get_user_id->get_result();

    if ($result_user_id->num_rows > 0) {
        $row_user_id = $result_user_id->fetch_assoc();
        $usuario_id = $row_user_id['usuario_id'];

        
        $sql_insert_pedido = "INSERT INTO pedidos (usuario_id, plato_id, cantidad_pedido) VALUES (?, ?, ?)";
        $stmt_insert_pedido = $conn->prepare($sql_insert_pedido);
        $stmt_insert_pedido->bind_param("iii", $usuario_id, $plato_id, $cantidad);
        if ($stmt_insert_pedido->execute() !== TRUE) {
            echo "Error al añadir el pedido: " . $conn->error;
            exit;
        }
    } else {
        echo "Error: No se encontró el usuario para el nombre: $username y la sala: $room_code.";
        exit;
    }

  
    $conn->close();

    echo '<form id="redirectForm" action="./pedidos.php" method="POST">';
    echo '<input type="hidden" name="room_code" value="' . $room_code . '">';
    echo '<input type="hidden" name="username" value="' . urlencode($username) . '">';
    echo '</form>';
    echo '<script>document.getElementById("redirectForm").submit();</script>';
    exit;
}
?>
