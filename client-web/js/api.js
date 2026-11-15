
const API_CONFIG = {
    baseURL: 'http://localhost',
    ports: {
        biens: 8001,
        gestion: 8002,
        admin: 8003
    }
};

class ApiClient {
    constructor(service) {
        this.baseURL = `${API_CONFIG.baseURL}:${API_CONFIG.ports[service]}/api`;
        this.token = localStorage.getItem('auth_token');
    }

    getHeaders() {
        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        };
        if (this.token) {
            headers['Authorization'] = `Bearer ${this.token}`;
        }
        return headers;
    }

    async request(endpoint, options = {}) {
        try {
            const response = await fetch(`${this.baseURL}${endpoint}`, {
                ...options,
                headers: this.getHeaders()
            });

            const data = await response.json();

            if (!response.ok) {
                return {
                    success: false,
                    status: response.status,
                    message: data.message || 'Erreur de requête',
                    errors: data.errors || null
                };
            }

            return {
                success: true,
                status: response.status,
                data: data.data || data,
                message: data.message || 'Succès'
            };
        } catch (error) {
            return {
                success: false,
                status: 0,
                message: 'Erreur de connexion au serveur',
                error: error.message
            };
        }
    }

    get(endpoint, params = {}) {
        const query = new URLSearchParams(params).toString();
        const url = query ? `${endpoint}?${query}` : endpoint;
        return this.request(url, { method: 'GET' });
    }

    post(endpoint, data) {
        return this.request(endpoint, {
            method: 'POST',
            body: JSON.stringify(data)
        });
    }

    put(endpoint, data) {
        return this.request(endpoint, {
            method: 'PUT',
            body: JSON.stringify(data)
        });
    }

    delete(endpoint) {
        return this.request(endpoint, { method: 'DELETE' });
    }
}

export default ApiClient;
