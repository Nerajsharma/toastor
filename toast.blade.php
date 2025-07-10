<!-- Toast Container -->
<div id="toast-container"></div>

<style>
    .toast-position {
        position: fixed;
        z-index: 9999;
        pointer-events: none;
        max-width: 100%;
    }

    .toast-top-right    { top: 1rem; right: 1rem; }
    .toast-top-left     { top: 1rem; left: 1rem; }
    .toast-bottom-right { bottom: 1rem; right: 1rem; }
    .toast-bottom-left  { bottom: 1rem; left: 1rem; }
    .toast-top-center   { top: 1rem; left: 50%; transform: translateX(-50%); }
    .toast-bottom-center{ bottom: 1rem; left: 50%; transform: translateX(-50%); }

    .toaster {
        position: relative;
        margin-bottom: 10px;
        pointer-events: auto;
        animation-duration: 0.6s;
        animation-fill-mode: both;
    }

    .toaster.slide-down {
        transition: 0.3s ease-in-out;
        transform: translateY(100%);
        opacity: 0;
    }

    .toaster::before {
        position: absolute;
        content: "";
        width: 100%;
        height: 3px;
        right: 0;
        bottom: 0;
        background-color: var(--barColor, #000); /* Default fallback */
        animation: toaster_timeup var(--timeout, 5s) linear;
    }

    @keyframes toaster_timeup {
        to { width: 0%; }
    }

    @keyframes slide-in-right {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    @keyframes slide-in-left {
        from { transform: translateX(-100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    @keyframes slide-in-bottom {
        from { transform: translateY(100%); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    @keyframes slide-in-top {
        from { transform: translateY(-100%); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .toaster i:first-child {
        font-size: 26px;
    }

    .toaster i:last-child {
        padding: 4px 6px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 12px;
        transition: 0.2s;
    }

    .toaster i:last-child:hover {
        background-color: transparent;
    }
</style>

<script>
    class Toaster {
        constructor(options = {}) {
            this.config = {
                theme: 'light', // light | dark | custom
                iconStyle: '2d', // 2d | 3d
                timeout: 5000,
                position: 'top-right',
                boxShadow: 'light', // light | dark | custom | false
                customShadowStyle: '',
                customBg: {},
                customTextColor: {},
                customBorderColor: {},
                customBarColor: {},
                customIcons: {},
                customIconColor: {},
                ...options
            };

            window.toaster = this.showToast.bind(this);
        }

        getAnimation(position) {
            switch (position) {
                case 'top-left':
                case 'bottom-left': return 'slide-in-left';
                case 'top-right':
                case 'bottom-right': return 'slide-in-right';
                case 'top-center': return 'slide-in-top';
                case 'bottom-center': return 'slide-in-bottom';
                default: return 'slide-in-right';
            }
        }

        showToast(type, title, text, overrideOptions = {}) {
            const config = { ...this.config, ...overrideOptions };

            const iconMap = {
                success: "nb_checkmark1",
                error: "nb_exclamation1",
                info: "nb_info3"
            };

            let iconClass = `nb ${iconMap[type] || "nb_info3"}`;
            let iconColor = 'inherit';
            let backgroundStyle = '';
            let barColor = '';
            let shadowStyle = '';

            if (config.theme === 'dark') {
                backgroundStyle = 'background-color: #1f2937; color: #fff;';
                barColor = '#fff';
                iconColor = '#fff';
            } else if (config.theme === 'light') {
                backgroundStyle = 'background-color: #ffffff; color: #000;';
                barColor = '#000';
                iconColor = '#000';
            } else if (config.theme === 'custom') {
                // fallback defaults from light
                let bg = '#ffffff';
                let txt = '#000000';
                let border = 'transparent';
                let bar = '#000000';
                let customIcon = `nb ${iconMap[type] || "nb_info3"}`;
                let customIconClr = '#000000';

                if (config.customBg?.[type]) bg = config.customBg[type];
                if (config.customTextColor?.[type]) txt = config.customTextColor[type];
                if (config.customBorderColor?.[type]) border = config.customBorderColor[type];
                if (config.customBarColor?.[type]) bar = config.customBarColor[type];
                if (config.customIcons?.[type]) customIcon = config.customIcons[type];
                if (config.customIconColor?.[type]) customIconClr = config.customIconColor[type];

                iconClass = customIcon;
                iconColor = customIconClr;
                barColor = bar;

                backgroundStyle = `
                    background: ${bg};
                    color: ${txt};
                    border: 1px solid ${border};
                    --barColor: ${bar};
                `;
            }

            // Shadow logic
            if (config.boxShadow === 'light') {
                shadowStyle = 'box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);';
            } else if (config.boxShadow === 'dark') {
                shadowStyle = 'box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);';
            } else if (config.boxShadow === 'custom' && config.customShadowStyle) {
                shadowStyle = `box-shadow: ${config.customShadowStyle};`;
            }

            const positionClass = `toast-position toast-${config.position}`;
            let container = document.querySelector(`.${positionClass.replace(/\s/g, '.')}`);
            if (!container) {
                container = document.createElement("div");
                container.className = positionClass;
                document.body.appendChild(container);
            }

            const toast = document.createElement("div");
            toast.classList.add("relative");

            const toastClasses = `toaster ${type} rounded px-4 py-2 flex items-center justify-between gap-4`;
            const anim = this.getAnimation(config.position);
            const fullStyle = `${backgroundStyle} ${shadowStyle} --timeout: ${config.timeout}ms; animation-name: ${anim};`;

            toast.innerHTML = `
                <div class="${toastClasses}" style="${fullStyle}">
                    <i class="${iconClass}" style="color: ${iconColor};"></i>
                    <div>
                        <p class="text-base font-bold">${title}</p>
                        <p class="text-md">${text}</p>
                    </div>
                    <i class="nb nb_cross text-sm" onclick="this.parentElement.remove()"></i>
                </div>`;

            container.insertBefore(toast, container.firstChild);

            let timer;
            const startTimer = () => {
                timer = setTimeout(() => {
                    toast.classList.add("slide-down");
                    setTimeout(() => toast.remove(), 300);
                }, config.timeout);
            };

            const cancelTimer = () => clearTimeout(timer);
            toast.addEventListener("mouseenter", cancelTimer);
            toast.addEventListener("mouseleave", startTimer);
            startTimer();
        }
    }

    // ✅ Initialize globally
    new Toaster({
        theme: 'custom',
        iconStyle: '2d',
        timeout: 10000,
        position: 'top-right',
        boxShadow: 'dark',
        // customShadowStyle: '0 10px 25px rgba(0, 128, 255, 0.2)',
        customBg: {
            success: '#1f2937',
            error: '#1f2937',
            info: '#1f2937',
        },
        customTextColor: {
            success: '#ffffff',
            error: '#ffffff',
            info: '#ffffff',
        },
        customBorderColor: {
            success: '#1f2937',
            error: '#1f2937',
            info: '#1f2937',
        },
        customBarColor: {
            success: '#198754',
            error: '#dc3545',
            info: '#0d6efd',
        },
        customIcons: {
            success: 'nb_checkmark1',
            error: 'nb_exclamation1',
            info: 'nb_info3',
        },
        customIconColor: {
            success: '#198754',
            error: '#dc3545',
            info: '#0d6efd',
        }
    });

    // ✅ Example usage
    // toaster('success', 'Success!', 'Custom success message.');
    // toaster('error', 'Oops!', 'Something went wrong.');
    // toaster('info', 'FYI', 'Heads up, here’s some info.');
</script>

