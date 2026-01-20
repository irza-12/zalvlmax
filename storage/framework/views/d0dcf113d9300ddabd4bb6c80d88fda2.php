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
    <!-- Keep Bootstrap Icons for Category Icons compatibility -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

     <?php $__env->slot('header', null, []); ?> 
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-secondary-900 leading-tight">
                    Kategori Kuis
                </h2>
                <p class="mt-1 text-sm text-secondary-500">Kelola kategori untuk mengelompokkan kuis</p>
            </div>
            <button @click="addModal = true"
                class="inline-flex items-center gap-x-2 rounded-md bg-brand-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-brand-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600 transition-colors">
                <svg class="-ml-0.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z"
                        clip-rule="evenodd" />
                </svg>
                Tambah Kategori
            </button>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="" x-data="{ 
        addModal: false, 
        editModal: false, 
        editForm: { 
            id: null, 
            name: '', 
            description: '', 
            icon: '', 
            color: '#6366f1', 
            is_active: true,
            action: '' 
        },
        openEdit(category) {
            this.editForm.id = category.id;
            this.editForm.name = category.name;
            this.editForm.description = category.description || '';
            this.editForm.icon = category.icon || '';
            this.editForm.color = category.color || '#6366f1';
            this.editForm.is_active = !!category.is_active;
            this.editForm.action = '/superadmin/categories/' + category.id;
            this.editModal = true;
        }
    }">

        <!-- Grid Layout -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div
                    class="relative flex flex-col overflow-hidden rounded-2xl bg-white shadow-card transition-all hover:shadow-lg border border-secondary-100">
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center justify-center w-12 h-12 rounded-xl"
                                style="background-color: <?php echo e($category->color); ?>20; color: <?php echo e($category->color); ?>">
                                <i class="bi bi-<?php echo e($category->icon ?? 'folder'); ?> text-xl"></i>
                            </div>

                            <!-- Dropdown -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" @click.outside="open = false"
                                    class="-m-2 p-2 text-secondary-400 hover:text-secondary-600 transition-colors">
                                    <span class="sr-only">Open options</span>
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z" />
                                    </svg>
                                </button>
                                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <button @click="open = false; openEdit(<?php echo e(json_encode($category)); ?>)"
                                        class="flex w-full px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-50">
                                        Edit
                                    </button>
                                    <form action="<?php echo e(route('superadmin.categories.destroy', $category)); ?>" method="POST"
                                        onsubmit="return confirm('Hapus kategori ini?')">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit"
                                            class="flex w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <h3 class="text-lg font-semibold text-secondary-900"><?php echo e($category->name); ?></h3>
                            <p class="mt-1 text-sm text-secondary-500 line-clamp-2 h-10">
                                <?php echo e($category->description ?? 'Tidak ada deskripsi'); ?></p>
                        </div>

                        <div class="mt-6 flex items-center justify-between border-t border-secondary-100 pt-4">
                            <span
                                class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset <?php echo e($category->is_active ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-red-50 text-red-700 ring-red-600/10'); ?>">
                                <?php echo e($category->is_active ? 'Aktif' : 'Nonaktif'); ?>

                            </span>
                            <span class="text-xs text-secondary-500"><?php echo e($category->quizzes_count); ?> kuis</span>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-dashed border-secondary-300">
                    <svg class="mx-auto h-12 w-12 text-secondary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-semibold text-secondary-900">Belum ada kategori</h3>
                    <p class="mt-1 text-sm text-secondary-500">Mulai dengan membuat kategori baru.</p>
                    <div class="mt-6">
                        <button @click="addModal = true"
                            class="inline-flex items-center rounded-md bg-brand-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-brand-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600">
                            <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z"
                                    clip-rule="evenodd" />
                            </svg>
                            Tambah Kategori
                        </button>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="mt-6">
            <?php echo e($categories->links()); ?>

        </div>

        <!-- Add Modal -->
        <div x-show="addModal" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true"
            style="display: none;">
            <div x-show="addModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-secondary-900/75 backdrop-blur-sm transition-opacity"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div x-show="addModal" @click.outside="addModal = false" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-secondary-100">
                        <form action="<?php echo e(route('superadmin.categories.store')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                <h3 class="text-lg font-semibold leading-6 text-secondary-900 mb-4" id="modal-title">
                                    Tambah Kategori</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium leading-6 text-secondary-900">Nama
                                            Kategori</label>
                                        <input type="text" name="name" required
                                            class="mt-1 block w-full rounded-md border-0 py-1.5 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-sm font-medium leading-6 text-secondary-900">Deskripsi</label>
                                        <textarea name="description" rows="3"
                                            class="mt-1 block w-full rounded-md border-0 py-1.5 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6"></textarea>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium leading-6 text-secondary-900">Icon
                                                (Bootstrap)</label>
                                            <input type="text" name="icon" placeholder="folder, star..."
                                                class="mt-1 block w-full rounded-md border-0 py-1.5 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6">
                                        </div>
                                        <div>
                                            <label
                                                class="block text-sm font-medium leading-6 text-secondary-900">Warna</label>
                                            <div class="mt-1 flex items-center gap-2">
                                                <input type="color" name="color" value="#6366f1"
                                                    class="h-9 w-full cursor-pointer rounded-md border-0 p-1 ring-1 ring-inset ring-secondary-300">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="relative flex gap-x-3">
                                        <div class="flex h-6 items-center">
                                            <input id="is_active" name="is_active" type="checkbox" checked
                                                class="h-4 w-4 rounded border-secondary-300 text-brand-600 focus:ring-brand-600">
                                        </div>
                                        <div class="text-sm leading-6">
                                            <label for="is_active" class="font-medium text-secondary-900">Aktif</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-secondary-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <button type="submit"
                                    class="inline-flex w-full justify-center rounded-md bg-brand-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-brand-500 sm:ml-3 sm:w-auto">Simpan</button>
                                <button type="button" @click="addModal = false"
                                    class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 hover:bg-secondary-50 sm:mt-0 sm:w-auto">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div x-show="editModal" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true"
            style="display: none;">
            <div x-show="editModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-secondary-900/75 backdrop-blur-sm transition-opacity"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div x-show="editModal" @click.outside="editModal = false"
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-secondary-100">
                        <form :action="editForm.action" method="POST">
                            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                <h3 class="text-lg font-semibold leading-6 text-secondary-900 mb-4">Edit Kategori</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium leading-6 text-secondary-900">Nama
                                            Kategori</label>
                                        <input type="text" name="name" x-model="editForm.name" required
                                            class="mt-1 block w-full rounded-md border-0 py-1.5 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6">
                                    </div>
                                    <div>
                                        <label
                                            class="block text-sm font-medium leading-6 text-secondary-900">Deskripsi</label>
                                        <textarea name="description" x-model="editForm.description" rows="3"
                                            class="mt-1 block w-full rounded-md border-0 py-1.5 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6"></textarea>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium leading-6 text-secondary-900">Icon
                                                (Bootstrap)</label>
                                            <input type="text" name="icon" x-model="editForm.icon"
                                                class="mt-1 block w-full rounded-md border-0 py-1.5 text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 placeholder:text-secondary-400 focus:ring-2 focus:ring-inset focus:ring-brand-600 sm:text-sm sm:leading-6">
                                        </div>
                                        <div>
                                            <label
                                                class="block text-sm font-medium leading-6 text-secondary-900">Warna</label>
                                            <div class="mt-1 flex items-center gap-2">
                                                <input type="color" name="color" x-model="editForm.color"
                                                    class="h-9 w-full cursor-pointer rounded-md border-0 p-1 ring-1 ring-inset ring-secondary-300">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="relative flex gap-x-3">
                                        <div class="flex h-6 items-center">
                                            <input id="edit_is_active" name="is_active" type="checkbox"
                                                x-model="editForm.is_active"
                                                class="h-4 w-4 rounded border-secondary-300 text-brand-600 focus:ring-brand-600">
                                        </div>
                                        <div class="text-sm leading-6">
                                            <label for="edit_is_active"
                                                class="font-medium text-secondary-900">Aktif</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-secondary-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <button type="submit"
                                    class="inline-flex w-full justify-center rounded-md bg-brand-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-brand-500 sm:ml-3 sm:w-auto">Simpan
                                    Perubahan</button>
                                <button type="button" @click="editModal = false"
                                    class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-secondary-900 shadow-sm ring-1 ring-inset ring-secondary-300 hover:bg-secondary-50 sm:mt-0 sm:w-auto">Batal</button>
                            </div>
                        </form>
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
<?php endif; ?><?php /**PATH C:\Users\Hype AMD\.gemini\antigravity\scratch\coc-quiz-app\resources\views/superadmin/categories/index.blade.php ENDPATH**/ ?>