<!DOCTYPE html>

<html lang="id">

<head>
    <?php include __DIR__ . '/../../helpers/HeadConfig.php'; ?>
    <title>Kelola Struktur Organisasi - P3M UNIM</title>
</head>

<body class="bg-gray-50 text-gray-800 font-sans antialiased">
    <!-- BEGIN: Layout Wrapper -->
    <div class="flex h-screen overflow-hidden">
        <!-- BEGIN: Sidebar -->
        <?php include __DIR__ . '/../layouts/sidebarAdmin.php'; ?>
        <!-- END: Sidebar -->
        <!-- BEGIN: Main Content Container -->
        <main class="flex-1 flex flex-col overflow-hidden pt-14 lg:pt-0">

            <!-- BEGIN: Content Area -->
            <section class="flex-1 overflow-y-auto p-4 md:p-8 bg-gray-50 custom-scrollbar">
                <div class="max-w-5xl mx-auto space-y-6">
                    <!-- Session Feedback -->
                    <?php if (isset($_SESSION['flash_success'])): ?>
                        <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
                            <i class="fas fa-check-circle"></i>
                            <span class="font-medium"><?= $_SESSION['flash_success'];
                                                        unset($_SESSION['flash_success']); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['flash_error'])): ?>
                        <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-3">
                            <i class="fas fa-exclamation-circle"></i>
                            <span class="font-medium"><?= $_SESSION['flash_error'];
                                                        unset($_SESSION['flash_error']); ?></span>
                        </div>
                    <?php endif; ?>

                    <!-- Page Title & Breadcrumbs -->
                    <div class="mb-4">
                        <nav aria-label="Breadcrumb" class="flex text-xs text-gray-500 mb-2">
                            <ol class="flex items-center space-x-2">
                                <li><a class="hover:text-primary" href="/admin/dashboard">Dashboard</a></li>
                                <li><i class="fas fa-chevron-right text-[10px]"></i></li>
                                <li><a class="hover:text-primary" href="#">Profil</a></li>
                                <li><i class="fas fa-chevron-right text-[10px]"></i></li>
                                <li class="text-gray-900 font-medium">Struktur Organisasi</li>
                            </ol>
                        </nav>
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div>
                                <h1 class="text-xl md:text-3xl font-bold text-gray-900" data-purpose="page-title">Kelola Struktur Organisasi</h1>
                                <p class="text-gray-600 mt-2">Halaman ini digunakan untuk mengunggah dan mengelola gambar struktur organisasi P3M UNIM.</p>
                            </div>
                            <a href="/struktur-organisasi" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-gray-100 text-gray-700 rounded-lg font-bold text-sm transition-all border border-gray-200 shadow-sm">
                                <span class="material-symbols-outlined text-lg">visibility</span>
                                Lihat Halaman
                            </a>
                        </div>
                    </div>
                    <!-- BEGIN: Main Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <!-- Information Alert -->
                        <div class="p-4 bg-orange-50 border-b border-orange-100 flex items-start gap-3">
                            <i class="fas fa-info-circle text-primary mt-1"></i>
                            <div class="text-sm text-orange-800">
                                <span class="font-bold uppercase tracking-wide">Pemberitahuan:</span>
                                Sistem hanya mengizinkan satu gambar struktur organisasi yang aktif dalam satu waktu. Mengunggah gambar baru akan <span class="font-bold underline">menggantikan secara permanen</span> gambar yang saat ini tersimpan.
                            </div>
                        </div>
                        <!-- Content Body -->
                        <div class="p-4 md:p-8">
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                                <!-- BEGIN: Image Preview Column -->
                                <div class="lg:col-span-2 space-y-4">
                                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Preview Gambar Aktif</h3>
                                    <div class="relative group aspect-[4/3] w-full bg-gray-100 rounded-xl border-2 border-dashed border-gray-200 overflow-hidden flex items-center justify-center">
                                        <!-- Current Image -->
                                        <?php if ($struktur && $struktur['image']): ?>
                                            <img alt="Struktur Organisasi P3M" class="object-contain w-full h-full p-4 transition-transform duration-500 group-hover:scale-105" id="structure-preview" src="<?= htmlspecialchars($struktur['image']); ?>" />
                                        <?php else: ?>
                                            <div class="absolute inset-0 flex flex-col items-center justify-center bg-gray-50 p-6 text-center" id="empty-state">
                                                <i class="fas fa-image text-gray-300 text-6xl mb-4"></i>
                                                <p class="text-gray-500">Belum ada gambar yang diunggah</p>
                                            </div>
                                            <img class="hidden object-contain w-full h-full p-4" id="structure-preview" />
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <!-- END: Image Preview Column -->
                                <!-- BEGIN: Controls Column -->
                                <div class="space-y-6">
                                    <form action="/admin/profile/struktur-organisasi/update" method="POST" enctype="multipart/form-data">
                                        <div>
                                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Aksi Pengelolaan</h3>
                                            <div class="p-5 rounded-xl border border-gray-200 bg-gray-50 space-y-5">
                                                <div class="space-y-2">
                                                    <label class="block text-sm font-medium text-gray-700">Ganti Struktur Organisasi</label>
                                                    <p class="text-xs text-gray-500">Format yang didukung: JPG, PNG atau SVG. Maksimal 2MB.</p>
                                                </div>
                                                <!-- Hidden File Input -->
                                                <input name="image" accept="image/*" class="hidden" id="image-upload" type="file" onchange="handleFileSelect(event)" />
                                                <!-- Replace Button Trigger -->
                                                <button type="button" class="w-full bg-primary hover:bg-secondary text-white font-bold py-3 px-6 rounded-lg transition-all flex items-center justify-center gap-2 shadow-lg shadow-orange-200 active:transform active:scale-95" onclick="document.getElementById('image-upload').click()">
                                                    <i class="fas fa-upload"></i>
                                                    <span>Pilih Gambar</span>
                                                </button>

                                                <!-- Save Button (Hidden initially) -->
                                                <button type="submit" id="btn-save" class="hidden w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition-all flex items-center justify-center gap-2 shadow-lg shadow-green-200 active:transform active:scale-95">
                                                    <i class="fas fa-save"></i>
                                                    <span>Simpan Perubahan</span>
                                                </button>

                                                <div class="pt-4 border-t border-gray-200">
                                                    <div class="flex items-center justify-between text-xs text-gray-500 mb-1">
                                                        <span>Terakhir diperbarui:</span>
                                                        <span class="font-medium text-gray-700"><?= $struktur ? date('d M Y', strtotime($struktur['updatedAt'])) : '-' ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- Instructions List -->
                                    <div class="space-y-3">
                                        <h4 class="text-xs font-bold text-gray-400 uppercase">Petunjuk Teknis:</h4>
                                        <ul class="text-sm text-gray-600 space-y-2">
                                            <li class="flex gap-2">
                                                <span class="text-primary">•</span>
                                                <span>Gunakan gambar dengan rasio aspek landscape agar terlihat optimal pada website.</span>
                                            </li>
                                            <li class="flex gap-2">
                                                <span class="text-primary">•</span>
                                                <span>Pastikan teks pada gambar dapat terbaca dengan jelas oleh pengunjung.</span>
                                            </li>
                                            <li class="flex gap-2">
                                                <span class="text-primary">•</span>
                                                <span>Klik 'Simpan Perubahan' setelah memilih file untuk memperbarui gambar.</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- END: Controls Column -->
                            </div>
                        </div>
                    </div>
                    <!-- END: Main Card -->
                    <!-- Footer Copy -->
                    <footer class="mt-12 py-6 border-t border-gray-200 text-center text-gray-400 text-xs">
                        © <?= date('Y') ?> P3M UNIM - Universitas Islam Majapahit. Seluruh hak cipta dilindungi.
                    </footer>
                </div>
            </section>
            <!-- END: Content Area -->
        </main>
        <!-- END: Main Content Container -->
    </div>
    <!-- END: Layout Wrapper -->
    <script>
        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            const icon = document.getElementById('icon-' + id.split('-')[1]);
            const isHidden = dropdown.classList.contains('hidden');
            if (isHidden) {
                dropdown.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                dropdown.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }

        function handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('structure-preview');
                    const emptyState = document.getElementById('empty-state');

                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (emptyState) emptyState.classList.add('hidden');

                    document.getElementById('btn-save').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>

</html>