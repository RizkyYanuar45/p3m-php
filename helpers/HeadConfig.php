<meta charset="utf-8" />
<meta content="width=device-width, initial-scale=1.0" name="viewport" />

<!-- Favicon untuk Tab Browser -->
<link rel="icon" href="/public/images/logo.ico" type="image/x-icon" />
<link rel="shortcut icon" href="/public/images/logo.ico" type="image/x-icon" />


<!-- Open Graph / WhatsApp / Facebook Meta Tags -->
<?php
// Tentukan Base URL secara otomatis berdasarkan request saat ini agar gambar tetap valid
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$domainName = $_SERVER['HTTP_HOST'];
$baseUrl = $protocol . $domainName;

// Gambar preview ketika link dibagikan. Pastikan file fotounim.webp berukuran cukup besar
$ogImageUrl = $baseUrl . '/public/images/fotounim.webp'; 
// Judul default jika variabel $title tidak di-set di view
$ogTitle = isset($pageTitle) ? $pageTitle : 'Lembaga Penelitian dan Pengabdian Masyarakat - UNIM';
$ogDescription = 'Universitas Islam Majapahit - Mengembangkan riset dan pengabdian masyarakat yang inovatif, unggul, dan berdaya guna bagi kemaslahatan umat.';
$currentUrl = $baseUrl . $_SERVER['REQUEST_URI'];
?>

<meta property="og:type" content="website" />
<meta property="og:url" content="<?= htmlspecialchars($currentUrl) ?>" />
<meta property="og:title" content="<?= htmlspecialchars($ogTitle) ?>" />
<meta property="og:description" content="<?= htmlspecialchars($ogDescription) ?>" />
<meta property="og:image" content="<?= htmlspecialchars($ogImageUrl) ?>" />

<!-- WhatsApp Specific Tags for Better Preview (Requires image > 300x200) -->
<meta property="og:image:secure_url" content="<?= htmlspecialchars($ogImageUrl) ?>" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="630" />
<meta property="og:site_name" content="P3M UNIM" />

<!-- Twitter Meta Tags -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:url" content="<?= htmlspecialchars($currentUrl) ?>" />
<meta name="twitter:title" content="<?= htmlspecialchars($ogTitle) ?>" />
<meta name="twitter:description" content="<?= htmlspecialchars($ogDescription) ?>" />
<meta name="twitter:image" content="<?= htmlspecialchars($ogImageUrl) ?>" />
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&amp;display=swap" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
<script id="tailwind-config">
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: {
                    "primary": "#FF9800",
                    "background-light": "#f6f8f7",
                    "background-dark": "#10221a",
                },
                fontFamily: {
                    "display": ["Inter", "sans-serif"]
                },
                borderRadius: {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
                },
            },
        },
    }
</script>
<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }

    body {
        font-family: 'Inter', sans-serif;
    }

    .nav-dropdown:hover .dropdown-menu {
        display: block;
    }
</style>