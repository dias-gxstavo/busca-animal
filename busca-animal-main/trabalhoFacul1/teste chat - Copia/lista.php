<?php
include ('lib/conexao.php');

// Recebe os filtros (se fornecidos)
$endereco = isset($_GET['endereco']) ? $_GET['endereco'] : '';
$especie = isset($_GET['especie']) ? $_GET['especie'] : '';
$raca = isset($_GET['raca']) ? $_GET['raca'] : '';
$data_perdido = isset($_GET['data_perdido']) ? $_GET['data_perdido'] : '';

// Constrói a consulta SQL com base nos filtros
$sql = "SELECT * FROM anuncios WHERE 1=1";

// Aplica o filtro de localização
if (!empty($endereco)) {
    $sql .= " AND endereco LIKE ?";
}

// Aplica o filtro de especie
if (!empty($especie)) {
    $sql .= " AND especie LIKE ?";
}

// Aplica o filtro de raça
if (!empty($raca)) {
    $sql .= " AND raca LIKE ?";
}

// Aplica o filtro de data de desaparecimento
if (!empty($data_perdido)) {
    $sql .= " AND data_perdido = ?";
}

$stmt = $conn->prepare($sql);

// Vincula os parâmetros dinamicamente
$bindParams = [];
if (!empty($endereco)) $bindParams[] = '%' . $endereco . '%';
if (!empty($especie)) $bindParams[] = '%' . $especie . '%';
if (!empty($raca)) $bindParams[] = '%' . $raca . '%';
if (!empty($data_perdido)) $bindParams[] = $data_perdido;

if ($bindParams) {
    $types = str_repeat('s', count($bindParams)); // Define os tipos dos parâmetros
    $stmt->bind_param($types, ...$bindParams);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../teste chat - Copia/css/lista.css">
    <link rel="stylesheet" href="../teste chat - Copia/js/lista.js">

    <script src="../teste chat - Copia/js/lista.js"></script>

</head>
<body>
<section class="container">
    <div class="filter-bar">
        <form method="GET" action="lista.php" class="animal">

        <label for="especie">Tipo de Animal:</label>
            <select name="especie" id="especie" >
                <option class="filtro" value="">Todos</option>
                <option value="cachorro" <?php if ($especie == 'cachorro') echo 'selected'; ?>>Cachorro</option>
                <option value="gato" <?php if ($especie == 'gato') echo 'selected'; ?>>Gato</option>
                <!-- Adicione mais tipos conforme necessário -->
            </select>

            <label for="endereco">Endereço:</label>
            <input type="text" name="endereco" id="endereco" placeholder="Cidade ou Bairro" value="<?php echo htmlspecialchars($endereco); ?>">

            <label for="data_inicio">Data de desaparecimento:</label>
            <input type="date" name="data_perdido" id="data_perdido" value="<?php echo htmlspecialchars($data_perdido); ?>">

            <button type="submit">Buscar</button>
        </form>
    </div>


        <div class="bloco-card">
                <div class="gallery-container">
            <?php while ($anuncio = $result->fetch_assoc()): ?>
                <a href="detalhes_anuncio.php?id=<?php echo $anuncio['id']; ?>" class="card-link">
                    <div class="card">
                        <img src="uploads/<?php echo htmlspecialchars($anuncio['imagem']); ?>" alt="Foto do Animal">
                        <h3><?php echo htmlspecialchars($anuncio['nome_animal']); ?></h3>
                    </div>
                </a>
            <?php endwhile; ?>
        </div>
</section>



</body>
</html>

