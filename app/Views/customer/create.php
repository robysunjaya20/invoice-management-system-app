<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="main-content-awal">
    <div class="auth-card">
        <h2 class="text-white">Tambah Customer</h2>
        <form method="post" action="<?= base_url('/customer/store') ?>" class="auth-form">
            <label>Nama</label>
            <input type="text" name="nama" required>
            <label>Email</label>
            <input type="email" name="email" required>
            <label>Telepon</label>
            <input type="text" name="telepon" required>
            <label>Alamat</label>
            <textarea name="alamat" required></textarea>
            <button type="submit" class="btn">Simpan</button>
        </form>
    </div>
<?= $this->endSection() ?>
