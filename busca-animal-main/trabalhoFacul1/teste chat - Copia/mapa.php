<?php
include ('lib/conexao.php'); // Arquivo de conexão ao banco de dados



// Buscar os anúncios de animais perdidos
$sql = "SELECT * FROM anuncios WHERE latitude IS NOT NULL AND longitude IS NOT NULL";
$result = $conn->query($sql);

// Verificar se há resultados
$animais = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Adicionar os dados dos animais ao array
        $animais[] = [
            'titulo' => $row['nome_animal'],
            'endereco' => $row['endereco'],
            'latitude' => $row['latitude'],
            'longitude' => $row['longitude']
        ];
    }
}

// Fechar a conexão
$conn->close();

// Retornar os dados como JSON
echo json_encode($animais);
?>