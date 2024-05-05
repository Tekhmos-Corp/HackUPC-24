<?php
session_start();


if(isset($_POST['room_code']) && isset($_POST['username'])) {

    $room_code = $_POST['room_code'];
    $username = $_POST['username'];

   
    $servername = "localhost";
    $db_username = "tekhmos";
    $db_password = "Tekhmos12";
    $dbname = "BadDays";


    $conn = new mysqli($servername, $db_username, $db_password, $dbname);


    if ($conn->connect_error) {
        die("Can't connect to DB: " . $conn->connect_error);
    }

   
    $sql_check_user = "SELECT * FROM usuarios WHERE nombre = ? AND room_code = ?";
    $stmt = $conn->prepare($sql_check_user);
    $stmt->bind_param("si", $username, $room_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      
        echo '<form id="redirectForm" action="./pedidos.php" method="POST">';
        echo '<input type="hidden" name="room_code" value="' . $room_code . '">';
        echo '<input type="hidden" name="username" value="' . urlencode($username) . '">';
        echo '</form>';
        echo '<script>document.getElementById("redirectForm").submit();</script>';
        exit;
    } else {
     
        $sql_insert_user = "INSERT INTO usuarios (nombre, room_code) VALUES (?, ?)";
        $stmt = $conn->prepare($sql_insert_user);
        $stmt->bind_param("si", $username, $room_code);
        if ($stmt->execute() === TRUE) {
     
            echo '<form id="redirectForm" action="./pedidos.php" method="POST">';
            echo '<input type="hidden" name="room_code" value="' . $room_code . '">';
            echo '<input type="hidden" name="username" value="' . urlencode($username) . '">';
            echo '</form>';
            echo '<script>document.getElementById("redirectForm").submit();</script>';
            exit;
        } else {
            echo "Error joining user to room: " . $conn->error;
        }
    }


    $conn->close();
} else {
    echo "Error: Room code and username not specified. <a href='../.'>Go back</a>";
}
?>
