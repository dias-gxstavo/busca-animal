<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="../teste chat - Copia/css/stylecadastro.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body>
  <header>
        <div class="logo-container">
            <a href="index.php">
                <img src="../teste chat - Copia/imagens/logotipo.png" alt="Logo do Site" class="logo">
            </a>
        </div>
    </header>
    <div class="container mt-5">
        <form method="POST" action="" class="mt-4">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome Completo</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Seu nome completo">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Seu e-mail">
            </div>
            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone Celular</label>
                <input type="text" class="form-control" id="telefone" name="telefone" placeholder="XX-XXXXXXXX">
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" maxlength="8" placeholder="Sua senha">
            </div>
            <div class="mb-3">
                <label for="confirmar_senha" class="form-label">Confirmação de Senha</label>
                <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" maxlength="8" placeholder="Confirme sua senha">
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>

    <?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Conexão com o banco de dados
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "busca_animal";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Falha na conexão: " . $conn->connect_error);
        }

        // Capturando e validando os dados
        $nome = trim($_POST["nome"]);
        $email = trim($_POST["email"]);
        $telefone = trim($_POST["telefone"]);
        $senha = $_POST["senha"];
        $confirmar_senha = $_POST["confirmar_senha"];
        $erros = [];

        // Validação dos campos
        if (strlen($nome) < 15 || strlen($nome) > 80 || !preg_match("/^[a-zA-Z\s]+$/", $nome)) {
            $erros[] = "O nome deve ter entre 15 e 80 caracteres e conter apenas letras e espaços.";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erros[] = "O e-mail fornecido não é válido.";
        }
        if (!preg_match('/^\d{11}$/', $telefone)) {
          $erros[] = "O telefone celular deve conter exatamente 11 dígitos (apenas números, incluindo o DDD).";
        }      
        if (strlen($senha) != 8 || !ctype_alnum($senha)) {
            $erros[] = "A senha deve ter exatamente 8 caracteres alfanuméricos.";
        }
        if ($senha !== $confirmar_senha) {
            $erros[] = "As senhas não correspondem.";
        }

        // Exibindo erros ou processando cadastro
        if (!empty($erros)) {
            echo "<script>";
            foreach ($erros as $erro) {
                echo "Swal.fire({
                    icon: 'error',
                    title: 'Erro de Validação',
                    text: '$erro',
                    showConfirmButton: true
                });";
            }
            echo "</script>";
        } else {
            // Inserindo dados no banco de dados
            $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);
            $sql = "INSERT INTO usuario (nome, email, telefone, senha) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $nome, $email, $telefone, $senha_criptografada);

            if ($stmt->execute()) {

	          $usuario_id = $stmt->insert_id;

            // Cria a sessão para o novo usuário, como se ele tivesse feito login
            $_SESSION['usuario_id'] = $usuario_id;
            $_SESSION['usuario_nome'] = $nome;

  
              echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Cadastro Realizado!',
                        text: 'Usuário cadastrado com sucesso!',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        window.location.href = 'index.php';
                    });
                </script>";
            } else {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro no Cadastro',
                        text: 'Houve um problema ao cadastrar. Tente novamente.',
                        showConfirmButton: true
                    });
                </script>";
            }

            $stmt->close();
        }

        $conn->close();
    }
    ?>
</body>
</html>
