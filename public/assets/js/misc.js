// Funciones misceláneas para la aplicación

// Función para inicializar el modal de cierre de caja
function initCloseCashRegisterModal() {
    // Obtener el botón que abre el modal
    const closeButton = document.querySelector('[data-bs-target="#closeCashRegisterModal"]');
    if (closeButton) {
        closeButton.addEventListener('click', function() {
            // Aquí puedes agregar lógica adicional antes de abrir el modal
            console.log('Abriendo modal de cierre de caja');
        });
    }

    // Obtener el formulario del modal
    const closeForm = document.getElementById('closeCashRegisterForm');
    if (closeForm) {
        closeForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Obtener los valores del formulario
            const formData = new FormData(this);

            // Enviar la solicitud al servidor
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mostrar mensaje de éxito
                    alert(data.message);
                    // Recargar la página o actualizar la tabla
                    window.location.reload();
                } else {
                    // Mostrar mensaje de error
                    alert(data.message || 'Error al cerrar la caja');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al procesar la solicitud');
            });
        });
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    initCloseCashRegisterModal();
});
