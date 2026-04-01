<?php
// Generate random captcha
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$captcha_a = rand(1, 9);
$captcha_b = rand(1, 9);
$_SESSION['captcha_answer'] = $captcha_a + $captcha_b;
?>
<!DOCTYPE html>

<html class="light" lang="id">

<head>
    <?php include __DIR__ . '/../../helpers/HeadConfig.php'; ?>
    <title>Login Admin P3M UNIM</title>
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 antialiased min-h-screen flex flex-col">

    <!-- Main Content: Centered Login Card -->
    <main class="flex-1 flex items-center justify-center p-6">
        <div class="w-full max-w-md bg-white dark:bg-slate-900 rounded-xl shadow-xl border border-slate-200 dark:border-slate-800 overflow-hidden">
            <!-- Card Header with Banner -->
            <div class="relative h-32 bg-primary/10 flex items-center justify-center overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-transparent"></div>
                <div class="relative flex flex-col items-center gap-2">
                    <span class="material-symbols-outlined text-5xl text-primary">admin_panel_settings</span>
                </div>
            </div>
            <!-- Card Body -->
            <div class="p-8">
                <?php if (isset($error)): ?>
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm">
                        <p><?php echo htmlspecialchars($error); ?></p>
                    </div>
                <?php endif; ?>
                <form action="/admin/login" class="space-y-6" method="POST">
                    <!-- Username Input -->
                    <div class="space-y-2">
                        <label class="text-sm font-semibold block" for="username">Username</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">person</span>
                            <input class="w-full pl-10 pr-4 py-3 bg-background-light dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all placeholder:text-slate-400" id="username" name="username" placeholder="Masukkan username Anda" required="" type="text" />
                        </div>
                    </div>
                    <!-- Password Input -->
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <label class="text-sm font-semibold" for="password">Password</label>
                            <a class="text-xs text-primary hover:underline" href="#">Lupa password?</a>
                        </div>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">lock</span>
                            <input class="w-full pl-10 pr-12 py-3 bg-background-light dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all placeholder:text-slate-400" id="password" name="password" placeholder="Masukkan password Anda" required="" type="password" />
                            <button id="togglePassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors" type="button">
                                <span class="material-symbols-outlined" id="togglePasswordIcon">visibility</span>
                            </button>
                        </div>
                    </div><!-- Captcha Input -->
                    <div class="space-y-2">
                        <label class="text-sm font-semibold block text-primary" for="captcha"><?= $captcha_a ?> + <?= $captcha_b ?> = ?</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">verified_user</span>
                            <input class="w-full pl-10 pr-4 py-3 bg-background-light dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all placeholder:text-slate-400" id="captcha" name="captcha" placeholder="Masukkan hasil penjumlahan" required="" type="number" />
                        </div>
                    </div>
                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input class="rounded border-slate-300 text-primary focus:ring-primary" id="remember" type="checkbox" />
                        <label class="ml-2 text-sm text-slate-600 dark:text-slate-400 cursor-pointer" for="remember">Ingat saya di perangkat ini</label>
                    </div>
                    <!-- Submit Button -->
                    <button class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-3 px-4 rounded-lg shadow-lg shadow-primary/20 transition-all flex items-center justify-center gap-2 group" type="submit">
                        <span>Masuk</span>
                        <span class="material-symbols-outlined text-xl group-hover:translate-x-1 transition-transform">login</span>
                    </button>
                </form>
                <!-- Footer Links -->
                <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-800 text-center">
                    <p class="text-xs text-slate-400">
                        © 2026 Lembaga Penelitian dan Pengabdian Masyarakat<br />
                        Universitas Islam Majapahit
                    </p>
                </div>
            </div>
        </div>
    </main>
    <!-- Optional Illustration/Pattern Background Decor -->
    <div class="fixed bottom-0 right-0 p-8 pointer-events-none opacity-10 dark:opacity-5 hidden lg:block">
        <span class="material-symbols-outlined text-[12rem]">history_edu</span>
    </div>
    <div class="fixed top-20 left-10 p-8 pointer-events-none opacity-10 dark:opacity-5 hidden lg:block">
        <span class="material-symbols-outlined text-[8rem]">menu_book</span>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const togglePasswordIcon = document.getElementById('togglePasswordIcon');

            if (togglePassword && passwordInput && togglePasswordIcon) {
                togglePassword.addEventListener('click', function() {
                    // Toggle the type attribute
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    // Toggle the icon
                    if (type === 'password') {
                        togglePasswordIcon.textContent = 'visibility';
                    } else {
                        togglePasswordIcon.textContent = 'visibility_off';
                    }
                });
            }
        });
    </script>
</body>

</html>