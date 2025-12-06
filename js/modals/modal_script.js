document.addEventListener('DOMContentLoaded', function() {

    const modalCrear = document.getElementById('crear-producto-modal');
    const btnAbrirCrear = document.getElementById('abrir-modal-btn');
    const btnCerrarCrear = document.querySelector('#crear-producto-modal .close-btn');
    const btnCancelarCrear = document.getElementById('cancelar-modal-btn');

    if (btnAbrirCrear) {
        btnAbrirCrear.onclick = function() {
            modalCrear.style.display = "block";
        }
    }

    if (btnCerrarCrear) {
        btnCerrarCrear.onclick = function() {
            modalCrear.style.display = "none";
        }
    }

    if (btnCancelarCrear) {
        btnCancelarCrear.onclick = function() {
            modalCrear.style.display = "none";
        }
    }

    const modalEditar = document.getElementById('editar-producto-modal');
    const btnCerrarEditar = document.querySelector('#editar-producto-modal .close-btn-edit');
    const btnCancelarEditar = document.getElementById('cancelar-edit-btn');

    if (btnCerrarEditar) {
        btnCerrarEditar.onclick = function() {
            modalEditar.style.display = "none";
        }
    }

    if (btnCancelarEditar) {
        btnCancelarEditar.onclick = function() {
            modalEditar.style.display = "none";
        }
    }

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('edit-btn')) {
            const button = e.target;
            const row = button.closest('tr');
            
            if (row) {
                const id = row.getAttribute('data-id');
                const nombre = row.getAttribute('data-nombre');
                const precio = row.getAttribute('data-precio');
                const descripcion = row.getAttribute('data-descripcion');
                
                document.getElementById('edit-id').value = id;
                document.getElementById('edit-nombre').value = nombre;
                document.getElementById('edit-precio').value = precio;
                document.getElementById('edit-descripcion').value = descripcion;
                document.getElementById('producto-nombre-edit').textContent = nombre;
                
                modalEditar.style.display = "block";
            }
        }
    });

    // -------------------------------------------------------------
    // LÓGICA GLOBAL DE CIERRE AL HACER CLIC FUERA
    // -------------------------------------------------------------

    window.addEventListener('click', function(event) {
        if (event.target === modalCrear) {
            modalCrear.style.display = "none";
        }
        if (modalEditar && event.target === modalEditar) {
            modalEditar.style.display = "none";
        }
    });
});