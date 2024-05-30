<html>
<head>
	<title>Cetak PDF</title>
	<style>
    .table {
        border-collapse:collapse;
        table-layout:fixed;width: 630px;
    }
    .table th {
        padding: 5px;
    }
    .table td {
        word-wrap:break-word;
        width: 20%;
        padding: 5px;
    }
	</style>
</head>
<body>
    <h4 style="margin-bottom: 5px;">Data Transaksi</h4>
	<?php echo $label ?>

	<table class="table" border="1" width="100%" style="margin-top: 10px;">
		<tr>
			<th>Tanggal</th>
			<th>Kode Transaksi</th>
			<th>Barang</th>
			<th>Jumlah</th>
			<th>Total Harga</th>
		</tr>

		<?php
        if(empty($transaksi)){ // Jika data tidak ada
            echo "<tr><td colspan='5'>Data tidak ada</td></tr>";
        }else{ // Jika jumlah data lebih dari 0 (Berarti jika data ada)
            foreach($transaksi as $data){ // Looping hasil data transaksi
                $tgl = date('d-m-Y', strtotime($data->waktu_pelaporan)); // Ubah format tanggal jadi dd-mm-yyyy

                echo "<tr>";
                echo "<td style='width: 80px;'>".$waktu_pelaporan."</td>";
                echo "<td style='width: 100px;'>".$data->no_tiket."</td>";
                echo "<td style='width: 300px;'>".$data->nama."</td>";
                echo "<td style='width: 60px;'>".$data->perihal."</td>";
                echo "<td style='width: 100px;'>".$data->status_ccs."</td>";
                echo "</tr>";
            }
        }
		?>
	</table>
</body>
</html>
