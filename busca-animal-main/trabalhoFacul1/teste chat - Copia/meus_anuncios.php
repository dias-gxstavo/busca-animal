<?php
session_start();

include ('lib/conexao.php'); // Arquivo de conexão ao banco de dados

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
$usuario_id = $_SESSION['usuario_id'];

// Verifica se foi solicitado a exclusão de um anúncio
if (isset($_GET['excluir_id'])) {
    $anuncio_id = $_GET['excluir_id'];

    // Exclui o anúncio do banco de dados
    $sql_delete = "DELETE FROM anuncios WHERE id = ? AND usuario_id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("ii", $anuncio_id, $usuario_id);
    
    if ($stmt_delete->execute()) {
        echo "<p>Anúncio excluído com sucesso.</p>";
    } else {
        echo "<p>Erro ao excluir anúncio.</p>";
    }
    $stmt_delete->close();
}

// Busca os anúncios do usuário
$sql = "SELECT id, nome_animal, descricao, imagem FROM anuncios WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busca Animal | Meus Anúncios</title>
    <link rel="stylesheet" href="../teste chat - Copia/css/meus_anuncios.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../teste chat - Copia/css/meus_anuncios.css">
</head>

<body>

<div class="container">
    <h2> Anúncios ativos:</h2>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="anuncio-container">
                <!-- Exibe a foto do anúncio -->
                <img src="uploads/<?php echo htmlspecialchars($row['imagem']); ?>" alt="Foto do Anúncio">

                <!-- Exibe o título e a descrição do anúncio -->
                <div class="anuncio-detalhes">
                    <h3><?php echo htmlspecialchars($row['nome_animal']); ?></h3>
                    <p><?php echo htmlspecialchars($row['descricao']); ?></p>
                </div>

                <!-- Botão para excluir o anúncio -->
                <form method="get" action="meus_anuncios.php" style="margin: 0;">
                    <input type="hidden" name="excluir_id" value="<?php echo $row['id']; ?>">
                    <button type="submit" class="excluir-btn" onclick="return confirm('Tem certeza que deseja excluir este anúncio?');">Excluir</button>
                </form>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Você não possui anúncios.</p>
    <?php endif; ?>

    <?php
    $stmt->close();
    $conn->close();
    ?>
</div>  
</body>
</html>
