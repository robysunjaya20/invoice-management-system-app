<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="main-content-awal">
    <div class="auth-card customer-card">
        <h2 class="text-white">Daftar Produk</h2>
        <div class="action-bar">
            <a href="<?= base_url('/produk/create') ?>" class="btn-create">+ Tambah Produk</a>
        </div>
        <div class="table-responsive">
            <table class="customer-table">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Harga (Rp)</th>
                        <th>Stok</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($products) > 0): ?>
                        <?php foreach ($products as $item): ?>
                            <tr>
                                <td><?= esc($item['nama_produk']) ?></td>
                                <td>Rp<?= number_format($item['harga'], 0, ',', '.') ?></td>
                                <td><?= esc($item['stok']) ?></td>
                                <td><?= esc($item['deskripsi']) ?></td>
                                <td class="text-center">
                                    <a href="<?= base_url('/produk/edit/' . $item['id']) ?>" class="btn btn-sm btn-edit">Edit</a>
                                    <a href="<?= base_url('/produk/delete/' . $item['id']) ?>" class="btn btn-sm btn-create" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data produk.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
