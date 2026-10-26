<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header & Navigation -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h3 class="fw-bold text-dark mb-1">Form Pengajuan Peminjaman</h3>
                    <p class="text-muted mb-0">Lengkapi rincian tanggal dan alasan peminjaman barang.</p>
                </div>
                <a href="<?= site_url('user_panel'); ?>" class="btn btn-outline-secondary rounded-3 btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Katalog
                </a>
            </div>

            <!-- Alert Error jika validasi gagal -->
            <?php if($this->session->flashdata('error_msg')): ?>
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> <?= $this->session->flashdata('error_msg'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="row g-4">
                <!-- Card Detail Barang -->
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                        <div class="bg-light text-center p-4">
                            <img src="<?= base_url('assets/img/assets/'.$asset['photo']); ?>" 
                                 class="img-fluid rounded-3 mb-2" 
                                 alt="<?= $asset['name']; ?>" 
                                 style="max-height: 180px; object-fit: contain;">
                        </div>
                        <div class="card-body p-4">
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-3 py-1 mb-2">
                                Detail Barang
                            </span>
                            <h5 class="fw-bold text-dark mb-1"><?= $asset['name']; ?></h5>
                            <p class="text-muted small mb-3"><?= $asset['brand'] ?: 'Merek -'; ?> <?= $asset['model'] ? '• '.$asset['model'] : ''; ?></p>
                            
                            <hr class="text-muted opacity-25 my-3">
                            
                            <div class="small">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Kode Aset:</span>
                                    <span class="fw-bold font-monospace"><?= $asset['asset_code']; ?></span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Serial Number:</span>
                                    <span class="fw-medium font-monospace"><?= $asset['serial_number'] ?: '-'; ?></span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Status Ketersediaan:</span>
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2">Tersedia</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Input Peminjaman -->
                <div class="col-md-7">
                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                        <form action="<?= site_url('borrowing/store'); ?>" method="POST" id="borrowForm">
                            <input type="hidden" name="asset_id" value="<?= $asset['id']; ?>">

                            <div class="mb-3">
                                <label class="form-label fw-medium text-dark small">Waktu Mulai Pinjam <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control rounded-3" name="requested_start_at" id="startAt" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium text-dark small">Rencana Waktu Pengembalian <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control rounded-3" name="requested_end_at" id="endAt" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-medium text-dark small">Alasan / Keperluan Peminjaman <span class="text-danger">*</span></label>
                                <textarea class="form-control rounded-3" name="reason" rows="4" placeholder="Tuliskan alasan atau kebutuhan penggunaan barang ini secara jelas..." required></textarea>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary fw-medium rounded-3 py-2">
                                    <i class="fas fa-paper-plane me-1"></i> Kirim Pengajuan Pinjaman
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script Set Default Min Date -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const startInput = document.getElementById('startAt');
    const endInput = document.getElementById('endAt');
    
    // Set format datetime-local sekarang
    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    const minDateTime = now.toISOString().slice(0, 16);
    
    startInput.min = minDateTime;
    startInput.value = minDateTime;
    
    // Default rentang kembali +24 jam
    const tomorrow = new Date(now.getTime() + (24 * 60 * 60 * 1000));
    endInput.min = minDateTime;
    endInput.value = tomorrow.toISOString().slice(0, 16);

    startInput.addEventListener('change', function() {
        endInput.min = startInput.value;
        if (endInput.value < startInput.value) {
            endInput.value = startInput.value;
        }
    });
});
</script>