<style>
    :root {
        /* Modern Monochrome Theme */
        --primary: #334155;
        /* Slate 700 */
        --primary-dark: #1e293b;
        /* Slate 800 */
        --secondary: #64748b;
        /* Slate 500 */
        --success: #059669;
        /* Emerald 600 - slightly darker helpful color */
        --warning: #d97706;
        /* Amber 600 */
        --danger: #dc2626;
        /* Red 600 */

        /* Light Theme Colors */
        --bg-body: #f1f5f9;
        /* Slate 100 */
        --bg-card: #ffffff;
        --text-main: #0f172a;
        /* Slate 900 */
        --text-muted: #64748b;
        /* Slate 500 */
        --border-color: #cbd5e1;
        /* Slate 300 - slightly stronger border */

        /* Monochrome Gradients */
        --gradient-1: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        --gradient-2: linear-gradient(135deg, #475569 0%, #64748b 100%);
        --gradient-3: linear-gradient(135deg, #94a3b8 0%, #cbd5e1 100%);
        --gradient-4: linear-gradient(135deg, #334155 0%, #475569 100%);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', sans-serif;
        background: var(--bg-body);
        color: var(--text-main);
        min-height: 100vh;
    }

    /* Sidebar */
    .sidebar {
        position: fixed;
        left: 0;
        top: 0;
        width: 280px;
        height: 100vh;
        background: #ffffff;
        border-right: 1px solid var(--border-color);
        z-index: 1000;
        box-shadow: 4px 0 24px rgba(0, 0, 0, 0.02);
    }

    .sidebar-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
        background: #ffffff;
    }

    .sidebar-logo {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        text-decoration: none;
    }

    .sidebar-logo-icon {
        width: 40px;
        height: 40px;
        background: var(--primary);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: white;
    }

    .sidebar-logo-text {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-main);
    }

    .sidebar-logo-text span {
        color: var(--primary);
    }

    .sidebar-nav {
        padding: 1rem 0;
    }

    .nav-section {
        padding: 0.75rem 1.75rem 0.5rem;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-muted);
        font-weight: 600;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1.75rem;
        color: var(--text-muted);
        text-decoration: none;
        transition: all 0.2s ease;
        font-weight: 500;
        border-left: 3px solid transparent;
    }

    .nav-link:hover {
        background: #f1f5f9;
        color: var(--primary);
    }

    .nav-link.active {
        background: #e2e8f0;
        /* Slate 200 */
        color: var(--primary-dark);
        border-left-color: var(--primary-dark);
        font-weight: 600;
    }

    .nav-link i {
        font-size: 1.25rem;
        width: 24px;
        text-align: center;
    }

    /* Main Content */
    .main-content {
        margin-left: 280px;
        min-height: 100vh;
        transition: margin-left 0.3s ease;
    }

    .topbar {
        position: sticky;
        top: 0;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(8px);
        border-bottom: 1px solid var(--border-color);
        padding: 1rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 100;
    }

    .topbar-title h1 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        letter-spacing: -0.02em;
    }

    .topbar-title p {
        color: var(--text-muted);
        font-size: 0.875rem;
        margin: 0;
    }

    .content-area {
        padding: 2rem;
    }

    /* Cards */
    .card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border-color);
        background: #ffffff;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-title {
        font-size: 1.125rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-title i {
        color: var(--primary);
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Tables */
    .table-modern {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-modern th {
        text-align: left;
        padding: 1rem;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-muted);
        background: #f8fafc;
        border-bottom: 1px solid var(--border-color);
        font-weight: 600;
    }

    .table-modern td {
        padding: 1rem;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
        background: #ffffff;
    }

    .table-modern tr:last-child td {
        border-bottom: none;
    }

    .table-modern tbody tr:hover td {
        background: #f8fafc;
    }

    /* Common UI Elements */
    .badge {
        padding: 0.35em 0.8em;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.75rem;
    }

    .badge-primary {
        background: #f1f5f9;
        color: var(--primary-dark);
        border: 1px solid var(--border-color);
    }

    .badge-success {
        background: #ecfdf5;
        color: var(--success);
        border: 1px solid rgba(16, 185, 129, 0.1);
    }

    .badge-warning {
        background: #fffbeb;
        color: var(--warning);
        border: 1px solid rgba(245, 158, 11, 0.1);
    }

    .badge-danger {
        background: #fef2f2;
        color: var(--danger);
        border: 1px solid rgba(239, 68, 68, 0.1);
    }

    .badge-secondary {
        background: #f1f5f9;
        color: var(--text-muted);
        border: 1px solid var(--border-color);
    }

    .btn-primary {
        background: var(--primary);
        color: white;
        border: none;
        padding: 0.625rem 1.25rem;
        border-radius: 8px;
        font-weight: 600;
        box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.3);
        transition: all 0.2s;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 6px 8px -1px rgba(99, 102, 241, 0.4);
    }

    .btn-outline-light {
        background: white;
        border: 1px solid var(--border-color);
        color: var(--text-main);
    }

    .btn-outline-light:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: var(--text-main);
    }

    .btn-action {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        color: var(--text-muted);
        transition: all 0.2s;
        border: 1px solid transparent;
        background: transparent;
    }

    .btn-action:hover {
        background: #f1f5f9;
        color: var(--primary);
    }

    .btn-action.danger:hover {
        background: #fef2f2;
        color: var(--danger);
    }

    .form-control,
    .form-select {
        background: #ffffff;
        border: 1px solid var(--border-color);
        color: var(--text-main);
        border-radius: 8px;
        padding: 0.625rem 1rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        outline: none;
    }

    .form-label {
        color: var(--text-main);
        font-weight: 500;
        font-size: 0.875rem;
    }

    /* Filter Bar */
    .filter-bar {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        align-items: center;
    }

    /* Modals */
    .modal-content {
        background: #ffffff;
        border: none;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        border-radius: 16px;
    }

    .modal-header {
        border-bottom: 1px solid var(--border-color);
        padding: 1.5rem;
    }

    .modal-footer {
        border-top: 1px solid var(--border-color);
        background: #f8fafc;
        border-bottom-left-radius: 16px;
        border-bottom-right-radius: 16px;
    }

    .btn-close {
        filter: none;
    }

    /* Reset invert */

    /* Dashboard & Stats */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: #ffffff;
        padding: 1.5rem;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
        transition: all 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: var(--text-main);
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: var(--text-muted);
        font-size: 0.875rem;
        font-weight: 500;
    }

    /* Dropdowns */
    .dropdown-menu {
        background: #ffffff;
        border: 1px solid var(--border-color);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        padding: 0.5rem;
    }

    .dropdown-item {
        color: var(--text-main);
        border-radius: 6px;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }

    .dropdown-item:hover {
        background: #f1f5f9;
        color: var(--text-main);
    }

    .dropdown-divider {
        border-color: var(--border-color);
    }

    /* Avatars & Users */
    .user-item-avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .user-item-info .name {
        color: var(--text-main);
        font-weight: 600;
        font-size: 0.9rem;
    }

    .user-item-info .email {
        color: var(--text-muted);
        font-size: 0.8rem;
    }

    /* Monitor & Progress */
    .progress-bar-custom {
        background: #e2e8f0;
        height: 8px;
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-bar-custom .fill {
        height: 100%;
        border-radius: 4px;
        transition: width 0.3s ease;
    }

    /* Topbar Actions */
    .topbar-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .btn-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        border: 1px solid var(--border-color);
        background: #ffffff;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-icon:hover {
        background: #f8fafc;
        color: var(--primary);
        border-color: var(--primary);
    }

    /* Live Indicator */
    .live-indicator {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 50px;
        color: var(--success);
        font-size: 0.85rem;
        font-weight: 500;
    }

    .live-indicator .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--success);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
            transform: scale(1);
        }

        50% {
            opacity: 0.5;
            transform: scale(1.2);
        }
    }

    /* User Avatar */
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: var(--gradient-1);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .user-avatar:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }

    .user-dropdown {
        position: relative;
    }

    /* User Item (for tables/lists) */
    .user-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    /* Activity Items */
    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid var(--border-color);
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .activity-icon.create {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success);
    }

    .activity-icon.update {
        background: rgba(14, 165, 233, 0.1);
        color: var(--secondary);
    }

    .activity-icon.delete {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger);
    }

    .activity-icon.login {
        background: rgba(99, 102, 241, 0.1);
        color: var(--primary);
    }

    .activity-content {
        flex: 1;
    }

    .activity-content .text {
        font-size: 0.9rem;
        line-height: 1.5;
        color: var(--text-main);
    }

    .activity-content .time {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-top: 0.25rem;
    }

    /* Category Cards */
    .category-card {
        transition: all 0.3s ease;
    }

    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .category-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    /* Grid layouts */
    .grid-2 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    @media (max-width: 992px) {
        .grid-2 {
            grid-template-columns: 1fr;
        }
    }

    /* Alert Styling */
    .alert {
        padding: 1rem 1.25rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 500;
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.2);
        color: var(--success);
    }

    .alert-danger {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.2);
        color: var(--danger);
    }

    .alert-warning {
        background: rgba(245, 158, 11, 0.1);
        border: 1px solid rgba(245, 158, 11, 0.2);
        color: var(--warning);
    }

    .alert-info {
        background: rgba(14, 165, 233, 0.1);
        border: 1px solid rgba(14, 165, 233, 0.2);
        color: var(--secondary);
    }

    /* Pagination */
    .pagination {
        display: flex;
        gap: 0.25rem;
        justify-content: center;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pagination .page-item .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 0.75rem;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        background: #ffffff;
        color: var(--text-main);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.875rem;
        transition: all 0.2s;
    }

    .pagination .page-item .page-link:hover {
        background: #f8fafc;
        border-color: var(--primary);
        color: var(--primary);
    }

    .pagination .page-item.active .page-link {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    .pagination .page-item.disabled .page-link {
        opacity: 0.5;
        pointer-events: none;
    }

    /* Stat Card Colors */
    .stat-card.primary .stat-icon {
        background: #f1f5f9;
        color: var(--primary);
    }

    .stat-card.secondary .stat-icon {
        background: rgba(14, 165, 233, 0.1);
        color: var(--secondary);
    }

    .stat-card.success .stat-icon {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success);
    }

    .stat-card.warning .stat-icon {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning);
    }

    .stat-card.danger .stat-icon {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger);
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .stat-change {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        background: rgba(16, 185, 129, 0.1);
        color: var(--success);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }

        .sidebar.active {
            transform: translateX(0);
        }

        .main-content {
            margin-left: 0;
        }

        .topbar {
            padding: 1rem;
        }

        .topbar-actions {
            gap: 0.5rem;
        }

        .live-indicator span {
            display: none;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>