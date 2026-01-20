<?php
    $navClass = "text-secondary-700 hover:text-brand-600 hover:bg-secondary-50 group flex gap-x-3 rounded-xl px-3 py-2.5 text-sm leading-6 font-semibold transition-all duration-200";
    $activeClass = "bg-brand-50 text-brand-600 group flex gap-x-3 rounded-xl px-3 py-2.5 text-sm leading-6 font-semibold shadow-sm ring-1 ring-brand-200";
?>

<?php if(Auth::user()->isSuperAdmin()): ?>
    <!-- Super Admin Menu -->
    <div class="text-xs font-semibold leading-6 text-secondary-400 uppercase tracking-wider mb-2 mt-4 ml-2">Main Menu</div>

    <li>
        <a href="<?php echo e(route('superadmin.dashboard')); ?>"
            class="<?php echo e(request()->routeIs('superadmin.dashboard') ? $activeClass : $navClass); ?>">
            <svg class="<?php echo e(request()->routeIs('superadmin.dashboard') ? 'text-brand-600' : 'text-secondary-400 group-hover:text-brand-600'); ?> h-6 w-6 shrink-0"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
            </svg>
            Dashboard
        </a>
    </li>

    <li>
        <a href="<?php echo e(route('superadmin.monitor.index')); ?>"
            class="<?php echo e(request()->routeIs('superadmin.monitor*') ? $activeClass : $navClass); ?>">
            <svg class="<?php echo e(request()->routeIs('superadmin.monitor*') ? 'text-brand-600' : 'text-secondary-400 group-hover:text-brand-600'); ?> h-6 w-6 shrink-0"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
            </svg>
            Live Monitor
        </a>
    </li>

    <div class="text-xs font-semibold leading-6 text-secondary-400 uppercase tracking-wider mb-2 mt-6 ml-2">Management</div>

    <li>
        <a href="<?php echo e(route('superadmin.quizzes.index')); ?>"
            class="<?php echo e(request()->routeIs('superadmin.quizzes*') ? $activeClass : $navClass); ?>">
            <svg class="<?php echo e(request()->routeIs('superadmin.quizzes*') ? 'text-brand-600' : 'text-secondary-400 group-hover:text-brand-600'); ?> h-6 w-6 shrink-0"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
            </svg>
            Quizzes
        </a>
    </li>

    <li>
        <a href="<?php echo e(route('superadmin.categories.index')); ?>"
            class="<?php echo e(request()->routeIs('superadmin.categories*') ? $activeClass : $navClass); ?>">
            <svg class="<?php echo e(request()->routeIs('superadmin.categories*') ? 'text-brand-600' : 'text-secondary-400 group-hover:text-brand-600'); ?> h-6 w-6 shrink-0"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
            </svg>
            Categories
        </a>
    </li>

    <li>
        <a href="<?php echo e(route('superadmin.users.index')); ?>"
            class="<?php echo e(request()->routeIs('superadmin.users*') ? $activeClass : $navClass); ?>">
            <svg class="<?php echo e(request()->routeIs('superadmin.users*') ? 'text-brand-600' : 'text-secondary-400 group-hover:text-brand-600'); ?> h-6 w-6 shrink-0"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
            </svg>
            Users
        </a>
    </li>

    <div class="text-xs font-semibold leading-6 text-secondary-400 uppercase tracking-wider mb-2 mt-6 ml-2">Analytics</div>

    <li>
        <a href="<?php echo e(route('superadmin.leaderboard.index')); ?>"
            class="<?php echo e(request()->routeIs('superadmin.leaderboard*') ? $activeClass : $navClass); ?>">
            <svg class="<?php echo e(request()->routeIs('superadmin.leaderboard*') ? 'text-brand-600' : 'text-secondary-400 group-hover:text-brand-600'); ?> h-6 w-6 shrink-0"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0V5.625a1.125 1.125 0 00-1.125-1.125h-3.375a1.125 1.125 0 00-1.125 1.125v8.625" />
            </svg>
            Leaderboard
        </a>
    </li>

    <li>
        <a href="<?php echo e(route('superadmin.statistics.index')); ?>"
            class="<?php echo e(request()->routeIs('superadmin.statistics*') ? $activeClass : $navClass); ?>">
            <svg class="<?php echo e(request()->routeIs('superadmin.statistics*') ? 'text-brand-600' : 'text-secondary-400 group-hover:text-brand-600'); ?> h-6 w-6 shrink-0"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
            </svg>
            Statistics
        </a>
    </li>

    <div class="text-xs font-semibold leading-6 text-secondary-400 uppercase tracking-wider mb-2 mt-6 ml-2">System</div>

    <li>
        <a href="<?php echo e(route('superadmin.activity-logs.index')); ?>"
            class="<?php echo e(request()->routeIs('superadmin.activity-logs*') ? $activeClass : $navClass); ?>">
            <svg class="<?php echo e(request()->routeIs('superadmin.activity-logs*') ? 'text-brand-600' : 'text-secondary-400 group-hover:text-brand-600'); ?> h-6 w-6 shrink-0"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Activity Logs
        </a>
    </li>

    <li>
        <a href="<?php echo e(route('superadmin.settings.index')); ?>"
            class="<?php echo e(request()->routeIs('superadmin.settings*') ? $activeClass : $navClass); ?>">
            <svg class="<?php echo e(request()->routeIs('superadmin.settings*') ? 'text-brand-600' : 'text-secondary-400 group-hover:text-brand-600'); ?> h-6 w-6 shrink-0"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Settings
        </a>
    </li>

<?php elseif(Auth::user()->isUser()): ?>
    <!-- Regular User Menu -->
    <div class="text-xs font-semibold leading-6 text-secondary-400 uppercase tracking-wider mb-2 mt-4 ml-2">Menu</div>

    <li>
        <a href="<?php echo e(route('user.dashboard')); ?>"
            class="<?php echo e(request()->routeIs('user.dashboard') ? $activeClass : $navClass); ?>">
            <svg class="<?php echo e(request()->routeIs('user.dashboard') ? 'text-brand-600' : 'text-secondary-400 group-hover:text-brand-600'); ?> h-6 w-6 shrink-0"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
            </svg>
            Dashboard
        </a>
    </li>

    <li>
        <a href="<?php echo e(route('user.quizzes.index')); ?>"
            class="<?php echo e(request()->routeIs('user.quizzes.index') ? $activeClass : $navClass); ?>">
            <svg class="<?php echo e(request()->routeIs('user.quizzes.index') ? 'text-brand-600' : 'text-secondary-400 group-hover:text-brand-600'); ?> h-6 w-6 shrink-0"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
            </svg>
            My Quizzes
        </a>
    </li>

    <li>
        <a href="<?php echo e(route('user.results.index')); ?>"
            class="<?php echo e(request()->routeIs('user.results*') ? $activeClass : $navClass); ?>">
            <svg class="<?php echo e(request()->routeIs('user.results*') ? 'text-brand-600' : 'text-secondary-400 group-hover:text-brand-600'); ?> h-6 w-6 shrink-0"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
            </svg>
            History & Results
        </a>
    </li>

    <li>
        <a href="<?php echo e(route('user.leaderboard')); ?>"
            class="<?php echo e(request()->routeIs('user.leaderboard') ? $activeClass : $navClass); ?>">
            <svg class="<?php echo e(request()->routeIs('user.leaderboard') ? 'text-brand-600' : 'text-secondary-400 group-hover:text-brand-600'); ?> h-6 w-6 shrink-0"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0V5.625a1.125 1.125 0 00-1.125-1.125h-3.375a1.125 1.125 0 00-1.125 1.125v8.625" />
            </svg>
            Global Leaderboard
        </a>
    </li>

<?php elseif(Auth::user()->isAdmin()): ?>
    <!-- Admin Menu -->
    <div class="text-xs font-semibold leading-6 text-secondary-400 uppercase tracking-wider mb-2 mt-4 ml-2">Admin Menu</div>
    <li>
        <a href="<?php echo e(route('admin.dashboard')); ?>"
            class="<?php echo e(request()->routeIs('admin.dashboard') ? $activeClass : $navClass); ?>">
            <svg class="<?php echo e(request()->routeIs('admin.dashboard') ? 'text-brand-600' : 'text-secondary-400 group-hover:text-brand-600'); ?> h-6 w-6 shrink-0"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
            </svg>
            Dashboard
        </a>
    </li>

    <div class="text-xs font-semibold leading-6 text-secondary-400 uppercase tracking-wider mb-2 mt-6 ml-2">Management</div>

    <li>
        <a href="<?php echo e(route('admin.quizzes.index')); ?>"
            class="<?php echo e(request()->routeIs('admin.quizzes*') ? $activeClass : $navClass); ?>">
            <svg class="<?php echo e(request()->routeIs('admin.quizzes*') ? 'text-brand-600' : 'text-secondary-400 group-hover:text-brand-600'); ?> h-6 w-6 shrink-0"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
            </svg>
            Quizzes
        </a>
    </li>

    <li>
        <a href="<?php echo e(route('admin.users.index')); ?>"
            class="<?php echo e(request()->routeIs('admin.users*') ? $activeClass : $navClass); ?>">
            <svg class="<?php echo e(request()->routeIs('admin.users*') ? 'text-brand-600' : 'text-secondary-400 group-hover:text-brand-600'); ?> h-6 w-6 shrink-0"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
            </svg>
            Users
        </a>
    </li>

    <li>
        <a href="<?php echo e(route('admin.results.index')); ?>"
            class="<?php echo e(request()->routeIs('admin.results*') ? $activeClass : $navClass); ?>">
            <svg class="<?php echo e(request()->routeIs('admin.results*') ? 'text-brand-600' : 'text-secondary-400 group-hover:text-brand-600'); ?> h-6 w-6 shrink-0"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
            </svg>
            Results
        </a>
    </li>
<?php endif; ?><?php /**PATH C:\Users\Hype AMD\.gemini\antigravity\scratch\coc-quiz-app\resources\views/layouts/partials/sidebar-links.blade.php ENDPATH**/ ?>