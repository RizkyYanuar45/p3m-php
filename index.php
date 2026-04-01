<?php

/**
 * P3M UNIM — PHP Native Backend
 * Main Entry Point & Router
 * 
 * All requests are routed through this file via .htaccess
 */

// ============ SESSION ============
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_samesite', 'Lax');
ini_set('session.gc_maxlifetime', 36000);
session_start();

// ============ CONFIG ============
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/helpers/Response.php';

// ============ CORS ============
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
if (in_array($origin, ALLOWED_ORIGINS)) {
    header("Access-Control-Allow-Origin: $origin");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Methods: GET, POST, PATCH, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
}

// Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// ============ ROUTING ============
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
$baseDir    = dirname($scriptName);

// Automatically remove the base directory from the request URI if app is hosted in a subfolder 
// (common in shared hosting / cPanel environments like Rumahweb)
if ($baseDir !== '/' && $baseDir !== '\\') {
    if (strpos($requestUri, $baseDir) === 0) {
        $requestUri = substr($requestUri, strlen($baseDir));
    }
}

$path = parse_url($requestUri, PHP_URL_PATH) ?? '/';
$method = $_SERVER['REQUEST_METHOD'];

// Remove trailing slash (except root)
if ($path !== '/' && str_ends_with($path, '/')) {
    $path = rtrim($path, '/');
}

// Set JSON content type ONLY for API responses
if (str_starts_with($path, '/api')) {
    header('Content-Type: application/json; charset=utf-8');
} else {
    header('Content-Type: text/html; charset=utf-8');
}

// ============ CONTROLLER AUTOLOADER ============
function loadController(string $name): object
{
    $file = __DIR__ . "/controllers/{$name}.php";
    if (!file_exists($file)) {
        $file = __DIR__ . "/controllers/Admin/{$name}.php";
    }
    require_once $file;
    return new $name();
}

// ============ ROUTE MATCHING ============
// Helper: extract ID from URL like /api/resource/{id}
function getIdFromPath(string $path, int $segmentIndex): ?int
{
    $segments = explode('/', trim($path, '/'));
    if (isset($segments[$segmentIndex]) && is_numeric($segments[$segmentIndex])) {
        return (int) $segments[$segmentIndex];
    }
    return null;
}

function getSegment(string $path, int $index): ?string
{
    $segments = explode('/', trim($path, '/'));
    return $segments[$index] ?? null;
}

// ============ ROUTES ============ 
try {
    // === ROUTE HALAMAN === 

    if ($path === '/' && $method === 'GET') {
        $c = loadController('ClientController');
        $c->home();
    } elseif ($path === '/struktur-organisasi' && $method === 'GET') {
        $c = loadController('ClientController');
        $c->strukturOrganisasi();
    } elseif ($path === '/dokumen-p3m' && $method === 'GET') {
        $c = loadController('ClientController');
        $c->dokumenP3M();
    } elseif ($path === '/luaran-p3m' && $method === 'GET') {
        $c = loadController('ClientController');
        $c->luaranP3M();
    } elseif ($path === '/contact-us' && $method === 'GET') {
        $c = loadController('ClientController');
        $c->contactUs();
    } elseif ($path === '/panduan-penelitian-p3m' && $method === 'GET') {
        $c = loadController('ClientController');
        $c->panduanPenelitian();
    } elseif ($path === '/sk-rektor-penelitian' && $method === 'GET') {
        $c = loadController('ClientController');
        $c->skRektorPenelitian();
    } elseif ($path === '/dokumen-penelitian' && $method === 'GET') {
        $c = loadController('ClientController');
        $c->dokumenPenelitian();
    } elseif ($path === '/informasi_penelitian' && $method === 'GET') {
        $c = loadController('ClientController');
        $c->informasiPenelitian();
    } elseif ($path === '/pengabdian-kepada-masyarakat-mandiri' && $method === 'GET') {
        $c = loadController('ClientController');
        $c->pengabdianMandiri();
    } elseif ($path === '/informasi-pengabdian-kepada-masyarakat-mandiri' && $method === 'GET') {
        $c = loadController('ClientController');
        $c->informasiPengabdianMandiri();
    } elseif ($path === '/panduan-pengabdian-kepada-masyarakat' && $method === 'GET') {
        $c = loadController('ClientController');
        $c->panduanPengabdian();
    } elseif ($path === '/informasi-pengabdian-kepada-masyarakat' && $method === 'GET') {
        $c = loadController('ClientController');
        $c->informasiPengabdian();
    } elseif ($path === '/sk-pengabdian-kepada-masyarakat' && $method === 'GET') {
        $c = loadController('ClientController');
        $c->skPengabdian();
    } elseif ($path === '/dokumen-pengabdian-kepada-masyarakat' && $method === 'GET') {
        $c = loadController('ClientController');
        $c->dokumenPengabdian();
    } elseif ($path === '/informasi-kkn-unim' && $method === 'GET') {
        $c = loadController('ClientController');
        $c->informasiKKNUnim();
    } elseif ($path === '/buku-panduan-kkn-pmm' && $method === 'GET') {
        $c = loadController('ClientController');
        $c->bukuPanduanKKNPMM();
    } elseif ($path === '/buku-panduan-kkn-bem' && $method === 'GET') {
        $c = loadController('ClientController');
        $c->bukuPanduanKKNBEM();
    } elseif ($path === '/buku-panduan-kkn-tematik' && $method === 'GET') {
        $c = loadController('ClientController');
        $c->bukuPanduanKKNTematik();
    } elseif ($path === '/panduan-layanan-hki' && $method === 'GET') {
        $c = loadController('ClientController');
        $c->panduanLayananHKI();
    } elseif ($path === '/hasil-pencarian' && $method === 'GET') {
        $c = loadController('ClientController');
        $c->hasilPencarian();
    } elseif (strpos($path, '/artikel/') === 0 && $method === 'GET') {
        $segments = explode('/', trim($path, '/'));
        $c = loadController('ClientController');
        if (count($segments) >= 3) {
            // format: /artikel/{category}/{slug}
            $category = $segments[1];
            $slug = $segments[2];
            $c->artikel($slug, $category);
        } else {
            // format: /artikel/{slug}
            $slug = $segments[1] ?? null;
            $c->artikel($slug);
        }
    } elseif ($path === '/artikel' && $method === 'GET') {
        $c = loadController('ClientController');
        $c->artikel();
    } elseif ($path === '/admin/login') {
        $c = loadController('AuthController');
        $c->login();
    } elseif ($path === '/admin/dashboard' && $method === 'GET') {
        $c = loadController('AdminController');
        $c->dashboard();
    } elseif ($path === '/admin/profile/dokumen-p3m' && $method === 'GET') {
        $c = loadController('DokumenP3MController');
        $c->index();
    } elseif ($path === '/admin/profile/dokumen-p3m/category/tambah' && $method === 'POST') {
        $c = loadController('DokumenP3MController');
        $c->storeCategory();
    } elseif ($path === '/admin/profile/dokumen-p3m/category/edit' && $method === 'POST') {
        $c = loadController('DokumenP3MController');
        $c->updateCategory();
    } elseif ($path === '/admin/profile/dokumen-p3m/category/hapus' && $method === 'POST') {
        $c = loadController('DokumenP3MController');
        $c->destroyCategory();
    } elseif ($path === '/admin/profile/dokumen-p3m/dokumen/tambah' && $method === 'POST') {
        $c = loadController('DokumenP3MController');
        $c->storeDocument();
    } elseif ($path === '/admin/profile/dokumen-p3m/dokumen/edit' && $method === 'POST') {
        $c = loadController('DokumenP3MController');
        $c->updateDocument();
    } elseif ($path === '/admin/profile/dokumen-p3m/dokumen/hapus' && $method === 'POST') {
        $c = loadController('DokumenP3MController');
        $c->destroyDocument();
    } elseif ($path === '/admin/logout' && $method === 'GET') {
        $c = loadController('AuthController');
        $c->logout();
    } elseif ($path === '/admin/profile/struktur-organisasi' && $method === 'GET') {
        $c = loadController('StrukturOrganisasiController');
        $c->index();
    } elseif ($path === '/admin/profile/struktur-organisasi/update' && $method === 'POST') {
        $c = loadController('StrukturOrganisasiController');
        $c->update();
    } elseif ($path === '/admin/profile/luaran-p3m' && $method === 'GET') {
        $c = loadController('LuaranP3MController');
        $c->index();
    } elseif ($path === '/admin/profile/luaran-p3m/tambah' && $method === 'POST') {
        $c = loadController('LuaranP3MController');
        $c->store();
    } elseif ($path === '/admin/profile/luaran-p3m/edit' && $method === 'POST') {
        $c = loadController('LuaranP3MController');
        $c->update();
    } elseif ($path === '/admin/profile/luaran-p3m/hapus' && $method === 'POST') {
        $c = loadController('LuaranP3MController');
        $c->destroy();
    } elseif ($path === '/admin/penelitian/panduan' && $method === 'GET') {
        $c = loadController('PanduanPenelitianController');
        $c->index();
    } elseif ($path === '/admin/penelitian/panduan/tambah' && $method === 'POST') {
        $c = loadController('PanduanPenelitianController');
        $c->store();
    } elseif ($path === '/admin/penelitian/panduan/edit' && $method === 'POST') {
        $c = loadController('PanduanPenelitianController');
        $c->update();
    } elseif ($path === '/admin/penelitian/panduan/hapus' && $method === 'POST') {
        $c = loadController('PanduanPenelitianController');
        $c->destroy();
    } elseif ($path === '/admin/penelitian/informasi' && $method === 'GET') {
        $c = loadController('InformasiPenelitianController');
        $c->index();
    } elseif ($path === '/admin/penelitian/informasi/tambah' && $method === 'POST') {
        $c = loadController('InformasiPenelitianController');
        $c->store();
    } elseif ($path === '/admin/penelitian/informasi/edit' && $method === 'POST') {
        $c = loadController('InformasiPenelitianController');
        $c->update();
    } elseif ($path === '/admin/penelitian/informasi/hapus' && $method === 'POST') {
        $c = loadController('InformasiPenelitianController');
        $c->destroy();
    } elseif ($path === '/admin/kkn/informasi' && $method === 'GET') {
        $c = loadController('InformasiKKNController');
        $c->index();
    } elseif ($path === '/admin/kkn/informasi/tambah' && $method === 'POST') {
        $c = loadController('InformasiKKNController');
        $c->store();
    } elseif ($path === '/admin/kkn/informasi/edit' && $method === 'POST') {
        $c = loadController('InformasiKKNController');
        $c->update();
    } elseif ($path === '/admin/kkn/informasi/hapus' && $method === 'POST') {
        $c = loadController('InformasiKKNController');
        $c->destroy();
    } elseif ($path === '/admin/pengabdian/informasi' && $method === 'GET') {
        $c = loadController('InformasiPengabdianMasyarakatController');
        $c->index();
    } elseif ($path === '/admin/pengabdian/informasi/tambah' && $method === 'POST') {
        $c = loadController('InformasiPengabdianMasyarakatController');
        $c->store();
    } elseif ($path === '/admin/pengabdian/informasi/edit' && $method === 'POST') {
        $c = loadController('InformasiPengabdianMasyarakatController');
        $c->update();
    } elseif ($path === '/admin/pengabdian/informasi/hapus' && $method === 'POST') {
        $c = loadController('InformasiPengabdianMasyarakatController');
        $c->destroy();
    } elseif ($path === '/admin/pengabdian/informasi-mandiri' && $method === 'GET') {
        $c = loadController('InformasiPengabdianMasyarakatMandiriController');
        $c->index();
    } elseif ($path === '/admin/pengabdian/informasi-mandiri/tambah' && $method === 'POST') {
        $c = loadController('InformasiPengabdianMasyarakatMandiriController');
        $c->store();
    } elseif ($path === '/admin/pengabdian/informasi-mandiri/edit' && $method === 'POST') {
        $c = loadController('InformasiPengabdianMasyarakatMandiriController');
        $c->update();
    } elseif ($path === '/admin/pengabdian/informasi-mandiri/hapus' && $method === 'POST') {
        $c = loadController('InformasiPengabdianMasyarakatMandiriController');
        $c->destroy();
    } elseif ($path === '/admin/panduan-layanan-hki' && $method === 'GET') {
        $c = loadController('PanduanLayananHKIController');
        $c->index();
    } elseif ($path === '/admin/panduan-layanan-hki/tambah' && $method === 'POST') {
        $c = loadController('PanduanLayananHKIController');
        $c->store();
    } elseif ($path === '/admin/panduan-layanan-hki/edit' && $method === 'POST') {
        $c = loadController('PanduanLayananHKIController');
        $c->update();
    } elseif ($path === '/admin/panduan-layanan-hki/hapus' && $method === 'POST') {
        $c = loadController('PanduanLayananHKIController');
        $c->destroy();
    }


    // --- NEW FILE CRUDS ---
    // SK Rektor Penelitian
    elseif ($path === '/admin/penelitian/sk-rektor' && $method === 'GET') {
        $c = loadController('SKRektorPenelitianController');
        $c->index();
    } elseif ($path === '/admin/penelitian/sk-rektor/tambah' && $method === 'POST') {
        $c = loadController('SKRektorPenelitianController');
        $c->store();
    } elseif ($path === '/admin/penelitian/sk-rektor/edit' && $method === 'POST') {
        $c = loadController('SKRektorPenelitianController');
        $c->update();
    } elseif ($path === '/admin/penelitian/sk-rektor/hapus' && $method === 'POST') {
        $c = loadController('SKRektorPenelitianController');
        $c->destroy();
    }
    // Dokumen Penelitian
    elseif ($path === '/admin/penelitian/dokumen' && $method === 'GET') {
        $c = loadController('DokumenPenelitianController');
        $c->index();
    } elseif ($path === '/admin/penelitian/dokumen/category/tambah' && $method === 'POST') {
        $c = loadController('DokumenPenelitianController');
        $c->storeCategory();
    } elseif ($path === '/admin/penelitian/dokumen/category/edit' && $method === 'POST') {
        $c = loadController('DokumenPenelitianController');
        $c->updateCategory();
    } elseif ($path === '/admin/penelitian/dokumen/category/hapus' && $method === 'POST') {
        $c = loadController('DokumenPenelitianController');
        $c->destroyCategory();
    } elseif ($path === '/admin/penelitian/dokumen/tambah' && $method === 'POST') {
        $c = loadController('DokumenPenelitianController');
        $c->storeDocument();
    } elseif ($path === '/admin/penelitian/dokumen/edit' && $method === 'POST') {
        $c = loadController('DokumenPenelitianController');
        $c->updateDocument();
    } elseif ($path === '/admin/penelitian/dokumen/hapus' && $method === 'POST') {
        $c = loadController('DokumenPenelitianController');
        $c->destroyDocument();
    }
    // Dokumen Pengabdian Masyarakat Mandiri
    elseif ($path === '/admin/pengabdian/dokumen-mandiri' && $method === 'GET') {
        $c = loadController('DokumenPengabdianMasyarakatMandiriController');
        $c->index();
    } elseif ($path === '/admin/pengabdian/dokumen-mandiri/tambah' && $method === 'POST') {
        $c = loadController('DokumenPengabdianMasyarakatMandiriController');
        $c->store();
    } elseif ($path === '/admin/pengabdian/dokumen-mandiri/edit' && $method === 'POST') {
        $c = loadController('DokumenPengabdianMasyarakatMandiriController');
        $c->update();
    } elseif ($path === '/admin/pengabdian/dokumen-mandiri/hapus' && $method === 'POST') {
        $c = loadController('DokumenPengabdianMasyarakatMandiriController');
        $c->destroy();
    }
    // Panduan Pengabdian Masyarakat
    elseif ($path === '/admin/pengabdian/panduan' && $method === 'GET') {
        $c = loadController('PanduanPengabdianMasyarakatController');
        $c->index();
    } elseif ($path === '/admin/pengabdian/panduan/tambah' && $method === 'POST') {
        $c = loadController('PanduanPengabdianMasyarakatController');
        $c->store();
    } elseif ($path === '/admin/pengabdian/panduan/edit' && $method === 'POST') {
        $c = loadController('PanduanPengabdianMasyarakatController');
        $c->update();
    } elseif ($path === '/admin/pengabdian/panduan/hapus' && $method === 'POST') {
        $c = loadController('PanduanPengabdianMasyarakatController');
        $c->destroy();
    }
    // SK Rektor Pengabdian Masyarakat
    elseif ($path === '/admin/pengabdian/sk-rektor' && $method === 'GET') {
        $c = loadController('SKRektorPengabdianMasyarakatController');
        $c->index();
    } elseif ($path === '/admin/pengabdian/sk-rektor/tambah' && $method === 'POST') {
        $c = loadController('SKRektorPengabdianMasyarakatController');
        $c->store();
    } elseif ($path === '/admin/pengabdian/sk-rektor/edit' && $method === 'POST') {
        $c = loadController('SKRektorPengabdianMasyarakatController');
        $c->update();
    } elseif ($path === '/admin/pengabdian/sk-rektor/hapus' && $method === 'POST') {
        $c = loadController('SKRektorPengabdianMasyarakatController');
        $c->destroy();
    }
    // Dokumen Pengabdian Masyarakat
    elseif ($path === '/admin/pengabdian/dokumen' && $method === 'GET') {
        $c = loadController('DokumenPengabdianMasyarakatController');
        $c->index();
    } elseif ($path === '/admin/pengabdian/dokumen/category/tambah' && $method === 'POST') {
        $c = loadController('DokumenPengabdianMasyarakatController');
        $c->storeCategory();
    } elseif ($path === '/admin/pengabdian/dokumen/category/edit' && $method === 'POST') {
        $c = loadController('DokumenPengabdianMasyarakatController');
        $c->updateCategory();
    } elseif ($path === '/admin/pengabdian/dokumen/category/hapus' && $method === 'POST') {
        $c = loadController('DokumenPengabdianMasyarakatController');
        $c->destroyCategory();
    } elseif ($path === '/admin/pengabdian/dokumen/tambah' && $method === 'POST') {
        $c = loadController('DokumenPengabdianMasyarakatController');
        $c->storeDocument();
    } elseif ($path === '/admin/pengabdian/dokumen/edit' && $method === 'POST') {
        $c = loadController('DokumenPengabdianMasyarakatController');
        $c->updateDocument();
    } elseif ($path === '/admin/pengabdian/dokumen/hapus' && $method === 'POST') {
        $c = loadController('DokumenPengabdianMasyarakatController');
        $c->destroyDocument();
    }
    // Buku Panduan KKN Tematik
    elseif ($path === '/admin/kkn/panduan-tematik' && $method === 'GET') {
        $c = loadController('BukuPanduanKKNTematikController');
        $c->index();
    } elseif ($path === '/admin/kkn/panduan-tematik/tambah' && $method === 'POST') {
        $c = loadController('BukuPanduanKKNTematikController');
        $c->store();
    } elseif ($path === '/admin/kkn/panduan-tematik/edit' && $method === 'POST') {
        $c = loadController('BukuPanduanKKNTematikController');
        $c->update();
    } elseif ($path === '/admin/kkn/panduan-tematik/hapus' && $method === 'POST') {
        $c = loadController('BukuPanduanKKNTematikController');
        $c->destroy();
    }
    // Layanan HKI
    elseif ($path === '/admin/layanan/hki' && $method === 'GET') {
        $c = loadController('LayananHKIController');
        $c->index();
    } elseif ($path === '/admin/layanan/hki/tambah' && $method === 'POST') {
        $c = loadController('LayananHKIController');
        $c->store();
    } elseif ($path === '/admin/layanan/hki/edit' && $method === 'POST') {
        $c = loadController('LayananHKIController');
        $c->update();
    } elseif ($path === '/admin/layanan/hki/hapus' && $method === 'POST') {
        $c = loadController('LayananHKIController');
        $c->destroy();
    }
    // Buku Panduan KKN PMM
    elseif ($path === '/admin/kkn/panduan-pmm' && $method === 'GET') {
        $c = loadController('BukuPanduanKKNPMMController');
        $c->index();
    } elseif ($path === '/admin/kkn/panduan-pmm/tambah' && $method === 'POST') {
        $c = loadController('BukuPanduanKKNPMMController');
        $c->store();
    } elseif ($path === '/admin/kkn/panduan-pmm/edit' && $method === 'POST') {
        $c = loadController('BukuPanduanKKNPMMController');
        $c->update();
    } elseif ($path === '/admin/kkn/panduan-pmm/hapus' && $method === 'POST') {
        $c = loadController('BukuPanduanKKNPMMController');
        $c->destroy();
    }
    // Buku Panduan KKN BEM
    elseif ($path === '/admin/kkn/panduan-bem' && $method === 'GET') {
        $c = loadController('BukuPanduanKKNBEMController');
        $c->index();
    } elseif ($path === '/admin/kkn/panduan-bem/tambah' && $method === 'POST') {
        $c = loadController('BukuPanduanKKNBEMController');
        $c->store();
    } elseif ($path === '/admin/kkn/panduan-bem/edit' && $method === 'POST') {
        $c = loadController('BukuPanduanKKNBEMController');
        $c->update();
    } elseif ($path === '/admin/kkn/panduan-bem/hapus' && $method === 'POST') {
        $c = loadController('BukuPanduanKKNBEMController');
        $c->destroy();
    }

    // === END ROUTE HALAMAN === 
    // === API ===
    // --- AUTH ---
    elseif ($path === '/api/auth/login' && $method === 'POST') {
        $c = loadController('AuthController');
        $c->login();
    } elseif ($path === '/api/auth/logout' && $method === 'POST') {
        $c = loadController('AuthController');
        $c->logout();
    }

    // --- ADMIN ---
    elseif ($path === '/api/admins' && $method === 'GET') {
        $c = loadController('AdminController');
        $c->getAll();
    } elseif (preg_match('#^/api/admins/(\d+)$#', $path, $m) && $method === 'GET') {
        $c = loadController('AdminController');
        $c->getById((int)$m[1]);
    }

    // --- ARTICLE ---
    elseif ($path === '/api/article' && $method === 'GET') {
        $c = loadController('ArticleController');
        $c->getAll();
    } elseif (preg_match('#^/api/article/slug/(.+)$#', $path, $m) && $method === 'GET') {
        $c = loadController('ArticleController');
        $c->getBySlug(urldecode($m[1]));
    } elseif (preg_match('#^/api/article/type/(.+)$#', $path, $m) && $method === 'GET') {
        $c = loadController('ArticleController');
        $c->getByType(urldecode($m[1]));
    } elseif ($path === '/api/article/add' && $method === 'POST') {
        $c = loadController('ArticleController');
        $c->create();
    } elseif (preg_match('#^/api/article/update/(\d+)$#', $path, $m) && $method === 'PATCH') {
        $c = loadController('ArticleController');
        $c->update((int)$m[1]);
    } elseif (preg_match('#^/api/article/delete/(\d+)$#', $path, $m) && $method === 'DELETE') {
        $c = loadController('ArticleController');
        $c->delete((int)$m[1]);
    }

    // --- PROFILE ---
    elseif ($path === '/api/profile' && $method === 'GET') {
        $c = loadController('ProfileController');
        $c->getAll();
    } elseif ($path === '/api/profile/type' && $method === 'GET') {
        $c = loadController('ProfileController');
        $c->getByType();
    } elseif (preg_match('#^/api/profile/(\d+)$#', $path, $m) && $method === 'GET') {
        $c = loadController('ProfileController');
        $c->getById((int)$m[1]);
    } elseif ($path === '/api/profile/add' && $method === 'POST') {
        $c = loadController('ProfileController');
        $c->create();
    } elseif (preg_match('#^/api/profile/update/(\d+)$#', $path, $m) && $method === 'PATCH') {
        $c = loadController('ProfileController');
        $c->update((int)$m[1]);
    } elseif (preg_match('#^/api/profile/delete/(\d+)$#', $path, $m) && $method === 'DELETE') {
        $c = loadController('ProfileController');
        $c->delete((int)$m[1]);
    }

    // --- YOUTUBE ---
    elseif ($path === '/api/youtube' && $method === 'GET') {
        $c = loadController('YoutubeController');
        $c->getAll();
    } elseif (preg_match('#^/api/youtube/(\d+)$#', $path, $m) && $method === 'GET') {
        $c = loadController('YoutubeController');
        $c->getById((int)$m[1]);
    } elseif ($path === '/api/youtube/add' && $method === 'POST') {
        $c = loadController('YoutubeController');
        $c->create();
    } elseif (preg_match('#^/api/youtube/update/(\d+)$#', $path, $m) && $method === 'PATCH') {
        $c = loadController('YoutubeController');
        $c->update((int)$m[1]);
    } elseif (preg_match('#^/api/youtube/delete/(\d+)$#', $path, $m) && $method === 'DELETE') {
        $c = loadController('YoutubeController');
        $c->delete((int)$m[1]);
    }

    // --- FILES ---
    elseif ($path === '/api/files' && $method === 'GET') {
        $c = loadController('FileController');
        $c->getAll();
    } elseif ($path === '/api/files/type' && $method === 'GET') {
        $c = loadController('FileController');
        $c->getByType();
    } elseif (preg_match('#^/api/files/(\d+)$#', $path, $m) && $method === 'GET') {
        $c = loadController('FileController');
        $c->getById((int)$m[1]);
    } elseif ($path === '/api/files/add' && $method === 'POST') {
        $c = loadController('FileController');
        $c->create();
    } elseif (preg_match('#^/api/files/update/(\d+)$#', $path, $m) && $method === 'PATCH') {
        $c = loadController('FileController');
        $c->update((int)$m[1]);
    } elseif (preg_match('#^/api/files/delete/(\d+)$#', $path, $m) && $method === 'DELETE') {
        $c = loadController('FileController');
        $c->delete((int)$m[1]);
    }

    // --- FORMS ---
    elseif ($path === '/api/forms' && $method === 'GET') {
        $c = loadController('FormController');
        $c->getAll();
    } elseif (preg_match('#^/api/forms/(\d+)$#', $path, $m) && $method === 'GET') {
        $c = loadController('FormController');
        $c->getById((int)$m[1]);
    } elseif ($path === '/api/forms/add' && $method === 'POST') {
        $c = loadController('FormController');
        $c->create();
    } elseif (preg_match('#^/api/forms/update/(\d+)$#', $path, $m) && $method === 'PATCH') {
        $c = loadController('FormController');
        $c->update((int)$m[1]);
    } elseif (preg_match('#^/api/forms/delete/(\d+)$#', $path, $m) && $method === 'DELETE') {
        $c = loadController('FormController');
        $c->delete((int)$m[1]);
    }

    // --- CAT DOKUMEN PENELITIAN ---
    elseif ($path === '/api/catdokumenpen' && $method === 'GET') {
        $c = loadController('CatDokumenPenController');
        $c->getAll();
    } elseif (preg_match('#^/api/catdokumenpen/(\d+)$#', $path, $m) && $method === 'GET') {
        $c = loadController('CatDokumenPenController');
        $c->getById((int)$m[1]);
    } elseif ($path === '/api/catdokumenpen/add' && $method === 'POST') {
        $c = loadController('CatDokumenPenController');
        $c->create();
    } elseif (preg_match('#^/api/catdokumenpen/update/(\d+)$#', $path, $m) && $method === 'PATCH') {
        $c = loadController('CatDokumenPenController');
        $c->update((int)$m[1]);
    } elseif (preg_match('#^/api/catdokumenpen/delete/(\d+)$#', $path, $m) && $method === 'DELETE') {
        $c = loadController('CatDokumenPenController');
        $c->delete((int)$m[1]);
    }

    // --- DOKUMEN PENELITIAN ---
    elseif ($path === '/api/dokumenpen' && $method === 'GET') {
        $c = loadController('DokumenPenController');
        $c->getAll();
    } elseif (preg_match('#^/api/dokumenpen/(\d+)$#', $path, $m) && $method === 'GET') {
        $c = loadController('DokumenPenController');
        $c->getById((int)$m[1]);
    } elseif ($path === '/api/dokumenpen/add' && $method === 'POST') {
        $c = loadController('DokumenPenController');
        $c->create();
    } elseif (preg_match('#^/api/dokumenpen/update/(\d+)$#', $path, $m) && $method === 'PATCH') {
        $c = loadController('DokumenPenController');
        $c->update((int)$m[1]);
    } elseif (preg_match('#^/api/dokumenpen/delete/(\d+)$#', $path, $m) && $method === 'DELETE') {
        $c = loadController('DokumenPenController');
        $c->delete((int)$m[1]);
    }

    // --- CAT DOKUMEN PENGABDIAN ---
    elseif ($path === '/api/catdokumenpengab' && $method === 'GET') {
        $c = loadController('CatDokumenPengabController');
        $c->getAll();
    } elseif (preg_match('#^/api/catdokumenpengab/(\d+)$#', $path, $m) && $method === 'GET') {
        $c = loadController('CatDokumenPengabController');
        $c->getById((int)$m[1]);
    } elseif ($path === '/api/catdokumenpengab/add' && $method === 'POST') {
        $c = loadController('CatDokumenPengabController');
        $c->create();
    } elseif (preg_match('#^/api/catdokumenpengab/update/(\d+)$#', $path, $m) && $method === 'PATCH') {
        $c = loadController('CatDokumenPengabController');
        $c->update((int)$m[1]);
    } elseif (preg_match('#^/api/catdokumenpengab/delete/(\d+)$#', $path, $m) && $method === 'DELETE') {
        $c = loadController('CatDokumenPengabController');
        $c->delete((int)$m[1]);
    }

    // --- DOKUMEN PENGABDIAN ---
    elseif ($path === '/api/dokumenpengab' && $method === 'GET') {
        $c = loadController('DokumenPengabController');
        $c->getAll();
    } elseif (preg_match('#^/api/dokumenpengab/(\d+)$#', $path, $m) && $method === 'GET') {
        $c = loadController('DokumenPengabController');
        $c->getById((int)$m[1]);
    } elseif ($path === '/api/dokumenpengab/add' && $method === 'POST') {
        $c = loadController('DokumenPengabController');
        $c->create();
    } elseif (preg_match('#^/api/dokumenpengab/update/(\d+)$#', $path, $m) && $method === 'PATCH') {
        $c = loadController('DokumenPengabController');
        $c->update((int)$m[1]);
    } elseif (preg_match('#^/api/dokumenpengab/delete/(\d+)$#', $path, $m) && $method === 'DELETE') {
        $c = loadController('DokumenPengabController');
        $c->delete((int)$m[1]);
    }

    // --- CAT DOKUMEN PROFESI ---
    elseif ($path === '/api/catdokumenprof' && $method === 'GET') {
        $c = loadController('CatDokumenProfController');
        $c->getAll();
    } elseif (preg_match('#^/api/catdokumenprof/(\d+)$#', $path, $m) && $method === 'GET') {
        $c = loadController('CatDokumenProfController');
        $c->getById((int)$m[1]);
    } elseif ($path === '/api/catdokumenprof/add' && $method === 'POST') {
        $c = loadController('CatDokumenProfController');
        $c->create();
    } elseif (preg_match('#^/api/catdokumenprof/update/(\d+)$#', $path, $m) && $method === 'PATCH') {
        $c = loadController('CatDokumenProfController');
        $c->update((int)$m[1]);
    } elseif (preg_match('#^/api/catdokumenprof/delete/(\d+)$#', $path, $m) && $method === 'DELETE') {
        $c = loadController('CatDokumenProfController');
        $c->delete((int)$m[1]);
    }

    // --- DOKUMEN PROFESI ---
    elseif ($path === '/api/dokumenprof' && $method === 'GET') {
        $c = loadController('DokumenProfController');
        $c->getAll();
    } elseif (preg_match('#^/api/dokumenprof/(\d+)$#', $path, $m) && $method === 'GET') {
        $c = loadController('DokumenProfController');
        $c->getById((int)$m[1]);
    } elseif ($path === '/api/dokumenprof/add' && $method === 'POST') {
        $c = loadController('DokumenProfController');
        $c->create();
    } elseif (preg_match('#^/api/dokumenprof/update/(\d+)$#', $path, $m) && $method === 'PATCH') {
        $c = loadController('DokumenProfController');
        $c->update((int)$m[1]);
    } elseif (preg_match('#^/api/dokumenprof/delete/(\d+)$#', $path, $m) && $method === 'DELETE') {
        $c = loadController('DokumenProfController');
        $c->delete((int)$m[1]);
    }
    // === END API ===
    // --- 404 ---
    else {
        Response::error('Route not found', 404);
    }
} catch (Exception $e) {
    Response::error('Internal Server Error', 500, $e->getMessage());
}
