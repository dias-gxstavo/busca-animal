<?php
session_start();
include ('lib/conexao.php');
include ('admin/verificar_admin.php'); // Chama a função para restringir o acesso
verificarAdmin(); // Garante que apenas administradores acessem


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Excluir o anúncio do banco de dados
    $query = "DELETE FROM anuncios WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Anúncio excluído com sucesso.";
    } else {
        echo "Erro ao excluir o anúncio.";
    }
    
    header("Location: admin_dashboard.php");
    exit();
}
?>
