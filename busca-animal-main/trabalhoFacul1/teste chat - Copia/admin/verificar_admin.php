<?php

function verificarAdmin() {
    // Verifica se o usuário está logado e se é um administrador
    if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
        header("Location: acesso_negado.php");
        exit();
    }
}