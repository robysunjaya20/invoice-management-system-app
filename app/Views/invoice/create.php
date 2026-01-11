<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="main-content-awal">
    <div class="auth-card">
        <h2 class="text-white">Buat Invoice</h2>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')) : ?>
            <div class="alert alert-error">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <?= esc($error) ?><br>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('invoice/store') ?>" method="post" class="auth-form">
            <?= csrf_field() ?>

            <label for="kode_invoice">Kode Invoice</label>
            <input type="text" name="kode_invoice" id="kode_invoice" value="<?= old('kode_invoice') ?>">

            <label for="customer_id">Customer</label>
            <select name="customer_id" id="customer_id">
                <option value="">-- Pilih Customer --</option>
                <?php foreach ($customers as $c) : ?>
                    <option value="<?= $c['id'] ?>" <?= old('customer_id') == $c['id'] ? 'selected' : '' ?>>
                        <?= esc($c['nama']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" value="<?= old('tanggal') ?>">

            <div id="items">
                <h4>Item Produk</h4>
                <div class="item-row" >
                    <select name="produk_id[]" required>
                        <option value="">-- Pilih Produk --</option>
                        <?php foreach ($produks as $p): ?>
                            <option value="<?= esc($p['id']) ?>">
                                <?= esc($p['nama_produk']) ?> (Rp<?= number_format($p['harga'], 0, ',', '.') ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <input type="number" name="jumlah[]" placeholder="Jumlah" min="1" required style="margin-top: 1rem;">
                    <input type="number" name="harga[]" placeholder="Harga Satuan" min="0" step="0.01" required>
                    <button type="button" class="btn-create" onclick="removeItem(this)" style="margin-bottom: 0.5rem;">Hapus</button>
                </div>
            </div>

            <button type="button" class="btn-edit" onclick="addItem()">+ Tambah Item</button>

            <label for="diskon">Diskon</label>
            <input type="number" name="diskon" id="diskon" step="0.01" min="0" value="<?= old('diskon') ?>">

            <label for="ppn">PPN</label>
            <input type="number" name="ppn" id="ppn" step="0.01" min="0" value="<?= old('ppn') ?>">

            <button type="submit" class="btn">Simpan Invoice</button>
        </form>
    </div>
</div>

<script>
    function addItem() {
        const item = document.querySelector('.item-row');
        const clone = item.cloneNode(true);
        clone.querySelectorAll('input').forEach(input => input.value = '');
        document.getElementById('items').appendChild(clone);
    }

    function removeItem(btn) {
        const row = btn.closest('.item-row');
        const items = document.querySelectorAll('.item-row');
        if (items.length > 1) {
            row.remove();
        }
    }
</script>

<?= $this->endSection() ?>
