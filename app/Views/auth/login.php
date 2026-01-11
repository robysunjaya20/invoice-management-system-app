<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="main-content-awal">
    <div class="auth-card">
        <h2 class="text-white">Masuk ke Sistem</h2>
        
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('/login') ?>" class="auth-form">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" placeholder="Masukkan username" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Masukkan password" required>

            <button type="submit" class="btn">Login</button>
            
        </form>

        <p class="auth-footer">
            <br>
            Belum punya akun? <a style="color: #FF6500;" href="<?= base_url('/register') ?>">Daftar di sini</a>
        </p>
    </div>
<?= $this->endSection() ?>
