/* ============================================================
   SGPE — Thème clair / sombre
   - Applique la classe "sombre" sur <html> le plus tôt possible
   - Ajoute un bouton flottant de bascule (🌙 / ☀️)
   - Persiste le choix dans localStorage['sgpe-theme']
   ============================================================ */
(function () {
    var KEY = 'sgpe-theme';

    function lireTheme() {
        try { return localStorage.getItem(KEY) || 'clair'; }
        catch (e) { return 'clair'; }
    }

    function appliquer(theme) {
        document.documentElement.classList.toggle('sombre', theme === 'sombre');
        if (window.Chart) {
            Chart.defaults.color = theme === 'sombre' ? '#9FB0CC' : '#666';
            Chart.defaults.borderColor = theme === 'sombre' ? 'rgba(148,163,184,0.15)' : 'rgba(0,0,0,0.08)';
        }
    }

    // Application immédiate (avant le rendu) pour éviter le flash
    var theme = lireTheme();
    appliquer(theme);

    // Bascule + bouton flottant une fois le DOM prêt
    document.addEventListener('DOMContentLoaded', function () {
        // Chart.js est chargé entre-temps : synchroniser ses couleurs par défaut
        appliquer(theme);

        var btn = document.createElement('button');
        btn.type = 'button';
        btn.id = 'btn-theme';
        btn.title = 'Basculer clair / sombre';
        btn.setAttribute('aria-label', 'Basculer clair / sombre');
        btn.innerHTML = theme === 'sombre' ? '☀️' : '🌙';
        Object.assign(btn.style, {
            position: 'fixed',
            bottom: '20px',
            right: '20px',
            zIndex: '9999',
            width: '46px',
            height: '46px',
            borderRadius: '50%',
            border: 'none',
            background: '#1D84F5',
            color: '#fff',
            fontSize: '20px',
            cursor: 'pointer',
            boxShadow: '0 4px 14px rgba(0,0,0,0.3)',
            transition: 'transform 0.15s'
        });
        btn.onmouseenter = function () { btn.style.transform = 'scale(1.08)'; };
        btn.onmouseleave = function () { btn.style.transform = 'scale(1)'; };
        btn.onclick = function () {
            theme = document.documentElement.classList.contains('sombre') ? 'clair' : 'sombre';
            try { localStorage.setItem(KEY, theme); } catch (e) {}
            appliquer(theme);
            btn.innerHTML = theme === 'sombre' ? '☀️' : '🌙';
            // Redessiner les graphiques existants avec les bonnes couleurs
            if (window.Chart && typeof window.dessinerGraphiques === 'function' && window._sgpeBiens) {
                try { window.dessinerGraphiques(window._sgpeBiens); } catch (e) {}
            }
        };
        document.body.appendChild(btn);
    });
})();
