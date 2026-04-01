<!DOCTYPE html>

<html lang="id">

<head>
    <?php include __DIR__ . '/../../helpers/HeadConfig.php'; ?>
    <title>Kelola Informasi Pengabdian Masyarakat</title>
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 overflow-hidden">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <?php include __DIR__ . '/../layouts/sidebarAdmin.php' ?>
        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-hidden pt-14 lg:pt-0">

            <!-- Content Area -->
            <div class="flex-1 overflow-y-auto p-4 md:p-8 custom-scrollbar">
                <!-- Top Actions -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                    <div class="flex flex-col md:flex-row md:items-center gap-4">
                        <div>
                            <h1 class="text-xl md:text-3xl font-black tracking-tight">Kelola Informasi Pengabdian Masyarakat</h1>
                            <p class="text-slate-500 dark:text-slate-400 mt-1">Daftar artikel pengabdian masyarakat yang telah diterbitkan.</p>
                        </div>
                        <a href="/informasi-pengabdian-kepada-masyarakat" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 rounded-lg font-bold text-sm transition-all border border-slate-200 dark:border-slate-700">
                            <span class="material-symbols-outlined text-lg">visibility</span>
                            Lihat Halaman
                        </a>
                    </div>
                    <button onclick="openModal('modal-add')" class="bg-primary hover:bg-orange-600 text-white font-bold py-2.5 px-6 rounded-lg flex items-center gap-2 transition-all shadow-md shadow-primary/20">
                        <span class="material-symbols-outlined">add</span>
                        Tambah Artikel Baru
                    </button>
                </div>

                <!-- Session Feedback -->
                <?php if (isset($_SESSION['flash_success'])): ?>
                    <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3 mb-6">
                        <span class="material-symbols-outlined">check_circle</span>
                        <span class="font-medium"><?= $_SESSION['flash_success'];
                                                    unset($_SESSION['flash_success']); ?></span>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['flash_error'])): ?>
                    <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-3 mb-6">
                        <span class="material-symbols-outlined">error</span>
                        <span class="font-medium"><?= $_SESSION['flash_error'];
                                                    unset($_SESSION['flash_error']); ?></span>
                    </div>
                <?php endif; ?>

                <!-- Table Container -->
                <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 uppercase text-[11px] font-bold tracking-wider">
                                    <th class="px-6 py-4">Thumbnail</th>
                                    <th class="px-6 py-4">Judul Artikel</th>
                                    <th class="px-6 py-4">Penulis</th>
                                    <th class="px-6 py-4">Tanggal</th>
                                    <th class="px-6 py-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800" id="article-table-body">
                                <?php if (empty($articles)): ?>
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                            <span class="material-symbols-outlined text-4xl mb-2">article</span>
                                            <p>Belum ada artikel informasi pengabdian masyarakat yang ditemukan.</p>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($articles as $article): ?>
                                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                            <td class="px-6 py-4">
                                                <?php if (!empty($article['thumbnail'])): ?>
                                                    <img src="<?= htmlspecialchars($article['thumbnail']); ?>" alt="Thumbnail" class="w-16 h-10 object-cover rounded shadow-sm border border-slate-200 dark:border-slate-700">
                                                <?php else: ?>
                                                    <div class="w-16 h-10 bg-slate-100 dark:bg-slate-800 rounded border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-400">
                                                        <span class="material-symbols-outlined text-sm">image</span>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-6 py-4 max-w-xs">
                                                <p class="font-semibold text-sm leading-tight line-clamp-2"><?= htmlspecialchars($article['title']); ?></p>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-6 h-6 rounded-full bg-primary/20 flex items-center justify-center text-[10px] font-bold text-primary">
                                                        <?= strtoupper(substr($article['author'] ?? 'A', 0, 1)); ?>
                                                    </div>
                                                    <span class="text-sm"><?= htmlspecialchars($article['author'] ?? 'Admin'); ?></span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-slate-500">
                                                <?= date('d M Y', strtotime($article['published_date'])); ?>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <div class="flex items-center justify-end gap-2 text-right">
                                                    <a href="/artikel/<?= htmlspecialchars($article['category']); ?>/<?= htmlspecialchars($article['slug']); ?>" target="_blank" class="p-1.5 text-slate-400 hover:text-primary transition-colors" title="Lihat">
                                                        <span class="material-symbols-outlined text-xl">visibility</span>
                                                    </a>
                                                    <button onclick='openEditModal(<?= json_encode($article, JSON_HEX_APOS | JSON_HEX_QUOT); ?>)' class="p-1.5 text-slate-400 hover:text-blue-500 transition-colors" title="Edit">
                                                        <span class="material-symbols-outlined text-xl">edit</span>
                                                    </button>
                                                    <button onclick="confirmDelete(<?= $article['id']; ?>)" class="p-1.5 text-slate-400 hover:text-red-500 transition-colors" title="Hapus">
                                                        <span class="material-symbols-outlined text-xl">delete</span>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/50 flex items-center justify-between border-t border-slate-100 dark:border-slate-800">
                        <p class="text-xs text-slate-500">Menampilkan <?= count($articles); ?> dari <?= $totalItems; ?> hasil</p>
                        <?php if ($totalPages > 1): ?>
                            <div class="flex items-center gap-1">
                                <?php if ($page > 1): ?>
                                    <a href="?page=<?= $page - 1; ?>" class="w-8 h-8 flex items-center justify-center rounded border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-400 transition-colors hover:border-primary">
                                        <span class="material-symbols-outlined text-lg">chevron_left</span>
                                    </a>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <a href="?page=<?= $i; ?>" class="w-8 h-8 flex items-center justify-center rounded border <?= $i === $page ? 'border-primary bg-primary text-white' : 'border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:border-primary' ?> text-xs font-bold transition-colors">
                                        <?= $i; ?>
                                    </a>
                                <?php endfor; ?>

                                <?php if ($page < $totalPages): ?>
                                    <a href="?page=<?= $page + 1; ?>" class="w-8 h-8 flex items-center justify-center rounded border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-400 transition-colors hover:border-primary">
                                        <span class="material-symbols-outlined text-lg">chevron_right</span>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Add Modal -->
    <div id="modal-add" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="bg-white dark:bg-slate-900 w-full max-w-2xl rounded-2xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
            <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <h3 class="text-xl font-bold">Tambah Informasi Pengabdian</h3>
                <button onclick="closeModal('modal-add')" class="text-slate-400 hover:text-slate-600 transition-colors"><span class="material-symbols-outlined">close</span></button>
            </div>
            <form action="/admin/pengabdian/informasi/tambah" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-sm font-semibold">Judul Artikel</label>
                        <input name="title" required class="w-full rounded-lg border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:border-primary focus:ring-primary h-11" type="text" placeholder="Masukkan judul..." />
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold">Penulis</label>
                        <input name="author" class="w-full rounded-lg border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:border-primary focus:ring-primary h-11" type="text" placeholder="Nama penulis..." />
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold">Thumbnail Artikel</label>
                        <input name="thumbnail" accept="image/*" class="w-full rounded-lg border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:border-primary focus:ring-primary h-11 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-primary/10 file:text-primary hover:file:bg-primary/20" type="file" />
                    </div>
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-sm font-semibold">Konten Artikel</label>
                        <textarea name="content" required class="w-full rounded-lg border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:border-primary focus:ring-primary p-3" rows="8" placeholder="Tuliskan konten di sini..."></textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <button type="button" onclick="closeModal('modal-add')" class="px-6 py-2.5 rounded-xl font-bold text-sm text-slate-500 hover:bg-slate-50 transition-colors">Batal</button>
                    <button type="submit" class="bg-primary hover:bg-orange-600 text-white px-8 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-primary/20 transition-all">Terbitkan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="modal-edit" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="bg-white dark:bg-slate-900 w-full max-w-2xl rounded-2xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
            <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <h3 class="text-xl font-bold">Edit Informasi Pengabdian</h3>
                <button onclick="closeModal('modal-edit')" class="text-slate-400 hover:text-slate-600 transition-colors"><span class="material-symbols-outlined">close</span></button>
            </div>
            <form action="/admin/pengabdian/informasi/edit" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                <input type="hidden" name="id" id="edit-id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-sm font-semibold">Judul Artikel</label>
                        <input name="title" id="edit-title" required class="w-full rounded-lg border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:border-primary focus:ring-primary h-11" type="text" />
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold">Penulis</label>
                        <input name="author" id="edit-author" class="w-full rounded-lg border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:border-primary focus:ring-primary h-11" type="text" />
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold">Thumbnail Baru (Opsional)</label>
                        <input name="thumbnail" accept="image/*" class="w-full rounded-lg border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:border-primary focus:ring-primary h-11 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-primary/10 file:text-primary hover:file:bg-primary/20" type="file" />
                    </div>
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-sm font-semibold">Konten Artikel</label>
                        <textarea name="content" id="edit-content" required class="w-full rounded-lg border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:border-primary focus:ring-primary p-3" rows="8"></textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                    <button type="button" onclick="closeModal('modal-edit')" class="px-6 py-2.5 rounded-xl font-bold text-sm text-slate-500 hover:bg-slate-50 transition-colors">Batal</button>
                    <button type="submit" class="bg-primary hover:bg-orange-600 text-white px-8 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-primary/20 transition-all">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="modal-delete" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="bg-white dark:bg-slate-900 w-full max-w-sm rounded-2xl shadow-2xl overflow-hidden p-8 text-center animate-in fade-in zoom-in duration-200">
            <div class="w-20 h-20 bg-red-100 dark:bg-red-900/30 text-red-600 rounded-full flex items-center justify-center mx-auto mb-6">
                <span class="material-symbols-outlined text-4xl">delete_forever</span>
            </div>
            <h3 class="text-xl font-bold mb-2">Hapus Informasi?</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm mb-8">Tindakan ini tidak dapat dibatalkan.</p>
            <form action="/admin/pengabdian/informasi/hapus" method="POST" class="flex flex-col gap-3">
                <input type="hidden" name="id" id="delete-id">
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-3 rounded-xl font-bold shadow-lg shadow-red-200 dark:shadow-none transition-all active:scale-95">Ya, Hapus Sekarang</button>
                <button type="button" onclick="closeModal('modal-delete')" class="w-full py-3 text-slate-500 font-bold hover:text-slate-700 transition-colors">Batal</button>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        function openEditModal(article) {
            document.getElementById('edit-id').value = article.id;
            document.getElementById('edit-title').value = article.title;
            document.getElementById('edit-author').value = article.author || '';
            document.getElementById('edit-content').value = article.content;

            openModal('modal-edit');
        }

        function confirmDelete(id) {
            document.getElementById('delete-id').value = id;
            openModal('modal-delete');
        }

        // Close on outside click
        window.onclick = function(event) {
            if (event.target.classList.contains('bg-black/50')) {
                const modals = ['modal-add', 'modal-edit', 'modal-delete'];
                modals.forEach(id => closeModal(id));
            }
        }
    </script>
</body>

</html>