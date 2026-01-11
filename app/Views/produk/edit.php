<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="main-content-awal">
    <div class="auth-card">
        <h2 class="text-white">Edit Produk</h2>

        <?php if (session()->getFlashdata('errors')) : ?>
            <div class="alert alert-error">
                <ul>
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('/produk/update/' . $produk['id']) ?>" method="post" class="auth-form">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="nama">Nama Produk</label>
                <input type="text" name="nama_produk" id="nama_produk" placeholder="Masukkan nama produk"
                       value="<?= old('nama_produk', esc($produk['nama_produk'])) ?>" required>
            </div>

            <div class="form-group">
                <label for="harga">Harga (Rp)</label>
                <input type="number" name="harga" id="harga" placeholder="Contoh: 100000" min="0"
                       value="<?= old('harga', esc($produk['harga'])) ?>" required>
            </div>

            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="number" name="stok" id="stok" placeholder="Contoh: 10" min="0"
                       value="<?= old('stok', esc($produk['stok'])) ?>" required>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <input type="text" name="deskripsi" id="deskripsi" placeholder="Deskripsi singkat produk"
                       value="<?= old('deskripsi', esc($produk['deskripsi'])) ?>">
            </div>

            <button type="submit" class="btn">Update Produk</button>
        </form>

        <div class="auth-footer">
            <a href="<?= base_url('/produk') ?>">← Kembali ke Daftar Produk</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
