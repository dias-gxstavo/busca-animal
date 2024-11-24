// Função para buscar e filtrar animais com base na barra de pesquisa
function buscarAnimal() {
    const searchInput = document.getElementById('searchBar').value.toLowerCase();
    const animalCards = document.querySelectorAll('.animal-card');

    animalCards.forEach(card => {
        const animalName = card.getAttribute('data-name').toLowerCase();
        if (animalName.includes(searchInput)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// Função de Validação do Formulário de Cadastro
document.getElementById('cadastroForm')
