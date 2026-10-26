<div class="container-fluid px-4">
    <div class="mb-4">
        <h4 class="fw-bold text-dark">Data Transaksi Peminjaman</h4>
        <p class="text-muted small">Kelola persetujuan dan serah terima aset perusahaan.</p>
    </div>

    <!-- Alerts -->
    <?php if($this->session->flashdata('success_msg')): ?>
        <div class="alert alert-success border-0 shadow-sm"><i class="fas fa-check-circle me-2"></i> <?= $this->session->flashdata('success_msg'); ?></div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error_msg')): ?>
        <div class="alert alert-danger border-0 shadow-sm"><i class="fas fa-times-circle me-2"></i> <?= $this->session->flashdata('error_msg'); ?></div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">Kode Pinjam</th>
                            <th class="py-3">Peminjam</th>
                            <th class="py-3">Barang Aset</th>
                            <th class="py-3">Waktu Pinjam</th>
                            <th class="py-3 text-center">Status</th>
                            <th class="py-3 text-center">Tindakan Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($transactions)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-clipboard-list fs-1 mb-3 opacity-50"></i>
                                    <p class="mb-0">Belum ada transaksi pengajuan peminjaman.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($transactions as $row): ?>
                                <tr>
                                    <td class="px-4 font-monospace text-secondary fw-bold small"><?= $row['borrowing_code']; ?></td>
                                    <td>
                                        <div class="fw-bold text-dark"><?= $row['user_name']; ?></div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-primary"><?= $row['asset_name']; ?></div>
                                        <div class="text-muted small font-monospace"><?= $row['asset_code']; ?></div>
                                    </td>
                                    <td>
                                        <div class="text-dark small"><?= date('d M Y, H:i', strtotime($row['requested_start_at'])); ?></div>
                                        <div class="text-muted small">s/d <?= date('d M Y', strtotime($row['requested_end_at'])); ?></div>
                                    </td>
                                    <td class="text-center">
                                        <?php 
                                            $badges = [
                                                'pending' => ['Pending', 'warning'],
                                                'approved' => ['Disetujui', 'info'],
                                                'in_use' => ['Dipinjam', 'success'],
                                                'returned' => ['Selesai', 'secondary'],
                                                'rejected' => ['Ditolak', 'danger'],
                                                'canceled' => ['Batal', 'dark']
                                            ];
                                            // Cek apakah status dari database ada di daftar array $badges
                                            if (isset($badges[$row['status']])) {
                                                $st = $badges[$row['status']];
                                            } else {
                                                // Jika kosong atau tidak dikenali, gunakan status default (abu-abu)
                                                $st = ['Tidak Diketahui', 'secondary']; 
                                            }
                                        ?>
                                        <span class="badge bg-<?= $st[1]; ?> bg-opacity-10 text-<?= $st[1]; ?> border border-<?= $st[1]; ?> border-opacity-25 px-2 py-1">
                                            <?= $st[0]; ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <!-- LOGIKA TOMBOL DINAMIS BERDASARKAN STATUS -->
                                        
                                        <!-- Jika masih Pending -> Muncul tombol Approve & Reject -->
                                        <?php if($row['status'] == 'pending'): ?>
                                            <a href="<?= site_url('transaction/approve/'.$row['id']); ?>" class="btn btn-sm btn-success text-white mb-1" onclick="return confirm('Setujui peminjaman ini?');" title="Setujui">
                                                <i class="fas fa-check"></i>
                                            </a>
                                            <a href="<?= site_url('transaction/reject/'.$row['id']); ?>" class="btn btn-sm btn-danger text-white mb-1" onclick="return confirm('Tolak peminjaman ini?');" title="Tolak">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        
                                        <!-- Jika sudah Approved -> Muncul tombol Serah Terima Fisik -->
                                        <?php elseif($row['status'] == 'approved'): ?>
                                            <a href="<?= site_url('transaction/handover/'.$row['id']); ?>" class="btn btn-sm btn-primary text-white" onclick="return confirm('Apakah barang fisik sudah diserahkan ke karyawan?');">
                                                <i class="fas fa-hand-holding"></i> Serah Terima
                                            </a>
                                            
                                        <!-- Jika sedang Dipinjam (In Use) -> Muncul tombol Kembalikan -->
                                        <?php elseif($row['status'] == 'in_use'): ?>
                                            <a href="<?= site_url('transaction/return_asset/'.$row['id']); ?>" class="btn btn-sm btn-warning text-dark fw-bold" onclick="return confirm('Pastikan barang sudah Anda terima kembali secara fisik dengan baik.');">
                                                <i class="fas fa-undo"></i> Kembalikan
                                            </a>
                                            
                                        <!-- Jika status Selesai/Tolak/Batal -> Tidak ada tombol aksi -->
                                        <?php else: ?>
                                            <span class="text-muted small"><i class="fas fa-lock"></i> Selesai</span>
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