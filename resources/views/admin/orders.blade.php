<admin-xapplayout>

<body class="light" lang="en" style="">
    <head>
        <meta charset="utf-8" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <title>CleanControl - Order Management</title>
        <!-- Material Symbols -->
        <link
            href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
            rel="stylesheet"
        />
        <link
            href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
            rel="stylesheet"
        />
        <link
            href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@100..900&amp;display=swap"
            rel="stylesheet"
        />
        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        <!-- Tailwind Theme Configuration -->
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
            body {
                font-family: "Work Sans", sans-serif;
                background-color: #f8fafc;
            }
            .material-symbols-outlined {
                font-variation-settings:
                    "FILL" 0,
                    "wght" 400,
                    "GRAD" 0,
                    "opsz" 24;
            }
            .icon-fill {
                font-variation-settings: "FILL" 1;
            }

            /* Subtle scrollbar for table */
            .table-scrollbar::-webkit-scrollbar {
                height: 6px;
            }
            .table-scrollbar::-webkit-scrollbar-track {
                background: transparent;
            }
            .table-scrollbar::-webkit-scrollbar-thumb {
                background: #c4c5d5;
                border-radius: 4px;
            }
            .table-scrollbar::-webkit-scrollbar-thumb:hover {
                background: #757684;
            }
        </style>
    </head>
    <body class="text-on-surface antialiased flex">
        <!-- SideNavBar (from JSON) -->
        <nav
            class="bg-surface-container-lowest dark:bg-surface-dim w-sidebar-width h-screen fixed left-0 top-0 shadow-sm dark:shadow-none flex flex-col h-full p-gutter z-50 hidden md:flex border-r border-surface-variant/50"
        >
            <!-- Header -->
            <div class="mb-8 px-2 flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-lg bg-primary-container flex items-center justify-center text-on-primary-container font-headline-sm text-headline-sm"
                >
                    C
                </div>
                <div>
                    <h1
                        class="font-headline-md text-headline-md font-bold text-primary dark:text-primary-fixed tracking-tight"
                    >
                        CleanControl
                    </h1>
                    <p
                        class="font-label-md text-label-md text-on-surface-variant"
                    >
                        Laundry Operations
                    </p>
                </div>
            </div>
            <!-- CTA Button -->
            <button
                class="w-full bg-primary hover:bg-primary-container text-on-primary font-label-md text-label-md py-3 px-4 rounded-lg flex items-center justify-center gap-2 mb-8 transition-colors duration-200 shadow-sm"
            >
                <span class="material-symbols-outlined text-[18px]">add</span>
                New Order
            </button>
            <!-- Main Navigation Tabs -->
            <div class="flex-1 space-y-1">
                <!-- Dashboard -->
                <a
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-on-surface-variant dark:text-outline hover:text-primary dark:hover:text-primary-fixed hover:bg-surface-container-low dark:hover:bg-surface-container transition-colors duration-200 scale-95 active:scale-90 transition-transform"
                    href="#"
                >
                    <span
                        class="material-symbols-outlined"
                        data-icon="dashboard"
                        >dashboard</span
                    >
                    <span class="font-body-md text-body-md">Dashboard</span>
                </a>
                <!-- Order Management (ACTIVE) -->
                <a
                    class="flex items-center gap-3 px-3 py-2.5 bg-secondary-container dark:bg-secondary-fixed text-on-secondary-container dark:text-on-secondary-fixed font-bold rounded-lg scale-95 active:scale-90 transition-transform"
                    href="#"
                >
                    <span
                        class="material-symbols-outlined icon-fill"
                        data-icon="inventory_2"
                        >inventory_2</span
                    >
                    <span class="font-body-md text-body-md"
                        >Order Management</span
                    >
                </a>
                <!-- Fleet & Couriers -->
                <a
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-on-surface-variant dark:text-outline hover:text-primary dark:hover:text-primary-fixed hover:bg-surface-container-low dark:hover:bg-surface-container transition-colors duration-200 scale-95 active:scale-90 transition-transform"
                    href="#"
                >
                    <span
                        class="material-symbols-outlined"
                        data-icon="local_shipping"
                        >local_shipping</span
                    >
                    <span class="font-body-md text-body-md"
                        >Fleet &amp; Couriers</span
                    >
                </a>
                <!-- Services & Pricing -->
                <a
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-on-surface-variant dark:text-outline hover:text-primary dark:hover:text-primary-fixed hover:bg-surface-container-low dark:hover:bg-surface-container transition-colors duration-200 scale-95 active:scale-90 transition-transform"
                    href="#"
                >
                    <span
                        class="material-symbols-outlined"
                        data-icon="settings_suggest"
                        >settings_suggest</span
                    >
                    <span class="font-body-md text-body-md"
                        >Services &amp; Pricing</span
                    >
                </a>
                <!-- WhatsApp Logs -->
                <a
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-on-surface-variant dark:text-outline hover:text-primary dark:hover:text-primary-fixed hover:bg-surface-container-low dark:hover:bg-surface-container transition-colors duration-200 scale-95 active:scale-90 transition-transform"
                    href="#"
                >
                    <span
                        class="material-symbols-outlined"
                        data-icon="history_edu"
                        >history_edu</span
                    >
                    <span class="font-body-md text-body-md">WhatsApp Logs</span>
                </a>
            </div>
            <!-- Footer Tabs -->
            <div
                class="mt-auto pt-4 border-t border-surface-variant/50 space-y-1"
            >
                <a
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-on-surface-variant dark:text-outline hover:text-primary dark:hover:text-primary-fixed hover:bg-surface-container-low dark:hover:bg-surface-container transition-colors duration-200"
                    href="#"
                >
                    <span class="material-symbols-outlined" data-icon="help"
                        >help</span
                    >
                    <span class="font-body-sm text-body-sm">Support</span>
                </a>
                <a
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-on-surface-variant dark:text-outline hover:text-primary dark:hover:text-primary-fixed hover:bg-surface-container-low dark:hover:bg-surface-container transition-colors duration-200"
                    href="#"
                >
                    <span class="material-symbols-outlined" data-icon="settings"
                        >settings</span
                    >
                    <span class="font-body-sm text-body-sm">Settings</span>
                </a>
            </div>
        </nav>
        <!-- TopNavBar (from JSON) -->
        <header
            class="bg-surface-container-lowest dark:bg-surface-dim h-16 fixed top-0 right-0 z-40 shadow-sm dark:shadow-none flex justify-between items-center px-container-padding w-full md:w-[calc(100%-260px)] md:ml-sidebar-width border-b border-surface-variant/50"
        >
            <div class="flex items-center gap-4">
                <!-- Mobile Menu Toggle (hidden on desktop) -->
                <button
                    class="md:hidden text-on-surface-variant hover:text-primary transition-colors"
                >
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div
                    class="font-headline-sm text-headline-sm font-black text-primary dark:text-primary-fixed"
                >
                    CleanControl Admin
                </div>
            </div>
            <div class="flex items-center gap-4">
                <!-- Search Bar -->
                <div class="relative hidden sm:block">
                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]"
                        >search</span
                    >
                    <input
                        class="pl-10 pr-4 py-1.5 bg-surface-container-low border border-surface-variant rounded-full font-body-sm text-body-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all w-64"
                        placeholder="Search orders..."
                        type="text"
                    />
                </div>
                <!-- Actions -->
                <div class="flex items-center gap-2">
                    <button
                        class="p-2 text-on-surface-variant dark:text-outline hover:text-primary dark:hover:text-primary-fixed transition-colors opacity-80 active:opacity-100 rounded-full hover:bg-surface-container-low relative"
                    >
                        <span
                            class="material-symbols-outlined"
                            data-icon="notifications"
                            >notifications</span
                        >
                        <span
                            class="absolute top-1.5 right-1.5 w-2 h-2 bg-error rounded-full border border-surface-container-lowest"
                        ></span>
                    </button>
                    <button
                        class="p-2 text-on-surface-variant dark:text-outline hover:text-primary dark:hover:text-primary-fixed transition-colors opacity-80 active:opacity-100 rounded-full hover:bg-surface-container-low"
                    >
                        <span class="material-symbols-outlined" data-icon="help"
                            >help</span
                        >
                    </button>
                </div>
                <!-- Profile -->
                <div
                    class="w-8 h-8 rounded-full bg-primary-container overflow-hidden border border-surface-variant ml-2"
                >
                    <img
                        alt="Admin Profile"
                        class="w-full h-full object-cover"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuAzS9z35GUMFBm0GHXMY-7_Ajn_lfezhXJlMid5oFLqk3pmDc9g2kdjrk4cogFGOADu-VyQNJcQg7X_DjlVV9XTOzjzZhX5G7fglbSAoBSAw-ic6P4uk8QO90InhN_V4pLEDVr8FsKePmBjj0WyC-2Sbo-vvNbQlWaTuxNprtQF3KvLFX7rhGULhSjwl3Xpcaciss42lHd2ZVcuZyiBVLvyHsZRSsChQ8s9SdZE9ca4q7exky6Toxvqhzv0h1cfOnNLvSSakkpwEGM"
                    />
                </div>
            </div>
        </header>
        <!-- Main Content Area -->
        <main
            class="flex-1 md:ml-sidebar-width mt-16 p-container-padding min-h-screen"
        >
            <!-- Page Header & Filters -->
            <div
                class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4"
            >
                <div>
                    <h2
                        class="font-headline-lg text-headline-lg text-on-surface"
                    >
                        Daftar Order
                    </h2>
                    <p
                        class="font-body-md text-body-md text-on-surface-variant mt-1"
                    >
                        Manage and track all active laundry operations.
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <div
                        class="flex items-center gap-2 bg-surface-container-lowest border border-outline-variant rounded-lg px-3 py-1.5"
                    >
                        <span
                            class="material-symbols-outlined text-[18px] text-on-surface-variant"
                            >calendar_today</span
                        >
                        <div class="flex items-center gap-1">
                            <input
                                type="date"
                                class="bg-transparent border-none p-0 font-body-sm text-body-sm text-on-surface focus:ring-0 outline-none cursor-pointer"
                                aria-label="Start Date"
                            />
                            <span class="text-outline-variant">-</span>
                            <input
                                type="date"
                                class="bg-transparent border-none p-0 font-body-sm text-body-sm text-on-surface focus:ring-0 outline-none cursor-pointer"
                                aria-label="End Date"
                            />
                        </div>
                    </div>
                    <!-- Status Filter -->
                    <select
                        class="bg-surface-container-lowest border border-outline-variant text-on-surface font-body-sm text-body-sm rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none cursor-pointer"
                    >
                        <option value="all">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="pickup">Pickup</option>
                        <option value="washing">Washing</option>
                        <option value="finished">Finished</option>
                        <option value="delivery">Delivery</option>
                    </select>
                    <!-- Service Type Filter -->
                    <select
                        class="bg-surface-container-lowest border border-outline-variant text-on-surface font-body-sm text-body-sm rounded-lg px-3 py-2 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none cursor-pointer"
                    >
                        <option value="all">All Services</option>
                        <option value="kiloan">Kiloan</option>
                        <option value="satuan">Satuan</option>
                    </select>
                    <div class="flex items-center gap-2">
                        <button
                            class="inline-flex items-center gap-1.5 px-3 py-2 bg-surface-container-lowest border border-outline-variant text-on-surface font-label-md text-label-md rounded-lg hover:bg-surface-container-low transition-colors shadow-sm"
                        >
                            <span class="material-symbols-outlined text-[18px]"
                                >description</span
                            >
                            Excel
                        </button>
                        <button
                            class="inline-flex items-center gap-1.5 px-3 py-2 bg-surface-container-lowest border border-outline-variant text-on-surface font-label-md text-label-md rounded-lg hover:bg-surface-container-low transition-colors shadow-sm"
                        >
                            <span class="material-symbols-outlined text-[18px]"
                                >picture_as_pdf</span
                            >
                            PDF
                        </button>
                    </div>
                </div>
            </div>
            <!-- Active Orders Table Card -->
            <div
                class="bg-surface-container-lowest rounded-xl shadow-[0_4px_24px_rgba(0,0,0,0.04)] border border-surface-variant/40 overflow-hidden"
            >
                <!-- Table Container for Horizontal Scroll -->
                <div class="w-full overflow-x-auto table-scrollbar">
                    <table
                        class="w-full min-w-[1000px] text-left border-collapse"
                    >
                        <thead>
                            <tr
                                class="bg-surface-container-low border-b border-surface-variant"
                            >
                                <th
                                    class="py-3 px-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider w-16"
                                >
                                    ID
                                </th>
                                <th
                                    class="py-3 px-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider"
                                >
                                    Customer Name
                                </th>
                                <th
                                    class="py-3 px-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider"
                                >
                                    Service Type
                                </th>
                                <th
                                    class="py-3 px-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider w-1/4"
                                >
                                    Address
                                </th>
                                <th
                                    class="py-3 px-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider text-right"
                                >
                                    Distance
                                </th>
                                <th
                                    class="py-3 px-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider"
                                >
                                    Status
                                </th>
                                <th
                                    class="py-3 px-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider text-right"
                                >
                                    Quick Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-variant/50">
                            <!-- Row 1: Pending -->
                            <tr
                                class="hover:bg-surface-container-low/50 transition-colors group"
                            >
                                <td
                                    class="py-4 px-4 font-body-sm text-body-sm text-on-surface-variant"
                                >
                                    #1042
                                </td>
                                <td class="py-4 px-4">
                                    <div
                                        class="font-body-md text-body-md font-semibold text-on-surface"
                                    >
                                        Budi Santoso
                                    </div>
                                    <div
                                        class="font-body-sm text-body-sm text-on-surface-variant flex items-center gap-1 mt-0.5"
                                    >
                                        <span
                                            class="material-symbols-outlined text-[14px]"
                                            >phone</span
                                        >
                                        0812-3456-7890
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-md bg-surface-variant text-on-surface font-label-md text-label-md"
                                        >Kiloan</span
                                    >
                                    <div
                                        class="font-body-sm text-body-sm text-on-surface-variant mt-1"
                                    >
                                        5 kg - Express
                                    </div>
                                </td>
                                <td
                                    class="py-4 px-4 font-body-sm text-body-sm text-on-surface-variant truncate max-w-xs"
                                >
                                    Jl. Sudirman No. 45, Komplek Mawar Blok B2
                                </td>
                                <td
                                    class="py-4 px-4 font-body-sm text-body-sm text-on-surface text-right"
                                >
                                    2.4 km
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-2">
                                        <!-- Pending Badge: Yellow/Gray mapped to Surface Variant for subtle neutral -->
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-surface-container-highest text-on-surface-variant font-label-md text-label-md border border-outline-variant/30"
                                        >
                                            <span
                                                class="w-1.5 h-1.5 rounded-full bg-outline"
                                            ></span>
                                            Pending
                                        </span>
                                        <!-- WhatsApp Not Sent/Pending -->
                                        <span
                                            class="material-symbols-outlined text-[18px] text-outline-variant"
                                            title="WhatsApp not sent"
                                            >chat</span
                                        >
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <button
                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-surface-container border border-outline-variant text-on-surface font-label-md text-label-md hover:bg-surface-container-high transition-colors shadow-sm"
                                    >
                                        To Pickup
                                        <span
                                            class="material-symbols-outlined text-[16px]"
                                            >arrow_forward</span
                                        >
                                    </button>
                                </td>
                            </tr>
                            <!-- Row 2: Pickup -->
                            <tr
                                class="hover:bg-surface-container-low/50 transition-colors group"
                            >
                                <td
                                    class="py-4 px-4 font-body-sm text-body-sm text-on-surface-variant"
                                >
                                    #1041
                                </td>
                                <td class="py-4 px-4">
                                    <div
                                        class="font-body-md text-body-md font-semibold text-on-surface"
                                    >
                                        Siti Aminah
                                    </div>
                                    <div
                                        class="font-body-sm text-body-sm text-on-surface-variant flex items-center gap-1 mt-0.5"
                                    >
                                        <span
                                            class="material-symbols-outlined text-[14px]"
                                            >phone</span
                                        >
                                        0857-1122-3344
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-md bg-inverse-on-surface text-on-surface font-label-md text-label-md"
                                        >Satuan</span
                                    >
                                    <div
                                        class="font-body-sm text-body-sm text-on-surface-variant mt-1"
                                    >
                                        3 Jas, 2 Gaun
                                    </div>
                                </td>
                                <td
                                    class="py-4 px-4 font-body-sm text-body-sm text-on-surface-variant truncate max-w-xs"
                                >
                                    Apartemen Taman Rasuna, Tower 12 Fl 8
                                </td>
                                <td
                                    class="py-4 px-4 font-body-sm text-body-sm text-on-surface text-right"
                                >
                                    5.1 km
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-2">
                                        <!-- Pickup Badge -->
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed font-label-md text-label-md border border-secondary-fixed-dim/30"
                                        >
                                            <span
                                                class="w-1.5 h-1.5 rounded-full bg-secondary"
                                            ></span>
                                            Pickup
                                        </span>
                                        <!-- WhatsApp Sent -->
                                        <span
                                            class="material-symbols-outlined text-[18px] text-[#25D366] icon-fill"
                                            title="WhatsApp sent"
                                            >check_circle</span
                                        >
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <button
                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-surface-container border border-outline-variant text-on-surface font-label-md text-label-md hover:bg-surface-container-high transition-colors shadow-sm"
                                    >
                                        To Washing
                                        <span
                                            class="material-symbols-outlined text-[16px]"
                                            >arrow_forward</span
                                        >
                                    </button>
                                </td>
                            </tr>
                            <!-- Row 3: Washing -->
                            <tr
                                class="hover:bg-surface-container-low/50 transition-colors group bg-primary-fixed/20 border-l-2 border-l-primary"
                            >
                                <td
                                    class="py-4 px-4 font-body-sm text-body-sm text-on-surface-variant"
                                >
                                    #1040
                                </td>
                                <td class="py-4 px-4">
                                    <div
                                        class="font-body-md text-body-md font-semibold text-on-surface"
                                    >
                                        Ahmad Fauzi
                                    </div>
                                    <div
                                        class="font-body-sm text-body-sm text-on-surface-variant flex items-center gap-1 mt-0.5"
                                    >
                                        <span
                                            class="material-symbols-outlined text-[14px]"
                                            >phone</span
                                        >
                                        0819-9988-7766
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-md bg-surface-variant text-on-surface font-label-md text-label-md"
                                        >Kiloan</span
                                    >
                                    <div
                                        class="font-body-sm text-body-sm text-on-surface-variant mt-1"
                                    >
                                        12 kg - Reguler
                                    </div>
                                </td>
                                <td
                                    class="py-4 px-4 font-body-sm text-body-sm text-on-surface-variant truncate max-w-xs"
                                >
                                    Perumahan Indah Asri Blok C No. 14
                                </td>
                                <td
                                    class="py-4 px-4 font-body-sm text-body-sm text-on-surface text-right"
                                >
                                    1.2 km
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-2">
                                        <!-- Washing Badge: Blue (Primary) -->
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-primary-container text-on-primary-container font-label-md text-label-md"
                                        >
                                            <span
                                                class="material-symbols-outlined text-[14px] animate-spin"
                                                >local_laundry_service</span
                                            >
                                            Washing
                                        </span>
                                        <!-- WhatsApp Sent -->
                                        <span
                                            class="material-symbols-outlined text-[18px] text-[#25D366] icon-fill"
                                            title="WhatsApp sent"
                                            >check_circle</span
                                        >
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <button
                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-primary text-on-primary font-label-md text-label-md hover:bg-primary-container transition-colors shadow-sm"
                                    >
                                        To Finished
                                        <span
                                            class="material-symbols-outlined text-[16px]"
                                            >done</span
                                        >
                                    </button>
                                </td>
                            </tr>
                            <!-- Row 4: Finished -->
                            <tr
                                class="hover:bg-surface-container-low/50 transition-colors group"
                            >
                                <td
                                    class="py-4 px-4 font-body-sm text-body-sm text-on-surface-variant"
                                >
                                    #1038
                                </td>
                                <td class="py-4 px-4">
                                    <div
                                        class="font-body-md text-body-md font-semibold text-on-surface"
                                    >
                                        Diana Putri
                                    </div>
                                    <div
                                        class="font-body-sm text-body-sm text-on-surface-variant flex items-center gap-1 mt-0.5"
                                    >
                                        <span
                                            class="material-symbols-outlined text-[14px]"
                                            >phone</span
                                        >
                                        0813-2233-4455
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-md bg-surface-variant text-on-surface font-label-md text-label-md"
                                        >Kiloan</span
                                    >
                                    <div
                                        class="font-body-sm text-body-sm text-on-surface-variant mt-1"
                                    >
                                        Bed Cover Set
                                    </div>
                                </td>
                                <td
                                    class="py-4 px-4 font-body-sm text-body-sm text-on-surface-variant truncate max-w-xs"
                                >
                                    Jl. Melati Raya No. 88
                                </td>
                                <td
                                    class="py-4 px-4 font-body-sm text-body-sm text-on-surface text-right"
                                >
                                    3.8 km
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-2">
                                        <!-- Finished Badge: Orange (Tertiary Container mapped to user request) -->
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-tertiary-container text-on-tertiary-container font-label-md text-label-md"
                                        >
                                            <span
                                                class="w-1.5 h-1.5 rounded-full bg-on-tertiary-container"
                                            ></span>
                                            Finished
                                        </span>
                                        <!-- WhatsApp Sent -->
                                        <span
                                            class="material-symbols-outlined text-[18px] text-[#25D366] icon-fill"
                                            title="WhatsApp sent"
                                            >check_circle</span
                                        >
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <button
                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-surface-container border border-outline-variant text-on-surface font-label-md text-label-md hover:bg-surface-container-high transition-colors shadow-sm"
                                    >
                                        To Delivery
                                        <span
                                            class="material-symbols-outlined text-[16px]"
                                            >local_shipping</span
                                        >
                                    </button>
                                </td>
                            </tr>
                            <!-- Row 5: Delivery -->
                            <tr
                                class="hover:bg-surface-container-low/50 transition-colors group opacity-70"
                            >
                                <td
                                    class="py-4 px-4 font-body-sm text-body-sm text-on-surface-variant"
                                >
                                    #1035
                                </td>
                                <td class="py-4 px-4">
                                    <div
                                        class="font-body-md text-body-md font-semibold text-on-surface"
                                    >
                                        Reza Utama
                                    </div>
                                    <div
                                        class="font-body-sm text-body-sm text-on-surface-variant flex items-center gap-1 mt-0.5"
                                    >
                                        <span
                                            class="material-symbols-outlined text-[14px]"
                                            >phone</span
                                        >
                                        0811-5566-7788
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-md bg-inverse-on-surface text-on-surface font-label-md text-label-md"
                                        >Satuan</span
                                    >
                                    <div
                                        class="font-body-sm text-body-sm text-on-surface-variant mt-1"
                                    >
                                        Karpet Besar
                                    </div>
                                </td>
                                <td
                                    class="py-4 px-4 font-body-sm text-body-sm text-on-surface-variant truncate max-w-xs"
                                >
                                    Jl. Anggrek Selatan, Kav 12
                                </td>
                                <td
                                    class="py-4 px-4 font-body-sm text-body-sm text-on-surface text-right"
                                >
                                    7.5 km
                                </td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-2">
                                        <!-- Delivery Badge: Green (Custom to match user request, blending with theme) -->
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-[#e6f4ea] text-[#1e8e3e] font-label-md text-label-md"
                                        >
                                            <span
                                                class="w-1.5 h-1.5 rounded-full bg-[#1e8e3e]"
                                            ></span>
                                            Delivery
                                        </span>
                                        <!-- WhatsApp Sent -->
                                        <span
                                            class="material-symbols-outlined text-[18px] text-[#25D366] icon-fill"
                                            title="WhatsApp sent"
                                            >check_circle</span
                                        >
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <button
                                        class="inline-flex items-center justify-center p-1.5 rounded-lg text-outline hover:text-primary transition-colors"
                                        title="More options"
                                    >
                                        <span class="material-symbols-outlined"
                                            >more_vert</span
                                        >
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination / Footer -->
                <div
                    class="px-6 py-4 border-t border-surface-variant flex items-center justify-between bg-surface-container-lowest"
                >
                    <span
                        class="font-body-sm text-body-sm text-on-surface-variant"
                        >Showing 1 to 5 of 24 entries</span
                    >
                    <div class="flex gap-2">
                        <button
                            class="px-3 py-1 border border-outline-variant rounded-md text-on-surface font-label-md text-label-md hover:bg-surface-container-low disabled:opacity-50"
                            disabled=""
                        >
                            Prev
                        </button>
                        <button
                            class="px-3 py-1 bg-primary text-on-primary rounded-md font-label-md text-label-md hover:bg-primary-container"
                        >
                            1
                        </button>
                        <button
                            class="px-3 py-1 border border-outline-variant rounded-md text-on-surface font-label-md text-label-md hover:bg-surface-container-low"
                        >
                            2
                        </button>
                        <button
                            class="px-3 py-1 border border-outline-variant rounded-md text-on-surface font-label-md text-label-md hover:bg-surface-container-low"
                        >
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </body>

</admin-xapplayout>
