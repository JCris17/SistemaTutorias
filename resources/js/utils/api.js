import { Helpers } from './helpers.js';

export class API {
    static baseURL = '/api';

    static async request(endpoint, options = {}) {
        const url = `${this.baseURL}${endpoint}`;
        
        // Configuración por defecto
        const config = {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin',
            ...options
        };

        // Si hay body, convertirlo a JSON
        if (config.body && typeof config.body === 'object') {
            config.body = JSON.stringify(config.body);
        }

        try {
            Helpers.mostrarLoading();
            const response = await fetch(url, config);
            
            if (!response.ok) {
                const errorData = await response.json().catch(() => ({}));
                throw new Error(errorData.message || `Error ${response.status}: ${response.statusText}`);
            }

            const data = await response.json();
            return data;
            
        } catch (error) {
            console.error('API Error:', error);
            Helpers.mostrarAlerta(error.message || 'Error en la conexión', 'danger');
            throw error;
        } finally {
            Helpers.ocultarLoading();
        }
    }

    // Métodos para tutorías
    static async getTutorias(params = '') {
        return await this.request(`/tutorias${params}`);
    }

    static async getTutoria(id) {
        return await this.request(`/tutorias/${id}`);
    }

    static async createTutoria(tutoriaData) {
        return await this.request('/tutorias', {
            method: 'POST',
            body: tutoriaData
        });
    }

    static async updateTutoria(id, tutoriaData) {
        return await this.request(`/tutorias/${id}`, {
            method: 'PUT',
            body: tutoriaData
        });
    }

    static async deleteTutoria(id) {
        return await this.request(`/tutorias/${id}`, {
            method: 'DELETE'
        });
    }

    // Métodos para usuarios
    static async getUsuarios() {
        return await this.request('/usuarios');
    }

    static async createUsuario(usuarioData) {
        return await this.request('/usuarios', {
            method: 'POST',
            body: usuarioData
        });
    }

    static async updateUsuario(id, usuarioData) {
        return await this.request(`/usuarios/${id}`, {
            method: 'PUT',
            body: usuarioData
        });
    }

    static async desactivarUsuario(id) {
        return await this.request(`/usuarios/${id}/desactivar`, {
            method: 'PUT'
        });
    }
}