$(document).ready(function() {
    $('#toggleButton').change(function() {
        $('body').toggleClass('light-mode'); // Alterna a classe light-mode no body

        // Altera o texto do botão com base no estado atual
        if ($('body').hasClass('light-mode')) {
            $('#toggleButton').attr('aria-label', 'Modo Escuro'); // Para acessibilidade
        } else {
            $('#toggleButton').attr('aria-label', 'Modo Claro'); // Para acessibilidade
        }
    });
});
