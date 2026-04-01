<?php

require_once __DIR__ . '/../models/ArticleModel.php';

/**
 * ClientController
 *
 * Menggabungkan semua controller klien (halaman publik) menjadi satu file.
 */
class ClientController
{
    private ArticleModel $articleModel;

    public function __construct()
    {
        $this->articleModel = new ArticleModel();
    }
    // --- Home ---
    public function home(): void
    {
        require_once __DIR__ . '/../models/FileModel.php';
        $fileModel = new FileModel();

        $totalArticles = $this->articleModel->countAll();
        $totalFiles = $fileModel->countAll();

        // Fetch latest news
        $latestNews = $this->articleModel->findPaginated(1, 3);

        // Fetch articles by category for specific sections
        $kknArticles = $this->articleModel->findPaginatedByCategory('informasi_kkn', 1, 3);
        $pengabdianArticles = $this->articleModel->findPaginatedByCategory('informasi_pengabdian_masyarakat', 1, 3);
        $pengabdianMandiriArticles = $this->articleModel->findPaginatedByCategory('informasi_pengabdian_masyarakat_mandiri', 1, 3);
        $penelitianArticles = $this->articleModel->findPaginatedByCategory('informasi_penelitian', 1, 3);

        require_once __DIR__ . '/../views/index.php';
    }

    // --- Profil ---
    public function strukturOrganisasi(): void
    {
        require_once __DIR__ . '/../models/ProfileModel.php';
        $profileModel = new ProfileModel();
        $struktur = $profileModel->findOneByType('struktur_organisasi');
        require_once __DIR__ . '/../views/strukturOrganisasi.php';
    }

    public function dokumenP3M(): void
    {
        require_once __DIR__ . '/../models/CatDokumenProfModel.php';
        $catModel = new CatDokumenProfModel();
        $categories = $catModel->findAllWithDokumen();
        require_once __DIR__ . '/../views/dokumenP3M.php';
    }

    public function luaranP3M(): void
    {
        require_once __DIR__ . '/../models/YoutubeModel.php';
        $youtubeModel = new YoutubeModel();

        $page = (int) ($_GET['page'] ?? 1);
        $limit = 9;
        $videos = $youtubeModel->findPaginated($page, $limit);
        $totalVideos = $youtubeModel->countAll();
        $totalPages = ceil($totalVideos / $limit);

        require_once __DIR__ . '/../views/luaranP3M.php';
    }

    // --- Penelitian ---
    public function panduanPenelitian(): void
    {
        require_once __DIR__ . '/../models/FileModel.php';
        $fileModel = new FileModel();

        $page = (int) ($_GET['page'] ?? 1);
        $limit = 10;
        $type = 'panduan_penelitian';

        $files = $fileModel->findPaginatedByType($type, $page, $limit);
        $totalFiles = $fileModel->countByType($type);
        $totalPages = ceil($totalFiles / $limit);

        require_once __DIR__ . '/../views/panduanPenelitianP3M.php';
    }

    public function informasiPenelitian(): void
    {
        $page = (int) ($_GET['page'] ?? 1);
        $limit = 9;
        $category = 'informasi_penelitian';
        
        $articles = $this->articleModel->findPaginatedByCategory($category, $page, $limit);
        $totalArticles = $this->articleModel->countByCategory($category);
        $totalPages = ceil($totalArticles / $limit);
        
        require_once __DIR__ . '/../views/informasiPenelitian.php';
    }

    public function dokumenPenelitian(): void
    {
        require_once __DIR__ . '/../models/CatDokumenPenModel.php';
        $catModel = new CatDokumenPenModel();
        $categories = $catModel->findAllWithDokumen();
        require_once __DIR__ . '/../views/dokumenPenelitian.php';
    }

    public function skRektorPenelitian(): void
    {
        require_once __DIR__ . '/../models/FileModel.php';
        $fileModel = new FileModel();

        $page = (int) ($_GET['page'] ?? 1);
        $limit = 10;
        $type = 'sk_rektor_penelitian';

        $files = $fileModel->findPaginatedByType($type, $page, $limit);
        $totalFiles = $fileModel->countByType($type);
        $totalPages = ceil($totalFiles / $limit);

        require_once __DIR__ . '/../views/SKRektorPenelitian.php';
    }

    // --- Pengabdian Kepada Masyarakat ---
    public function informasiPengabdian(): void
    {
        $page = (int) ($_GET['page'] ?? 1);
        $limit = 9;
        $category = 'informasi_pengabdian_masyarakat';

        $articles = $this->articleModel->findPaginatedByCategory($category, $page, $limit);
        $totalArticles = $this->articleModel->countByCategory($category);
        $totalPages = ceil($totalArticles / $limit);

        require_once __DIR__ . '/../views/informasiPengabdianKepadaMasyarakat.php';
    }

    public function informasiPengabdianMandiri(): void
    {
        $page = (int) ($_GET['page'] ?? 1);
        $limit = 9;
        $category = 'informasi_pengabdian_masyarakat_mandiri';

        $articles = $this->articleModel->findPaginatedByCategory($category, $page, $limit);
        $totalArticles = $this->articleModel->countByCategory($category);
        $totalPages = ceil($totalArticles / $limit);

        require_once __DIR__ . '/../views/informasiPengabdianKepadaMasyarakatMandiri.php';
    }

    public function pengabdianMandiri(): void
    {
        require_once __DIR__ . '/../models/FileModel.php';
        $fileModel = new FileModel();

        $page = (int) ($_GET['page'] ?? 1);
        $limit = 10;
        $type = 'dokumen_pengabdian_masyarakat_mandiri';

        $files = $fileModel->findPaginatedByType($type, $page, $limit);
        $totalFiles = $fileModel->countByType($type);
        $totalPages = ceil($totalFiles / $limit);

        require_once __DIR__ . '/../views/pengabdianKepadaMasyarakatMandiri.php';
    }

    public function panduanPengabdian(): void
    {
        require_once __DIR__ . '/../models/FileModel.php';
        $fileModel = new FileModel();

        $page = (int) ($_GET['page'] ?? 1);
        $limit = 10;
        $type = 'panduan_pengabdian_masyarakat';

        $files = $fileModel->findPaginatedByType($type, $page, $limit);
        $totalFiles = $fileModel->countByType($type);
        $totalPages = ceil($totalFiles / $limit);

        require_once __DIR__ . '/../views/panduanPengabdianKepadaMasyarakat.php';
    }

    public function dokumenPengabdian(): void
    {
        require_once __DIR__ . '/../models/CatDokumenPengabModel.php';
        $catModel = new CatDokumenPengabModel();
        $categories = $catModel->findAllWithDokumen();
        require_once __DIR__ . '/../views/dokumenPengabdianKepadaMasyarakat.php';
    }

    public function skPengabdian(): void
    {
        require_once __DIR__ . '/../models/FileModel.php';
        $fileModel = new FileModel();

        $page = (int) ($_GET['page'] ?? 1);
        $limit = 10;
        $type = 'sk_rektor_pengabdian_masyarakat';

        $files = $fileModel->findPaginatedByType($type, $page, $limit);
        $totalFiles = $fileModel->countByType($type);
        $totalPages = ceil($totalFiles / $limit);

        require_once __DIR__ . '/../views/skPengabdianKepadaMasyarakat.php';
    }

    // --- KKN ---
    public function informasiKKNUnim(): void
    {
        $page = (int) ($_GET['page'] ?? 1);
        $limit = 9;
        $category = 'informasi_kkn';

        $articles = $this->articleModel->findPaginatedByCategory($category, $page, $limit);
        $totalArticles = $this->articleModel->countByCategory($category);
        $totalPages = ceil($totalArticles / $limit);

        require_once __DIR__ . '/../views/informasiKKNUnim.php';
    }

    public function bukuPanduanKKNTematik(): void
    {
        require_once __DIR__ . '/../models/FileModel.php';
        $fileModel = new FileModel();

        $page = (int) ($_GET['page'] ?? 1);
        $limit = 10;
        $type = 'panduan_kkn_tematik';

        $files = $fileModel->findPaginatedByType($type, $page, $limit);
        $totalFiles = $fileModel->countByType($type);
        $totalPages = ceil($totalFiles / $limit);

        require_once __DIR__ . '/../views/bukuPanduanKKNTematik.php';
    }

    public function bukuPanduanKKNBEM(): void
    {
        require_once __DIR__ . '/../models/FileModel.php';
        $fileModel = new FileModel();

        $page = (int) ($_GET['page'] ?? 1);
        $limit = 10;
        $type = 'panduan_kkn_pkn_bem';

        $files = $fileModel->findPaginatedByType($type, $page, $limit);
        $totalFiles = $fileModel->countByType($type);
        $totalPages = ceil($totalFiles / $limit);

        require_once __DIR__ . '/../views/bukuPanduanKKNBEM.php';
    }

    public function bukuPanduanKKNPMM(): void
    {
        require_once __DIR__ . '/../models/FileModel.php';
        $fileModel = new FileModel();

        $page = (int) ($_GET['page'] ?? 1);
        $limit = 10;
        $type = 'panduan_kkn_pmm';

        $files = $fileModel->findPaginatedByType($type, $page, $limit);
        $totalFiles = $fileModel->countByType($type);
        $totalPages = ceil($totalFiles / $limit);

        require_once __DIR__ . '/../views/bukuPanduanKKNPMM.php';
    }

    // --- Layanan ---
    public function panduanLayananHKI(): void
    {
        require_once __DIR__ . '/../models/FileModel.php';
        $fileModel = new FileModel();

        $page = (int) ($_GET['page'] ?? 1);
        $limit = 10;
        $type = 'panduan_layanan_hki';

        $files = $fileModel->findPaginatedByType($type, $page, $limit);
        $totalFiles = $fileModel->countByType($type);
        $totalPages = ceil($totalFiles / $limit);

        require_once __DIR__ . '/../views/panduanLayananHKI.php';
    }

    public function hasilPencarian(): void
    {
        $query = $_GET['q'] ?? '';
        $category = $_GET['cat'] ?? 'semua';
        $page = (int) ($_GET['page'] ?? 1);
        $limit = 12; // Menampilkan 12 item agar pas dengan grid 4 kolom

        $results = $this->articleModel->findPaginatedFiltered($query, $category, $page, $limit);
        $totalResults = $this->articleModel->countFiltered($query, $category);
        $totalPages = ceil($totalResults / $limit);

        require_once __DIR__ . '/../views/hasilPencarian.php';
    }

    public function contactUs(): void
    {
        require_once __DIR__ . '/../views/contactUs.php';
    }
    public function artikel(?string $slug = null, ?string $category = null): void
    {
        if (!$slug) {
            header('Location: /informasi-penelitian');
            exit;
        }

        $article = $this->articleModel->findBySlug($slug);

        if (!$article) {
            http_response_code(404);
            require_once __DIR__ . '/../views/errors/404.php';
            exit;
        }

        // Canonical Redirect: If category in URL is wrong, redirect to correct one
        $correctCategory = $article['category'];
        if ($category && $category !== $correctCategory) {
            header("Location: /artikel/{$correctCategory}/{$slug}");
            exit;
        }

        // Fetch related articles (same category, excluding current)
        $relatedArticles = $this->articleModel->findRelatedArticles($correctCategory, (int)$article['id'], 3);

        require_once __DIR__ . '/../views/Artikel.php';
    }
}
