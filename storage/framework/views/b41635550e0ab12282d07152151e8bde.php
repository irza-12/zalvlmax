<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        Dashboard Overview
     <?php $__env->endSlot(); ?>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <!-- Total Users -->
        <div
            class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-card group hover:shadow-lg transition-all duration-300 border border-secondary-100">
            <dt>
                <div class="absolute rounded-xl bg-brand-50 p-3">
                    <svg class="h-6 w-6 text-brand-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </div>
                <p class="ml-16 truncate text-sm font-medium text-secondary-500">Total Users</p>
            </dt>
            <dd class="ml-16 flex items-baseline pb-1 sm:pb-2">
                <p class="text-2xl font-bold text-secondary-900"><?php echo e(number_format($stats['total_users'])); ?></p>
            </dd>
        </div>

        <!-- Total Quizzes -->
        <div
            class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-card group hover:shadow-lg transition-all duration-300 border border-secondary-100">
            <dt>
                <div class="absolute rounded-xl bg-indigo-50 p-3">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-30 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 30 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <p class="ml-16 truncate text-sm font-medium text-secondary-500">Total Quizzes</p>
            </dt>
            <dd class="ml-16 flex items-baseline pb-1 sm:pb-2">
                <p class="text-2xl font-bold text-secondary-900"><?php echo e(number_format($stats['total_quizzes'])); ?></p>
            </dd>
        </div>

        <!-- Active Sessions / Attempts -->
        <div
            class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-card group hover:shadow-lg transition-all duration-300 border border-secondary-100">
            <dt>
                <div class="absolute rounded-xl bg-emerald-50 p-3">
                    <svg class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="ml-16 truncate text-sm font-medium text-secondary-500">Attempts Today</p>
            </dt>
            <dd class="ml-16 flex items-baseline pb-1 sm:pb-2">
                <p class="text-2xl font-bold text-secondary-900"><?php echo e(number_format($stats['attempts_today'])); ?></p>
                <span
                    class="ml-2 text-sm font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">+<?php echo e($stats['active_sessions']); ?>

                    active</span>
            </dd>
        </div>

        <!-- Avg Score -->
        <div
            class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-card group hover:shadow-lg transition-all duration-300 border border-secondary-100">
            <dt>
                <div class="absolute rounded-xl bg-amber-50 p-3">
                    <svg class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                    </svg>
                </div>
                <p class="ml-16 truncate text-sm font-medium text-secondary-500">Avg. Score</p>
            </dt>
            <dd class="ml-16 flex items-baseline pb-1 sm:pb-2">
                <p class="text-2xl font-bold text-secondary-900"><?php echo e($stats['avg_score']); ?>%</p>
            </dd>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">

        <!-- Left Column (Users & Activities) -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Recent Users -->
            <div class="bg-white rounded-2xl shadow-card border border-secondary-100 overflow-hidden">
                <div
                    class="border-b border-secondary-100 bg-secondary-50/50 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-base font-semibold leading-6 text-secondary-900">New Users</h3>
                    <a href="<?php echo e(route('superadmin.users.index')); ?>"
                        class="text-sm font-semibold text-brand-600 hover:text-brand-500">View all</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full whitespace-nowrap text-left text-sm">
                        <thead class="bg-secondary-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 font-semibold text-secondary-900">User</th>
                                <th scope="col" class="px-6 py-3 font-semibold text-secondary-900">Role</th>
                                <th scope="col" class="px-6 py-3 font-semibold text-secondary-900 hidden sm:table-cell">
                                    Joined</th>
                                <th scope="col" class="px-6 py-3 font-semibold text-secondary-900">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-secondary-100 bg-white">
                            <?php $__empty_1 = true; $__currentLoopData = $recentUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-secondary-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-x-4">
                                            <div
                                                class="h-8 w-8 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-bold text-xs ring-2 ring-white">
                                                <?php echo e(strtoupper(substr($user->name, 0, 2))); ?>

                                            </div>
                                            <div class="font-medium text-secondary-900"><?php echo e($user->name); ?></div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php if($user->role === 'super_admin'): ?>
                                            <span
                                                class="inline-flex items-center rounded-md bg-purple-50 px-2 py-1 text-xs font-medium text-purple-700 ring-1 ring-inset ring-purple-700/10">Super
                                                Admin</span>
                                        <?php elseif($user->role === 'admin'): ?>
                                            <span
                                                class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">Admin</span>
                                        <?php else: ?>
                                            <span
                                                class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">User</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-secondary-500 hidden sm:table-cell">
                                        <?php echo e($user->created_at->format('M d, Y')); ?></td>
                                    <td class="px-6 py-4">
                                        <?php if($user->is_active): ?>
                                            <div class="flex items-center gap-x-2">
                                                <div class="h-1.5 w-1.5 rounded-full bg-emerald-500"></div>
                                                <span class="text-xs text-secondary-500">Active</span>
                                            </div>
                                        <?php else: ?>
                                            <div class="flex items-center gap-x-2">
                                                <div class="h-1.5 w-1.5 rounded-full bg-red-500"></div>
                                                <span class="text-xs text-secondary-500">Inactive</span>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-sm text-secondary-500">
                                        No users found.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Activity Feed -->
            <div class="bg-white rounded-2xl shadow-card border border-secondary-100 overflow-hidden">
                <div class="border-b border-secondary-100 bg-secondary-50/50 px-6 py-4">
                    <h3 class="text-base font-semibold leading-6 text-secondary-900">Recent Activity</h3>
                </div>
                <div class="p-6">
                    <ul role="list" class="-mb-8">
                        <?php $__empty_1 = true; $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <li>
                                <div class="relative pb-8">
                                    <?php if(!$loop->last): ?>
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-secondary-200"
                                            aria-hidden="true"></span>
                                    <?php endif; ?>
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white 
                                                <?php if($activity->action === 'create'): ?> bg-green-500 
                                                <?php elseif($activity->action === 'update'): ?> bg-blue-500 
                                                <?php elseif($activity->action === 'delete'): ?> bg-red-500 
                                                <?php else: ?> bg-gray-500 <?php endif; ?>">
                                                <?php if($activity->action === 'create'): ?>
                                                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 4v16m8-8H4" />
                                                    </svg>
                                                <?php elseif($activity->action === 'update'): ?>
                                                    <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                    </svg>
                                                <?php elseif($activity->action === 'delete'): ?>
                                                    <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                <?php else: ?>
                                                    <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                            <div>
                                                <p class="text-sm text-secondary-500">
                                                    <span
                                                        class="font-medium text-secondary-900"><?php echo e($activity->user->name ?? 'System'); ?></span>
                                                    <?php echo e($activity->description); ?>

                                                </p>
                                            </div>
                                            <div class="whitespace-nowrap text-right text-sm text-secondary-400">
                                                <time
                                                    datetime="<?php echo e($activity->created_at); ?>"><?php echo e($activity->created_at->diffForHumans()); ?></time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <li class="py-4 text-center text-sm text-secondary-500">No recent activity</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Right Column (Top Quizzes) -->
        <div class="space-y-8">
            <div class="bg-white rounded-2xl shadow-card border border-secondary-100 overflow-hidden">
                <div
                    class="border-b border-secondary-100 bg-secondary-50/50 px-6 py-4 flex items-center justify-between">
                    <h3 class="text-base font-semibold leading-6 text-secondary-900">Popular Quizzes</h3>
                </div>
                <div class="divide-y divide-secondary-100">
                    <?php $__empty_1 = true; $__currentLoopData = $topQuizzes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="px-6 py-4 hover:bg-secondary-50/50 transition-colors">
                            <div class="flex items-center justify-between mb-2">
                                <span
                                    class="inline-flex items-center justify-center rounded-md bg-brand-50 px-2 py-1 text-xs font-medium text-brand-700 ring-1 ring-inset ring-brand-700/10">
                                    #<?php echo e($index + 1); ?>

                                </span>
                                <span class="text-xs text-secondary-500"><?php echo e($quiz->attempt_count ?? 0); ?> attempts</span>
                            </div>
                            <h4 class="text-sm font-semibold text-secondary-900 mb-1 line-clamp-2"
                                title="<?php echo e($quiz->title); ?>">
                                <?php echo e($quiz->title); ?>

                            </h4>
                            <div class="flex items-center justify-between text-xs text-secondary-500 mt-3">
                                <span>Avg Score</span>
                                <span
                                    class="font-bold <?php echo e(($quiz->avg_score ?? 0) >= 70 ? 'text-green-600' : 'text-amber-600'); ?>">
                                    <?php echo e(round($quiz->avg_score ?? 0, 1)); ?>%
                                </span>
                            </div>
                            <!-- Simple bar -->
                            <div class="mt-2 h-1.5 w-full bg-secondary-100 rounded-full overflow-hidden">
                                <div class="h-full bg-brand-500 rounded-full" style="width: <?php echo e($quiz->avg_score ?? 0); ?>%">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="px-6 py-8 text-center text-sm text-secondary-500">
                            No quizzes found.
                        </div>
                    <?php endif; ?>

                    <div class="px-6 py-4 bg-secondary-50 border-t border-secondary-100">
                        <a href="<?php echo e(route('superadmin.quizzes.index')); ?>"
                            class="block w-full text-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 hover:bg-secondary-50">View
                            All Quizzes</a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div
                class="bg-secondary-900 rounded-2xl shadow-lg border border-secondary-800 overflow-hidden text-white relative">
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-40 h-40 rounded-full bg-brand-500/20 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-40 h-40 rounded-full bg-indigo-500/20 blur-3xl">
                </div>

                <div class="p-6 relative z-10">
                    <h3 class="text-lg font-bold mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="<?php echo e(route('superadmin.quizzes.create')); ?>"
                            class="flex items-center justify-between w-full p-3 rounded-xl bg-white/10 hover:bg-white/20 transition-colors border border-white/10 group">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-brand-500 rounded-lg group-hover:scale-110 transition-transform">
                                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                                <span class="font-medium">Create New Quiz</span>
                            </div>
                            <svg class="h-5 w-5 text-secondary-400 group-hover:text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <a href="<?php echo e(route('superadmin.users.create')); ?>"
                            class="flex items-center justify-between w-full p-3 rounded-xl bg-white/10 hover:bg-white/20 transition-colors border border-white/10 group">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-indigo-500 rounded-lg group-hover:scale-110 transition-transform">
                                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                </div>
                                <span class="font-medium">Add User</span>
                            </div>
                            <svg class="h-5 w-5 text-secondary-400 group-hover:text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\Hype AMD\.gemini\antigravity\scratch\coc-quiz-app\resources\views/superadmin/dashboard.blade.php ENDPATH**/ ?>