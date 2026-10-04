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
    
    <!-- Design System Scripts & Fonts (Stitch Sovereign Banking Design System) -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    
    <script id="tailwind-config">
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: {
                    primary: {
                        DEFAULT: "#004226",
                        container: "#0f5b38",
                        fixed: "#aaf2c4",
                        "fixed-dim": "#8fd6a9",
                        dark: "#00301b",
                    },
                    "on-primary": "#ffffff",
                    "on-primary-container": "#8ad1a4",
                    "on-primary-fixed": "#002110",
                    "on-primary-fixed-variant": "#005230",
                    secondary: {
                        DEFAULT: "#53625b",
                        container: "#d3e3db",
                        fixed: "#d6e6de",
                        "fixed-dim": "#bacac2",
                    },
                    "on-secondary": "#ffffff",
                    "on-secondary-container": "#57665f",
                    tertiary: {
                        DEFAULT: "#004219",
                        container: "#005c26",
                        fixed: "#6bff8f",
                        "fixed-dim": "#4ae176",
                    },
                    "on-tertiary": "#ffffff",
                    "on-tertiary-container": "#43db71",
                    surface: {
                        DEFAULT: "#f8faf9",
                        bright: "#f8faf9",
                        dim: "#d8dad9",
                        tint: "#246b46",
                        variant: "#e1e3e2",
                        container: {
                            lowest: "#ffffff",
                            low: "#f2f4f3",
                            DEFAULT: "#eceeed",
                            high: "#e6e9e8",
                            highest: "#e1e3e2",
                        }
                    },
                    "on-surface": "#191c1c",
                    "on-surface-variant": "#404942",
                    background: "#f8faf9",
                    "on-background": "#191c1c",
                    outline: {
                        DEFAULT: "#707971",
                        variant: "#bfc9bf",
                    },
                    error: {
                        DEFAULT: "#ba1a1a",
                        container: "#ffdad6",
                    },
                    "on-error": "#ffffff",
                    "on-error-container": "#93000a",
                    gold: {
                        DEFAULT: "#c59b27",
                        light: "#dfbb58",
                        dark: "#9c7614",
                    }
                },
                fontFamily: {
                    sans: ["'Inter'", "sans-serif"],
                    heading: ["'Plus Jakarta Sans'", "sans-serif"],
                    display: ["'Plus Jakarta Sans'", "sans-serif"],
                    mono: ["'JetBrains Mono'", "monospace"],
                },
                boxShadow: {
                    'subtle': '0 1px 4px rgba(0, 0, 0, 0.03)',
                    'card': '0 4px 20px -2px rgba(15, 91, 56, 0.04), 0 2px 6px rgba(0, 0, 0, 0.02)',
                    'card-elevated': '0 8px 24px -4px rgba(15, 91, 56, 0.18)',
                    'primary-glow': '0 4px 16px rgba(15, 91, 56, 0.20)',
                },
                borderRadius: {
                    'xl': '0.75rem',
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
