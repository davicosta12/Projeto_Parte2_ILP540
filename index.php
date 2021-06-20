<?php 

$servername = "localhost";
$username = "root";
$password = "davi10";
$dbname = "mydb";

// dados do formulário
$nome = filter_input(INPUT_POST, 'usuario_nome', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'usuario_email', FILTER_SANITIZE_EMAIL);
$telefone = filter_input(INPUT_POST, 'usuario_telefone', FILTER_SANITIZE_STRING);
$msg = filter_input(INPUT_POST, 'usuario_msg', FILTER_SANITIZE_STRING);

// Cria conexão 
$conn = mysqli_connect($servername, $username, $password);
$db = mysqli_select_db($conn, $dbname);

// Checa a conexão
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if($db) {
  $conn = mysqli_connect($servername, $username, $password, $dbname);

  // Checa a conexão
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  $table = "myguests";
  $result = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
  $tableExists = $result && $result->num_rows > 0;

  if (!$tableExists) {
    // sql para criar a tabela
    $sql = "CREATE TABLE MyGuests (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(28) NOT NULL,
    email VARCHAR(28) NOT NULL,
    telefone VARCHAR(11) NOT NULL,
    mensagem VARCHAR(75) NOT NULL
    )";
    
    if (mysqli_query($conn, $sql)) {
      echo "Table MyGuests created successfully";
    } else {
      echo "Error creating table: " . mysqli_error($conn);
    }
  }

  // sql para inserir dados na tabela criada
  $sql = "INSERT INTO MyGuests (nome, email, telefone, mensagem)
  VALUES ('$nome',  '$email', '$telefone', '$msg')";

  if (mysqli_query($conn, $sql)) {
    if ($tableExists) {
      $text = "New record ($nome,  $email, $telefone, $msg) created successfully";
      echo $text;
    } else {
      $text = "\nNew record ($nome,  $email, $telefone, $msg) created successfully";
      echo nl2br($text);
    }
  } else {
    if ($tableExists) {
      $text = "\nError: " . $sql . "<br>" . mysqli_error($conn);
      echo nl2br($text);
    } else {
      $text = "Error: " . $sql . "<br>" . mysqli_error($conn);
      echo $text;
    }
    
  }

  mysqli_close($conn);
} else {

  // Cria data base
  $sql = "CREATE DATABASE myDB";
  if (mysqli_query($conn, $sql)) {
    echo "Database created successfully. Enter the data again in the form.";
  } else {
    echo "Error creating database: " . mysqli_error($conn);
  }

  mysqli_close($conn);
}
 
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    a {
      text-decoration: none;
      color: blue;
      transition: .5s;
    } 
    a:hover {
      color: #87CEFA;
    }
  </style>
  <title>Projeto - parte 2</title>
</head>

<body>
  <br>
  <a href="index.html"><h3>Volte para o formulário clicando aqui</h3></a>
</body>

</html>