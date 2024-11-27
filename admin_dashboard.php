<?php
session_start();
include 'lib/conexao.php';
include 'admin/verificar_admin.php'; // Verifica se é admin
verificarAdmin(); // Restringe o acesso a administradores

// Definir os filtros padrão
$nome_animal = isset($_GET['nome_animal']) ? $_GET['nome_animal'] : '';
$especie = isset($_GET['especie']) ? $_GET['especie'] : '';
$data_perdido = isset($_GET['data_perdido']) ? $_GET['data_perdido'] : '';

// Construção da consulta com base nos filtros
$query = "SELECT * FROM anuncios WHERE 1";

if (!empty($nome_animal)) {
    $query .= " AND nome_animal LIKE '%" . $conn->real_escape_string($nome_animal) . "%'";
}

if (!empty($especie)) {
    $query .= " AND especie LIKE '%" . $conn->real_escape_string($especie) . "%'";
}

if (!empty($data_perdido)) {
    $query .= " AND data_perdido = '" . $conn->real_escape_string($data_perdido) . "'";
}

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="pt-br">
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.min.css">
    <link rel="icon" type="image/x-icon" href="imagens/logotipo.png">
	<link rel="stylesheet" href="css/style-dashboard.css">
	<script src="js/script-dashboard.js" defer></script>
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
        h2 {
            margin: 20px;
            text-align: center;
            color: #333;
        }
    </style>

    <script>
        // Função para confirmação de exclusão de anúncio
        function confirmDelete() {
            return confirm('Tem certeza que deseja excluir este anúncio?');
        }
    </script>
</head>

<body>
<div class="sidebar">
      <div class="logo-details">
      <i class="bi bi-clipboard-check"></i>
        <span class="logo_name">ADM</span>
      </div>
      <ul class="nav-links">
        <li>
          <a href="#" class="active">
            <i class="bx bx-grid-alt"></i>
            <span class="links_name">Dashboard</span>
          </a>
        </li>
        <li>
          <a href="meus_anuncios.php">
            <i class="bx bx-box"></i>
            <span class="links_name">Meus Anúncios</span>
          </a>
        </li>
        <li class="log_out">
          <a href="logout.php">
            <i class="bx bx-log-out"></i>
            <span class="links_name">Sair</span>
          </a>
        </li>
      </ul>
    </div>
    <section class="home-section">
      <nav>
        <div class="sidebar-button">
          <i class="bx bx-menu sidebarBtn"></i>
          <span class="dashboard">Dashboard</span>
        </div>
        
        <div class="profile-details">
          <img src="imagens/logotipo.png" alt="" />
          <span class="admin_name">Busca Animal</span>
          <i class="bx bx-chevron-down"></i>
        </div>
      </nav>

      <div class="main-content" style="margin-left: 10px; padding: 20px;">
    <h2>Dashboard do Administrador</h2>

    <!-- Filtro -->
    <form method="GET" action="" class="filter-form">
        <input type="number" name="filter-id" placeholder="ID" value="<?php echo isset($_GET['filter-id']) ? $_GET['filter-id'] : ''; ?>">
        <input type="text" name="filter-nome" placeholder="Nome do Pet" value="<?php echo isset($_GET['filter-nome']) ? $_GET['filter-nome'] : ''; ?>">
        <select name="filter-especie">
            <option value="">Espécie</option>
            <option value="cachorro" <?php echo (isset($_GET['filter-especie']) && $_GET['filter-especie'] == 'cachorro') ? 'selected' : ''; ?>>Cachorro</option>
            <option value="gato" <?php echo (isset($_GET['filter-especie']) && $_GET['filter-especie'] == 'gato') ? 'selected' : ''; ?>>Gato</option>
        </select>
        <input type="text" name="filter-contato" placeholder="Contato" value="<?php echo isset($_GET['filter-contato']) ? $_GET['filter-contato'] : ''; ?>">
        <input type="date" name="filter-data" value="<?php echo isset($_GET['filter-data']) ? $_GET['filter-data'] : ''; ?>">
        <button type="submit">Filtrar</button>
    </form>

    <!-- Box para a Tabela -->
    <div class="table-box">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome do Pet</th>
                    <th>Espécie</th>
                    <th>Data</th>
                    <th>Contato do Dono</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Construção da consulta com filtros
                $query = "SELECT * FROM anuncios WHERE 1=1";

                if (!empty($_GET['filter-id'])) {
                    $id = intval($_GET['filter-id']);
                    $query .= " AND id = $id";
                }
                if (!empty($_GET['filter-nome'])) {
                    $nome = $conn->real_escape_string($_GET['filter-nome']);
                    $query .= " AND nome_animal LIKE '%$nome%'";
                }
                if (!empty($_GET['filter-especie'])) {
                    $especie = $conn->real_escape_string($_GET['filter-especie']);
                    $query .= " AND especie = '$especie'";
                }

                if (!empty($_GET['filter-contato'])) {
                    $contato = $conn->real_escape_string($_GET['filter-contato']);
                    $query .= " AND contato LIKE '%$contato%'";
                }

                if (!empty($_GET['filter-data'])) {
                    $data = $conn->real_escape_string($_GET['filter-data']);
                    $query .= " AND data_perdido = '$data'";
                }

                $result = $conn->query($query);

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['nome_animal']}</td>
                                <td>{$row['especie']}</td>
                                <td>{$row['data_perdido']}</td>
                                <td>{$row['contato']}</td>
                                <td class='actions'>
                                    <a href='editar_anuncio.php?id={$row['id']}'>Editar</a> |
                                    <a href='excluir_anuncio.php?id={$row['id']}' onclick='return confirmDelete();'>Excluir</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Nenhum resultado encontrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

    <script>
   let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".sidebarBtn");
sidebarBtn.onclick = function() {
  sidebar.classList.toggle("active");
  if(sidebar.classList.contains("active")){
  sidebarBtn.classList.replace("bx-menu" ,"bx-menu-alt-right");
}else
  sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
}
 </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybB4p5aC4A4Kt0uR1v6n5RfFmPqWdo0v0p/ScB9tRi2BdQFpr4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0g1zN4Kpq8ZnV0gA1XvHhz2VY2z6ck7FVTVNkx0z5L7WhBbs" crossorigin="anonymous"></script>
</body>
</html>