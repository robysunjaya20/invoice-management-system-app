<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="main-content-awal">
    <div class="auth-card customer-card">
        <h2 class="text-white">Daftar Invoice</h2>
        <div class="action-bar">
            <a href="<?= base_url('/invoice/create') ?>" class="btn-create">+ Tambah Invoice</a>
        </div>
        <div class="table-responsive">
            <table class="customer-table">
                <thead>
                    <tr>
                        <th>Kode Invoice</th>
                        <th>Customer</th>
                        <th>Tanggal</th>
                        <th>Total (Rp)</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($invoices) > 0): ?>
                        <?php foreach ($invoices as $invoice): ?>
                            <tr>
                                <td><?= esc($invoice['kode_invoice']) ?></td>
                                <td><?= esc($invoice['customer_nama']) ?></td>
                                <td><?= esc($invoice['tanggal']) ?></td>
                                <td>Rp<?= number_format($invoice['grand_total'], 0, ',', '.') ?></td>
                                <td><?= esc($invoice['status']) ?></td>
                                <td class="text-center">
                                    <form action="<?= base_url('/invoice/delete/' . $invoice['id']) ?>" method="post" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus invoice ini?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-create">Hapus</button>
                                    </form>

                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data invoice.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
