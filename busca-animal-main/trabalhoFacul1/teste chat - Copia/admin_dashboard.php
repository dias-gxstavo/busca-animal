<?php
session_start();
include 'lib/conexao.php';
include 'admin/verificar_admin.php'; // Verifica se é admin
verificarAdmin(); // Restringe o acesso a administradores

// Consulta para obter todos os anúncios
$query = "SELECT * FROM anuncios";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="pt-br">
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.min.css">
    <link rel="icon" type="image/x-icon" href="../teste chat - Copia/imagens/logotipo.png">
    <title>Dashboard - Adm | Busca Animal</title>

    <!-- FONTES UTILIZADAS (ROBOTO, LORA) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Administrativo</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Dashboard do Administrador</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome do Pet</th>
            <th>Contato do Dono</th>
            <th>Data</th>
            <th>Ações</th>
        </tr>
        <?php while ($anuncio = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $anuncio['id']; ?></td>
                <td><?php echo $anuncio['nome_animal']; ?></td>
                <td><?php echo $anuncio['contato']; ?></td>
                <td><?php echo $anuncio['data_perdido']; ?></td>
                <td>
                    <a href="editar_anuncio.php?id=<?php echo $anuncio['id']; ?>">Editar</a> |
                    <a href="excluir_anuncio.php?id=<?php echo $anuncio['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este anúncio?');">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
