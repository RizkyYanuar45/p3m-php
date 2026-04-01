<!DOCTYPE html>

<html lang="id">

<head>
    <?php include __DIR__ . '/../../helpers/HeadConfig.php'; ?>
    <title>Kelola Dokumen Penelitian</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
        }

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
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar Navigation -->
        <?php include __DIR__ . "/../layouts/sidebarAdmin.php" ?>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-hidden pt-14 lg:pt-0">
            <!-- Header/Content Area -->
            <div class="flex-1 overflow-y-auto p-4 md:p-8 bg-background-light dark:bg-background-dark custom-scrollbar">
                <div class="max-w-7xl mx-auto space-y-8">
                    <header class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl md:text-3xl font-black tracking-tight mb-2">Kelola Dokumen Penelitian</h2>
                            <p class="text-slate-500">Tambah, edit, atau hapus berkas dokumen penelitian dalam sistem.</p>
                        </div>
                        <a href="/dokumen-penelitian" target="_blank" class="inline-flex items-center gap-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 px-6 py-3 rounded-xl text-primary font-bold hover:bg-primary hover:text-white transition-all shadow-sm active:scale-95 text-sm w-fit">
                            <span class="material-symbols-outlined text-xl">visibility</span>
                            Lihat Halaman
                        </a>
                    </header>

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

                    <!-- First Row: Kelola Kategori -->
                    <section class="bg-white dark:bg-background-dark/50 rounded-2xl shadow-sm border border-primary/10 overflow-hidden">
                        <div class="p-6 border-b border-primary/5 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary">category</span>
                                <h3 class="text-lg font-bold">Kelola Kategori Dokumen Penelitian</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <form action="/admin/penelitian/dokumen/category/tambah" method="POST" class="flex flex-col md:flex-row gap-4 mb-8 bg-primary/5 p-4 rounded-xl border border-primary/10">
                                <div class="flex-1">
                                    <label class="block text-sm font-semibold mb-2 ml-1">Nama Kategori Baru</label>
                                    <input name="name" required class="w-full px-4 py-3 bg-white dark:bg-background-dark border border-primary/20 focus:border-primary focus:ring-1 focus:ring-primary rounded-xl text-sm transition-all" placeholder="Contoh: Dokumen Penelitian 2026" type="text" />
                                </div>
                                <div class="flex items-end">
                                    <button type="submit" class="bg-primary hover:bg-orange-600 text-white px-8 py-3 rounded-xl font-bold flex items-center gap-2 shadow-lg shadow-primary/20 transition-all active:scale-95">
                                        <span class="material-symbols-outlined">add</span>
                                        Tambah
                                    </button>
                                </div>
                            </form>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <?php foreach ($categories as $cat): ?>
                                    <div class="flex items-center justify-between p-4 bg-white dark:bg-slate-800 rounded-xl border border-slate-100 dark:border-slate-700 hover:shadow-md transition-all group">
                                        <div class="flex items-center gap-3">
                                            <span class="material-symbols-outlined text-primary/60">folder_open</span>
                                            <span class="font-medium text-sm"><?= htmlspecialchars($cat['name']); ?></span>
                                        </div>
                                        <div class="flex gap-1 opacity-10 md:opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button onclick="openEditCat(<?= $cat['id']; ?>, '<?= addslashes(htmlspecialchars($cat['name'])); ?>')" class="p-1.5 hover:bg-blue-50 text-blue-600 rounded-lg transition-colors"><span class="material-symbols-outlined text-sm">edit</span></button>
                                            <form id="form-del-cat-<?= $cat['id']; ?>" action="/admin/penelitian/dokumen/category/hapus" method="POST" class="inline">
                                                <input type="hidden" name="id" value="<?= $cat['id']; ?>">
                                                <button type="button" onclick="confirmDelete('form-del-cat-<?= $cat['id']; ?>', 'Hapus kategori ini? Dokumen di dalamnya mungkin akan kehilangan referensi.')" class="p-1.5 hover:bg-red-50 text-red-600 rounded-lg transition-colors"><span class="material-symbols-outlined text-sm">delete</span></button>
                                            </form>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Category Pagination -->
                            <?php if ($totalCatPages > 1): ?>
                                <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800 flex justify-center gap-2">
                                    <?php for ($i = 1; $i <= $totalCatPages; $i++): ?>
                                        <a href="?cat_page=<?= $i; ?>&doc_page=<?= $docPage; ?>"
                                            class="size-8 flex items-center justify-center rounded-lg text-xs font-bold transition-all <?= $i === $catPage ? 'bg-primary text-white shadow-lg shadow-orange-200' : 'bg-slate-50 dark:bg-slate-900 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800' ?>">
                                            <?= $i; ?>
                                        </a>
                                    <?php endfor; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </section>

                    <!-- Second Row: Daftar Dokumen -->
                    <section class="bg-white dark:bg-background-dark/50 rounded-2xl shadow-sm border border-primary/10 overflow-hidden">
                        <div class="p-6 border-b border-primary/5 flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary">description</span>
                                <h3 class="text-lg font-bold">Daftar Dokumen Penelitian</h3>
                            </div>
                            <div class="flex flex-wrap items-center gap-3">
                                <button onclick="openModal('modal-dokumen')" class="bg-primary hover:bg-orange-600 text-white px-6 py-2.5 rounded-xl font-bold flex items-center gap-2 shadow-lg shadow-primary/20 transition-all active:scale-95 text-sm">
                                    <span class="material-symbols-outlined text-lg">upload_file</span>
                                    Tambah Dokumen
                                </button>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="bg-primary/5 text-xs font-bold text-slate-500 uppercase tracking-widest border-b border-primary/10">
                                        <th class="px-6 py-4 w-16">No</th>
                                        <th class="px-6 py-4">Judul Dokumen</th>
                                        <th class="px-6 py-4">Kategori</th>
                                        <th class="px-6 py-4">Link/File</th>
                                        <th class="px-6 py-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-primary/5">
                                    <?php if (empty($documents)): ?>
                                        <tr>
                                            <td colspan="5" class="px-6 py-8 text-center text-slate-500 font-medium">Belum ada dokumen yang diunggah.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($documents as $i => $dok): ?>
                                            <tr class="hover:bg-primary/5 transition-colors group">
                                                <td class="px-6 py-4 text-sm font-medium"><?= ($docPage - 1) * 10 + $i + 1 ?></td>
                                                <td class="px-6 py-4">
                                                    <p class="font-bold text-slate-800 dark:text-slate-200"><?= htmlspecialchars($dok['file_name']); ?></p>
                                                    <p class="text-[10px] text-slate-500"><?= date('d M Y', strtotime($dok['createdAt'])); ?></p>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span class="px-3 py-1 bg-primary/10 text-primary text-[10px] font-bold rounded-full uppercase"><?= htmlspecialchars($dok['kategori']['name'] ?? 'Uncategorized'); ?></span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <a class="text-primary hover:underline flex items-center gap-1 text-sm font-medium" href="<?= htmlspecialchars($dok['file_url']); ?>" target="_blank">
                                                        <span class="material-symbols-outlined text-sm">link</span>
                                                        Buka File
                                                    </a>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="flex justify-center gap-2">
                                                        <button onclick="openEditDok(<?= htmlspecialchars(json_encode($dok)); ?>)" class="p-2 hover:bg-blue-50 text-blue-600 rounded-lg transition-colors" title="Edit"><span class="material-symbols-outlined">edit</span></button>
                                                        <form id="form-del-dok-<?= $dok['id']; ?>" action="/admin/penelitian/dokumen/hapus" method="POST" class="inline">
                                                            <input type="hidden" name="id" value="<?= $dok['id']; ?>">
                                                            <button type="button" onclick="confirmDelete('form-del-dok-<?= $dok['id']; ?>', 'Hapus dokumen ini?')" class="p-2 hover:bg-red-50 text-red-600 rounded-lg transition-colors" title="Hapus"><span class="material-symbols-outlined">delete</span></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Document Pagination -->
                        <?php if ($totalDocPages > 1): ?>
                            <div class="px-6 py-4 bg-slate-50/50 dark:bg-slate-900/50 border-t border-primary/5 flex items-center justify-between">
                                <p class="text-xs text-slate-500">
                                    Menampilkan <span class="font-bold"><?= count($documents); ?></span> dari <span class="font-medium"><?= $totalDocs; ?></span> dokumen
                                </p>
                                <div class="flex gap-1">
                                    <?php if ($docPage > 1): ?>
                                        <a href="?cat_page=<?= $catPage; ?>&doc_page=<?= $docPage - 1; ?>" class="px-3 py-1.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">Prev</a>
                                    <?php endif; ?>

                                    <?php for ($i = 1; $i <= $totalDocPages; $i++): ?>
                                        <a href="?cat_page=<?= $catPage; ?>&doc_page=<?= $i; ?>"
                                            class="size-8 flex items-center justify-center rounded-lg text-xs font-bold transition-all <?= $i === $docPage ? 'bg-primary text-white shadow-lg shadow-orange-200' : 'bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700' ?>">
                                            <?= $i; ?>
                                        </a>
                                    <?php endfor; ?>

                                    <?php if ($docPage < $totalDocPages): ?>
                                        <a href="?cat_page=<?= $catPage; ?>&doc_page=<?= $docPage + 1; ?>" class="px-3 py-1.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">Next</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </section>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Cat Edit -->
    <div id="modal-cat" class="modal px-4">
        <div class="bg-white dark:bg-background-dark w-full max-w-md rounded-2xl shadow-2xl overflow-hidden">
            <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <h3 class="text-lg font-bold">Edit Kategori</h3>
                <button onclick="closeModal('modal-cat')" class="text-slate-400 hover:text-slate-600"><span class="material-symbols-outlined">close</span></button>
            </div>
            <form action="/admin/penelitian/dokumen/category/edit" method="POST" class="p-6 space-y-4">
                <input type="hidden" name="id" id="edit-cat-id">
                <div>
                    <label class="block text-sm font-semibold mb-2">Nama Kategori</label>
                    <input name="name" id="edit-cat-name" required class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:ring-primary focus:border-primary" type="text" />
                </div>
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="closeModal('modal-cat')" class="px-6 py-2.5 rounded-xl font-bold text-sm text-slate-500">Batal</button>
                    <button type="submit" class="bg-primary text-white px-8 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-primary/20">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Dokumen Add/Edit -->
    <div id="modal-dokumen" class="modal px-4">
        <div class="bg-white dark:bg-background-dark w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden">
            <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <h3 class="text-lg font-bold" id="dokumen-modal-title">Tambah Dokumen Baru</h3>
                <button onclick="closeModal('modal-dokumen')" class="text-slate-400 hover:text-slate-600"><span class="material-symbols-outlined">close</span></button>
            </div>
            <form id="form-dokumen" action="/admin/penelitian/dokumen/tambah" method="POST" class="p-6 space-y-4">
                <input type="hidden" name="id" id="dok-id">
                <div>
                    <label class="block text-sm font-semibold mb-2">Judul Dokumen</label>
                    <input name="file_name" id="dok-name" required class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:ring-primary focus:border-primary" placeholder="Masukkan judul dokumen" type="text" />
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2">Link/URL File</label>
                    <input name="file_url" id="dok-url" required class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:ring-primary focus:border-primary" placeholder="https://..." type="url" />
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2">Kategori</label>
                    <select name="catdokumenpenId" id="dok-cat" required class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:ring-primary focus:border-primary">
                        <option value="">Pilih Kategori</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id']; ?>"><?= htmlspecialchars($cat['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="closeModal('modal-dokumen')" class="px-6 py-2.5 rounded-xl font-bold text-sm text-slate-500">Batal</button>
                    <button type="submit" id="dok-submit-btn" class="bg-primary text-white px-8 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-primary/20">Upload Dokumen</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Delete Confirmation -->
    <div id="modal-delete" class="modal px-4">
        <div class="bg-white dark:bg-background-dark w-full max-w-sm rounded-2xl shadow-2xl overflow-hidden text-center p-8">
            <div class="size-20 bg-red-100 dark:bg-red-900/30 text-red-600 rounded-full flex items-center justify-center mx-auto mb-6 scale-110">
                <span class="material-symbols-outlined text-4xl">delete_forever</span>
            </div>
            <h3 class="text-xl font-bold mb-2">Konfirmasi Hapus</h3>
            <p id="delete-message" class="text-slate-500 dark:text-slate-400 text-sm mb-8 leading-relaxed">Apakah Anda yakin ingin menghapus item ini? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex flex-col gap-3">
                <button id="btn-confirm-delete" onclick="executeDelete()" class="w-full bg-red-600 hover:bg-red-700 text-white py-3 rounded-xl font-bold shadow-lg shadow-red-200 dark:shadow-none transition-all active:scale-95">Ya, Hapus Sekarang</button>
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

        function openEditCat(id, name) {
            document.getElementById('edit-cat-id').value = id;
            document.getElementById('edit-cat-name').value = name;
            openModal('modal-cat');
        }

        function openEditDok(dok) {
            document.getElementById('dokumen-modal-title').innerText = 'Edit Dokumen';
            document.getElementById('form-dokumen').action = '/admin/penelitian/dokumen/edit';
            document.getElementById('dok-id').value = dok.id;
            document.getElementById('dok-name').value = dok.file_name;
            document.getElementById('dok-url').value = dok.file_url;
            document.getElementById('dok-cat').value = dok.catdokumenpenId;
            document.getElementById('dok-submit-btn').innerText = 'Simpan Perubahan';
            openModal('modal-dokumen');
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

        // Reset document modal for adding
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('active');
            }
        }
    </script>
</body>

</html>