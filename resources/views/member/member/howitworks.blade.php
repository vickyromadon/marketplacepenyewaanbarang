@extends('layouts.app')

@section('css')
	<style>
		.divFA{
			margin: 10px 0px; 
			padding: 0px;
		}

		.divFA p{
			font-size: 20px;
		}
	</style>
@endsection

@section('content')
	<div class="work-section">
		<div class="container">
			<h2 class="head text-center">Cara Kerja</h2>
			
			<div class="col-md-6">
				<h3 class="head text-center">Apakah Anda ingin menyewa produk ?</h3>

				<div class="col-md-12 work-section-grid divFA">
					<div class="col-md-2">
						<i class="fa fa-search"></i>
					</div>
					<div class="col-md-10">
						<p>
							Jelajahi kategori rental kami atau Cari produk.
						</p>
					</div>
				</div>
				<div class="col-md-12 work-section-grid divFA" style="margin-top: -50px;">
					<div class="col-md-2">
						<i class="fa fa-phone"></i>
					</div>
					<div class="col-md-10">
						<p>
							Hubungi pemilik untuk produk yang ingin Anda sewa.
						</p>
					</div>
				</div>
				<div class="col-md-12 work-section-grid divFA" style="margin-top: -50px;">
					<div class="col-md-2">
						<i class="fa fa-cube"></i>
					</div>
					<div class="col-md-10">
						<p>
							Dapatkan detail produk (biaya sewa, ketersediaan, dll.).
						</p>
					</div>
				</div>
				<div class="col-md-12 work-section-grid divFA" style="margin-top: -50px;">
					<div class="col-md-2">
						<i class="fa fa-money"></i>
					</div>
					<div class="col-md-10">
						<p>
							Lakukan pembayaran yang diperlukan dengan memilih metode pembayaran yang tersedia dan mengambil produk.
						</p>
					</div>
				</div>
				<div class="col-md-12 work-section-grid divFA" style="margin-top: -50px;">
					<div class="col-md-2">
						<i class="fa fa-hand-lizard-o"></i>
					</div>
					<div class="col-md-10">
						<p>
							Setelah masa sewa berakhir, kembalikan produk langsung ke pemilik dan ambil kembali uang jaminan (jika ada).
						</p>
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<h3 class="head text-center">Apakah Anda seorang individu yang memiliki beberapa produk yang tidak terpakai ? Iklankan di Rentoncome untuk disewakan.</h3>

				<div class="col-md-12 work-section-grid divFA">
					<div class="col-md-2">
						<i class="fa fa-pencil"></i>
					</div>
					<div class="col-md-10">
						<p>
							Daftarkan diri Anda di Rentoncome sebagai pemilik.
						</p>
					</div>
				</div>
				<div class="col-md-12 work-section-grid divFA" style="margin-top: -50px;">
					<div class="col-md-2">
						<i class="fa fa-cubes"></i>
					</div>
					<div class="col-md-10">
						<p>
							Buat daftar produk yang ingin Anda sewa di Rentoncome.
						</p>
					</div>
				</div>
				<div class="col-md-12 work-section-grid divFA" style="margin-top: -50px;">
					<div class="col-md-2">
						<i class="fa fa-pencil-square-o"></i>
					</div>
					<div class="col-md-10">
						<p>
							Isi detail produk Anda dengan jelas.
						</p>
					</div>
				</div>
				<div class="col-md-12 work-section-grid divFA" style="margin-top: -50px;">
					<div class="col-md-2">
						<i class="fa fa-user-secret"></i>
					</div>
					<div class="col-md-10">
						<p>
							Admin menyetujui daftar Anda dan barang Anda terdaftar secara GRATIS.
						</p>
					</div>
				</div>
				<div class="col-md-12 work-section-grid divFA" style="margin-top: -50px;">
					<div class="col-md-2">
						<i class="fa fa-question"></i>
					</div>
					<div class="col-md-10">
						<p>
							Terima pertanyaan dari penyewa.
						</p>
					</div>
				</div>
				<div class="col-md-12 work-section-grid divFA" style="margin-top: -50px;">
					<div class="col-md-2">
						<i class="fa fa-check-square-o"></i>
					</div>
					<div class="col-md-10">
						<p>
							Sewa produk Anda ke penyewa pilihan Anda.
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection