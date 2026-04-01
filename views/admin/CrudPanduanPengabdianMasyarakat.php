<!DOCTYPE html>
<html lang="id">

<head>
    <?php include __DIR__ . '/../../helpers/HeadConfig.php'; ?>
    <title>Kelola Panduan Pengabdian Masyarakat</title>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 font-display">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <?php include __DIR__ . "/../layouts/sidebarAdmin.php" ?>
        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-hidden pt-14 lg:pt-0">
            <div class="flex-1 overflow-y-auto p-4 md:p-8 bg-background-light dark:bg-background-dark custom-scrollbar">
                <header class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-xl md:text-3xl font-black tracking-tight mb-2">Kelola Panduan Pengabdian Masyarakat</h2>
                        <p class="text-slate-500">Tambah, edit, atau hapus panduan pengabdian masyarakat dalam sistem.</p>
                    </div>
                    <a href="/panduan-pengabdian-kepada-masyarakat" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 rounded-lg font-bold text-sm transition-all border border-slate-200 dark:border-slate-700">
                        <span class="material-symbols-outlined text-lg">visibility</span>
                        Lihat Halaman
                    </a>
                </header>

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

                <!-- Form Section -->
                <section class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-6 mb-8 shadow-sm">
                    <div class="flex items-center gap-2 mb-6 border-b border-slate-100 dark:border-slate-800 pb-4">
                        <span class="material-symbols-outlined text-primary">add_circle</span>
                        <h3 class="text-lg font-bold">Formulir Input Panduan</h3>
                    </div>
                    <form action="/admin/pengabdian/panduan/tambah" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col gap-2">
                            <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Nama File</label>
                            <input name="file_name" required class="w-full rounded-lg border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:border-primary focus:ring-primary h-12" placeholder="Contoh: Panduan Hibah 2026" type="text" />
                        </div>
                        <div class="flex flex-col gap-2">
                            <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Link Google Drive</label>
                            <input name="file_url" required class="w-full rounded-lg border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:border-primary focus:ring-primary h-12" placeholder="https://drive.google.com/..." type="url" />
                        </div>
                        <div class="flex flex-col gap-2 md:col-span-2">
                            <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Deskripsi File</label>
                            <textarea name="file_description" class="w-full rounded-lg border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:border-primary focus:ring-primary" placeholder="Masukkan deskripsi singkat tentang file ini..." rows="3"></textarea>
                        </div>
                        <div class="md:col-span-2 flex justify-end">
                            <button class="bg-primary hover:bg-primary/90 text-white font-bold py-3 px-8 rounded-lg transition-all flex items-center gap-2" type="submit">
                                <span class="material-symbols-outlined text-xl">save</span>
                                Simpan File
                            </button>
                        </div>
                    </form>
                </section>

                <!-- Table Section -->
                <section class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
                        <h3 class="text-lg font-bold">Daftar Panduan</h3>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
                            <input class="pl-9 pr-4 py-2 rounded-full border-slate-200 dark:border-slate-700 dark:bg-slate-800 text-sm focus:border-primary focus:ring-primary" placeholder="Cari file..." type="text" />
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 dark:bg-slate-800/50">
                                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider w-16">No</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Deskripsi</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800" id="file-table-body">
                                <?php if (empty($files)): ?>
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                            <span class="material-symbols-outlined text-4xl mb-2">folder_off</span>
                                            <p>Belum ada panduan yang ditemukan.</p>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($files as $index => $file): ?>
                                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                            <td class="px-6 py-4 text-sm font-medium text-slate-400"><?= $index + 1; ?></td>
                                            <td class="px-6 py-4 text-sm font-bold text-slate-900 dark:text-white"><?= htmlspecialchars($file['file_name']); ?></td>
                                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 max-w-xs truncate"><?= htmlspecialchars($file['file_description'] ?? '-'); ?></td>
                                            <td class="px-6 py-4 text-sm text-right">
                                                <div class="flex justify-end gap-1">
                                                    <a href="<?= htmlspecialchars($file['file_url']); ?>" target="_blank" class="p-2 text-primary hover:bg-orange-50 dark:hover:bg-orange-900/30 rounded-lg transition-colors" title="Buka Link">
                                                        <span class="material-symbols-outlined">open_in_new</span>
                                                    </a>
                                                    <button onclick="openEditModal(<?= htmlspecialchars(json_encode($file)); ?>)" class="p-2 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors" title="Edit">
                                                        <span class="material-symbols-outlined">edit</span>
                                                    </button>
                                                    <button onclick="confirmDelete(<?= $file['id']; ?>)" class="p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors" title="Hapus">
                                                        <span class="material-symbols-outlined">delete</span>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <!-- Edit Modal -->
    <div id="modal-edit" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="bg-white dark:bg-slate-900 w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
            <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <h3 class="text-lg font-bold">Edit Panduan</h3>
                <button onclick="closeModal('modal-edit')" class="text-slate-400 hover:text-slate-600 transition-colors"><span class="material-symbols-outlined">close</span></button>
            </div>
            <form action="/admin/pengabdian/panduan/edit" method="POST" class="p-6 space-y-4">
                <input type="hidden" name="id" id="edit-id">
                <div class="space-y-2">
                    <label class="text-sm font-semibold">Nama File</label>
                    <input name="file_name" id="edit-file_name" required class="w-full rounded-lg border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:border-primary focus:ring-primary h-12" type="text" />
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold">Link Google Drive</label>
                    <input name="file_url" id="edit-file_url" required class="w-full rounded-lg border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:border-primary focus:ring-primary h-12" type="url" />
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-semibold">Deskripsi File</label>
                    <textarea name="file_description" id="edit-file_description" class="w-full rounded-lg border-slate-200 dark:border-slate-700 dark:bg-slate-800 focus:border-primary focus:ring-primary" rows="3"></textarea>
                </div>
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="closeModal('modal-edit')" class="px-6 py-2.5 rounded-xl font-bold text-sm text-slate-500 hover:bg-slate-50 transition-colors">Batal</button>
                    <button type="submit" class="bg-primary hover:bg-orange-600 text-white px-8 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-primary/20 transition-all">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="modal-delete" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="bg-white dark:bg-slate-900 w-full max-w-sm rounded-2xl shadow-2xl overflow-hidden text-center p-8">
            <div class="size-20 bg-red-100 dark:bg-red-900/30 text-red-600 rounded-full flex items-center justify-center mx-auto mb-6">
                <span class="material-symbols-outlined text-4xl">delete_forever</span>
            </div>
            <h3 class="text-xl font-bold mb-2">Hapus File?</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm mb-8">Tindakan ini tidak dapat dibatalkan. File akan dihapus secara permanen dari sistem.</p>
            <form action="/admin/pengabdian/panduan/hapus" method="POST" class="flex flex-col gap-3">
                <input type="hidden" name="id" id="delete-id">
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-3 rounded-xl font-bold transition-all active:scale-95 shadow-lg shadow-red-200 dark:shadow-none">Ya, Hapus Sekarang</button>
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

        function openEditModal(file) {
            document.getElementById('edit-id').value = file.id;
            document.getElementById('edit-file_name').value = file.file_name;
            document.getElementById('edit-file_url').value = file.file_url;
            document.getElementById('edit-file_description').value = file.file_description || '';
            openModal('modal-edit');
        }

        function confirmDelete(id) {
            document.getElementById('delete-id').value = id;
            openModal('modal-delete');
        }

        // Simple Search
        document.querySelector('input[placeholder="Cari file..."]').addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('#file-table-body tr:not(:has(td[colspan]))');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(term) ? '' : 'none';
            });
        });

        // Close on outside click
        window.onclick = function(event) {
            if (event.target.classList.contains('bg-black/50')) {
                event.target.classList.add('hidden');
                event.target.classList.remove('flex');
                document.body.style.overflow = 'auto';
            }
        }
    </script>
</body>

</html>