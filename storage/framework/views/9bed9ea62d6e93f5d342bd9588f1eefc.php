

<?php $__env->startSection('title', $microsite->name . ' — Nongkrong Asik'); ?>

<?php $__env->startSection('content'); ?>
    
    <section class="relative h-96 sm:h-[500px] rounded-3xl overflow-hidden mb-10 reveal-up">
        <div class="absolute inset-0 bg-gradient-to-b from-brand-900/90 via-brand-800/70 to-brand-900/95"></div>
        <?php if($microsite->logo && admin_storage_url($microsite->logo)): ?>
            <img src="<?php echo e(admin_storage_url($microsite->logo)); ?>" class="absolute inset-0 w-full h-full object-cover opacity-30">
        <?php endif; ?>
        <div class="relative z-10 h-full flex flex-col items-center justify-center text-center px-6">
            <span class="inline-block py-1 px-4 rounded-full bg-gold-400/20 border border-gold-400/40 text-gold-300 text-xs font-semibold tracking-wider uppercase mb-6 animate-fade-in-up">
                ☕ Kopi Premium
            </span>
            <h1 class="font-serif text-4xl sm:text-6xl font-bold text-white mb-4 leading-tight animate-fade-in-up" style="animation-delay: 0.1s;">
                Selamat Datang di <?php echo e($microsite->name); ?>

            </h1>
            <p class="text-brand-100 text-lg sm:text-xl mb-8 max-w-lg mx-auto animate-fade-in-up" style="animation-delay: 0.2s;">
                <?php echo e($microsite->settings['tagline'] ?? 'Kopi terbaik disajikan dengan hangat dan penuh cinta'); ?>

            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center animate-fade-in-up" style="animation-delay: 0.3s;">
                <a href="<?php echo e(route('menu.index')); ?>" class="btn-gold bg-gold-400 text-white font-semibold px-8 py-3 rounded-full hover:bg-gold-300 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1">
                    Lihat Menu →
                </a>
                <a href="<?php echo e(route('order.track')); ?>" class="bg-white/10 backdrop-blur-sm border border-white/20 text-white font-semibold px-6 py-3 rounded-full hover:bg-white/20 transition-all">
                    Lacak Pesanan
                </a>
            </div>
        </div>
    </section>

    
    <?php if(count($promos)): ?>
        <section class="mb-12 reveal-up">
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-serif text-2xl font-bold text-brand-900">🎉 Promo Spesial</h2>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php $__currentLoopData = $promos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="glass p-6 rounded-2xl card-lift border border-brand-200">
                        <p class="font-serif font-bold text-xl text-brand-800 mb-2"><?php echo e($promo->title); ?></p>
                        <p class="text-stone-600 text-sm mb-4"><?php echo e($promo->description); ?></p>
                        <p class="text-xs text-brand-500 font-medium">Berlaku s.d. <?php echo e($promo->end_date->isoFormat('D MMM Y')); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </section>
    <?php endif; ?>

    
    <section class="mb-12 grid md:grid-cols-3 gap-6">
        <?php $__currentLoopData = [
            ['icon' => '☕', 'title' => 'Kopi Premium', 'desc' => 'Bij kopi pilihan dari petani lokal'],
            ['icon' => '🥐', 'title' => 'Makanan Ringan', 'desc' => 'Pastry dan sandwich segar setiap hari'],
            ['icon' => '📶', 'title' => 'Wi-Fi Gratis', 'desc' => 'Nyaman untuk nongkrong maupun bekerja'],
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="glass p-6 rounded-2xl text-center card-lift reveal-up">
                <div class="text-4xl mb-3 float-slow"><?php echo e($feat['icon']); ?></div>
                <h3 class="font-serif text-xl font-bold text-brand-900 mb-2"><?php echo e($feat['title']); ?></h3>
                <p class="text-stone-600 text-sm"><?php echo e($feat['desc']); ?></p>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </section>

    
    <section class="mb-12 reveal-up">
        <h2 class="font-serif text-2xl font-bold text-brand-900 mb-8 text-center">📂 Pilih Kategori</h2>
        <div class="flex flex-wrap justify-center gap-3">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('menu.index', ['kategori' => $cat->id])); ?>"
                   class="px-6 py-3 rounded-full text-sm font-medium transition-all <?php echo e(is_null($activeCategory) ? 'bg-brand-900 text-white shadow-lg' : 'bg-white border border-brand-200 text-stone-600 hover:bg-brand-100 hover:text-brand-700'); ?>">
                    <?php echo e($cat->name); ?>

                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    
    <section class="mb-12 reveal-up">
        <div class="flex items-center justify-between mb-8">
            <h2 class="font-serif text-2xl font-bold text-brand-900">⭐ Menu Favorit</h2>
            <a href="<?php echo e(route('menu.index')); ?>" class="text-sm text-brand-500 hover:text-brand-800 transition-colors">Lihat semua →</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php $__currentLoopData = $featuredMenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('menu.show', $menu->id)); ?>" class="group card-lift reveal-up">
                    <div class="relative h-48 rounded-2xl overflow-hidden mb-4 border border-brand-100 bg-white group-hover:border-brand-300 transition-colors">
                        <?php if($menu->imageUrl()): ?>
                            <img src="<?php echo e($menu->imageUrl()); ?>" alt="<?php echo e($menu->name); ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <?php else: ?>
                            <div class="w-full h-full bg-brand-100 flex items-center justify-center text-5xl float-slow">🍽️</div>
                        <?php endif; ?>
                        <span class="absolute top-3 right-3 bg-white/90 backdrop-blur text-brand-800 text-xs font-bold px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                            <?php echo e(rupiah($menu->price)); ?>

                        </span>
                    </div>
                    <p class="font-semibold text-stone-800 text-sm"><?php echo e($menu->name); ?></p>
                    <p class="text-xs text-stone-400 mt-1"><?php echo e($menu->category?->name); ?></p>
                    <p class="text-brand-700 font-bold text-sm mt-1.5"><?php echo e(rupiah($menu->price)); ?></p>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    
    <section class="reveal-up">
        <h2 class="font-serif text-2xl font-bold text-brand-900 mb-8 text-center">📸 Galeri</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php $__currentLoopData = $galleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="rounded-2xl overflow-hidden border border-brand-100 card-lift bg-white">
                    <?php if(admin_storage_url($g->image)): ?>
                        <img src="<?php echo e(admin_storage_url($g->image)); ?>" alt="<?php echo e($g->caption); ?>" class="h-32 w-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <?php else: ?>
                        <div class="h-32 bg-brand-100 flex items-center justify-center text-3xl">🖼️</div>
                    <?php endif; ?>
                    <p class="text-xs p-3 text-stone-500 text-center"><?php echo e($g->caption); ?></p>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ACER\Documents\PORTO\Cafe Colab\kafe-system\resources\views/home.blade.php ENDPATH**/ ?>