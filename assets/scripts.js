document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("#livroForm");
    if (!form) return;

    const tituloInput = document.querySelector("#titulo");
    const autorInput = document.querySelector("#autor");
    const categoriaSelect = document.querySelector("#categoria");
    const statusSelect = document.querySelector("#status");

    form.addEventListener("submit", (event) => {
        let hasError = false;

        document.querySelectorAll(".client-error").forEach(el => el.style.display = "none");

        if (!tituloInput.value.trim() || tituloInput.value.trim().length < 2) {
            showError("tituloError", "O título é obrigatório e deve ter ao menos 2 caracteres.");
            hasError = true;
        }

        if (!autorInput.value.trim() || autorInput.value.trim().length < 2) {
            showError("autorError", "O autor é obrigatório e deve ter ao menos 2 caracteres.");
            hasError = true;
        }

        if (!categoriaSelect.value) {
            showError("categoriaError", "Selecione uma categoria válida.");
            hasError = true;
        }

        const statusValidos = ["Nunca lido", "Em andamento", "Lido"];
        if (!statusValidos.includes(statusSelect.value)) {
            showError("statusError", "Selecione um status válido.");
            hasError = true;
        }

        if (hasError) {
            event.preventDefault(); 
        }
    });

    function showError(elementId, message) {
        const errorEl = document.getElementById(elementId);
        if (errorEl) {
            errorEl.textContent = message;
            errorEl.style.display = "block";
        }
    }
});
