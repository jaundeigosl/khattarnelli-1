const modal = document.getElementById('crear-producto-modal');
const btnAbrir = document.getElementById('abrir-modal-btn');
const btnCerrar = document.querySelector('.close-btn');
const btnCancelar = document.getElementById('cancelar-modal-btn');

btnAbrir.onclick = function() {
    modal.style.display = "block";
}

btnCerrar.onclick = function() {
    modal.style.display = "none";
}

btnCancelar.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
}