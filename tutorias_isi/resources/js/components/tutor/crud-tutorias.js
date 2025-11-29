import { Helpers } from '../../../utils/helpers.js';
import { API } from '../../../utils/api.js';

class CRUDTutorias {
    constructor() {
        this.tutorias = [];
        this.modal = null;
        this.init();
    }

    async init() {
        await this.cargarTutorias();
        this.configurarEventos();
        this.inicializarModal();
    }

    configurarEventos() {
        // Botón nueva tutoría
        document.getElementById('btnNuevaTutoria')?.addEventListener('click', () => {
            this.mostrarModalCrear();
        });

        // Botón guardar tutoría
        document.getElementById('btnGuardarTutoria')?.addEventListener('click', () => {
            this.guardarTutoria();
        });

        // Cerrar modal al guardar
        document.getElementById('modalTutoria')?.addEventListener('hidden.bs.modal', () => {
            this.limpiarFormulario();
        });
    }

    inicializarModal() {
        const modalElement = document.getElementById('modalTutoria');
        if (modalElement) {
            this.modal = new bootstrap.Modal(modalElement);
        }
    }

    async cargarTutorias() {
        try {
            this.tutorias = await API.getTutorias();
            this.mostrarTutorias();
        } catch (error) {
            console.error('Error cargando tutorías:', error);
        }
    }

    mostrarTutorias() {
        const tbody = document.getElementById('tutoriasBody');
        if (!tbody) return;

        if (this.tutorias.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        No hay tutorías registradas
                    </td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = this.tutorias.map(tutoria => `
            <tr>
                <td>${tutoria.titulo || 'Sin título'}</td>
                <td>${tutoria.estudiante_nombre || 'Sin asignar'}</td>
                <td>${Helpers.formatearFecha(tutoria.fecha_tutoria)}</td>
                <td>${tutoria.duracion_minutos || 60} min</td>
                <td>
                    <span class="badge badge-estado bg-${this.getColorEstado(tutoria.estado)}">
                        ${this.formatearEstado(tutoria.estado)}
                    </span>
                </td>
                <td class="table-actions">
                    <button class="btn btn-sm btn-outline-primary me-1" onclick="window.crudTutorias.editarTutoria(${tutoria.id})">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="window.crudTutorias.eliminarTutoria(${tutoria.id})">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `).join('');
    }

    mostrarModalCrear() {
        document.getElementById('modalTitulo').textContent = 'Nueva Tutoría';
        document.getElementById('tutoria_id').value = '';
        this.modal?.show();
    }

    async editarTutoria(id) {
        try {
            const tutoria = await API.getTutoria(id);
            
            document.getElementById('modalTitulo').textContent = 'Editar Tutoría';
            document.getElementById('tutoria_id').value = tutoria.id;
            document.getElementById('titulo').value = tutoria.titulo || '';
            document.getElementById('fecha_tutoria').value = Helpers.formatearFechaParaInput(tutoria.fecha_tutoria);
            document.getElementById('duracion_minutos').value = tutoria.duracion_minutos || 60;
            document.getElementById('descripcion').value = tutoria.descripcion || '';
            
            this.modal?.show();
        } catch (error) {
            console.error('Error cargando tutoría:', error);
        }
    }

    async guardarTutoria() {
        const formData = {
            titulo: document.getElementById('titulo').value,
            fecha_tutoria: document.getElementById('fecha_tutoria').value,
            duracion_minutos: parseInt(document.getElementById('duracion_minutos').value),
            descripcion: document.getElementById('descripcion').value
        };

        const tutoriaId = document.getElementById('tutoria_id').value;

        try {
            if (tutoriaId) {
                await API.updateTutoria(tutoriaId, formData);
                Helpers.mostrarAlerta('Tutoría actualizada exitosamente');
            } else {
                await API.createTutoria(formData);
                Helpers.mostrarAlerta('Tutoría creada exitosamente');
            }

            await this.cargarTutorias();
            this.modal?.hide();
        } catch (error) {
            console.error('Error guardando tutoría:', error);
        }
    }

    async eliminarTutoria(id) {
        const confirmado = await Helpers.confirmarAccion('¿Estás seguro de eliminar esta tutoría?');
        if (!confirmado) return;

        try {
            await API.deleteTutoria(id);
            Helpers.mostrarAlerta('Tutoría eliminada exitosamente');
            await this.cargarTutorias();
        } catch (error) {
            console.error('Error eliminando tutoría:', error);
        }
    }

    limpiarFormulario() {
        document.getElementById('formTutoria')?.reset();
        document.getElementById('tutoria_id').value = '';
    }

    formatearEstado(estado) {
        const estados = {
            'programada': 'Programada',
            'en_curso': 'En Curso',
            'completada': 'Completada',
            'cancelada': 'Cancelada',
            'activa': 'Activa',
            'pendiente': 'Pendiente'
        };
        return estados[estado] || estado;
    }

    getColorEstado(estado) {
        const colores = {
            'programada': 'primary',
            'en_curso': 'warning',
            'completada': 'success',
            'cancelada': 'danger',
            'activa': 'success',
            'pendiente': 'warning'
        };
        return colores[estado] || 'secondary';
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    // Solo inicializar si estamos en una página de tutorías
    if (document.getElementById('tutoriasBody')) {
        window.crudTutorias = new CRUDTutorias();
    }
});

export default CRUDTutorias;