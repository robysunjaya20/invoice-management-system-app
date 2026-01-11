<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
    <div class="main-content-utama">
        <div class="auth-card">
            <h2 class="text-white">Selamat Datang di Aplikasi Manajemen <span style="color: var(--highlight-color);">INVOICE</span></h2>
            <p>Kelola data pelanggan, produk, dan invoice Anda dengan mudah dan efisien.</p>
            <a href="<?= base_url('login') ?>" class="btn">Masuk ke Sistem</a>
        </div>
    </div>

<?= $this->endSection() ?>
