<div class="preferences-wrapper">
    <button id="preferencesButton" class="preferences-trigger">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
        </svg>
    </button>

    <div id="preferencesOverlay" class="preferences-overlay"></div>

    <div id="preferencesCanvas" class="preferences-canvas">
        <div class="canvas-header">
            <h2>Preferences</h2>
            <button id="closeButton" class="close-button" aria-label="Close">
                <span class="close-icon"></span>
            </button>
        </div>

        <div class="canvas-content">
            <!-- Settings Sections -->
            <div class="settings-sections">
                <!-- Appearance Section -->
                <div class="settings-section">
                    <div class="section-header">
                        <div class="section-icon">🎨</div>
                        <h3>{{ __('common.appearance') }}</h3>
                    </div>
                    <div class="section-content">
                        <div class="setting-item">
                            <div class="setting-info">
                                <span class="setting-label">{{ __('common.dark_mode') }}</span>
                                <span class="setting-description">Switch theme</span>
                            </div>
                            <button class="theme-toggle" id="themeToggle" aria-label="Toggle theme">
                                <span class="theme-toggle-track">
                                    <span class="theme-toggle-thumb"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Language Section -->
                <div class="settings-section">
                    <div class="section-header">
                        <div class="section-icon">🌍</div>
                        <h3>{{ __('common.language') }}</h3>
                    </div>
                    <div class="section-content">
                        <div class="language-grid">
                            <button class="language-option active">
                                <span class="lang-flag">🇺🇸</span>
                                <span class="lang-name">English</span>
                            </button>
                            <button class="language-option">
                                <span class="lang-flag">🇫🇷</span>
                                <span class="lang-name">Français</span>
                            </button>
                            <button class="language-option">
                                <span class="lang-flag">🇸🇦</span>
                                <span class="lang-name">العربية</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .preferences-wrapper {
        position: fixed;
        right: 1.5rem;
        bottom: 1.5rem;
        z-index: 9999;
        /* Increased z-index */
    }

    .preferences-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(4px);
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 9998;
        /* Just below the canvas */
    }

    .preferences-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .preferences-trigger {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: white;
        width: 3.5rem;
        height: 3.5rem;
        border-radius: 1rem;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
    }

    .preferences-trigger:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
    }

    .preferences-canvas {
        position: fixed;
        top: 0;
        right: 0;
        width: 400px;
        height: 100vh;
        background: #ffffff;
        box-shadow: -10px 0 40px -5px rgba(0, 0, 0, 0.2);
        z-index: 9999;
        /* Same as wrapper */
        display: flex;
        flex-direction: column;
        transform: translateX(100%);
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .preferences-canvas.active {
        transform: translateX(0);
    }

    .canvas-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border-bottom: 1px solid #e2e8f0;
    }

    .header-content h2 {
        font-size: 1.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, #1e293b, #334155);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 0.25rem;
    }

    /* Rest of the styles remain the same but with improved colors and shadows */
    .menu-item {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .menu-item:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        transform: translateX(4px);
    }

    .menu-item.active {
        background: #eef2ff;
        border-color: #c7d2fe;
    }

    .section-icon {
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
    }

    /* Add smooth scrollbar for the content */
    .canvas-content {
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 #f1f5f9;
    }

    .canvas-content::-webkit-scrollbar {
        width: 6px;
    }

    .canvas-content::-webkit-scrollbar-track {
        background: #f1f5f9;
    }

    .canvas-content::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 3px;
    }

    .canvas-header {
        background: #fff;
        border-bottom: 1px solid #e5e7eb;
        padding: 1.5rem;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 1rem;
        padding: 1rem;
        background: linear-gradient(to right, #f3f4f6, #f9fafb);
        border-radius: 1rem;
    }

    .user-avatar {
        width: 3rem;
        height: 3rem;
        border-radius: 1rem;
        overflow: hidden;
    }

    .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .user-details {
        display: flex;
        flex-direction: column;
    }

    .user-name {
        font-weight: 600;
        color: #1f2937;
    }

    .user-email {
        font-size: 0.875rem;
        color: #6b7280;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
        padding: 1.5rem;
        background: #fff;
        border-bottom: 1px solid #e5e7eb;
    }

    .quick-action-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem;
        border-radius: 1rem;
        background: #f9fafb;
        color: #4b5563;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .quick-action-item:hover {
        background: #f3f4f6;
        transform: translateY(-2px);
    }

    .action-icon {
        padding: 0.75rem;
        background: #fff;
        border-radius: 0.75rem;
        color: #4f46e5;
    }

    .settings-sections {
        padding: 1.5rem;
    }

    .settings-section {
        background: #fff;
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 1rem;
        border: 1px solid #e2e8f0;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .section-icon {
        font-size: 1.25rem;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8fafc;
        border-radius: 8px;
    }

    .setting-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: #f9fafb;
        border-radius: 0.75rem;
    }

    .setting-info {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .setting-label {
        font-weight: 500;
        color: #1f2937;
    }

    .setting-description {
        font-size: 0.875rem;
        color: #6b7280;
    }

    .language-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
    }

    .language-option {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .language-option:hover {
        background: #f3f4f6;
        border-color: #d1d5db;
    }

    .language-option.active {
        background: #eef2ff;
        border-color: #c7d2fe;
    }

    .lang-flag {
        font-size: 1.5rem;
    }

    .lang-name {
        font-size: 0.875rem;
        font-weight: 500;
        color: #4b5563;
    }

    /* Improved toggle switch */
    .toggle-switch label {
        background: #e5e7eb;
        width: 3rem;
        height: 1.75rem;
        border-radius: 1rem;
        position: relative;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .toggle-switch label:after {
        content: '';
        position: absolute;
        top: 0.25rem;
        left: 0.25rem;
        width: 1.25rem;
        height: 1.25rem;
        border-radius: 50%;
        background: #fff;
        transition: all 0.3s ease;
    }

    .toggle-switch input:checked+label {
        background: #4f46e5;
    }

    .toggle-switch input:checked+label:after {
        transform: translateX(1.25rem);
    }

    .close-button {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        background: #f1f5f9;
        position: relative;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .close-button:hover {
        background: #e2e8f0;
    }

    .close-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 16px;
        height: 16px;
        transform: translate(-50%, -50%);
    }

    .close-icon::before,
    .close-icon::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 2px;
        background-color: #64748b;
        top: 50%;
        left: 0;
    }

    .close-icon::before {
        transform: rotate(45deg);
    }

    .close-icon::after {
        transform: rotate(-45deg);
    }

    .close-button:hover .close-icon::before,
    .close-button:hover .close-icon::after {
        background-color: #ef4444;
    }

    /* New theme toggle styles */
    .theme-toggle {
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
    }

    .theme-toggle-track {
        width: 48px;
        height: 24px;
        background-color: #e2e8f0;
        border-radius: 12px;
        position: relative;
        display: block;
        transition: background-color 0.3s ease;
    }

    .theme-toggle-thumb {
        width: 20px;
        height: 20px;
        background-color: white;
        border-radius: 50%;
        position: absolute;
        top: 2px;
        left: 2px;
        transition: transform 0.3s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .theme-toggle[aria-checked="true"] .theme-toggle-track {
        background-color: #4f46e5;
    }

    .theme-toggle[aria-checked="true"] .theme-toggle-thumb {
        transform: translateX(24px);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const button = document.getElementById('preferencesButton');
        const canvas = document.getElementById('preferencesCanvas');
        const overlay = document.getElementById('preferencesOverlay');
        const closeButton = document.getElementById('closeButton');
        const themeToggle = document.getElementById('themeToggle');

        // Theme toggle functionality
        themeToggle.setAttribute('aria-checked', 'false');

        themeToggle.addEventListener('click', function() {
            const isChecked = this.getAttribute('aria-checked') === 'true';
            this.setAttribute('aria-checked', !isChecked);
            // Add your theme switching logic here
        });

        function toggleCanvas() {
            canvas.classList.toggle('active');
            overlay.classList.toggle('active');
            document.body.style.overflow = canvas.classList.contains('active') ? 'hidden' : '';
        }

        function closeCanvas() {
            canvas.classList.remove('active');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        button.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleCanvas();
        });

        closeButton.addEventListener('click', closeCanvas);
        overlay.addEventListener('click', closeCanvas);

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && canvas.classList.contains('active')) {
                closeCanvas();
            }
        });
    });
</script>
