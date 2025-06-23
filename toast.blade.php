{{-- Toast Container --}}
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
        background-color: rgb(247, 206, 199);
    }
</style>

<script>
    class Toaster {
        constructor(options = {}) {
            this.config = {
                boxShadow: true,
                theme: 'light', // 'light' | 'dark' | 'custom'
                iconStyle: '2d', // '2d' | '3d'
                timeout: 5000,
                position: 'top-right', // position class
                customBg: {},
                customTextColor: {},
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

            let icon = `nb ${iconMap[type] || "nb_info3"}`;
            if (config.iconStyle === '3d') icon += " icon-3d";

            // Style handling
            let backgroundStyle = '';
            if (config.theme === 'dark') {
                backgroundStyle = 'background-color: #1f2937; color: #fff;';
            } else if (config.theme === 'light') {
                backgroundStyle = 'background-color: #ffffff; color: #000;';
            } else if (config.theme === 'custom' && config.customBg?.[type]) {
                const bg = config.customBg[type];
                const txt = config.customTextColor?.[type] || '#000';
                backgroundStyle = `background: ${bg}; color: ${txt};`;
            }

            // Create or get the container for this position
            const positionClass = `toast-position toast-${config.position}`;
            let container = document.querySelector(`.${positionClass.replace(/\s/g, '.')}`);

            if (!container) {
                container = document.createElement("div");
                container.className = positionClass;
                document.body.appendChild(container);
            }

            const toast = document.createElement("div");
            toast.classList.add("relative");

            const toastClasses = `toaster ${type} rounded px-4 py-2 flex items-center justify-between gap-4${config.boxShadow ? ' shadow-lg' : ''}`;
            const anim = this.getAnimation(config.position);

            toast.innerHTML = `
                <div class="${toastClasses}" style="${backgroundStyle} --timeout: ${config.timeout}ms; animation-name: ${anim};">
                    <i class="${icon}"></i>
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

    // ✅ Initialize with global config
    new Toaster({
        theme: 'dark', // light | dark | custom
        iconStyle: '3d', // 2d | 3d
        timeout: 4000, // in milliseconds
        position: 'top-center', // top-right | top-left | bottom-right | bottom-left | top-center | bottom-center
        boxShadow: true,
        // customBg: {
        //     success: 'linear-gradient(to right, #a8ff78, #78ffd6)',
        //     error: '#ffe2e2',
        //     info: '#d1e7ff'
        // },
        // customTextColor: {
        //     success: '#075e00',
        //     error: '#8b0000',
        //     info: '#003865'
        // }
    });
</script>
