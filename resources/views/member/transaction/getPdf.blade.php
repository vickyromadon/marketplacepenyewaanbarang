<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Surat Perjanjian</title>
</head>

<style>
	.tabelPihak1 tr td{
		padding: 0px 10px 0px 0px;
	}
</style>

<body>
	<?php
		function tanggal_indo($tanggal, $cetak_hari = false) 
		{ 
			$hari = array ( 1 => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu' );
			$bulan = array (1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember' ); 

			$split = explode('-', $tanggal); 
			
			$tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0]; 
			
			if ($cetak_hari) { 
				$num = date('N', strtotime($tanggal)); return $hari[$num] . ', ' . $tgl_indo; 
			} 
			return $tgl_indo; 
		}
	?>

	<header>
		<center>
			<h3>Surat Perjanjian Sewa Menyewa Barang</h3>
		</center>
	</header>

	<div>
		<p>
			Pada hari ini, <?= tanggal_indo(date('Y-m-d'), true); ?>, Kami yang bertanda tangan di bawah ini:
		</p>
		<table class="tabelPihak1">
			<tr>
				<td>Nama</td>
				<td>:</td>
				<td>{{ $transaction->booking->user->name }}</td>
			</tr>
			<tr>
				<td>Alamat</td>
				<td>:</td>
				<td>{{ $transaction->booking->user->address }}</td>
			</tr>
			<tr>
				<td>No. KTP</td>
				<td>:</td>
				<td>{{ $transaction->booking->user->identity_card->number }}</td>
			</tr>
		</table>
		<p>
			selanjutnya disebut <b>PIHAK PERTAMA.</b>
		</p>
		<table>
			<tr>
				<td style="padding: 0px 55px 0px 0px;">Nama</td>
				<td style="padding: 0px 20px 0px 0px;">:</td>
				<td>{{ $transaction->booking->product->user->name }}</td>
			</tr>
			<tr>
				<td style="padding: 0px 55px 0px 0px;">Alamat</td>
				<td style="padding: 0px 20px 0px 0px;">:</td>
				<td>{{ $transaction->booking->product->user->address }}</td>
			</tr>
			<tr>
				<td>No. KTP</td>
				<td style="padding: 0px 20px 0px 0px;">:</td>
				<td>{{ $transaction->booking->product->user->identity_card->number }}</td>
			</tr>
		</table>
		<p>
			selanjutnya disebut <b>PIHAK KEDUA.</b>
		</p>
		<p>
			Kedua pelah pihak terlebih dahulu menerangkan hal-hal sebagai berikut :
		</p>

		<ol>
			<li>
				Bahwa pada tangal <?= tanggal_indo(date('Y-m-d'), true); ?>, <b>PIHAK PERTAMA</b> telah mengajukan permohonan penyewaan barang sebanyak {{ $transaction->booking->quantity }} item berupa {{ $transaction->booking->product->name }} dengan total keseluruhan Rp. {{ number_format($transaction->grand_total) }},- dengan rincian yaitu harga barang per {{ $transaction->booking->product->time_periode }} Rp. {{ number_format($transaction->booking->product->price) }}, uang jaminan per barang {{ number_format($transaction->booking->product->deposite) }}, dan barang disewakan selama {{ $transaction->total_periode }} {{ $transaction->booking->product->time_periode }}. 
			</li>
			<br>
			<!-- <li>
				Bahwa atas pengajuan <b>PIHAK PERTAMA, PIHAK KEDUA</b> telah meyetujui untuk menyewakan {{ $transaction->booking->product->name }} dengan nilai Rp. {{ number_format($transaction->booking->product->price) }},- kepada <b>PIHAK PERTAMA</b> dari pada <?= tanggal_indo($transaction->booking->start_rent); ?>.
			</li>
			<br> -->
			<li>
				<b>PIHAK PERTAMA</b> dan <b>PIHAK KEDUA</b> telah sepakat bahwa proses penyewaan barang yang telah disebutkan diatas oleh <b>PIHAK PERTAMA</b> dari <b>PIHAK KEDUA</b> dimulai pada tanggal <?= tanggal_indo($transaction->booking->start_rent); ?> dan berakhir pada <?= tanggal_indo($transaction->booking->end_rent); ?>.
			</li>
			<br>
			<li>
				<b>PIHAK PERTAMA</b> (penyewa) bertanggung jawab penuh atas kerusakan, kehilangan, maupun hal-hal lain yang terjadi pada barang yang disewakan selama masa sewa masih berjalan. 
			</li>
			<br>
			<li>
				<b>PIHAK PERTAMA</b> (penyewa) tidak diperkenankan memutuskan penyewaan sebelum akhir masa sewa barang, kecuali atas persetujuan dari <b>PIHAK KEDUA</b>.
			</li>
			<br>
			<li>
				<b>PIHAK KEDUA</b> tidak diperkenankan memutuskan penyewaan barang sebelum akhir masa sewa, kecuali atas persetujuan dari <b>PIHAK PERTAMA</b>.
			</li>
		</ol>
		<p>Demikian surat perjanjian ini dibuat, agar dapat digunakan sebagaimana mestinya.</p>
	</div>

	<p style="margin-left: 80%;">Medan, <?= tanggal_indo(date('Y-m-d')); ?></p>

	<div>
		<span style="margin-left: 20%">Pihak Pertama</span>
		<span style="margin-left: 40%;">Pihak Kedua</span>

		<div style="margin-left: 10%; margin-top: 10px; width: 100px; height: 60px; border: 1px solid #000;">
			<center>MATERAI <br> 6000</center>
		</div>

		<div style="margin-left: 63%; margin-top: -62px; width: 100px; height: 60px; border: 1px solid #000;">
			<center>MATERAI <br> 6000</center>
		</div>

		<div style="margin-top:60px; margin-left: 10%; width: 200px; border-top: 1px solid #000;"></div>
		<div style="margin-top:60px; margin-left: 63%; width: 200px; border-top: 1px solid #000;"></div>
	</div>
</body>
</html>


	