<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0 text-dark">Data Penugasan Aset</h4>
        <button type="button" class="btn btn-info text-white shadow-sm" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fas fa-user-check me-2"></i> Tugaskan Aset Baru
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
                        <th class="px-4 py-3">Nama Karyawan</th>
                        <th class="py-3">Aset Ditugaskan</th>
                        <th class="py-3">Tgl Diberikan</th>
                        <th class="py-3 text-center">Status</th>
                        <th class="py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($assignments)): ?>
                        <tr><td colspan="5" class="text-center py-4">Belum ada data penugasan aset.</td></tr>
                    <?php else: ?>
                        <?php foreach($assignments as $row): ?>
                            <tr>
                                <td class="px-4 fw-bold text-dark"><?= $row['user_name']; ?></td>
                                <td>
                                    <div class="fw-bold text-primary"><?= $row['asset_name']; ?></div>
                                    <div class="text-muted small font-monospace"><?= $row['asset_code']; ?></div>
                                </td>
                                <td><?= date('d M Y', strtotime($row['assigned_date'])); ?></td>
                                <td class="text-center">
                                    <?php if($row['status'] == 'assigned'): ?>
                                        <span class="badge bg-info text-white">Aktif Ditugaskan</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Telah Ditarik</span><br>
                                        <small class="text-muted"><?= date('d M Y', strtotime($row['return_date'])); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if($row['status'] == 'assigned'): ?>
                                        <button class="btn btn-sm btn-warning text-dark fw-bold" data-bs-toggle="modal" data-bs-target="#revokeModal<?= $row['id']; ?>">
                                            <i class="fas fa-undo"></i> Tarik Aset
                                        </button>
                                    <?php else: ?>
                                        <span class="text-muted small"><i class="fas fa-check"></i> Selesai</span>
                                    <?php endif; ?>
                                </td>
                            </tr>

                            <!-- MODAL TARIK ASET -->
                            <div class="modal fade" id="revokeModal<?= $row['id']; ?>" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="<?= site_url('assignment/revoke') ?>" method="POST">
                                            <div class="modal-header"><h5 class="modal-title fw-bold">Tarik / Kembalikan Aset</h5></div>
                                            <div class="modal-body p-4 text-center">
                                                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                <input type="hidden" name="asset_id" value="<?= $row['asset_id']; ?>">
                                                <i class="fas fa-exclamation-circle text-warning fs-1 mb-3"></i>
                                                <p>Anda yakin ingin menarik <strong><?= $row['asset_name']; ?></strong> dari <strong><?= $row['user_name']; ?></strong>?</p>
                                            </div>
                                            <div class="modal-footer border-0 bg-light">
                                                <button type="submit" class="btn btn-warning fw-bold">Ya, Tarik Aset</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL TUGASKAN ASET BARU -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= site_url('assignment/add') ?>" method="POST">
                <div class="modal-header bg-light"><h5 class="modal-title fw-bold">Tugaskan Aset ke Karyawan</h5></div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">Pilih Karyawan <span class="text-danger">*</span></label>
                        <select class="form-select" name="user_id" required>
                            <option value="">-- Pilih Karyawan --</option>
                            <?php foreach($employees as $emp): ?>
                                <!-- Hanya tampilkan role employee (karyawan biasa) -->
                                <?php if($emp['role'] == 'employee'): ?>
                                    <option value="<?= $emp['id']; ?>"><?= $emp['name']; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">Pilih Aset (Khusus tipe Assignable) <span class="text-danger">*</span></label>
                        <select class="form-select" name="asset_id" required>
                            <option value="">-- Pilih Aset --</option>
                            <?php foreach($assets as $ast): ?>
                                <option value="<?= $ast['id']; ?>"><?= $ast['name']; ?> (<?= $ast['asset_code']; ?>)</option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">Jika kosong, berarti tidak ada aset tipe "Ditugaskan" yang sedang tersedia.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">Tgl Diberikan <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="assigned_date" value="<?= date('Y-m-d'); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small fw-bold">Catatan (Opsional)</label>
                        <textarea class="form-control" name="notes" rows="2" placeholder="Misal: Termasuk tas dan charger"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="submit" class="btn btn-info text-white">Simpan Penugasan</button>
                </div>
            </form>
        </div>
    </div>
</div>