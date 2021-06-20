<?php 

/* FUNCTIONS */

function sqlCriaBanco() {
  //sql para criar data base
  $sql = "CREATE DATABASE myDB";
  return $sql;
}

function criaBanco($conn, $sql) {
  // Cria data base
  if (mysqli_query($conn, $sql)) {
    echo "Database created successfully.";
  } else {
    echo "Error creating database: " . mysqli_error($conn);
  }
}

function sqlCriaTabela() {
  // sql para criar a tabela
  $sql = "CREATE TABLE MyGuests (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    telefone VARCHAR(13) NOT NULL,
    mensagem VARCHAR(75) NOT NULL
    )";
  return $sql;
}

function criaTabela($conn, $sql, bool $quebraLinhaMsg) {
  // cria a tabela
  if ($quebraLinhaMsg) {
    if (mysqli_query($conn, $sql)) {
      $text = "\nTable MyGuests created successfully";
      echo nl2br($text);
    } else {
      $text = "\nError creating table: " . mysqli_error($conn);
      echo nl2br($text);
    }
  } else {
    if (mysqli_query($conn, $sql)) {
      echo "Table MyGuests created successfully";
    } else {
      echo "Error creating table: " . mysqli_error($conn);
    }
  }
}

function sqlInseriDados(string $nome, string $email, string $telefone, string $msg) {
  // sql para inserir dados na tabela 
  $sql = "INSERT INTO MyGuests (nome, email, telefone, mensagem)
  VALUES ('$nome',  '$email', '$telefone', '$msg')";
  return $sql;
}

function inseriDados($conn, $sql,
  string $nome, string $email, string $telefone, string $msg,
  bool $allMsgQuebraLinha, $tableExists = null) {
  // Inseri dados na tabela
  if($allMsgQuebraLinha) {
    if (mysqli_query($conn, $sql)) {
      $text = "\nNew record ($nome,  $email, $telefone, $msg) created successfully";
      echo nl2br($text);
    } else {
      $text = "\nError: " . $sql . "<br>" . mysqli_error($conn);
      echo nl2br($text);
    }
  } else {
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
  }
  
}

function checaConexao($conn) {
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
}

/* MAIN */

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";

// dados do formulário
$nome = filter_input(INPUT_POST, 'usuario_nome', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'usuario_email', FILTER_SANITIZE_EMAIL);
$telefone = filter_input(INPUT_POST, 'usuario_telefone', FILTER_SANITIZE_STRING);
$msg = filter_input(INPUT_POST, 'usuario_msg', FILTER_SANITIZE_STRING);

// Cria conexão 
$conn = mysqli_connect($servername, $username, $password);

// Checa a conexão
checaConexao($conn);

// Verifica se existe o banco pelo nome
$db = mysqli_select_db($conn, $dbname);

// Realiza a conexão caso exista o banco
if($db) {
  // Cria conexão
  $conn = mysqli_connect($servername, $username, $password, $dbname);

  // Checa a conexão
  checaConexao($conn);

  $table = "myguests";
  $result = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
  $tableExists = $result && $result->num_rows > 0;

  // Verifica se existe a tabela pelo nome
  if (!$tableExists) {
    // sql para criar a tabela
    $sql = sqlCriaTabela();
    criaTabela($conn, $sql, false);
  }

  // sql para inserir dados na tabela criada
  $sql = sqlInseriDados($nome, $email, $telefone, $msg);
  inseriDados($conn, $sql, $nome, $email, $telefone, $msg, false, $tableExists);
  
  mysqli_close($conn);

} else {
  $sql = sqlCriaBanco();
  criaBanco($conn, $sql);

  // Cria conexão
  $conn = mysqli_connect($servername, $username, $password, $dbname);

  // Checa a conexão
  checaConexao($conn);

  // sql para criar a tabela
  $sql = sqlCriaTabela();  
  criaTabela($conn, $sql, true);
  
  // sql para inserir dados na tabela criada
  $sql = sqlInseriDados($nome, $email, $telefone, $msg);
  inseriDados($conn, $sql, $nome, $email, $telefone, $msg, true);

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
      display: inline-block;
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