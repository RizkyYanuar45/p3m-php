<?php
// Mengambil path URL saat ini
$current_uri = $_SERVER['REQUEST_URI'];

/**
 * Fungsi helper untuk mengecek apakah link aktif
 * Mengembalikan string class Tailwind jika aktif
 */
function is_active($path, $current_uri)
{
    $current_path = parse_url($current_uri, PHP_URL_PATH);
    if (strpos($path, '/') === 0) {
        return ($current_path === $path) ? 'text-primary font-bold bg-slate-50 dark:bg-slate-800/50' : '';
    }
    return (strpos($current_uri, $path) !== false) ? 'text-primary font-bold bg-slate-50 dark:bg-slate-800/50' : '';
}

/**
 * Fungsi helper untuk submenu aktif
 */
function is_sub_active($path, $current_uri)
{
    $current_path = parse_url($current_uri, PHP_URL_PATH);
    // Jika path diawali dengan /, gunakan exact match
    if (strpos($path, '/') === 0) {
        return ($current_path === $path) ? 'text-primary font-bold' : 'text-slate-600 dark:text-slate-400';
    }
    // Jika tidak, cek apakah current path berakhir dengan / + path (untuk menghindari partial match seperti dokumen-mandiri vs dokumen)
    return ($current_path === $path || str_ends_with($current_path, '/' . trim($path, '/'))) ? 'text-primary font-bold' : 'text-slate-600 dark:text-slate-400';
}

/**
 * Fungsi untuk mengecek apakah parent dropdown harus terbuka
 */
function is_dropdown_open($paths, $current_uri)
{
    foreach ($paths as $path) {
        if (strpos($current_uri, $path) !== false) return ''; // '' berarti hapus class 'hidden'
    }
    return 'hidden';
}

/**
 * Fungsi untuk memutar panah jika dropdown terbuka
 */
function is_arrow_rotated($paths, $current_uri)
{
    foreach ($paths as $path) {
        if (strpos($current_uri, $path) !== false) return 'rotate-180';
    }
    return '';
}
?>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(238, 179, 179, 0.2);
        border-radius: 10px;
    }

    .dark .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.1);
    }

    .rotate-180 {
        transform: rotate(180deg);
    }

    /* Mobile sidebar transition */
    #admin-sidebar {
        transition: transform 0.3s ease-in-out;
    }
    @media (max-width: 1023px) {
        #admin-sidebar {
            transform: translateX(-100%);
        }
        #admin-sidebar.sidebar-open {
            transform: translateX(0);
        }
    }
</style>

<!-- Mobile Top Bar (visible only on mobile) -->
<div id="admin-mobile-topbar" class="lg:hidden fixed top-0 left-0 right-0 z-40 bg-white dark:bg-background-dark border-b border-slate-200 dark:border-slate-800 px-4 py-3 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <div class="size-8 bg-primary rounded-lg flex items-center justify-center shadow-md shadow-primary/20">
            <span class="material-symbols-outlined text-white text-lg">school</span>
        </div>
        <h1 class="text-lg font-bold tracking-tight text-slate-900 dark:text-white">P3M UNIM</h1>
    </div>
    <button id="admin-sidebar-open" class="p-2 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">
        <span class="material-symbols-outlined text-2xl">menu</span>
    </button>
</div>

<!-- Sidebar Overlay (mobile only) -->
<div id="admin-sidebar-overlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 hidden lg:hidden" onclick="closeSidebar()"></div>

<!-- Sidebar -->
<aside id="admin-sidebar" class="fixed lg:relative w-72 flex-shrink-0 border-r border-slate-200 dark:border-slate-800 bg-white dark:bg-background-dark flex flex-col h-screen overflow-hidden z-50">
    <!-- Sidebar Header -->
    <div class="p-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="size-10 bg-primary rounded-xl flex items-center justify-center shadow-lg shadow-primary/20">
                <span class="material-symbols-outlined text-white text-2xl">school</span>
            </div>
            <div>
                <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white leading-none">P3M UNIM</h1>
                <p class="text-[10px] uppercase tracking-widest text-primary font-semibold mt-1">Majapahit University</p>
            </div>
        </div>
        <!-- Close button (mobile only) -->
        <button id="admin-sidebar-close" class="lg:hidden p-1.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>

    <nav class="flex-1 overflow-y-auto px-4 py-2 space-y-1 custom-scrollbar">
        <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all group <?= (strpos($current_uri, 'dashboard') !== false) ? 'bg-primary text-white font-medium' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' ?>" href="/admin/dashboard">
            <span class="material-symbols-outlined transition-transform group-hover:scale-110">dashboard</span>
            <span>Dashboard</span>
        </a>

        <div class="pt-4 pb-2 px-3">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Manajemen Utama</p>
        </div>

        <div class="space-y-1">

            <?php $profilPaths = ['/admin/profile/struktur-organisasi', '/admin/profile/dokumen-p3m', '/admin/profile/luaran-p3m']; ?>
            <div class="relative">
                <button class="dropdown-btn w-full flex items-center justify-between px-3 py-2.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 transition-all group">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-slate-400 group-hover:text-primary <?= is_arrow_rotated($profilPaths, $current_uri) ? 'text-primary' : '' ?>">account_circle</span>
                        <span class="font-medium <?= is_arrow_rotated($profilPaths, $current_uri) ? 'text-primary font-bold' : '' ?>">Profil</span>
                    </div>
                    <span class="arrow-icon material-symbols-outlined text-sm transition-transform <?= is_arrow_rotated($profilPaths, $current_uri) ?>">expand_more</span>
                </button>
                <div class="submenu <?= is_dropdown_open($profilPaths, $current_uri) ?> ml-9 space-y-1 border-l border-slate-200 dark:border-slate-800 pl-4 mt-1">
                    <a class="block py-2 text-sm hover:text-primary transition-all <?= is_sub_active('/admin/profile/struktur-organisasi', $current_uri) ?>" href="/admin/profile/struktur-organisasi">Struktur Organisasi</a>
                    <a class="block py-2 text-sm hover:text-primary transition-all <?= is_sub_active('/admin/profile/dokumen-p3m', $current_uri) ?>" href="/admin/profile/dokumen-p3m">Dokumen P3M</a>
                    <a class="block py-2 text-sm hover:text-primary transition-all <?= is_sub_active('/admin/profile/luaran-p3m', $current_uri) ?>" href="/admin/profile/luaran-p3m">Luaran P3M</a>
                </div>
            </div>

            <?php $penelitianPaths = ['/admin/penelitian/panduan', '/admin/penelitian/informasi', '/admin/penelitian/dokumen', '/admin/penelitian/sk-rektor']; ?>
            <div class="relative">
                <button class="dropdown-btn w-full flex items-center justify-between px-3 py-2.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 transition-all group">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-slate-400 group-hover:text-primary <?= is_arrow_rotated($penelitianPaths, $current_uri) ? 'text-primary' : '' ?>">menu_book</span>
                        <span class="font-medium <?= is_arrow_rotated($penelitianPaths, $current_uri) ? 'text-primary font-bold' : '' ?>">Penelitian</span>
                    </div>
                    <span class="arrow-icon material-symbols-outlined text-sm transition-transform <?= is_arrow_rotated($penelitianPaths, $current_uri) ?>">expand_more</span>
                </button>
                <div class="submenu <?= is_dropdown_open($penelitianPaths, $current_uri) ?> ml-9 space-y-1 border-l border-slate-200 dark:border-slate-800 pl-4 mt-1">
                    <a class="block py-2 text-sm hover:text-primary transition-all <?= is_sub_active('/admin/penelitian/panduan', $current_uri) ?>" href="/admin/penelitian/panduan">Panduan Penelitian</a>
                    <a class="block py-2 text-sm hover:text-primary transition-all <?= is_sub_active('/admin/penelitian/informasi', $current_uri) ?>" href="/admin/penelitian/informasi">Informasi Penelitian</a>
                    <a class="block py-2 text-sm hover:text-primary transition-all <?= is_sub_active('/admin/penelitian/dokumen', $current_uri) ?>" href="/admin/penelitian/dokumen">Dokumen Penelitian</a>
                    <a class="block py-2 text-sm hover:text-primary transition-all <?= is_sub_active('/admin/penelitian/sk-rektor', $current_uri) ?>" href="/admin/penelitian/sk-rektor">SK Rektor</a>
                </div>
            </div>

            <?php $pengabdianPaths = ['/admin/pengabdian/informasi-mandiri', '/admin/pengabdian/mandiri', '/admin/pengabdian/panduan', '/admin/pengabdian/informasi', '/admin/pengabdian/sk-rektor', '/admin/pengabdian/dokumen']; ?>
            <div class="relative">
                <button class="dropdown-btn w-full flex items-center justify-between px-3 py-2.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 transition-all group text-left">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-slate-400 group-hover:text-primary <?= is_arrow_rotated($pengabdianPaths, $current_uri) ? 'text-primary' : '' ?>">group_work</span>
                        <span class="font-medium <?= is_arrow_rotated($pengabdianPaths, $current_uri) ? 'text-primary font-bold' : '' ?>">Pengabdian Masyarakat</span>
                    </div>
                    <span class="arrow-icon material-symbols-outlined text-sm transition-transform <?= is_arrow_rotated($pengabdianPaths, $current_uri) ?>">expand_more</span>
                </button>
                <div class="submenu <?= is_dropdown_open($pengabdianPaths, $current_uri) ?> ml-9 space-y-1 border-l border-slate-200 dark:border-slate-800 pl-4 mt-1">
                    <a class="block py-2 text-sm hover:text-primary transition-all <?= is_sub_active('/admin/pengabdian/informasi-mandiri', $current_uri) ?>" href="/admin/pengabdian/informasi-mandiri">Informasi Mandiri</a>
                    <a class="block py-2 text-sm hover:text-primary transition-all <?= is_sub_active('/admin/pengabdian/dokumen-mandiri', $current_uri) ?>" href="/admin/pengabdian/dokumen-mandiri">Dokumen Pengabdian Mandiri</a>
                    <a class="block py-2 text-sm hover:text-primary transition-all <?= is_sub_active('/admin/pengabdian/panduan', $current_uri) ?>" href="/admin/pengabdian/panduan">Panduan Pengabdian</a>
                    <a class="block py-2 text-sm hover:text-primary transition-all <?= is_sub_active('/admin/pengabdian/informasi', $current_uri) ?>" href="/admin/pengabdian/informasi">Informasi Pengabdian</a>
                    <a class="block py-2 text-sm hover:text-primary transition-all <?= is_sub_active('/admin/pengabdian/sk-rektor', $current_uri) ?>" href="/admin/pengabdian/sk-rektor">SK Pengabdian</a>
                    <a class="block py-2 text-sm hover:text-primary transition-all <?= is_sub_active('/admin/pengabdian/dokumen', $current_uri) ?>" href="/admin/pengabdian/dokumen">Dokumen Pengabdian</a>
                </div>
            </div>

            <?php $kknPaths = ['/admin/kkn/informasi', '/admin/kkn/panduan-tematik', '/admin/kkn/panduan-pmm', '/admin/kkn/panduan-bem']; ?>
            <div class="relative">
                <button class="dropdown-btn w-full flex items-center justify-between px-3 py-2.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 transition-all group">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-slate-400 group-hover:text-primary <?= is_arrow_rotated($kknPaths, $current_uri) ? 'text-primary' : '' ?>">diversity_3</span>
                        <span class="font-medium <?= is_arrow_rotated($kknPaths, $current_uri) ? 'text-primary font-bold' : '' ?>">KKN</span>
                    </div>
                    <span class="arrow-icon material-symbols-outlined text-sm transition-transform <?= is_arrow_rotated($kknPaths, $current_uri) ?>">expand_more</span>
                </button>
                <div class="submenu <?= is_dropdown_open($kknPaths, $current_uri) ?> ml-9 space-y-1 border-l border-slate-200 dark:border-slate-800 pl-4 mt-1">
                    <a class="block py-2 text-sm hover:text-primary transition-all <?= is_sub_active('/admin/kkn/informasi', $current_uri) ?>" href="/admin/kkn/informasi">Informasi KKN</a>
                    <a class="block py-2 text-sm hover:text-primary transition-all <?= is_sub_active('/admin/kkn/panduan-tematik', $current_uri) ?>" href="/admin/kkn/panduan-tematik">Panduan KKN Tematik</a>
                    <a class="block py-2 text-sm hover:text-primary transition-all <?= is_sub_active('/admin/kkn/panduan-pmm', $current_uri) ?>" href="/admin/kkn/panduan-pmm">Panduan KKN PMM</a>
                    <a class="block py-2 text-sm hover:text-primary transition-all <?= is_sub_active('/admin/kkn/panduan-bem', $current_uri) ?>" href="/admin/kkn/panduan-bem">Panduan KKN BEM</a>
                </div>
            </div>

            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 transition-all group <?= is_active('/admin/panduan-layanan-hki', $current_uri) ?>" href="/admin/panduan-layanan-hki">
                <span class="material-symbols-outlined text-slate-400 group-hover:text-primary <?= is_active('/admin/panduan-layanan-hki', $current_uri) ? 'text-primary' : '' ?>">article</span>
                <span class="font-medium">Panduan Layanan HKI</span>
            </a>
        </div>
    </nav>

    <div class="p-4 border-t border-slate-200 dark:border-slate-800">
        <a class="w-full flex items-center justify-center gap-2 bg-slate-900 dark:bg-slate-800 text-white py-3 rounded-lg font-bold text-sm hover:bg-slate-800 transition-all" href="/admin/logout">
            <span class="material-symbols-outlined text-sm">logout</span>
            Keluar Sesi
        </a>
    </div>
</aside>

<script>
    // Sidebar toggle logic
    function openSidebar() {
        document.getElementById('admin-sidebar').classList.add('sidebar-open');
        document.getElementById('admin-sidebar-overlay').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        document.getElementById('admin-sidebar').classList.remove('sidebar-open');
        document.getElementById('admin-sidebar-overlay').classList.add('hidden');
        document.body.style.overflow = '';
    }

    document.getElementById('admin-sidebar-open').addEventListener('click', openSidebar);
    document.getElementById('admin-sidebar-close').addEventListener('click', closeSidebar);

    // Close sidebar when clicking a nav link on mobile
    document.querySelectorAll('#admin-sidebar nav a').forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth < 1024) {
                closeSidebar();
            }
        });
    });

    // Logic Klik Manual agar user tetap bisa buka tutup tanpa reload
    document.querySelectorAll('.dropdown-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const parent = this.parentElement;
            const submenu = parent.querySelector('.submenu');
            const arrow = this.querySelector('.arrow-icon');

            submenu.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        });
    });
</script>