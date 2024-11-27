// Controle do menu hambúrguer (3 listras)
const hamburger = document.querySelector('.hamburger');
const sidebar = document.querySelector('.sidebar');

hamburger.addEventListener('click', () => {
    sidebar.classList.toggle('open'); // Abre ou fecha a sidebar
    hamburger.classList.toggle('active'); // Altera a cor do ícone quando aberto
});


// Função para adicionar efeito de animação na sidebar
document.querySelector(".sidebar a").addEventListener("click", function () {
    this.classList.add("active");
    // Remove a classe active de outros links
    const links = document.querySelectorAll(".sidebar a");
    links.forEach(link => {
        if (link !== this) {
            link.classList.remove("active");
        }
    });
});

let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".sidebarBtn");

// Verificar estado salvo no localStorage
if (localStorage.getItem("sidebarState") === "active") {
    sidebar.classList.add("active");
    sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
}

// Alternar estado ao clicar no botão
sidebarBtn.onclick = function () {
    sidebar.classList.toggle("active");

    if (sidebar.classList.contains("active")) {
        sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        localStorage.setItem("sidebarState", "active"); // Salvar estado
    } else {
        sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
        localStorage.setItem("sidebarState", "inactive"); // Salvar estado
    }
};
