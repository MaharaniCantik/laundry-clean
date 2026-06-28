<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <title>Main Dashboard - CleanControl</title>
        <link href="https://fonts.googleapis.com" rel="preconnect" />
        <link
            crossorigin=""
            href="https://fonts.gstatic.com"
            rel="preconnect"
        />
        <link
            href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;600;700&display=swap"
            rel="stylesheet"
        />
        <link
            href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
            rel="stylesheet"
        />
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        <script id="tailwind-config">
            tailwind.config = {
                darkMode: "class",
                theme: {
                    extend: {
                        colors: {
                            "on-primary-fixed-variant": "#173bab",
                            "on-primary": "#ffffff",
                            "on-tertiary": "#ffffff",
                            "on-tertiary-container": "#ffa583",
                            "secondary-container": "#2170e4",
                            "on-tertiary-fixed": "#380d00",
                            "on-surface": "#1a1b22",
                            "on-error": "#ffffff",
                            "error-container": "#ffdad6",
                            "inverse-surface": "#2f3037",
                            "on-secondary-fixed-variant": "#004395",
                            "on-background": "#1a1b22",
                            surface: "#fbf8ff",
                            "surface-dim": "#dad9e3",
                            "on-primary-fixed": "#001453",
                            "surface-container-highest": "#e3e1eb",
                            "on-error-container": "#93000a",
                            "secondary-fixed": "#d8e2ff",
                            "inverse-on-surface": "#f1f0fa",
                            "outline-variant": "#c4c5d5",
                            background: "#fbf8ff",
                            "on-surface-variant": "#444653",
                            outline: "#757684",
                            "surface-container": "#eeedf7",
                            "secondary-fixed-dim": "#adc6ff",
                            "on-secondary-fixed": "#001a42",
                            "tertiary-fixed-dim": "#ffb59a",
                            primary: "#00288e",
                            "surface-bright": "#fbf8ff",
                            error: "#ba1a1a",
                            "tertiary-container": "#872d00",
                            "surface-container-high": "#e8e7f1",
                            "surface-container-lowest": "#ffffff",
                            "on-secondary-container": "#fefcff",
                            tertiary: "#611e00",
                            "surface-tint": "#3755c3",
                            "surface-variant": "#e3e1eb",
                            "tertiary-fixed": "#ffdbce",
                            "primary-container": "#1e40af",
                            "inverse-primary": "#b8c4ff",
                            "primary-fixed": "#dde1ff",
                            "on-secondary": "#ffffff",
                            secondary: "#0058be",
                            "on-tertiary-fixed-variant": "#802a00",
                            "primary-fixed-dim": "#b8c4ff",
                            "on-primary-container": "#a8b8ff",
                            "surface-container-low": "#f4f2fc",
                        },
                        borderRadius: {
                            DEFAULT: "0.25rem",
                            lg: "0.5rem",
                            xl: "0.75rem",
                            full: "9999px",
                        },
                        spacing: {
                            "card-gap": "20px",
                            gutter: "16px",
                            "container-padding": "24px",
                            "sidebar-width": "260px",
                            base: "8px",
                        },
                        fontFamily: {
                            "headline-lg": ["Work Sans"],
                            "body-sm": ["Work Sans"],
                            "headline-md": ["Work Sans"],
                            "body-lg": ["Work Sans"],
                            "label-md": ["Work Sans"],
                            "headline-lg-mobile": ["Work Sans"],
                            "display-lg": ["Work Sans"],
                            "body-md": ["Work Sans"],
                            "headline-sm": ["Work Sans"],
                        },
                        fontSize: {
                            "headline-lg": [
                                "32px",
                                { lineHeight: "40px", fontWeight: "600" },
                            ],
                            "body-sm": [
                                "14px",
                                { lineHeight: "20px", fontWeight: "400" },
                            ],
                            "headline-md": [
                                "24px",
                                { lineHeight: "32px", fontWeight: "600" },
                            ],
                            "body-lg": [
                                "18px",
                                { lineHeight: "28px", fontWeight: "400" },
                            ],
                            "label-md": [
                                "12px",
                                {
                                    lineHeight: "16px",
                                    letterSpacing: "0.05em",
                                    fontWeight: "600",
                                },
                            ],
                            "headline-lg-mobile": [
                                "28px",
                                { lineHeight: "36px", fontWeight: "600" },
                            ],
                            "display-lg": [
                                "48px",
                                {
                                    lineHeight: "56px",
                                    letterSpacing: "-0.02em",
                                    fontWeight: "700",
                                },
                            ],
                            "body-md": [
                                "16px",
                                { lineHeight: "24px", fontWeight: "400" },
                            ],
                            "headline-sm": [
                                "20px",
                                { lineHeight: "28px", fontWeight: "600" },
                            ],
                        },
                    },
                },
            };
        </script>
        <style>
            .material-symbols-outlined {
                font-variation-settings:
                    "FILL" 0,
                    "wght" 400,
                    "GRAD" 0,
                    "opsz" 24;
            }
            .material-symbols-outlined[data-weight="fill"] {
                font-variation-settings: "FILL" 1;
            }
            .ambient-shadow {
                box-shadow:
                    0 4px 24px -2px rgba(0, 0, 0, 0.04),
                    0 2px 12px -2px rgba(0, 0, 0, 0.02);
            }
            .ambient-shadow-hover:hover {
                box-shadow:
                    0 8px 32px -4px rgba(0, 0, 0, 0.06),
                    0 4px 16px -4px rgba(0, 0, 0, 0.04);
                transform: translateY(-2px);
            }
        </style>
    </head>
    <body
        class="bg-background text-on-surface font-body-md antialiased min-h-screen overflow-x-hidden">
        <aside class="w-sidebar-width h-screen fixed left-0 top-0 bg-surface-container-lowest shadow-sm flex flex-col p-gutter z-50 hidden md:flex border-r border-outline-variant/20">
            <div class="flex flex-col gap-8 h-full">
                <div class="px-2">
                    <h1 class="font-headline-md text-headline-md font-bold text-primary tracking-tight">
                        CleanControl
                    </h1>
                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">
                        Laundry Operations
                    </p>
                </div>
                <button class="w-full bg-primary-container text-on-primary py-3 px-4 rounded-lg font-label-md text-label-md flex items-center justify-center gap-2 hover:opacity-90 transition-opacity shadow-sm">
                    <span class="material-symbols-outlined" style="font-size: 20px">add</span>
                    New Order
                </button>
                <div class="flex-1 space-y-1">
                    <!-- Dashboard -->
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-on-surface-variant dark:text-outline hover:text-primary dark:hover:text-primary-fixed hover:bg-surface-container-low dark:hover:bg-surface-container transition-colors duration-200 scale-95 active:scale-90 transition-transform"
                        href="{{route ('admin.dashboard') }}">
                        <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
                        <span class="font-body-md text-body-md">Dashboard</span>
                    </a>
                    <!-- Order Management (ACTIVE) -->
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-on-surface-variant dark:text-outline hover:text-primary dark:hover:text-primary-fixed hover:bg-surface-container-low dark:hover:bg-surface-container transition-colors duration-200 scale-95 active:scale-90 transition-transform"
                        href="{{route ('admin.orders') }}">
                        <span class="material-symbols-outlined icon-fill"data-icon="inventory_2">inventory_2</span>
                        <span class="font-body-md text-body-md">Order Management</span>
                    </a>
                    <!-- Fleet & Couriers -->
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-on-surface-variant dark:text-outline hover:text-primary dark:hover:text-primary-fixed hover:bg-surface-container-low dark:hover:bg-surface-container transition-colors duration-200 scale-95 active:scale-90 transition-transform"
                        href="{{route ('admin.armada_kurir') }}">
                        <span class="material-symbols-outlined"data-icon="local_shipping">local_shipping</span>
                        <span class="font-body-md text-body-md">Fleet &amp; Couriers</span>
                    </a>
                    <!-- Services & Pricing -->
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-on-surface-variant dark:text-outline hover:text-primary dark:hover:text-primary-fixed hover:bg-surface-container-low dark:hover:bg-surface-container transition-colors duration-200 scale-95 active:scale-90 transition-transform"
                        href="#">
                        <span class="material-symbols-outlined" data-icon="settings_suggest">settings_suggest</span>
                        <span class="font-body-md text-body-md" >Services &amp; Pricing</span>
                    </a>
                    <!-- WhatsApp Logs -->
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-on-surface-variant dark:text-outline hover:text-primary dark:hover:text-primary-fixed hover:bg-surface-container-low dark:hover:bg-surface-container transition-colors duration-200 scale-95 active:scale-90 transition-transform"
                        href="#">
                        <span class="material-symbols-outlined" data-icon="history_edu" >history_edu</span>
                        <span class="font-body-md text-body-md" >WhatsApp Logs</span>
                    </a>
                </div>
            </div>
            <div class="mt-auto px-4 py-4 border-t border-outline-variant">
                {{-- Form POST untuk memproses Logout ke sistem Laravel auth --}}
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl font-medium transition-colors group">
                        {{-- Menggunakan Material Symbols Outlined agar icon-nya senada dengan tema CleanControl --}}
                        <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">logout</span>
                        <span>Keluar Sistem</span>
                    </button>
                </form>
            </div>
        </aside>

        <header
            class="h-16 fixed top-0 right-0 z-40 bg-surface-container-lowest/80 backdrop-blur-md border-b border-outline-variant/10 flex justify-between items-center px-container-padding w-full md:w-[calc(100%-260px)] transition-all">
            <div class="flex items-center w-full max-w-md">
                <div class="relative w-full">
                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline"
                        >search</span >
                    <input
                        class="w-full pl-10 pr-4 py-2 bg-surface-container-low border border-outline-variant/30 rounded-full font-body-sm text-body-sm focus:outline-none"
                        placeholder="Search..."
                        type="text"/>
                </div>
            </div>
        </header>


        <div class="content-wrapper">
            {{ $slot }}
        </div>

        
    </body>
</html>
