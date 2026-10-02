<!DOCTYPE html>
<html lang="en">
<?php 
    $confiG = DB::table('configs')->where('id','1')->first();
    $popupsN = DB::table('ba_pop_pages')->orderby('id','asc')->get();
?>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title><?= $confiG->bank_name ?? 'Equitable Bank' ?></title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />
    
    <!-- Design System Scripts & Fonts -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    
    <script id="tailwind-config">
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: {
                    base: {
                        50: "#fafafa",
                        100: "#f4f6f8",
                        200: "#e5e7eb",
                        300: "#d1d5db",
                        400: "#9ca3af",
                        500: "#64748b",
                        600: "#475569",
                        700: "#334155",
                        800: "#1e293b",
                        900: "#0f172a",
                    },
                    brand: {
                        dark: "#0f131a",
                        surface: "#ffffff",
                        subtle: "#f8f9fb",
                        border: "#edf0f4",
                        gold: "#c59b27",
                        goldLight: "#e9c668",
                        goldDark: "#9c7614",
                        navy: "#0f172a",
                        charcoal: "#181f2a"
                    },
                    status: {
                        success: "#10b981",
                        successBg: "#ecfdf5",
                        danger: "#ef4444",
                        dangerBg: "#fef2f2",
                        warning: "#f59e0b",
                        warningBg: "#fffbeb",
                        info: "#3b82f6",
                        infoBg: "#eff6ff"
                    }
                },
                fontFamily: {
                    sans: ["'Plus Jakarta Sans'", "sans-serif"],
                    display: ["'Playfair Display'", "serif"],
                    mono: ["'JetBrains Mono'", "monospace"]
                },
                boxShadow: {
                    'card': '0 2px 10px rgba(0, 0, 0, 0.03), 0 1px 2px rgba(0, 0, 0, 0.02)',
                    'card-hover': '0 12px 30px -4px rgba(15, 23, 42, 0.08), 0 4px 6px -2px rgba(15, 23, 42, 0.03)',
                    'card-elevated': '0 20px 40px -15px rgba(0, 0, 0, 0.08)',
                    'gold': '0 4px 14px 0 rgba(197, 155, 39, 0.35)',
                    'dark-hero': '0 20px 35px -10px rgba(15, 19, 26, 0.5)'
                },
                borderRadius: {
                    'xl': '0.875rem',
                    '2xl': '1rem',
                    '3xl': '1.5rem',
                }
            }
        }
    }
    </script>
    
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            vertical-align: middle;
            line-height: 1;
        }
        .material-symbols-outlined.fill {
            font-variation-settings: 'FILL' 1;
        }
        
        /* Modern Scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Banking UI Utilities */
        .glass-header {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .gold-gradient-btn {
            background: linear-gradient(135deg, #e5c07b 0%, #c59b27 100%);
            color: #0f131a;
            font-weight: 600;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .gold-gradient-btn:hover {
            background: linear-gradient(135deg, #edd193 0%, #d4aa33 100%);
            box-shadow: 0 6px 20px rgba(197, 155, 39, 0.35);
            transform: translateY(-1px);
        }

        .dark-hero-card {
            background: radial-gradient(circle at top right, #1f2735 0%, #11151e 60%, #0a0d13 100%);
            box-shadow: 0 15px 35px -5px rgba(10, 13, 19, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .card-visa-metallic {
            background: linear-gradient(135deg, #1b202a 0%, #0d1017 60%, #1a1e27 100%);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.12);
        }
        .card-visa-metallic::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.12) 0%, transparent 55%);
            pointer-events: none;
        }

        /* Minimal Legacy Bootstrap Modal Styles for Compatibility */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1050;
            width: 100%;
            height: 100%;
            overflow: hidden;
            outline: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
        }
        .modal.show {
            display: block;
            overflow-x: hidden;
            overflow-y: auto;
        }
        .modal-dialog {
            position: relative;
            width: auto;
            margin: 2rem auto;
            max-width: 650px;
            pointer-events: none;
            transform: translateY(-20px);
            transition: transform 0.25s ease-out;
        }
        .modal.show .modal-dialog {
            transform: none;
        }
        .modal-content {
            position: relative;
            display: flex;
            flex-direction: column;
            width: 100%;
            pointer-events: auto;
            background-color: #ffffff;
            border-radius: 1.25rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            outline: 0;
            overflow: hidden;
        }
        .modal-backdrop {
            display: none !important;
        }

        /* DataTables Custom Clean Styling */
        .dataTables_wrapper .dataTables_length select {
            padding: 4px 28px 4px 10px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            font-size: 13px;
            background-color: #ffffff;
        }
        .dataTables_wrapper .dataTables_filter input {
            padding: 6px 12px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            font-size: 13px;
            outline: none;
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #0f172a;
            box-shadow: 0 0 0 2px rgba(15, 23, 42, 0.08);
        }
        table.dataTable {
            border-collapse: separate !important;
            border-spacing: 0 !important;
            width: 100% !important;
        }
        table.dataTable thead th {
            background-color: #f8fafc;
            color: #64748b;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
            padding: 12px 16px;
            border-bottom: 1px solid #e2e8f0 !important;
        }
        table.dataTable tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid #f1f5f9;
            color: #1e293b;
            font-size: 13.5px;
        }
        table.dataTable tbody tr:hover td {
            background-color: #f8fafc;
        }
    </style>
    
    <!-- jQuery for legacy banking scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
</head>
<body class="bg-[#f8f9fb] text-base-900 font-sans antialiased min-h-screen selection:bg-brand-gold/20 selection:text-brand-dark">
    <!-- Loader Start -->
    <div id="loading" class="hidden">
        <div id="loading-center"></div>
    </div>
    <!-- Loader END -->
