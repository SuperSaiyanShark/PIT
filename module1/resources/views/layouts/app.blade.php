<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Wellmeadow Hospital — Patient Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --teal-900: #0a4a52;
            --teal-700: #0e6b77;
            --teal-600: #0d8fa0;
            --teal-500: #12a8bd;
            --teal-400: #27bdd1;
            --teal-300: #6fd6e3;
            --teal-100: #d0f4f8;
            --teal-50:  #ebfbfd;
            --accent:   #f0a500;
            --danger:   #e05260;
            --success:  #29a87c;
            --white:    #ffffff;
            --gray-900: #111827;
            --gray-700: #374151;
            --gray-500: #6b7280;
            --gray-300: #d1d5db;
            --gray-100: #f3f4f6;
            --gray-50:  #f9fafb;
            --sidebar-w: 248px;
            --font: 'DM Sans', sans-serif;
        }

        html, body {
            height: 100%;
            font-family: var(--font);
            background: var(--gray-50);
            color: var(--gray-900);
            font-size: 14px;
        }

        .app-layout { display: flex; min-height: 100vh; }

        /* SIDEBAR */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--teal-900);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 20px 18px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .brand-top {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 9px;
        }

        .brand-icon {
            width: 48px; height: 48px;
            background: var(--teal-500);
            border-radius: 13px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 14px rgba(18,168,189,0.45);
        }

        .brand-icon svg { width: 30px; height: 30px; }

        .brand-text h1 {
            font-size: 12.5px;
            font-weight: 800;
            color: white;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            line-height: 1.25;
        }

        .brand-sub {
            font-size: 10px;
            font-weight: 600;
            color: var(--teal-300);
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .brand-quote {
            font-size: 10.5px;
            color: rgba(255,255,255,0.42);
            font-style: italic;
            line-height: 1.45;
            padding-left: 2px;
        }

        .sidebar-nav { padding: 14px 12px; flex: 1; }

        .nav-label {
            display: block;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--teal-300);
            padding: 0 8px;
            margin: 18px 0 6px;
            opacity: 0.7;
        }

        .nav-label:first-child { margin-top: 4px; }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            transition: all 0.15s;
            margin-bottom: 2px;
        }

        .nav-link svg { width: 18px; height: 18px; flex-shrink: 0; }
        .nav-link:hover { background: rgba(255,255,255,0.08); color: white; }
        .nav-link.active { background: var(--teal-600); color: white; }

        .sidebar-footer {
            padding: 14px 20px;
            border-top: 1px solid rgba(255,255,255,0.08);
            font-size: 11.5px;
            color: rgba(255,255,255,0.35);
        }

        .sidebar-footer strong { color: rgba(255,255,255,0.55); display: block; margin-bottom: 1px; }

        /* MAIN */
        .main-content { flex: 1; overflow-x: hidden; }

        .topbar {
            background: white;
            border-bottom: 1px solid var(--gray-300);
            padding: 0 28px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-title { font-size: 16px; font-weight: 600; color: var(--gray-900); }
        .topbar-right  { display: flex; align-items: center; gap: 12px; }
        .topbar-date   { font-size: 12px; color: var(--gray-500); }

        .page-content { padding: 28px; }

        /* BUTTONS */
        .btn {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 9px 18px; border-radius: 10px;
            font-family: var(--font); font-size: 13.5px; font-weight: 600;
            cursor: pointer; border: none; text-decoration: none;
            transition: all 0.15s; line-height: 1;
        }
        .btn svg { width: 16px; height: 16px; }
        .btn-primary { background: var(--teal-500); color: white; }
        .btn-primary:hover { background: var(--teal-600); }
        .btn-outline { background: transparent; border: 1.5px solid var(--gray-300); color: var(--gray-700); }
        .btn-outline:hover { border-color: var(--teal-400); color: var(--teal-600); }
        .btn-danger { background: var(--danger); color: white; }
        .btn-danger:hover { opacity: 0.9; }
        .btn-success { background: var(--success); color: white; }
        .btn-sm { padding: 6px 12px; font-size: 12px; border-radius: 8px; }

        /* ALERTS */
        .alert { padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 13.5px; font-weight: 500; }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .alert-error   { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

        /* MODAL */
        .modal-backdrop {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.45);
            backdrop-filter: blur(3px);
            z-index: 100;
            display: none; align-items: center; justify-content: center;
            padding: 20px;
        }
        .modal-backdrop.open { display: flex; }

        .modal {
            background: white; border-radius: 20px;
            width: 100%; max-width: 680px; max-height: 90vh; overflow-y: auto;
            box-shadow: 0 25px 60px rgba(0,0,0,0.2);
            animation: modalIn 0.2s ease;
        }

        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.96) translateY(8px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }

        .modal-header {
            background: linear-gradient(135deg, var(--teal-700), var(--teal-500));
            padding: 22px 26px; border-radius: 20px 20px 0 0;
            display: flex; align-items: center; justify-content: space-between;
        }
        .modal-header h2 { color: white; font-size: 17px; font-weight: 700; }
        .modal-header p  { color: rgba(255,255,255,0.75); font-size: 12px; margin-top: 2px; }

        .modal-close {
            width: 32px; height: 32px; background: rgba(255,255,255,0.15);
            border: none; border-radius: 8px; color: white; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: background 0.15s;
        }
        .modal-close:hover { background: rgba(255,255,255,0.25); }

        .modal-body { padding: 26px; }

        /* FORM */
        .form-section-title {
            font-size: 12px; font-weight: 700; letter-spacing: 0.06em;
            text-transform: uppercase; color: var(--teal-600);
            margin: 20px 0 12px; padding-bottom: 6px;
            border-bottom: 2px solid var(--teal-100);
        }
        .form-section-title:first-child { margin-top: 0; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .form-grid.cols-3 { grid-template-columns: 1fr 1fr 1fr; }
        .form-group { display: flex; flex-direction: column; gap: 5px; }
        .form-group.span-2 { grid-column: span 2; }

        label { font-size: 12px; font-weight: 600; color: var(--gray-700); }
        label .req { color: var(--danger); margin-left: 2px; }

        input, select, textarea {
            font-family: var(--font); font-size: 13.5px;
            border: 1.5px solid var(--gray-300); border-radius: 9px;
            padding: 9px 12px; color: var(--gray-900); background: white;
            outline: none; transition: border-color 0.15s; width: 100%;
        }
        input:focus, select:focus, textarea:focus {
            border-color: var(--teal-400);
            box-shadow: 0 0 0 3px rgba(18,168,189,0.12);
        }
        textarea { resize: vertical; min-height: 80px; }
        .input-error { border-color: var(--danger) !important; }
        .error-msg { font-size: 11px; color: var(--danger); margin-top: 3px; }

        .modal-footer {
            padding: 16px 26px; border-top: 1px solid var(--gray-100);
            display: flex; justify-content: flex-end; gap: 10px;
        }

        /* CARDS */
        .card { background: white; border-radius: 16px; border: 1px solid var(--gray-300); overflow: hidden; }
        .card-header {
            padding: 18px 22px; border-bottom: 1px solid var(--gray-100);
            display: flex; align-items: center; justify-content: space-between;
        }
        .card-header h3 { font-size: 15px; font-weight: 700; color: var(--gray-900); }
        .card-body { padding: 22px; }

        /* TABLE */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead th {
            background: var(--gray-50); padding: 11px 16px;
            font-size: 11.5px; font-weight: 700; letter-spacing: 0.04em;
            text-transform: uppercase; color: var(--gray-500);
            text-align: left; border-bottom: 1px solid var(--gray-300);
        }
        tbody tr { transition: background 0.1s; }
        tbody tr:hover { background: var(--teal-50); }
        tbody td {
            padding: 13px 16px; font-size: 13.5px; color: var(--gray-700);
            border-bottom: 1px solid var(--gray-100); vertical-align: middle;
        }
        tbody tr:last-child td { border-bottom: none; }

        /* BADGES */
        .badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 20px; font-size: 11.5px; font-weight: 600; letter-spacing: 0.03em; }
        .badge-admitted   { background: #d1fae5; color: #065f46; }
        .badge-discharged { background: var(--gray-100); color: var(--gray-500); }
        .badge-outpatient { background: #fef3c7; color: #92400e; }

        /* UTILS */
        .text-muted   { color: var(--gray-500); }
        .text-sm      { font-size: 12px; }
        .fw-600       { font-weight: 600; }
        .patient-id   { font-size: 12px; font-weight: 700; color: var(--teal-600); font-family: monospace; }
        .patient-name { font-weight: 600; color: var(--gray-900); }

        /* PAGINATION */
        .pagination {
            display: flex; align-items: center; gap: 6px;
            padding: 14px 20px; border-top: 1px solid var(--gray-100);
            justify-content: flex-end;
        }
        .pagination a, .pagination span {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 32px; height: 32px; border-radius: 8px;
            font-size: 13px; font-weight: 500; text-decoration: none;
            color: var(--gray-700); border: 1px solid var(--gray-300); padding: 0 8px;
        }
        .pagination .active span { background: var(--teal-500); color: white; border-color: var(--teal-500); }
        .pagination a:hover { background: var(--teal-50); border-color: var(--teal-300); }

        /* EMPTY STATE */
        .empty-state { text-align: center; padding: 60px 20px; color: var(--gray-500); }
        .empty-state svg { width: 48px; height: 48px; opacity: 0.3; margin-bottom: 12px; }
        .empty-state p   { font-size: 14px; }

        @media (max-width: 768px) {
            .sidebar { display: none; }
            .form-grid { grid-template-columns: 1fr; }
            .form-grid.cols-3 { grid-template-columns: 1fr 1fr; }
            .form-group.span-2 { grid-column: span 1; }
        }
    </style>
    @stack('styles')
</head>
<body>
<div class="app-layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-top">
                <div class="brand-icon">
                    <!--
                        Recreated from Figma:
                        Two open hands cradling a heart that has a medical cross on it.
                        The hands curve upward symmetrically from below the heart.
                    -->
                    <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Heart body -->
                        <path d="M20 16.5
                                 C20 16.5 17.5 13 14.5 13
                                 C11.5 13 9 15.2 9 18
                                 C9 22 13.5 25.5 20 30
                                 C26.5 25.5 31 22 31 18
                                 C31 15.2 28.5 13 25.5 13
                                 C22.5 13 20 16.5 20 16.5Z"
                              fill="white" fill-opacity="0.95"/>
                        <!-- Medical cross: vertical bar -->
                        <rect x="18.5" y="14.5" width="3" height="8" rx="0.8" fill="#0b7285"/>
                        <!-- Medical cross: horizontal bar -->
                        <rect x="15.5" y="17.5" width="9" height="3" rx="0.8" fill="#0b7285"/>

                        <!-- Left hand: palm curving up from bottom-left -->
                        <path d="M4 27
                                 C4 27 7 24.5 10 25.2
                                 C12 25.7 13.5 27 15.5 28
                                 C17 28.8 18.5 29 20 29"
                              stroke="white" stroke-width="2.2"
                              stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        <!-- Left hand: wrist curling under -->
                        <path d="M4 27
                                 C3.2 29 3.5 31.2 5 32.5
                                 C7 34 10.5 33.5 13 32.8"
                              stroke="white" stroke-width="2.2"
                              stroke-linecap="round" fill="none"/>

                        <!-- Right hand: palm curving up from bottom-right -->
                        <path d="M36 27
                                 C36 27 33 24.5 30 25.2
                                 C28 25.7 26.5 27 24.5 28
                                 C23 28.8 21.5 29 20 29"
                              stroke="white" stroke-width="2.2"
                              stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        <!-- Right hand: wrist curling under -->
                        <path d="M36 27
                                 C36.8 29 36.5 31.2 35 32.5
                                 C33 34 29.5 33.5 27 32.8"
                              stroke="white" stroke-width="2.2"
                              stroke-linecap="round" fill="none"/>
                    </svg>
                </div>
                <div class="brand-text">
                    <h1>Wellmeadow<br>Hospital</h1>
                    <div class="brand-sub">Patient Management</div>
                </div>
            </div>
            <div class="brand-quote">"Compassion in every heartbeat."</div>
        </div>

        <nav class="sidebar-nav">
            <span class="nav-label">Module 1</span>
            <a href="{{ route('patients.index') }}" class="nav-link {{ request()->routeIs('patients.index') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                    <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                </svg>
                Dashboard
            </a>
            <a href="{{ route('patients.index') }}" class="nav-link {{ request()->routeIs('patients.show') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                Patients
            </a>

            <span class="nav-label">Other Modules</span>
            <a href="#" class="nav-link" style="opacity:0.38;pointer-events:none;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                </svg>
                Ward Management
            </a>
            <a href="#" class="nav-link" style="opacity:0.38;pointer-events:none;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/>
                </svg>
                Appointments
            </a>
        </nav>

        <div class="sidebar-footer">
            <strong>Module 1</strong>
            Patient Registration
        </div>
    </aside>

    <!-- MAIN -->
    <div class="main-content">
        <header class="topbar">
            <span class="topbar-title">@yield('page-title', 'Patient Management')</span>
            <div class="topbar-right">
                <span class="topbar-date">{{ now()->format('l, F j, Y') }}</span>
            </div>
        </header>

        <main class="page-content">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
