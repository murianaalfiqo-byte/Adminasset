<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0 text-dark">Data Maintenance (Perbaikan)</h4>
        <button type="button" class="btn btn-danger shadow-sm" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fas fa-tools me-2"></i> Servis Aset
        </button>
    </div>

    <?php if($this->session->flashdata('success_msg')): ?>
        <div class="alert alert-success border-0 shadow-sm"><i class="fas fa-check-circle me-2"></i> <?= $this->session->flashdata('success_msg'); ?></div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-3 mb-5">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3">Nama Barang</th>
                        <th class="py-3">Deskripsi Kerusakan</th>
                        <th class="py-3">Tgl Masuk</th>
                        <th class="py-3">Biaya Servis</th>
                        <th class="py-3 text-center">Status</th>
                        <th class="py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($maintenances as $row): ?>
                        <tr>
                            <td class="px-4"><strong><?= $row['asset_name']; ?></strong><br><small><?= $row['asset_code']; ?></small></td>
                            <td><?= $row['problem_description']; ?></td>
                            <td><?= date('d M Y', strtotime($row['start_date'])); ?></td>
                            <td>Rp <?= number_format($row['cost'], 0, ',', '.'); ?></td>
                            <td class="text-center">
                                <?php if($row['status'] == 'ongoing'): ?>
                                    <span class="badge bg-warning text-dark">Sedang Diservis</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Selesai</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if($row['status'] == 'ongoing'): ?>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#completeModal<?= $row['id']; ?>">
                                        Selesaikan
                                    </button>
                                <?php else: ?>
                                    <span class="text-muted small"><i class="fas fa-check"></i> Tuntas</span>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <!-- MODAL SELESAIKAN SERVIS -->
                        <div class="modal fade" id="completeModal<?= $row['id']; ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="<?= site_url('maintenance/complete') ?>" method="POST">
                                        <div class="modal-header"><h5 class="modal-title">Selesaikan Perbaikan</h5></div>
                                        <div class="modal-body p-4">
                                            <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                            <input type="hidden" name="asset_id" value="<?= $row['asset_id']; ?>">
                                            <div class="mb-3">
                                                <label class="form-label text-secondary small fw-bold">Biaya Perbaikan</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light">Rp</span>
                                                    <input type="text" class="form-control rupiah-input" name="cost" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 bg-light">
                                            <button type="submit" class="btn btn-primary">Simpan & Selesai</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH SERVIS -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= site_url('maintenance/add') ?>" method="POST">
                <div class="modal-header bg-light"><h5 class="modal-title fw-bold">Input Barang Rusak / Servis</h5></div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">Pilih Aset <span class="text-danger">*</span></label>
                        <select class="form-select" name="asset_id" required>
                            <option value="">-- Pilih Barang --</option>
                            <?php foreach($assets as $ast): ?>
                                <option value="<?= $ast['id']; ?>"><?= $ast['name']; ?> (<?= $ast['asset_code']; ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">Deskripsi Kerusakan <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="problem_description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">Tanggal Masuk Servis <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="start_date" value="<?= date('Y-m-d'); ?>" required>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="submit" class="btn btn-danger">Simpan ke Maintenance</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SCRIPT RUPIAH -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var rupiahInputs = document.querySelectorAll('.rupiah-input');
        rupiahInputs.forEach(function(input) {
            input.addEventListener('keyup', function(e) {
                this.value = formatRupiah(this.value);
            });
        });
        function formatRupiah(angka) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(), split = number_string.split(','),
                sisa = split[0].length % 3, rupiah = split[0].substr(0, sisa), ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            if(ribuan) { separator = sisa ? '.' : ''; rupiah += separator + ribuan.join('.'); }
            return split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        }
    });
</script>