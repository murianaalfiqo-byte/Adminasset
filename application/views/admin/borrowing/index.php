<div class="container-fluid p-4">
    <!-- Header Page -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Data Transaksi Peminjaman</h4>
            <p class="text-muted extra-small mb-0">Kelola persetujuan, penyerahan, dan pengembalian unit perangkat medis/IT.</p>
        </div>
    </div>

    <!-- Alert Flash Data -->
    <?php if($this->session->flashdata('success_msg')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?= $this->session->flashdata('success_msg'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if($this->session->flashdata('error_msg')): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> <?= $this->session->flashdata('error_msg'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Summary Filter Tabs -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap gap-2">
                <a href="<?= site_url('borrowing'); ?>" class="btn btn-sm <?= empty($this->input->get('status')) ? 'btn-teal text-white fw-bold' : 'btn-light text-muted'; ?> rounded-pill px-3">
                    Semua Transaksi <span class="badge bg-white text-dark ms-1"><?= $count_all; ?></span>
                </a>
                <a href="<?= site_url('borrowing?status=pending'); ?>" class="btn btn-sm <?= ($this->input->get('status') == 'pending') ? 'btn-warning text-dark fw-bold' : 'btn-light text-muted'; ?> rounded-pill px-3">
                    <i class="fas fa-clock me-1"></i> Menunggu Approval <span class="badge bg-dark text-white ms-1"><?= $count_pending; ?></span>
                </a>
                <a href="<?= site_url('borrowing?status=in_use'); ?>" class="btn btn-sm <?= ($this->input->get('status') == 'in_use') ? 'btn-success text-white fw-bold' : 'btn-light text-muted'; ?> rounded-pill px-3">
                    <i class="fas fa-box me-1"></i> Sedang Dipinjam <span class="badge bg-white text-dark ms-1"><?= $count_in_use; ?></span>
                </a>
                <a href="<?= site_url('borrowing?status=returned'); ?>" class="btn btn-sm <?= ($this->input->get('status') == 'returned') ? 'btn-primary text-white fw-bold' : 'btn-light text-muted'; ?> rounded-pill px-3">
                    <i class="fas fa-check-double me-1"></i> Selesai/Dikembalikan <span class="badge bg-white text-dark ms-1"><?= $count_returned; ?></span>
                </a>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light border-bottom">
                        <tr class="text-muted small">
                            <th class="ps-4 py-3 border-0">Peminjam</th>
                            <th class="py-3 border-0">Perangkat</th>
                            <th class="py-3 border-0">Jadwal Pinjam</th>
                            <th class="py-3 border-0">Alasan / Tujuan</th>
                            <th class="py-3 border-0 text-center">Status</th>
                            <th class="pe-4 py-3 border-0 text-center" width="18%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($borrowings)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="fas fa-inbox fs-1 text-teal opacity-25 mb-3 d-block"></i>
                                    <h6 class="fw-bold text-dark mb-1">Belum Ada Data Peminjaman</h6>
                                    <p class="text-muted extra-small mb-0">Tidak ditemukan transaksi peminjaman sesuai filter ini.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($borrowings as $row): ?>
                                <tr class="border-bottom-subtle">
                                    <!-- User Info -->
                                    <td class="ps-4 py-3">
                                        <div class="fw-bold text-dark small"><?= $row['user_name']; ?></div>
                                        <small class="text-muted extra-small"><?= $row['user_email']; ?></small>
                                    </td>

                                    <!-- Asset Info -->
                                    <td class="py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-3 bg-light p-1 me-2 border d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <img src="<?= base_url('assets/img/assets/'.$row['photo']); ?>" class="img-fluid rounded-2" style="max-height: 32px; object-fit: contain;">
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark extra-small"><?= $row['asset_name']; ?></div>
                                                <span class="text-muted extra-small font-monospace">S/N: <?= $row['asset_code']; ?></span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Date Schedule -->
                                    <td class="py-3">
                                        <div class="extra-small fw-medium text-dark">
                                            <i class="far fa-calendar-alt text-teal me-1"></i><?= date('d M Y', strtotime($row['requested_start_at'])); ?>
                                        </div>
                                        <div class="extra-small text-muted">
                                            s.d <?= date('d M Y', strtotime($row['requested_end_at'])); ?>
                                        </div>
                                    </td>

                                    <!-- Reason -->
                                    <td class="py-3">
                                        <p class="extra-small text-dark mb-0 text-truncate" style="max-width: 200px;" title="<?= $row['reason']; ?>">
                                            <?= !empty($row['reason']) ? $row['reason'] : '-'; ?>
                                        </p>
                                    </td>

                                    <!-- Status Badge -->
                                    <td class="py-3 text-center">
                                        <?php 
                                            switch($row['status']) {
                                                case 'pending':
                                                    echo '<span class="badge badge-amber px-3 py-1 rounded-pill extra-small"><i class="fas fa-spinner fa-spin me-1"></i>Menunggu</span>';
                                                    break;
                                                case 'approved':
                                                    echo '<span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-3 py-1 rounded-pill extra-small"><i class="fas fa-check me-1"></i>Disetujui</span>';
                                                    break;
                                                case 'in_use':
                                                    echo '<span class="badge badge-emerald px-3 py-1 rounded-pill extra-small"><i class="fas fa-box me-1"></i>Dipinjam</span>';
                                                    break;
                                                case 'returned':
                                                    echo '<span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-1 rounded-pill extra-small"><i class="fas fa-check-double me-1"></i>Selesai</span>';
                                                    break;
                                                case 'rejected':
                                                    echo '<span class="badge badge-red px-3 py-1 rounded-pill extra-small">Ditolak</span>';
                                                    break;
                                                default:
                                                    echo '<span class="badge bg-secondary extra-small">'.$row['status'].'</span>';
                                                    break;
                                            }
                                        ?>
                                    </td>

                                    <!-- Action Buttons -->
                                    <td class="pe-4 py-3 text-center">
                                        <?php if($row['status'] == 'pending'): ?>
                                            <div class="d-flex gap-1 justify-content-center">
                                                <a href="<?= site_url('borrowing/approve/'.$row['id']); ?>" class="btn btn-sm btn-success rounded-3 px-2 py-1 extra-small fw-bold" title="Setujui">
                                                    <i class="fas fa-check me-1"></i> Setujui
                                                </a>
                                                <a href="<?= site_url('borrowing/reject/'.$row['id']); ?>" class="btn btn-sm btn-outline-danger rounded-3 px-2 py-1 extra-small fw-bold" title="Tolak" onclick="return confirm('Yakin tolak pengajuan ini?');">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </div>
                                        <?php elseif($row['status'] == 'approved'): ?>
                                            <a href="<?= site_url('borrowing/handover/'.$row['id']); ?>" class="btn btn-sm btn-teal text-white rounded-3 px-3 py-1 extra-small fw-bold">
                                                <i class="fas fa-hand-holding me-1"></i> Serahkan Barang
                                            </a>
                                        <?php elseif($row['status'] == 'in_use'): ?>
                                            <a href="<?= site_url('borrowing/return_asset/'.$row['id']); ?>" class="btn btn-sm btn-primary rounded-3 px-3 py-1 extra-small fw-bold">
                                                <i class="fas fa-undo me-1"></i> Kembalikan Unit
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted extra-small"><i class="fas fa-check-circle me-1"></i> Selesai</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.btn-teal {
    background-color: #0D9488 !important;
    border-color: #0D9488 !important;
}
.btn-teal:hover {
    background-color: #0F766E !important;
}
.text-teal {
    color: #0D9488 !important;
}
.extra-small {
    font-size: 0.78rem;
}
</style>