<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi Peminjaman - PT Indo Techno Medic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 12px; color: #1e293b; }
        .text-teal { color: #0d9488 !important; }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; margin: 0; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container py-4">
        <!-- Tombol Aksi (Hanya tampil di layar, tersembunyi saat dicetak) -->
        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <button onclick="window.print()" class="btn btn-primary btn-sm rounded-3"><i class="fas fa-print me-1"></i> Cetak Dokumen</button>
            <button onclick="window.close()" class="btn btn-secondary btn-sm rounded-3">Tutup Halaman</button>
        </div>

        <!-- Kop Surat Laporan -->
        <div class="text-center border-bottom pb-3 mb-4">
            <h3 class="fw-bold mb-0 text-dark">PT INDO TECHNO MEDIC</h3>
            <p class="mb-1 text-muted">Laporan Resmi Transaksi Peminjaman & Pengembalian Aset</p>
            <small class="text-secondary">Dicetak pada: <?= date('d F Y, H:i'); ?> WIB</small>
        </div>

        <!-- Tabel Laporan Transaksi -->
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th width="4%" class="text-center">No</th>
                    <th width="12%">Kode Pinjam</th>
                    <th width="18%">Nama Peminjam</th>
                    <th width="22%">Barang / Aset</th>
                    <th width="14%">Tgl Pinjam</th>
                    <th width="14%">Tgl Kembali</th>
                    <th width="16%" class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($borrowings)): ?>
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada data transaksi peminjaman.</td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach($borrowings as $row): ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td class="font-monospace fw-bold text-teal">
                                <?= !empty($row['borrowing_code']) ? $row['borrowing_code'] : 'TRX-'.str_pad($row['id'], 4, '0', STR_PAD_LEFT); ?>
                            </td>
                            <td class="fw-semibold"><?= !empty($row['user_name']) ? $row['user_name'] : '-'; ?></td>
                            <td>
                                <div class="fw-bold"><?= !empty($row['asset_name']) ? $row['asset_name'] : '-'; ?></div>
                                <?php if(!empty($row['asset_code'])): ?>
                                    <small class="text-muted font-monospace">S/N: <?= $row['asset_code']; ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php 
                                    $tgl_start = !empty($row['requested_start_at']) ? $row['requested_start_at'] : (!empty($row['start_date']) ? $row['start_date'] : null);
                                    echo $tgl_start ? date('d/m/Y H:i', strtotime($tgl_start)) : '-';
                                ?>
                            </td>
                            <td>
                                <?php 
                                    $tgl_end = !empty($row['requested_end_at']) ? $row['requested_end_at'] : (!empty($row['end_date']) ? $row['end_date'] : null);
                                    echo $tgl_end ? date('d/m/Y H:i', strtotime($tgl_end)) : '-';
                                ?>
                            </td>
                            <td class="text-center fw-bold">
                                <?php 
                                    $st = strtolower($row['status'] ?? '');
                                    switch($st) {
                                        case 'pending':
                                            echo '<span class="text-warning">Menunggu</span>';
                                            break;
                                        case 'approved':
                                            echo '<span class="text-info">Disetujui</span>';
                                            break;
                                        case 'in_use':
                                            echo '<span class="text-success">Dipinjam</span>';
                                            break;
                                        case 'returned':
                                            echo '<span class="text-primary">Selesai</span>';
                                            break;
                                        case 'rejected':
                                            echo '<span class="text-danger">Ditolak</span>';
                                            break;
                                        default:
                                            echo '<span class="text-secondary">'.$st.'</span>';
                                            break;
                                    }
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="row mt-5 pt-3">
            <div class="col-8"></div>
            <div class="col-4 text-center">
                <p class="mb-5">Mengetahui,<br><strong>Super Admin PT Indo Techno Medic</strong></p>
                <p class="mt-4 mb-0"><u>( ________________________ )</u></p>
            </div>
        </div>
    </div>
</body>
</html> 