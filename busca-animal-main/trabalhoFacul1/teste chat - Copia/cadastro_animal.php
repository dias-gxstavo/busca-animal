<?php include 'auth.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../teste chat - Copia/css/style copy.css">
    <title>Anuncie seu Pet | Busca Animal</title>
    <link rel="icon" type="image/x-icon" href="../teste chat - Copia/imagens/logotipo.png">
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet" />
</head>

<body>

    <div class="container">
    
        <div class="form-image">
        </div>
        
        <div class="form" method="post" action="salvar_anuncios.php">
            <div class="form-header">
                <div class="title">
                    <h1>Crie o anúncio do seu pet</h1>
                </div>
            </div>

            <form action="salvar_anuncios.php" method="POST" enctype="multipart/form-data">
                <div class="input-group">

                    <div class="input-box">
                        <label for="nome">Nome do pet</label>
                        <input id="nome" type="text" name="nome_animal" placeholder="Digite o nome do pet" required>
                    </div>
                    
                    <div class="input-box">
                        <label for="especie">Espécie  </label>
                       <select name="especie" id="especie" required>
                        <option value="cachorro"> Cachorro</option>
                        <option value="gato"> Gato</option>
                       </select>
                    </div>

                    <div class="input-box">
                        <label for="raca">Raça</label>
                        <input id="raca" type="text" name="raca" placeholder="Digite a raça do pet">
                    </div>

                    <div class="input-box">
                        <label for="idade">Idade</label>
                        <input id="idade" type="text" name="idade" placeholder="Digite a idade do pet">
                    </div>

                    <div class="input-box">
                        <label for="cor">Cor</label>
                        <input id="cor" type="text" name="cor" placeholder="Digite a cor do pet" required>
                    </div>

                    <div class="input-box">
                        <label for="descricao">Descrição</label>
                        <textarea name="descricao" id="descricao" cols="30" rows="10"></textarea>
                    </div> 

                    <div class="input-box">
                        <label for="data_perdido">Data de desaparecimento (aproximada)</label>
                        <input id="data" type="date" name="data_perdido" required>
                    </div>

                    <div class="input-box">
                        <label for="endereco">Endereço</label>
                        <input type="text" id="endereco" name="endereco" autocomplete="off" required placeholder="Digite o endereco de busca">
                        <div id="suggestions" class="autocomplete-suggestions"></div>
                    </div>


                    <div class="input-box">
                        <label for="contato">Contato</label>
                        <input type="text" name="contato" placeholder="Digite um número para possíveis contatos">
                    </div>

                    <div class="input-box">
                        <label for="foto">Foto do pet</label>
                        <input id="foto" type="file" name="imagem" accept="image/*" required>
                    </div> 
                </div>
            
                <div class="continue-button">
                    <button><a href="#">CRIAR ANUNCIO</a> </button>
                </div>
            </form>
        </div>
    </div>
     <script>
        const MAPBOX_TOKEN = 'pk.eyJ1IjoiZGlhc2d4c3Rhdm8iLCJhIjoiY20zN2liMWtsMDZvODJqcHU2c2ZtdmpsZCJ9.afC_oBHqQYESnTgLjmBOXg';

        const enderecoInput = document.getElementById('endereco');
        const suggestionsBox = document.getElementById('suggestions');

        enderecoInput.addEventListener('input', function () {
            const query = enderecoInput.value;

            if (query.length > 2) {
                fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(query)}.json?access_token=${MAPBOX_TOKEN}&autocomplete=true`)
            .then(response => response.json())
            .then(data => {
                suggestionsBox.innerHTML = ''; // Limpa sugestões anteriores

                if (data.features && data.features.length) {
                    data.features.forEach(feature => {
                        // Busca os componentes desejados
                        const rua = feature.text || ''; // Nome da rua
                        const cidade = feature.context?.find(c => c.id.startsWith('place'))?.text || ''; // Cidade

                        // Cria o elemento de sugestão
                        const suggestion = document.createElement('div');
                        suggestion.className = 'autocomplete-suggestion';
                        suggestion.textContent = `${rua}, ${cidade}`;
                        suggestion.onclick = () => {
                            enderecoInput.value = `${rua}, ${cidade}`; // Preenche o input
                            document.getElementById('rua').value = rua; // Preenche o campo oculto da rua
                            document.getElementById('cidade').value = cidade; // Preenche o campo oculto da cidade
                            suggestionsBox.innerHTML = ''; // Limpa sugestões
                        };
                        suggestionsBox.appendChild(suggestion);
                    });
                }
            })
            .catch(error => console.error('Erro ao buscar sugestões:', error));
    } else {
        suggestionsBox.innerHTML = ''; // Limpa sugestões se o input for pequeno
    }
});

        // Fecha as sugestões se o usuário clicar fora do input
        document.addEventListener('click', function (event) {
            if (!enderecoInput.contains(event.target)) {
                suggestionsBox.innerHTML = '';
            }
        });
</script> 
</body>
</html>