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
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-secondary-900 leading-tight flex items-center gap-2">
                    <svg class="h-6 w-6 text-green-500 animate-pulse" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.636 18.364a9 9 0 010-12.728m12.728 0a9 9 0 010 12.728m-9.9-2.829a5 5 0 010-7.07m7.072 0a5 5 0 010 7.07M13 12a1 1 0 11-2 0 1 1 0 012 0z" />
                    </svg>
                    Live Monitor
                </h2>
                <p class="mt-1 text-sm text-secondary-500">Pantau user yang sedang mengerjakan kuis secara realtime</p>
            </div>
            <div
                class="flex items-center gap-2 rounded-full bg-white px-3 py-1 text-sm font-medium text-secondary-700 shadow-sm ring-1 ring-inset ring-secondary-300">
                <span class="relative flex h-2.5 w-2.5">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                </span>
                <span><?php echo e($activeSessions->count()); ?> user aktif</span>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <!-- Active Quizzes Grid -->
    <?php if($activeQuizzes->count() > 0): ?>
        <div class="mb-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <?php $__currentLoopData = $activeQuizzes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('superadmin.monitor.quiz', $quiz)); ?>"
                    class="relative flex items-center space-x-3 rounded-lg border border-secondary-200 bg-white px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-brand-500 focus-within:ring-offset-2 hover:border-secondary-300 hover:shadow-md transition-all">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-brand-50 flex items-center justify-center ring-1 ring-brand-100">
                            <svg class="h-6 w-6 text-brand-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="absolute inset-0" aria-hidden="true"></span>
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-secondary-900"><?php echo e($quiz->title); ?></p>
                            <span class="relative flex h-2 w-2 ml-2">
                                <span
                                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                            </span>
                        </div>
                        <div class="flex items-center gap-1 mt-1 text-sm text-secondary-500">
                            <svg class="h-4 w-4 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span class="font-bold text-secondary-900"><?php echo e($quiz->active_count); ?></span> peserta aktif
                        </div>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

    <!-- Active Sessions Table -->
    <div class="rounded-lg bg-white shadow-card border border-secondary-100 overflow-hidden">
        <div class="border-b border-secondary-200 px-4 py-4 sm:px-6 flex justify-between items-center bg-secondary-50">
            <h3 class="text-base font-semibold leading-6 text-secondary-900 flex items-center gap-2">
                <svg class="h-5 w-5 text-secondary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Sesi Aktif
            </h3>
            <button onclick="location.reload()"
                class="inline-flex items-center gap-x-1.5 rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 hover:bg-secondary-50 transition-colors">
                <svg class="-ml-0.5 h-4 w-4 text-secondary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Refresh
            </button>
        </div>
        <div id="sessionListContainer">
            <?php echo $__env->make('superadmin.monitor._session_list', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>

    <script>
        // Auto refresh monitoring data
        function refreshMonitor() {
            fetch("<?php echo e(route('superadmin.monitor.index')); ?>", {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.text())
                .then(html => {
                    const container = document.getElementById('sessionListContainer');

                    // Only update if content changed to avoid excessive flickering
                    if (container.innerHTML !== html) {
                        container.innerHTML = html;
                    }

                    // Recalculate timers after data refresh
                    updateTimers();
                })
                .catch(error => console.error('Error fetching monitor data:', error));
        }

        // Timer Logic
        function updateTimers() {
            const now = Math.floor(Date.now() / 1000);

            document.querySelectorAll('.session-row').forEach(row => {
                const startTime = parseInt(row.getAttribute('data-start'));
                const answered = parseInt(row.getAttribute('data-answered'));

                if (startTime) {
                    // 1. Update Timer Elapsed
                    const elapsed = now - startTime;
                    const minutes = Math.floor(elapsed / 60).toString().padStart(2, '0');
                    const seconds = (elapsed % 60).toString().padStart(2, '0');

                    const timerEl = row.querySelector('.elapsed-time');
                    if (timerEl) timerEl.innerText = `${minutes}:${seconds}`;

                    // 2. Update Avg Speed (Elapsed / Answered)
                    if (answered > 0) {
                        const avgSeconds = Math.round(elapsed / answered);
                        const avgEl = row.querySelector('.avg-time');
                        if (avgEl) avgEl.innerText = `${avgSeconds}s`;
                    }
                }
            });
        }

        // Run timer every second
        setInterval(updateTimers, 1000);

        // Fetch new data every 3 seconds
        setInterval(refreshMonitor, 3000);

        // Initial run
        updateTimers();
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\Hype AMD\.gemini\antigravity\scratch\coc-quiz-app\resources\views/superadmin/monitor/index.blade.php ENDPATH**/ ?>