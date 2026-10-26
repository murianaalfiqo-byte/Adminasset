<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; margin: 0; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 15px; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 20px; text-transform: uppercase; letter-spacing: 1px; }
        .header p { margin: 5px 0 0 0; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        table, th, td { border: 1px solid #333; }
        th { background-color: #f4f4f4; padding: 10px; text-align: left; }
        td { padding: 8px 10px; }
        .text-center { text-align: center; }
        .footer-ttd { width: 100%; margin-top: 40px; }
        .ttd-box { float: right; width: 250px; text-align: center; }
        .ttd-box p { margin: 0 0 70px 0; }
        @media print {
            @page { margin: 1cm; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>Laporan Transaksi Peminjaman Aset</h2>
        <p>Sistem Informasi Manajemen Aset (AssetFlow)</p>
        <p>Dicetak pada: <?= date('d F Y - H:i'); ?> WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="15%">Kode Pinjam</th>
                <th width="20%">Nama Peminjam</th>
                <th width="25%">Barang Aset</th>
                <th width="15%">Waktu Pinjam</th>
                <th width="15%" class="text-center">Status Transaksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($transactions)): ?>
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data transaksi.</td>
                </tr>
            <?php else: ?>
                <?php $no = 1; foreach($transactions as $row): ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td><?= $row['borrowing_code']; ?></td>
                        <td><strong><?= $row['user_name']; ?></strong></td>
                        <td><?= $row['asset_name']; ?><br><small><?= $row['asset_code']; ?></small></td>
                        <td><?= date('d M Y', strtotime($row['requested_start_at'])); ?></td>
                        <td class="text-center">
                            <?php 
                                $status_indo = [
                                    'pending' => 'Menunggu',
                                    'approved' => 'Disetujui',
                                    'in_use' => 'Dipinjam',
                                    'returned' => 'Selesai',
                                    'rejected' => 'Ditolak',
                                    'canceled' => 'Dibatalkan'
                                ];
                                echo strtoupper($status_indo[$row['status']]); 
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer-ttd">
        <div class="ttd-box">
            <p>Mengetahui,<br>Administrator Sistem</p>
            <strong><?= $this->session->userdata('name'); ?></strong>
        </div>
    </div>

</body>
</html>