<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="main-content-awal">
    <div class="auth-card">
        <h2 class="text-white">Tambah Produk Baru</h2>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('/produk/store') ?>" method="post" class="auth-form">
            <div class="form-group">
                <label for="nama">Nama Produk</label>
                <input type="text" name="nama_produk" id="nama_produk" placeholder="Masukkan nama produk" required>
            </div>

            <div class="form-group">
                <label for="harga">Harga (Rp)</label>
                <input type="number" name="harga" id="harga" placeholder="Contoh: 100000" min="0" required>
            </div>

            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="number" name="stok" id="stok" placeholder="Contoh: 10" min="0" required>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <input type="text" name="deskripsi" id="deskripsi" placeholder="Deskripsi singkat produk">
            </div>

            <button type="submit" class="btn">Simpan Produk</button>
        </form>

        <div class="auth-footer">
            <a href="<?= base_url('/produk') ?>">← Kembali ke Daftar Produk</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
