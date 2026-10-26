<div class="container py-4 my-2">
    <!-- Header Page -->
    <div class="mb-4">
        <h3 class="fw-bold text-dark mb-1">Riwayat Peminjamanku</h3>
        <p class="text-muted small mb-0">Pantau status pengajuan, masa pakai, dan histori pengembalian unit perangkat.</p>
    </div>

    <!-- Alert Messages -->
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

    <!-- Table Card -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light border-bottom">
                        <tr class="text-muted small">
                            <th class="ps-4 py-3 border-0" width="12%">Kode Pinjam</th>
                            <th class="py-3 border-0" width="30%">Perangkat</th>
                            <th class="py-3 border-0">Waktu Pinjam</th>
                            <th class="py-3 border-0">Rencana Kembali</th>
                            <th class="py-3 border-0 text-center">Status</th>
                            <th class="pe-4 py-3 border-0 text-center" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($borrowings)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="fas fa-history fs-1 text-teal opacity-25 mb-3 d-block"></i>
                                    <h6 class="fw-bold text-dark mb-1">Belum ada riwayat peminjaman</h6>
                                    <p class="text-muted small mb-3">Anda belum pernah melakukan pengajuan perangkat.</p>
                                    <a href="<?= site_url('user_panel/catalog') ?>" class="btn btn-teal text-white fw-bold rounded-3 btn-sm">
                                        <i class="fas fa-boxes me-1"></i> Mulai Pinjam Barang
                                    </a>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($borrowings as $row): ?>
                                <tr class="border-bottom-subtle">
                                    <td class="ps-4 font-monospace text-teal small fw-bold">
                                        <?= $row['borrowing_code']; ?>
                                    </td>
                                    <td class="py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-3 bg-light p-1 me-3 border d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                                <img src="<?= base_url('assets/img/assets/'.$row['photo']) ?>" class="img-fluid rounded-2" style="max-height: 38px; object-fit: contain;">
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark small mb-0"><?= $row['asset_name']; ?></div>
                                                <div class="text-muted extra-small font-monospace">S/N: <?= $row['asset_code']; ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <div class="fw-medium text-dark small mb-0"><?= date('d M Y', strtotime($row['requested_start_at'])); ?></div>
                                        <div class="text-muted extra-small"><i class="far fa-clock me-1"></i><?= date('H:i', strtotime($row['requested_start_at'])); ?> WIB</div>
                                    </td>
                                    <td class="py-3">
                                        <div class="fw-medium text-dark small mb-0"><?= date('d M Y', strtotime($row['requested_end_at'])); ?></div>
                                        <div class="text-muted extra-small"><i class="far fa-clock me-1"></i><?= date('H:i', strtotime($row['requested_end_at'])); ?> WIB</div>
                                    </td>
                                    <td class="py-3 text-center">
                                        <?php 
                                            switch($row['status']) {
                                                case 'pending':
                                                    echo '<span class="badge badge-amber px-3 py-1 rounded-pill extra-small"><i class="fas fa-spinner fa-spin me-1"></i>Menunggu Approval</span>';
                                                    break;
                                                case 'approved':
                                                case 'ready_for_handover':
                                                    echo '<span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-3 py-1 rounded-pill extra-small"><i class="fas fa-check me-1"></i>Siap Diambil</span>';
                                                    break;
                                                case 'in_use':
                                                    echo '<span class="badge badge-emerald px-3 py-1 rounded-pill extra-small"><i class="fas fa-box me-1"></i>Sedang Dipinjam</span>';
                                                    break;
                                                case 'returned':
                                                    echo '<span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-1 rounded-pill extra-small"><i class="fas fa-check-double me-1"></i>Selesai</span>';
                                                    break;
                                                case 'rejected':
                                                    echo '<span class="badge badge-red px-3 py-1 rounded-pill extra-small"><i class="fas fa-times me-1"></i>Ditolak</span>';
                                                    break;
                                                case 'canceled':
                                                    echo '<span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-3 py-1 rounded-pill extra-small">Dibatalkan</span>';
                                                    break;
                                                default:
                                                    echo '<span class="badge bg-light text-dark extra-small">'.$row['status'].'</span>';
                                                    break;
                                            }
                                        ?>
                                    </td>
                                    <td class="pe-4 py-3 text-center">
                                        <?php if($row['status'] == 'pending'): ?>
                                            <a href="<?= site_url('history/cancel/'.$row['id']) ?>" 
                                               class="btn btn-sm btn-outline-danger rounded-3 px-2 py-1" 
                                               title="Batalkan Pengajuan"
                                               onclick="return confirm('Apakah Anda yakin ingin membatalkan pengajuan ini?');">
                                                <i class="fas fa-times me-1"></i> Batalkan
                                            </a>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-light text-muted rounded-3 px-2 py-1" disabled title="Tidak ada aksi">
                                                <i class="fas fa-lock"></i>
                                            </button>
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