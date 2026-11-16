/* ============================================================
   SGPE — Client API
   Passerelle unique : /api  (proxifié par nginx du client-web)
   Services : biens -> /api/biens/*   gestion -> /api/gestion/*   admin -> /api/admin/*
   ============================================================ */
const SGPE = (() => {
    // Local (Docker) : /api est proxifié par nginx du client-web vers la passerelle.
    // En ligne (Render) : chaque service a sa propre URL, pas de passerelle.
    const IS_LOCAL = ['localhost', '127.0.0.1'].includes(location.hostname);
    // Surcharge possible : définir window.SGPE_REMOTE_URLS = { biens: '...', ... }
    // dans la console ou un script avant api.js si les URLs Render diffèrent.
    const REMOTE = window.SGPE_REMOTE_URLS || {
        biens: 'https://sgpe-biens.onrender.com/api',
        gestion: 'https://sgpe-gestion.onrender.com/api',
        admin: 'https://sgpe-admin.onrender.com/api'
    };
    const PREFIX = { biens: '', gestion: '/gestion', admin: '/admin' };

    function url(service, endpoint) {
        return IS_LOCAL
            ? '/api' + PREFIX[service] + endpoint
            : REMOTE[service] + endpoint;
    }

    let token = localStorage.getItem('auth_token') || null;

    function setToken(t) {
        token = t;
        if (t) localStorage.setItem('auth_token', t);
        else localStorage.removeItem('auth_token');
    }

    function getToken() { return token; }

    async function request(service, endpoint, options = {}) {
        if (!IS_LOCAL && !REMOTE[service]) throw new Error('Service inconnu : ' + service);
        if (IS_LOCAL && PREFIX[service] === undefined) throw new Error('Service inconnu : ' + service);

        const res = await fetch(url(service, endpoint), {
            ...options,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                ...(token ? { Authorization: `Bearer ${token}` } : {}),
                ...(options.headers || {})
            }
        });

        let body = null;
        try { body = await res.json(); } catch (e) { /* réponse non JSON */ }

        // Token expiré ou révoqué -> retour à la connexion
        if (res.status === 401 && !endpoint.endsWith('/login')) {
            effacerSession();
            const page = location.pathname.split('/').pop();
            if (page !== 'login.html' && page !== 'index.html') {
                location.href = 'login.html';
            }
        }

        return { ok: res.ok, status: res.status, data: body };
    }

    function get(service, endpoint, params = {}) {
        const qs = new URLSearchParams(
            Object.fromEntries(Object.entries(params).filter(([, v]) => v !== undefined && v !== null && v !== ''))
        ).toString();
        return request(service, endpoint + (qs ? '?' + qs : ''), { method: 'GET' });
    }

    function post(service, endpoint, data) {
        return request(service, endpoint, { method: 'POST', body: JSON.stringify(data) });
    }

    function put(service, endpoint, data) {
        return request(service, endpoint, { method: 'PUT', body: JSON.stringify(data) });
    }

    function del(service, endpoint) {
        return request(service, endpoint, { method: 'DELETE' });
    }

    return { get, post, put, del, setToken, getToken };
})();

/* ==================== Session & helpers ==================== */

function getUtilisateur() {
    try { return JSON.parse(localStorage.getItem('utilisateur') || 'null'); }
    catch (e) { return null; }
}

function estConnecte() {
    return localStorage.getItem('connecte') === 'oui' && !!SGPE.getToken();
}

function effacerSession() {
    localStorage.removeItem('connecte');
    localStorage.removeItem('utilisateur');
    SGPE.setToken(null);
}

function requireAuth() {
    if (!estConnecte()) {
        window.location.href = 'login.html';
        return false;
    }
    return true;
}

async function deconnecter() {
    try { await SGPE.post('admin', '/logout'); } catch (e) { /* silencieux */ }
    effacerSession();
    window.location.href = 'login.html';
}

function afficherUtilisateur() {
    const u = getUtilisateur();
    const el = document.getElementById('nom-utilisateur');
    if (el && u) {
        el.textContent = [u.prenom, u.nom].filter(Boolean).join(' ') || u.email || 'Utilisateur';
    }
}

function formaterFCFA(n) {
    const v = Number(n);
    return (isNaN(v) ? 0 : v).toLocaleString('fr-FR') + ' FCFA';
}

function formaterDate(d) {
    if (!d) return '—';
    const date = new Date(String(d).slice(0, 10) + 'T00:00:00');
    return isNaN(date) ? d : date.toLocaleDateString('fr-FR');
}

function echapper(s) {
    return String(s ?? '').replace(/[&<>"']/g, c => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
    }[c]));
}
