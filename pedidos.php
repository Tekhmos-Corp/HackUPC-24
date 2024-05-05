<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buffet base</title>
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="cover.css">
  <link href='https://fonts.googleapis.com/css?family=Space Grotesk' rel='stylesheet'>
  <link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet'>
  <style>
    
    .platos-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    .platos-table th, .platos-table td {
      border: 1px solid #dee2e6;
      padding: 8px;
    }
    .platos-table th {
      background-color: #007bff;
      color: white;
    }
    .form-inline {
      margin-top: 20px;
    }
    .form-inline label {
      margin-right: 10px;
    }
    .form-inline input[type="number"],
    .form-inline input[type="text"],
    .form-inline button {
      margin-right: 10px;
    }
    .form-inline input[type="number"],
    .form-inline input[type="text"] {
      width: 150px;
    }
    .form-inline button {
      background-color: #007bff;
      color: white;
      border: none;
      padding: 10px 20px;
      cursor: pointer;
    }
    
  </style>
</head>
<body>

<div class="header">
  <h1>Sala
  <?php
      // Verificar si se recibió el código de sala
      if(isset($_POST['room_code'])) {
        echo $_POST['room_code']; // Mostrar el número de sala
      } else {
        echo "Error: No se especificó el código de sala.";
      }
      ?>
    </span>
    <span style=" font-family: 'Space Grotesk'; color: black; font-size: 40%;">
        <?php
        // Verificar si se recibió el nombre de usuario
        if(isset($_POST['username'])) {
            echo "Usuario: " . $_POST['username']; // Mostrar el nombre de usuario
        } else {
            echo "Error: No se especificó el nombre de usuario.";
        }
        ?>
    </span>
  </h1>
</div>

<div class="container">
  <?php
  // Verificar si se recibió el código de sala
  if(isset($_POST['room_code'])) {
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

    // Obtener el código de sala
    $room_code = $_POST['room_code'];

    // Consulta para obtener los platos pedidos en esta sala
    $sql = "SELECT pl.numero_plato, pl.comentario, u.nombre AS nombre_usuario, p.cantidad_pedido
            FROM platos pl
            INNER JOIN pedidos p ON pl.plato_id = p.plato_id
            INNER JOIN usuarios u ON p.usuario_id = u.usuario_id
            WHERE pl.room_code = '$room_code'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // Mostrar la tabla de platos pedidos
      echo "<table class='platos-table'>";
      echo "<tr><th>Número</th><th>Nombre</th><th>Usuario</th><th>Cantidad</th></tr>";
      while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row["numero_plato"]."</td>";
        echo "<td>".$row["comentario"]."</td>";
        echo "<td>".$row["nombre_usuario"]."</td>";
        echo "<td>".$row["cantidad_pedido"]."</td>";
        echo "</tr>";
      }
      echo "</table>";
    } else {
      echo "<p>No se encontraron platos pedidos en esta sala.</p>";
    }

    // Cerrar la conexión
    $conn->close();
  } else {
    echo "<p>No se especificó el código de sala.</p>";
  }
  ?>
</div>

 <!-- Formulario para agregar platos -->
<<!-- Formulario para agregar platos -->
<div class="arriba" id="footer">
  <form class="form-inline" action="./procesar_pedido.php" method="POST">
    <!-- Campo oculto para recibir el código de sala -->
    <input type="hidden" name="room_code" value="<?php echo isset($_POST['room_code']) ? $_POST['room_code'] : ''; ?>">

    <!-- Campo oculto para recibir el nombre de usuario -->
    <input type="hidden" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">

    <label for="num">Número de plato</label>
    <input type="number" id="num" placeholder="Nº" name="numero_plato" required>
    <label for="fn">Nombre del plato</label>
    <input type="text" id="fn" placeholder="Nombre del plato" name="nombre_plato">
    <label for="qn">Cantidad</label>
    <input type="number" id="qn" placeholder="Cantidad" name="cantidad" required>
    <button type="submit" name="submit">Agregar Plato</button>
  </form>
</div>

</body>
</html>
