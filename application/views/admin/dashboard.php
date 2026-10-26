<div class="container-fluid p-4">

    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden card-hover">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-medium">Total Inventaris</span>
                        <div class="rounded-3 p-2 bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-box fs-5"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold text-dark mb-0 stat-number"><?= isset($total_asset) ? number_format($total_asset) : 0; ?></h2>
                </div>
                <div class="card-footer bg-light border-0 py-2 px-3">
                    <a href="<?= site_url('asset'); ?>" class="text-primary text-decoration-none extra-small fw-bold d-flex align-items-center justify-content-between">
                        Kelola Aset <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden card-hover">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-medium">Tersedia / Bebas</span>
                        <div class="rounded-3 p-2 bg-success bg-opacity-10 text-success">
                            <i class="fas fa-check-circle fs-5"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold text-dark mb-0 stat-number"><?= isset($asset_available) ? number_format($asset_available) : 0; ?></h2>
                </div>
                <div class="card-footer bg-light border-0 py-2 px-3">
                    <a href="<?= site_url('asset?status=available'); ?>" class="text-success text-decoration-none extra-small fw-bold d-flex align-items-center justify-content-between">
                        Lihat Unit Bebas <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden card-hover">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-medium">Sedang Dipinjam</span>
                        <div class="rounded-3 p-2 bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-clock fs-5"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold text-dark mb-0 stat-number"><?= isset($asset_borrowed) ? number_format($asset_borrowed) : 0; ?></h2>
                </div>
                <div class="card-footer bg-light border-0 py-2 px-3">
                    <a href="<?= site_url('borrowing'); ?>" class="text-warning text-darken text-decoration-none extra-small fw-bold d-flex align-items-center justify-content-between">
                        Pantau Transaksi <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden card-hover">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted small fw-medium">Dalam Perbaikan</span>
                        <div class="rounded-3 p-2 bg-danger bg-opacity-10 text-danger">
                            <i class="fas fa-wrench fs-5"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold text-dark mb-0 stat-number"><?= isset($asset_maintenance) ? number_format($asset_maintenance) : 0; ?></h2>
                </div>
                <div class="card-footer bg-light border-0 py-2 px-3">
                    <a href="<?= site_url('maintenance'); ?>" class="text-danger text-decoration-none extra-small fw-bold d-flex align-items-center justify-content-between">
                        Cek Servis <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 p-3 mb-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h6 class="fw-bold text-dark mb-0"><i class="fas fa-bolt text-warning me-2"></i>Aksi Cepat Admin</h6>
            <span class="text-muted extra-small">Pintasan Pintar</span>
        </div>
        <div class="row g-2">
            <div class="col-md-3 col-6">
                <a href="<?= site_url('asset/add'); ?>" class="btn btn-outline-teal w-100 rounded-pill py-2 small fw-bold text-truncate shadow-sm-hover">
                    <i class="fas fa-plus-circle me-1"></i> Tambah Aset Baru
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?= site_url('borrowing?status=pending'); ?>" class="btn btn-outline-warning w-100 rounded-pill py-2 small fw-bold text-truncate shadow-sm-hover">
                    <i class="fas fa-file-signature me-1"></i> Persetujuan Pinjam
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?= site_url('assignment/add'); ?>" class="btn btn-outline-primary w-100 rounded-pill py-2 small fw-bold text-truncate shadow-sm-hover">
                    <i class="fas fa-user-check me-1"></i> Beri Penugasan
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="<?= site_url('report'); ?>" class="btn btn-outline-secondary w-100 rounded-pill py-2 small fw-bold text-truncate shadow-sm-hover">
                    <i class="fas fa-print me-1"></i> Cetak Laporan
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h6 class="fw-bold text-dark mb-0">Tren Peminjaman Bulanan</h6>
                        <small class="text-muted extra-small">Statistik penggunaan aset medis & IT tahun ini</small>
                    </div>
                    <span class="badge bg-teal bg-opacity-10 text-teal border border-teal border-opacity-25 rounded-pill px-2 py-1 extra-small">Grafik Realtime</span>
                </div>
                <div class="chart-container position-relative flex-grow-1" style="min-height: 250px;">
                    <canvas id="monthlyBorrowingChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="fw-bold text-dark mb-0">Menunggu Persetujuan Anda</h6>
                        <small class="text-muted extra-small">Pengajuan pinjaman terbaru dari karyawan</small>
                    </div>
                    <a href="<?= site_url('borrowing?status=pending'); ?>" class="text-teal extra-small fw-bold text-decoration-none">Semua</a>
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <tbody>
                                <?php if(empty($pending_requests)): ?>
                                    <tr>
                                        <td colspan="2" class="text-center py-4 text-muted small">
                                            <i class="fas fa-check-circle fs-3 text-success d-block mb-2 opacity-50"></i>
                                            Tidak ada pengajuan pending saat ini.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach($pending_requests as $row): ?>
                                        <tr class="border-bottom-subtle">
                                            <td class="ps-2 py-3">
                                                <div class="fw-bold text-dark small"><?= $row['user_name']; ?></div>
                                                <div class="text-muted extra-small"><?= $row['asset_name']; ?></div>
                                                <span class="text-muted extra-small font-monospace"><i class="far fa-clock me-1"></i><?= date('d M Y, H:i', strtotime($row['requested_start_at'])); ?></span>
                                            </td>
                                            <td class="text-end pe-2 py-3">
                                                <div class="d-flex gap-1 justify-content-end">
                                                    <a href="<?= site_url('borrowing/approve/'.$row['id']); ?>" class="btn btn-sm btn-success rounded-pill px-2 py-1 extra-small fw-bold" title="Setujui">
                                                        <i class="fas fa-check me-1"></i> Setujui
                                                    </a>
                                                    <a href="<?= site_url('borrowing/reject/'.$row['id']); ?>" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1 extra-small fw-bold" title="Tolak" onclick="return confirm('Tolak pengajuan ini?');">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                </div>
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
    </div>
</div>

<style>
.btn-outline-teal {
    color: #0D9488;
    border-color: #0D9488;
}
.btn-outline-teal:hover {
    background-color: #0D9488;
    color: #FFFFFF;
}
.shadow-sm-hover {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.shadow-sm-hover:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('monthlyBorrowingChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Jumlah Peminjaman',
                data: [12, 19, 15, 25, 22, 30, 28, 35, 40, 32, 0, 0],
                backgroundColor: '#0D9488',
                borderRadius: 8,
                borderSkipped: false,
                barThickness: 18
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { family: 'Plus Jakarta Sans', size: 11 } }
                },
                y: {
                    grid: { color: '#E2E8F0', borderDash: [4, 4] },
                    ticks: { font: { family: 'Plus Jakarta Sans', size: 11 }, beginAtZero: true }
                }
            }
        }
    });
});
</script>