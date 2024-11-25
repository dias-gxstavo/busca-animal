<?php

include ('lib/conexao.php'); // Arquivo de conexão ao banco de dados


// Verifica se o ID do anúncio foi passado na URL
if (isset($_GET['id'])) {
    $anuncio_id = $_GET['id'];

    // Busca as informações do anúncio e do dono
    $stmt = $conn->prepare("SELECT anuncios.*, usuario.nome AS dono_nome, usuario.telefone AS dono_contato FROM anuncios JOIN usuario ON anuncios.usuario_id = usuario.id WHERE anuncios.id = ?");
    $stmt->bind_param("i", $anuncio_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $anuncio = $result->fetch_assoc();
    } else {
        echo "Anúncio não encontrado.";
        exit;
    }
    $stmt->close();
} else {
    echo "ID do anúncio não foi fornecido.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <title>Detalhes do Anúncio</title>
    <link rel="stylesheet" href="../teste chat - Copia/css/detalhes_anuncio.css">
</head>


<body>
    <div class="details-container">
        <h2><?php echo htmlspecialchars($anuncio['nome_animal']); ?></h2>
        <img src="uploads/<?php echo htmlspecialchars($anuncio['imagem']); ?>" alt="Imagem do Pet">
        <p><strong>Raça:</strong> <?php echo htmlspecialchars($anuncio['raca']); ?></p>
        <p><strong>Idade:</strong> <?php echo htmlspecialchars($anuncio['idade']); ?> anos</p>
        <p><strong>Cor:</strong> <?php echo htmlspecialchars($anuncio['cor']); ?></p>
        <p><strong>Descrição:</strong> <?php echo htmlspecialchars($anuncio['descricao']); ?></p>
        <p><strong>Data Perdido:</strong> <?php echo htmlspecialchars($anuncio['data_perdido']); ?></p>
        <p><strong>Endereço:</strong> <?php echo htmlspecialchars($anuncio['endereco']); ?></p>
        <p><strong>Número para contato:</strong> <?php echo htmlspecialchars($anuncio['dono_contato']); ?></p>    
    </div>


    
</body>
</html>
