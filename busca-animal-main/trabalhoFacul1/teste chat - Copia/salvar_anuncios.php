
<?php

session_start();
include ('lib/conexao.php'); // Arquivo de conexão ao banco de dados


if (isset($_SESSION['usuario_id'])) {
    $usuario_id = $_SESSION['usuario_id'];
    $nome_animal = $_POST['nome_animal'];
    $especie = $_POST['especie'];
    $raca = $_POST['raca'];
    $idade = $_POST['idade'];
    $cor = $_POST['cor'];
    $descricao = $_POST['descricao'];
    $data_perdido = $_POST['data_perdido'];
    $endereco = $_POST['endereco'];
    $contato = preg_replace('/\D/', '', $_POST['contato']);

    $imagem = $_FILES['imagem']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($imagem);

    if (move_uploaded_file($_FILES['imagem']['tmp_name'], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO anuncios (nome_animal, especie, raca, idade, cor, descricao, data_perdido, endereco, contato, imagem, usuario_id)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssss", $nome_animal, $especie, $raca, $idade, $cor, $descricao, $data_perdido, $endereco, $contato, $imagem, $usuario_id);

        if ($stmt->execute()) {
            header("Location: lista.php");
        } else {
            echo "Erro: " . $stmt->error;
        }
    } else {
        echo "Erro ao fazer upload da imagem.";
    }
} 

$conn->close();
?>
