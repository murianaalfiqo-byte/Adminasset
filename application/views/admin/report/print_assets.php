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
        /* Perintah CSS agar tidak mencetak elemen yang tidak perlu */
        @media print {
            @page { margin: 1cm; }
        }
    </style>
</head>
<!-- Fungsi window.print() akan otomatis memanggil dialog Print saat halaman terbuka -->
<body onload="window.print()">

    <div class="header">
        <h2>Laporan Inventaris Aset Perusahaan</h2>
        <p>Sistem Informasi Manajemen Aset (AssetFlow)</p>
        <p>Dicetak pada: <?= date('d F Y - H:i'); ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Kode Aset</th>
                <th width="30%">Nama Barang</th>
                <th width="15%">Kategori</th>
                <th width="15%">Lokasi</th>
                <th width="10%" class="text-center">Kondisi</th>
                <th width="10%" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($assets)): ?>
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data aset ditemukan.</td>
                </tr>
            <?php else: ?>
                <?php $no = 1; foreach($assets as $row): ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td><?= $row['asset_code']; ?></td>
                        <td>
                            <strong><?= $row['name']; ?></strong><br>
                            <small><?= $row['brand']; ?> <?= $row['model']; ?></small>
                        </td>
                        <td><?= $row['category_name']; ?></td>
                        <td><?= $row['location_name']; ?></td>
                        <td class="text-center"><?= strtoupper($row['condition_status']); ?></td>
                        <td class="text-center"><?= strtoupper($row['operational_status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Tempat Tanda Tangan -->
    <div class="footer-ttd">
        <div class="ttd-box">
            <p>Mengetahui,<br>Administrator Sistem</p>
            <strong><?= $this->session->userdata('name'); ?></strong>
        </div>
    </div>

</body>
</html>