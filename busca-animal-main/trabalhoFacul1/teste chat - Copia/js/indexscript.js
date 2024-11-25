$(document).ready(function () {
    $('#toggleButton').click(function () {
        $('body').toggleClass('light-mode'); // Alterna entre os modos

        // Altera o atributo de acessibilidade
        if ($('body').hasClass('light-mode')) {
            $('#toggleButton').attr('aria-label', 'Modo Escuro'); // Texto para modo claro ativo
        } else {
            $('#toggleButton').attr('aria-label', 'Modo Claro'); // Texto para modo escuro ativo
        }
    });
});
