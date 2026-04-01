<!DOCTYPE html>

<html lang="id">

<head>
    <?php include __DIR__ . '/../../helpers/HeadConfig.php'; ?>
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 50;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }
    </style>
    <title>Kelola Luaran P3M (Video)</title>
</head>

<?php
function getYoutubeId($url)
{
    // Handle embed link
    if (strpos($url, 'embed/') !== false) {
        $parts = explode('embed/', $url);
        return explode('?', $parts[1])[0];
    }
    // Handle watch?v=
    if (strpos($url, 'v=') !== false) {
        $parts = explode('v=', $url);
        return explode('&', $parts[1])[0];
    }
    // Handle youtu.be/
    if (strpos($url, 'youtu.be/') !== false) {
        $parts = explode('youtu.be/', $url);
        return explode('?', $parts[1])[0];
    }
    // Handle youtube.com/v/
    if (strpos($url, 'youtube.com/v/') !== false) {
        $parts = explode('youtube.com/v/', $url);
        return explode('?', $parts[1])[0];
    }
    return '';
}
?>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 antialiased font-display">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar Navigation -->
        <?php include __DIR__ . '/../layouts/sidebarAdmin.php' ?>
        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col overflow-hidden pt-14 lg:pt-0">

            <!-- Scrollable Page Content -->
            <div class="flex-1 overflow-y-auto p-4 md:p-8 bg-background-light dark:bg-background-dark">
                <div class="max-w-6xl mx-auto space-y-8">

                    <!-- Session Feedback -->
                    <?php if (isset($_SESSION['flash_success'])): ?>
                        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
                            <span class="material-symbols-outlined">check_circle</span>
                            <span class="font-medium"><?= $_SESSION['flash_success'];
                                                        unset($_SESSION['flash_success']); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['flash_error'])): ?>
                        <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-3">
                            <span class="material-symbols-outlined">error</span>
                            <span class="font-medium"><?= $_SESSION['flash_error'];
                                                        unset($_SESSION['flash_error']); ?></span>
                        </div>
                    <?php endif; ?>

                    <!-- Page Title Section -->
                    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                        <div>
                            <p class="text-primary font-bold tracking-wider text-xs uppercase mb-1">Manajemen Konten</p>
                            <h1 class="text-xl md:text-3xl font-black text-slate-900 dark:text-white tracking-tight">Kelola Luaran P3M (Video)</h1>
                            <p class="text-slate-500 mt-2">Kelola data luaran hasil penelitian dan pengabdian dalam format media video.</p>
                        </div>
                        <a href="/luaran-p3m" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 rounded-lg font-bold text-sm transition-all border border-slate-200 dark:border-slate-700">
                            <span class="material-symbols-outlined text-lg">visibility</span>
                            Lihat Halaman
                        </a>
                    </div>

                    <!-- Form Section: Tambah Video Baru -->
                    <section class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
                        <div class="p-6 border-b border-slate-100 dark:border-slate-800">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">add_circle</span>
                                <h2 class="text-lg font-bold">Tambah Video Baru</h2>
                            </div>
                        </div>
                        <div class="p-4 md:p-8">
                            <form action="/admin/profile/luaran-p3m/tambah" method="POST">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Judul Video</label>
                                        <input name="title" required class="w-full rounded-lg border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:border-primary focus:ring-primary h-12" placeholder="Masukkan judul video luaran" type="text" />
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Link Embed YouTube</label>
                                        <div class="relative">
                                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">link</span>
                                            <input name="link" id="input-link-add" required class="w-full pl-10 rounded-lg border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:border-primary focus:ring-primary h-12" placeholder="https://www.youtube.com/watch?v=..." type="text" onblur="autoFormatYoutube(this)" />
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="bg-primary hover:bg-orange-600 text-white font-bold py-3 px-8 rounded-lg shadow-lg shadow-primary/20 transition-all flex items-center gap-2">
                                        <span class="material-symbols-outlined">save</span>
                                        Simpan Video
                                    </button>
                                </div>
                            </form>
                        </div>
                    </section>
                    <!-- List Section: Daftar Video Luaran -->
                    <section class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">video_library</span>
                                <h2 class="text-xl font-bold">Daftar Video Luaran</h2>
                            </div>
                            <?php if ($totalItems > 0): ?>
                                <span class="text-sm text-slate-500 font-medium tracking-tight">Menampilkan <?= count($videos); ?> dari <?= $totalItems; ?> video</span>
                            <?php endif; ?>
                        </div>

                        <?php if (empty($videos)): ?>
                            <div class="bg-white dark:bg-slate-900 rounded-xl p-12 text-center border border-dashed border-slate-200 dark:border-slate-800">
                                <span class="material-symbols-outlined text-5xl text-slate-200 mb-4">video_library</span>
                                <p class="text-slate-500 font-medium">Belum ada video luaran yang ditambahkan.</p>
                            </div>
                        <?php else: ?>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <?php foreach ($videos as $video):
                                    $ytId = getYoutubeId($video['link']);
                                    $thumb = $ytId ? "https://img.youtube.com/vi/$ytId/mqdefault.jpg" : 'https://placehold.co/600x400?text=No+Thumbnail';
                                ?>
                                    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden flex flex-col group h-full">
                                        <div class="aspect-video relative overflow-hidden bg-slate-100">
                                            <img alt="<?= htmlspecialchars($video['title']); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="<?= $thumb; ?>" />
                                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                <a href="<?= htmlspecialchars($video['link']); ?>" target="_blank" class="material-symbols-outlined text-white text-5xl hover:scale-110 transition-transform">play_circle</a>
                                            </div>
                                        </div>
                                        <div class="p-4 flex-1 flex flex-col justify-between">
                                            <h3 class="font-bold text-slate-900 dark:text-white line-clamp-2 leading-snug mb-4 h-12" title="<?= htmlspecialchars($video['title']); ?>">
                                                <?= htmlspecialchars($video['title']); ?>
                                            </h3>
                                            <div class="pt-4 border-t border-slate-50 dark:border-slate-800 flex items-center justify-between">
                                                <div class="flex gap-2">
                                                    <button onclick="openEditModal(<?= htmlspecialchars(json_encode($video)); ?>)" class="p-2 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors" title="Edit">
                                                        <span class="material-symbols-outlined text-lg">edit</span>
                                                    </button>
                                                    <form id="form-del-<?= $video['id']; ?>" action="/admin/profile/luaran-p3m/hapus" method="POST" class="inline">
                                                        <input type="hidden" name="id" value="<?= $video['id']; ?>">
                                                        <button type="button" onclick="confirmDelete('form-del-<?= $video['id']; ?>', 'Apakah Anda yakin ingin menghapus video ini?')" class="p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors" title="Hapus">
                                                            <span class="material-symbols-outlined text-lg">delete</span>
                                                        </button>
                                                    </form>
                                                </div>
                                                <div class="flex items-center gap-1 text-slate-400">
                                                    <span class="material-symbols-outlined text-sm">calendar_today</span>
                                                    <span class="text-[10px] font-bold"><?= date('d M Y', strtotime($video['createdAt'])); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Pagination -->
                            <?php if ($totalPages > 1): ?>
                                <div class="flex items-center justify-center pt-8">
                                    <nav class="flex items-center gap-1">
                                        <?php if ($page > 1): ?>
                                            <a href="?page=<?= $page - 1; ?>" class="w-10 h-10 flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-800 hover:bg-white dark:hover:bg-slate-800 transition-colors">
                                                <span class="material-symbols-outlined">chevron_left</span>
                                            </a>
                                        <?php endif; ?>

                                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                            <a href="?page=<?= $i; ?>" class="w-10 h-10 flex items-center justify-center rounded-lg <?= $i === $page ? 'bg-primary text-white font-bold shadow-lg shadow-orange-200' : 'hover:bg-white dark:hover:bg-slate-800 font-medium' ?>">
                                                <?= $i; ?>
                                            </a>
                                        <?php endfor; ?>

                                        <?php if ($page < $totalPages): ?>
                                            <a href="?page=<?= $page + 1; ?>" class="w-10 h-10 flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-800 hover:bg-white dark:hover:bg-slate-800 transition-colors">
                                                <span class="material-symbols-outlined">chevron_right</span>
                                            </a>
                                        <?php endif; ?>
                                    </nav>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </section>
                </div>
            </div>
        </main>
    </div>

    <!-- Edit Modal -->
    <div id="modal-edit" class="modal px-4">
        <div class="bg-white dark:bg-slate-900 w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden mx-4">
            <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <h3 class="text-lg font-bold">Edit Video Luaran</h3>
                <button onclick="closeModal('modal-edit')" class="text-slate-400 hover:text-slate-600"><span class="material-symbols-outlined">close</span></button>
            </div>
            <form action="/admin/profile/luaran-p3m/edit" method="POST" class="p-6 space-y-4">
                <input type="hidden" name="id" id="edit-id">
                <div class="space-y-2">
                    <label class="text-sm font-semibold">Judul Video</label>
                    <input name="title" id="edit-title" required class="w-full rounded-lg border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:border-primary focus:ring-primary h-12" type="text" />
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold">Link Embed YouTube</label>
                    <input name="link" id="edit-link" required class="w-full rounded-lg border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:border-primary focus:ring-primary h-12" type="text" onblur="autoFormatYoutube(this)" />
                </div>
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="closeModal('modal-edit')" class="px-6 py-2.5 rounded-xl font-bold text-sm text-slate-500">Batal</button>
                    <button type="submit" class="bg-primary text-white px-8 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-primary/20">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="modal-delete" class="modal px-4">
        <div class="bg-white dark:bg-slate-900 w-full max-w-sm rounded-2xl shadow-2xl overflow-hidden text-center p-8 mx-4">
            <div class="size-20 bg-red-100 dark:bg-red-900/30 text-red-600 rounded-full flex items-center justify-center mx-auto mb-6">
                <span class="material-symbols-outlined text-4xl">delete_forever</span>
            </div>
            <h3 class="text-xl font-bold mb-2">Konfirmasi Hapus</h3>
            <p id="delete-message" class="text-slate-500 dark:text-slate-400 text-sm mb-8">Apakah Anda yakin ingin menghapus item ini?</p>
            <div class="flex flex-col gap-3">
                <button id="btn-confirm-delete" onclick="executeDelete()" class="w-full bg-red-600 hover:bg-red-700 text-white py-3 rounded-xl font-bold transition-all active:scale-95">Ya, Hapus Sekarang</button>
                <button onclick="closeModal('modal-delete')" class="w-full py-3 text-slate-500 font-bold hover:text-slate-700 transition-colors">Batal</button>
            </div>
        </div>
    </div>

    <script>
        let currentTargetForm = null;

        function openModal(id) {
            document.getElementById(id).classList.add('active');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
        }

        function openEditModal(video) {
            document.getElementById('edit-id').value = video.id;
            document.getElementById('edit-title').value = video.title;
            document.getElementById('edit-link').value = video.link;
            openModal('modal-edit');
        }

        function confirmDelete(formId, message) {
            currentTargetForm = formId;
            document.getElementById('delete-message').innerText = message;
            openModal('modal-delete');
        }

        function executeDelete() {
            if (currentTargetForm) {
                document.getElementById(currentTargetForm).submit();
            }
        }

        function autoFormatYoutube(input) {
            let url = input.value.trim();
            if (!url) return;

            // If already embed, do nothing
            if (url.includes('youtube.com/embed/')) return;

            let videoId = '';
            const watchRegex = /[\\?&]v=([^&#?]+)/;
            const shortRegex = /youtu\.be\/([^&#?]+)/;
            const vRegex = /\/v\/([^&#?]+)/;

            let match = url.match(watchRegex);
            if (match) {
                videoId = match[1];
            } else {
                match = url.match(shortRegex);
                if (match) {
                    videoId = match[1];
                } else {
                    match = url.match(vRegex);
                    if (match) videoId = match[1];
                }
            }

            if (videoId) {
                input.value = `https://www.youtube.com/embed/${videoId}`;
            }
        }

        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('active');
            }
        }
    </script>
</body>

</html>