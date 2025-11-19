export class Helpers {
    static mostrarLoading(mensaje = 'Cargando...') {
        const loadingHTML = `
            <div class="loading-overlay">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">${mensaje}</span>
                </div>
                <p class="mt-2">${mensaje}</p>
            </div>
        `;
        
        // Remover loading existente primero
        this.ocultarLoading();
        document.body.insertAdjacentHTML('beforeend', loadingHTML);
    }

    static ocultarLoading() {
        const loading = document.querySelector('.loading-overlay');
        if (loading) loading.remove();
    }

    static mostrarAlerta(mensaje, tipo = 'success') {
        // Crear elemento de alerta
        const alertaId = 'alert-' + Date.now();
        const alertaHTML = `
            <div id="${alertaId}" class="alert alert-${tipo} alert-dismissible fade show" role="alert">
                ${mensaje}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        // Insertar al inicio del main
        const main = document.querySelector('main');
        if (main) {
            main.insertAdjacentHTML('afterbegin', alertaHTML);
            
            // Auto-eliminar después de 5 segundos
            setTimeout(() => {
                const alert = document.getElementById(alertaId);
                if (alert) {
                    alert.remove();
                }
            }, 5000);
        }
    }

    static formatearFecha(fecha) {
        if (!fecha) return 'N/A';
        return new Date(fecha).toLocaleDateString('es-ES', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    static formatearFechaParaInput(fecha) {
        if (!fecha) return '';
        const date = new Date(fecha);
        return date.toISOString().slice(0, 16);
    }

    static confirmarAccion(mensaje = '¿Estás seguro de realizar esta acción?') {
        return new Promise((resolve) => {
            // Usar el confirm nativo del navegador por simplicidad
            const resultado = confirm(mensaje);
            resolve(resultado);
        });
    }
}