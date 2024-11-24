<?php
session_start();
include ('lib/conexao.php');
include ('admin/verificar_admin.php'); // Chama a função para restringir o acesso
verificarAdmin(); // Garante que apenas administradores acessem

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obter os detalhes do anúncio
    $query = "SELECT * FROM anuncios WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $anuncio = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome_animal = $_POST['nome_animal'];
        $descricao = $_POST['descricao'];

        // Atualizar o anúncio no banco de dados
        $query = "UPDATE anuncios SET nome_animal = ?, descricao = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $nome_animal, $descricao, $id);

        if ($stmt->execute()) {
            echo "Anúncio atualizado com sucesso.";
            header("Location: admin_dashboard.php");
            exit();
        } else {
            echo "Erro ao atualizar o anúncio.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Anúncio</title>
</head>
<body>
    <h2>Editar Anúncio</h2>
    <form action="editar_anuncio.php?id=<?php echo $id; ?>" method="POST">
        <label for="titulo">Nome do pet:</label>
        <input type="text" name="nome_animal" value="<?php echo $anuncio['nome_animal']; ?>" required><br>
        
        <label for="descricao">Descrição:</label>
        <textarea name="descricao" required><?php echo $anuncio['descricao']; ?></textarea><br>
        
        <button type="submit">Atualizar Anúncio</button>
    </form>
</body>
</html>
