<div class="container py-3">
    <!-- 1. Compact Hero Banner -->
    <!-- 1. Compact Hero Banner -->
<div class="card border-0 shadow-sm rounded-4 text-white mb-4 overflow-hidden position-relative" 
     style="background: linear-gradient(135deg, #0D9488 0%, #0F172A 100%);">
    <div class="card-body p-4 position-relative z-1">
        <div class="row align-items-center">
            <div class="col-md-8">
                <!-- Badge PT Indo Techno Medic dengan penegasan warna teks putih -->
                <span class="badge rounded-pill px-3 py-1 mb-2 extra-small" 
                      style="background-color: rgba(255, 255, 255, 0.2); color: #FFFFFF !important; border: 1px solid rgba(255, 255, 255, 0.35);">
                    <i class="fas fa-building me-1"></i> PT Indo Techno Medic
                </span>
                
                <h3 class="fw-bold mb-1 text-white">Selamat Datang, <?= $user_name; ?>! 👋</h3>
                <p class="mb-3 text-white text-opacity-75 small" style="max-width: 550px;">
                    Kelola dan pantau peminjaman perangkat medis & operasional Anda secara real-time.
                </p>
                <div>
                    <a href="<?= site_url('user_panel/catalog'); ?>" class="btn btn-light text-teal fw-bold rounded-3 px-3 py-2 btn-sm shadow-sm">
                        <i class="fas fa-boxes me-1"></i> Jelajahi Katalog Barang
                    </a>
                </div>
            </div>
        </div>
    </div>
    <i class="fas fa-stethoscope position-absolute end-0 bottom-0 me-4 mb-n3 text-white opacity-10 d-none d-md-block" style="font-size: 8.5rem; pointer-events: none;"></i>
</div>

    <!-- 2. Stat Cards (4 Kolom) -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-3 card-hover">
                <div class="d-flex align-items-center">
                    <div class="rounded-4 p-3 me-3 d-flex align-items-center justify-content-center bg-teal-subtle text-teal" style="width: 52px; height: 52px;">
                        <i class="fas fa-box-open fs-4"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium d-block mb-1">Sedang Dipinjam</span>
                        <h3 class="fw-bold text-dark mb-0 stat-number"><?= isset($stats['in_use']) ? $stats['in_use'] : 0; ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-3 card-hover">
                <div class="d-flex align-items-center">
                    <div class="rounded-4 p-3 me-3 d-flex align-items-center justify-content-center bg-warning-subtle text-warning" style="width: 52px; height: 52px;">
                        <i class="fas fa-clock fs-4"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium d-block mb-1">Menunggu Approval</span>
                        <h3 class="fw-bold text-dark mb-0 stat-number"><?= isset($stats['pending']) ? $stats['pending'] : 0; ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-3 card-hover">
                <div class="d-flex align-items-center">
                    <div class="rounded-4 p-3 me-3 d-flex align-items-center justify-content-center bg-info-subtle text-info" style="width: 52px; height: 52px;">
                        <i class="fas fa-hand-holding-medical fs-4"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium d-block mb-1">Siap Diambil</span>
                        <h3 class="fw-bold text-dark mb-0 stat-number"><?= isset($stats['ready']) ? $stats['ready'] : 0; ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-3 card-hover">
                <div class="d-flex align-items-center">
                    <div class="rounded-4 p-3 me-3 d-flex align-items-center justify-content-center bg-primary-subtle text-primary" style="width: 52px; height: 52px;">
                        <i class="fas fa-check-double fs-4"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-medium d-block mb-1">Selesai</span>
                        <h3 class="fw-bold text-dark mb-0 stat-number"><?= isset($stats['returned']) ? $stats['returned'] : 0; ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Content Area (Split Layout 70% / 30%) -->
    <div class="row g-4">
        <!-- Kiri: Tabel Aktivitas Terbaru -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2 d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Aktivitas Peminjaman Terbaru</h5>
                        <p class="text-muted extra-small mb-0">Pantau pergerakan transaksi pengajuan terakhir Anda.</p>
                    </div>
                    <a href="<?= site_url('history'); ?>" class="btn btn-sm btn-light text-teal fw-bold rounded-3 px-3">
                        Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                
                <div class="card-body p-4 pt-2">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr class="text-muted border-bottom small">
                                    <th class="ps-2 py-3 border-0 fw-semibold">Barang</th>
                                    <th class="py-3 border-0 fw-semibold">Waktu Pinjam</th>
                                    <th class="pe-2 py-3 border-0 text-center fw-semibold">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($recent_borrowings)): ?>
                                    <tr>
                                        <td colspan="3" class="text-center py-5 text-muted small">
                                            <i class="fas fa-inbox fs-2 mb-2 d-block opacity-25"></i>
                                            Belum ada aktivitas peminjaman barang saat ini.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach($recent_borrowings as $row): ?>
                                        <tr class="border-bottom-subtle">
                                            <td class="ps-2 py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-3 bg-light p-1 me-3 border d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                                        <img src="<?= base_url('assets/img/assets/'.$row['photo']); ?>" 
                                                             alt="<?= $row['asset_name']; ?>" 
                                                             class="img-fluid rounded-2" 
                                                             style="max-height: 34px; object-fit: contain;">
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-dark small mb-0"><?= $row['asset_name']; ?></div>
                                                        <span class="text-muted extra-small font-monospace">S/N: <?= $row['asset_code']; ?></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                <?php 
                                                    $timestamp = strtotime($row['requested_start_at']);
                                                    $isValidDate = ($timestamp && $timestamp > 0 && date('Y', $timestamp) > 2000);
                                                ?>
                                                <?php if($isValidDate): ?>
                                                    <div class="fw-medium text-dark small mb-0"><?= date('d M Y', $timestamp); ?></div>
                                                    <div class="text-muted extra-small"><i class="far fa-clock me-1"></i><?= date('H:i', $timestamp); ?> WIB</div>
                                                <?php else: ?>
                                                    <span class="text-muted small">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="pe-2 py-3 text-center">
                                                <?php 
                                                    switch($row['status']) {
                                                        case 'pending':
                                                            echo '<span class="badge badge-amber px-3 py-1 rounded-pill extra-small"><i class="fas fa-spinner fa-spin me-1"></i>Menunggu</span>';
                                                            break;
                                                        case 'in_use':
                                                            echo '<span class="badge badge-emerald px-3 py-1 rounded-pill extra-small"><i class="fas fa-box me-1"></i>Dipinjam</span>';
                                                            break;
                                                        case 'approved':
                                                        case 'ready_for_handover':
                                                            echo '<span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-3 py-1 rounded-pill extra-small"><i class="fas fa-check me-1"></i>Siap Diambil</span>';
                                                            break;
                                                        case 'returned':
                                                            echo '<span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-1 rounded-pill extra-small"><i class="fas fa-check-double me-1"></i>Selesai</span>';
                                                            break;
                                                        case 'canceled':
                                                            echo '<span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-3 py-1 rounded-pill extra-small">Dibatalkan</span>';
                                                            break;
                                                        default:
                                                            echo '<span class="badge badge-red px-3 py-1 rounded-pill extra-small">'.$row['status'].'</span>';
                                                            break;
                                                    }
                                                ?>
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

        <!-- Kanan: Widget Alur Peminjaman -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <div class="d-flex align-items-center mb-2">
                    <div class="rounded-3 bg-teal-subtle text-teal p-2 me-2">
                        <i class="fas fa-route fs-5"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-0">Alur Peminjaman</h5>
                </div>
                <p class="text-muted extra-small mb-4">Panduan mudah peminjaman perangkat medis PT Indo Techno Medic.</p>

                <!-- Vertical Stepper -->
                <div class="position-relative ps-2">
                    <!-- Dashed Connecting Line -->
                    <div class="position-absolute start-0 top-0 bottom-0 ms-3 border-start border-2 border-dashed border-teal opacity-50" style="z-index: 0; margin-top: 15px; margin-bottom: 25px;"></div>

                    <!-- Step 1 -->
                    <div class="d-flex mb-3 position-relative z-1">
                        <div class="me-3 rounded-circle bg-teal text-white fw-bold d-flex align-items-center justify-content-center shadow-sm" 
                             style="width: 32px; height: 32px; flex-shrink: 0; font-size: 0.85rem;">1</div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1 small">Pilih Barang</h6>
                            <p class="text-muted extra-small mb-0">Cari unit di Katalog Aset.</p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="d-flex mb-3 position-relative z-1">
                        <div class="me-3 rounded-circle bg-teal text-white fw-bold d-flex align-items-center justify-content-center shadow-sm" 
                             style="width: 32px; height: 32px; flex-shrink: 0; font-size: 0.85rem;">2</div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1 small">Isi Form Pengajuan</h6>
                            <p class="text-muted extra-small mb-0">Tentukan tanggal & alasan penggunaan.</p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="d-flex mb-3 position-relative z-1">
                        <div class="me-3 rounded-circle bg-teal text-white fw-bold d-flex align-items-center justify-content-center shadow-sm" 
                             style="width: 32px; height: 32px; flex-shrink: 0; font-size: 0.85rem;">3</div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1 small">Persetujuan Admin</h6>
                            <p class="text-muted extra-small mb-0">Tim inventaris menyetujui pengajuan.</p>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="d-flex position-relative z-1">
                        <div class="me-3 rounded-circle bg-navy text-white fw-bold d-flex align-items-center justify-content-center shadow-sm" 
                             style="width: 32px; height: 32px; flex-shrink: 0; font-size: 0.85rem;">4</div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1 small">Ambil & Kembalikan</h6>
                            <p class="text-muted extra-small mb-0">Ambil di gudang & kembalikan tepat waktu.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-teal-subtle { background-color: rgba(13, 148, 136, 0.12) !important; }
.bg-warning-subtle { background-color: rgba(245, 158, 11, 0.12) !important; }
.bg-info-subtle { background-color: rgba(13, 202, 240, 0.12) !important; }
.bg-primary-subtle { background-color: rgba(13, 110, 253, 0.12) !important; }
.bg-navy { background-color: #0F172A !important; }
.border-dashed { border-style: dashed !important; }
</style>