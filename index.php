<?php
session_start();
include ('lib/conexao.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/x-icon" href="imagens/logotipo.png">
    <title>Home | Busca Animal</title>

    <!-- FONTES UTILIZADAS (ROBOTO, LORA) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/indexscript.js"></script>
    <link rel='stylesheet' href='https://unpkg.com/maplibre-gl@4.7.1/dist/maplibre-gl.css' />
    <script src='https://unpkg.com/maplibre-gl@4.7.1/dist/maplibre-gl.js'></script>
    <style>
        #map {             
            height: 500px;
            max-width: 1200px;
            margin: auto;
            padding: 2rem 1rem;

        }

        .maplibregl-popup-content {
            color: black; /* Altera a cor da fonte para preto */
            font-size: 14px; /* Ajusta o tamanho da fonte */
            font-weight: bold; /* Torna a fonte em negrito */
        }
    
    </style>
</head>

<body>
<style>
    .marker {
        display: block;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        padding: 0;
    }
</style>

    <div id="theme-toggle">
    <i id="theme-icon" class="fa-solid fa-sun"></i>
    </div>

    <nav>   
        <div class="nav-logo">
            <a href="index.php">
                <img src="imagens/logotipo.png" alt="Logo">
            </a>
        </div>

    <div class="header-icon">
        <!-- Verifica se o usuário está logado para exibir o ícone de perfil -->
            <div>
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <ul class="nav-menu">
                    <!-- Menus -->
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link"> Anúncios <i class="fas fa-chevron-down"></i></a>
                        <ul class="dropdown-menu">
                            <a href="meus_anuncios.php">Meus Anúncios</a>
                            <li><a href="lista.php">Buscar pets</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link" onclick="scrollToSection('contato')"> Contate-nos <i class="fas fa-chevron-down"></i></a>
                    </li>
                    <!-- Ícone de perfil com menu suspenso para usuário logado -->
                    <div class="profile-menu">
                    <img width="50" height="50" src="imagens/profile-round-1346-svgrepo-com.svg" alt="user-male-circle" alt="Perfil" class="profile-icon" onclick="toggleMenu()">
                        <div class="dropdown-menu" id="dropdown-menu">
                            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                                <li><a href="admin_dashboard.php">Dashboard</a></li>
                            <?php endif; ?>
                            <a href="resetar_senha.php">Redefinir senha</a>
                            <a href="logout.php">Logout</a>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Botões de Login e Cadastro para visitantes -->
                    <div class="auth-buttons">
                        <ul class="nav-links">
                            <li id="link1" class="link"> 
                                <a onclick="window.location.href='cadastro_usuario.php'">CADASTRE-SE</a> 
                                <i class="ri-user-line"></i>
                            </li>

                            <li id="link1" class="link"> 
                                <a onclick="window.location.href='login.php'"> LOGIN</a> 
                            </li>
                    <?php endif; ?>
                        </ul>
                    </div>
            </div>
    </div>

    </nav>

    <header class="container-header">
        <div class="conteudo">
            <H1>Reencontre seu melhor amigo.</H1>
            <p>
                Cada dia traz novas possibilidades e, mesmo que pareça difícil, 
                continue espalhando amor e cuidado. 
                Seu pet sente a sua energia e torce para voltar para casa.
            </p>
            <a href="cadastro_animal.php">
                <button class="btn">ANUNCIAR PET </button>
            </a>

            <a href="lista.php">
                <button class="btn">BUSCAR PETS </button>
            </a>
        </div>

        <div class="image">
            <img src="imagens/undraw_dog_c7i6 (3).svg">
        </div>
    </header>

     <section class="container">
        <h2 class="header">OBJETIVOS & METAS</h2>
        <div class="bloco-card">
            <div class="card" onclick="openPopup('popup1')">
                <span><i class="ri-search-line"></i></span>
                <h4>Visibilidade</h4>
                <p>
                    Proporcionar um espaço para divulgação de fotos e informações sobre pets desaparecidos, 
                    aumentando as chances de encontrá-los.
                </p>
            </div>
            <div class="card"  onclick="openPopup('popup2')">
                <span><i class="ri-service-fill"></i></span>
                <h4>Promover a Comunidade</h4>
                <p>
                    Fomentar uma rede de apoio entre amantes de animais, incentivando a solidariedade e a colaboração na busca.
                </p>
            </div>
            <div class="card" onclick="openPopup('popup3')">
                <span><i class="ri-book-fill"></i></span>
                <h4>Educar</h4>
                <p>
                    Informar os donos sobre medidas preventivas e ações a serem tomadas em caso de perda do pet.
                </p>
            </div>
            <div class="card" onclick="openPopup('popup4')">
                <span><i class="ri-shake-hands-line"></i></span>
                <h4>Conexão</h4>
                <p>
                    Criar um elo entre donos e voluntários para que possam se conectar rapidamente para ajudar na busca de pets perdidos.
                </p>
            </div>
        </div>
    </section>

        <div id="popup1" class="popup">
        <div class="popup-content">
            <span class="close-btn" onclick="closePopup('popup1')">&times;</span>
            <h3>Visibilidade</h3>
            <p>A visibilidade é essencial para ajudar a encontrar animais desaparecidos. 
                Por meio deste projeto, oferecemos um espaço dedicado à divulgação de informações, fotos e descrições de pets perdidos, aumentando significativamente as chances de reencontro. 
                Nosso objetivo é tornar o processo mais acessível e eficiente para todos os envolvidos.</p>

        </div>
    </div>
    <div id="popup2" class="popup">
        <div class="popup-content">
            <span class="close-btn" onclick="closePopup('popup2')">&times;</span>
            <h3>Promover a Comunidade</h3>
            <p>Este projeto visa unir amantes de animais e organizações dedicadas à causa, formando uma rede de apoio solidária. 
            Com a colaboração da comunidade, pretendemos incentivar o trabalho conjunto para oferecer suporte a donos em busca de seus pets e promover iniciativas de cuidado e proteção animal.</p>
        </div>
    </div>
    <div id="popup3" class="popup">
        <div class="popup-content">
            <span class="close-btn" onclick="closePopup('popup3')">&times;</span>
            <h3>Educar</h3>
            <p>A educação é uma ferramenta poderosa na prevenção de casos de perda de animais. Queremos capacitar donos com informações sobre segurança, cuidados essenciais e ações preventivas. 
                Além disso, fornecemos orientações detalhadas sobre como proceder em situações de desaparecimento para garantir uma busca rápida e eficaz.</p>

        </div>
    </div>
    <div id="popup4" class="popup">
        <div class="popup-content">
            <span class="close-btn" onclick="closePopup('popup4')">&times;</span>
            <h3>Conexão</h3>
            <p>Criamos este espaço com o propósito de estabelecer um elo entre donos de pets, voluntários e organizações de proteção animal. 
                A conexão possibilita que pessoas dispostas a ajudar possam se unir rapidamente em prol de um objetivo comum: trazer animais perdidos de volta ao lar de forma ágil e segura.</p>
        </div>
    </div>
     
    <div class="container">
        <h2> Busque apoio em ONGs próximas a você!</h2>
    </div>
    <div id="map"></div>

    <script>
                function openPopup(id) {
            document.getElementById(id).style.display = 'flex';
        }

        function closePopup(id) {
            document.getElementById(id).style.display = 'none';
        }
    </script>
   
    <script>
        const map = new maplibregl.Map({
            container: "map",
            style: "https://api.maptiler.com/maps/basic-v2/style.json?key=LircVPKHkODBtZ02mH3o",
            center: [-43.1729, -22.9068], // Centraliza o mapa para o Rio de Janeiro 
            zoom: 10,
        });
    </script>
    <script src="js/mapa.js"></script>
    
    
    <section class="container">
        <div class="about" id="about">
            <div class="esquerda">
                <img src="imagens/karsten-winegeart-qklA-HTyZ6k-unsplash.jpg" alt="Cachorro">
            </div>
            
            <div class="direita">
                <h1>Aprenda a prevenir desaparecimentos</h1>
                <p>
                    A prevenção é fundamental para garantir a saúde e o bem-estar dos pets.
                    Consulte nossas dicas abaixo para contribuir para a proteção dos nossos amigos de quatro patas.
                </p>

               <a href="index.saibamais.html">
                <button class="btn-inferior"> SAIBA MAIS </button>
               </a>
            </div>
        </div>
    </section> 
    <section class="container">
       
       <div class="container-form">
        <div class="form">

          <div class="contact-info">
            <h3 class="title">Contato</h3>
            <p class="text">
              Entre em contato conosco preenchendo o formulário ao lado. Faremos o <span class="bold"> máximo </span> para te ajudar!
            </p>
  
            <div class="info">
              <div class="information">
                <i class="ri-mail-fill"></i>
                 <p>projetobusca.animal@gmail.com  </p>
              </div>
            </div>
          </div>
  
          <div class="contact-form">
          
            <form action="lib/form_contato.php" id="contato"  method="POST">
              <h3 class="title">Fale conosco</h3>
              <div class="input-container">
                <input type="text" name="nome" class="input" placeholder="Nome" required>
              </div>

              <div class="input-container">
                <input type="email" name="email" class="input"placeholder='Email' required/>
              </div>

              <div class="input-container">
                <input type="text" name="assunto" class="input" placeholder="Assunto" />
              </div>

              <div class="input-container textarea">
                <textarea name="mensagem" class="input" placeholder="Mensagem" required></textarea>
              </div>

              <input type="submit" value="ENVIAR" class="btn-form" />
            </form>
          </div>
        </div>
      </div>
  
    </section> 

    <footer>
    
        <div class="top">
            <div class="logo">
                <a href="index.php">
                    <img src="imagens/logotipo.png" alt="Logo">
                </a>           
             </div>

            <ul>
                <li><a href="cadastro_usuario.php">Cadastre-se</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="index.saibamais.html">Saiba mais</a></li>
            </ul>
          
        </div>
        <div class="separator"></div>
    </footer>
   
<script>
    function scrollToSection(sectionId) {
        const section = document.getElementById(sectionId);
        section.scrollIntoView({
            behavior: 'smooth', // Rola suavemente
            block: 'start'      // Alinha a seção no topo
        });
    }

    // Função para exibir ou ocultar o menu suspenso
    function toggleMenu() {
        var menu = document.getElementById("dropdown-menu");
        menu.style.display = (menu.style.display === "block") ? "none" : "block";
    }

    // Ocultar o menu suspenso ao clicar fora dele
    window.onclick = function(event) {
        var menu = document.getElementById("dropdown-menu");
        if (menu && !event.target.closest(".profile-menu")) {
            menu.style.display = "none";
        }
    }
</script>
</body>
</html>
   