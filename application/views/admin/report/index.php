<div class="container-fluid p-4">
    <div class="mb-4">
        <h4 class="fw-bold text-dark mb-1">Laporan & Analitik</h4>
        <p class="text-muted extra-small mb-0">Ringkasan kondisi inventaris dan opsi cetak dokumen.</p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 text-white h-100 p-4 position-relative overflow-hidden" 
                 style="background: linear-gradient(135deg, #0D9488 0%, #0F172A 100%);">
                <div class="position-relative z-1 d-flex flex-column justify-content-between h-100">
                    <div>
                        <span class="text-white text-opacity-75 extra-small fw-bold text-uppercase d-block mb-1">
                            Total Nilai Investasi Aset
                        </span>
                        <h2 class="fw-bold text-white mb-2 stat-number">
                            Rp <?= isset($total_investment) ? number_format($total_investment, 0, ',', '.') : '0'; ?>
                        </h2>
                        <p class="text-white text-opacity-75 extra-small mb-0">
                            Total harga beli seluruh aset yang tercatat dan aktif di sistem saat ini.
                        </p>
                    </div>
                </div>
                <i class="fas fa-coins position-absolute end-0 bottom-0 me-3 mb-n2 text-white opacity-10 d-none d-sm-block" style="font-size: 7rem; pointer-events: none;"></i>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-4">
                <h6 class="fw-bold text-dark mb-3">Status Kondisi Fisik Aset</h6>
                <div class="row g-3">
                    <div class="col-6 col-sm-3">
                        <div class="rounded-4 p-3 text-center border border-success border-opacity-25 bg-success bg-opacity-10 h-100 d-flex flex-column justify-content-center">
                            <h3 class="fw-bold text-success mb-1 stat-number"><?= isset($condition['bagus']) ? $condition['bagus'] : 0; ?></h3>
                            <span class="extra-small fw-semibold text-success">Bagus</span>
                        </div>
                    </div>
                    <div class="col-6 col-sm-3">
                        <div class="rounded-4 p-3 text-center border border-warning border-opacity-25 bg-warning bg-opacity-10 h-100 d-flex flex-column justify-content-center">
                            <h3 class="fw-bold text-warning mb-1 stat-number"><?= isset($condition['layak']) ? $condition['layak'] : 0; ?></h3>
                            <span class="extra-small fw-semibold text-warning">Layak</span>
                        </div>
                    </div>
                    <div class="col-6 col-sm-3">
                        <div class="rounded-4 p-3 text-center border border-danger border-opacity-25 bg-danger bg-opacity-10 h-100 d-flex flex-column justify-content-center">
                            <h3 class="fw-bold text-danger mb-1 stat-number"><?= isset($condition['rusak']) ? $condition['rusak'] : 0; ?></h3>
                            <span class="extra-small fw-semibold text-danger">Rusak</span>
                        </div>
                    </div>
                    <div class="col-6 col-sm-3">
                        <div class="rounded-4 p-3 text-center border border-secondary border-opacity-25 bg-secondary bg-opacity-10 h-100 d-flex flex-column justify-content-center">
                            <h3 class="fw-bold text-secondary mb-1 stat-number"><?= isset($condition['hilang']) ? $condition['hilang'] : 0; ?></h3>
                            <span class="extra-small fw-semibold text-secondary">Hilang</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h6 class="fw-bold text-dark mb-3">Cetak Dokumen Laporan</h6>
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="rounded-circle bg-teal-subtle text-teal p-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                        <i class="fas fa-file-invoice fs-4"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Laporan Daftar Aset</h5>
                    <p class="text-muted extra-small mb-4">Cetak seluruh daftar aset perusahaan yang sedang aktif beserta kondisinya.</p>
                </div>
                <div>
                    <a href="<?= site_url('report/print_assets'); ?>" target="_blank" class="btn btn-primary bg-teal border-0 fw-bold rounded-3 px-4 py-2 w-100">
                        <i class="fas fa-print me-2"></i> Cetak Aset
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="rounded-circle bg-warning-subtle text-warning p-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                        <i class="fas fa-file-signature fs-4"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Laporan Transaksi</h5>
                    <p class="text-muted extra-small mb-4">Cetak seluruh riwayat peminjaman aset oleh karyawan (Disetujui/Ditolak).</p>
                </div>
                <div>
                    <a href="<?= site_url('report/print_transactions'); ?>" target="_blank" class="btn btn-warning text-dark fw-bold rounded-3 px-4 py-2 w-100">
                        <i class="fas fa-print me-2"></i> Cetak Transaksi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-teal-subtle { background-color: rgba(13, 148, 136, 0.12) !important; }
.bg-warning-subtle { background-color: rgba(245, 158, 11, 0.12) !important; }
.bg-teal { background-color: #0D9488 !important; }
.text-teal { color: #0D9488 !important; }
</style 4>