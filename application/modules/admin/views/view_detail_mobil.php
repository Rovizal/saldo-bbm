<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('layoutsV2/begin_html_admin');
$this->load->view('layoutsV2/navbar_admin');
?>

<style>
	.nav-tabs .nav-link.active {
		background-color: #007bff;
		color: white;
		border-color: #007bff;
	}

	.nav-tabs .nav-link {
		color: #007bff;
	}

	.nav-tabs .nav-link:hover {
		color: #0056b3;
	}

	.nav-link:hover {
		cursor: pointer;
		/* Ubah kursor menjadi pointer */
	}
</style>
<!-- Page content -->
<div class="page-content">

	<?php $this->load->view('view_sidebar_admin'); ?>

	<!-- Main content -->
	<div class="content-wrapper">

		<!-- Page header -->
		<div class="page-header page-header-light">
			<div class="page-header-content header-elements-md-inline">
				<div class="page-title">
					<h4><i class="icon-car"></i>&nbsp;Detail Mobil</h4>
					<!--<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>-->
				</div>
			</div>
		</div>
		<!-- /page header -->


		<!-- Content area -->
		<div class="content">
			<div class="card">
				<div class="card-header">
					<a href="<?= base_url('admin/mobil') ?>" class="btn btn-primary btn-sm"><i class="icon-arrow-left7"></i> Kembali</a>
				</div>
				<div class="card-body">
					<div class="row mb-3">
						<div class="col-md-6 d-flex justify-content-center">
							<img src="<?= base_url('uploads/' . $gambar_mobil) ?>" alt="Gambar Mobil" style="max-height:300px;max-width:100%;">
						</div>
						<div class="col-md-6">
							<p style="font-size:60px;font-weight:bold;"><?= $nomor_plat ?></p>
							<p class="mb-0 mt-3" style="font-size:40px;font-weight:bold;color:#a64c11"><?= $saldo_awal ?> liter</p>
							<small><i>*BBM di tangki saat ini</i></small>
							<p class="mb-0 mt-3" style="font-size:40px;font-weight:bold;color:#007bff"><?= $liter_per_100km ?> liter / 100km</p>
							<small><i>*Konsumsi BBM rata-rata per 100 km</i></small>
						</div>
					</div>
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item" role="presentation">
							<button class="nav-link active" id="data-mobil-tab" data-toggle="tab" data-target="#dataMobil" type="button" role="tab" aria-controls="home" aria-selected="true">Data Mobil</button>
						</li>
						<li class="nav-item" role="presentation">
							<button onclick="loadHistory()" class="nav-link" id="history-tab" data-toggle="tab" data-target="#history" type="button" role="tab" aria-controls="profile" aria-selected="false">History</button>
						</li>
						<li class="nav-item" role="presentation">
							<button onclick="loadActivity()" class="nav-link" id="perjalanan-tab" data-toggle="tab" data-target="#perjalanan" type="button" role="tab" aria-controls="profile" aria-selected="false">Perjalanan</button>
						</li>
					</ul>
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show active" id="dataMobil" role="tabpanel" aria-labelledby="home-tab">
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label style="font-weight: bold;">Merek</label>
										<p id="merkView"><?= $merk ?></p>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label style="font-weight: bold;">Tipe</label>
										<p id="tipeView"><?= $type ?></p>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label style="font-weight: bold;">Isi Tangki Saat ini</label>
										<p id="tangkiView"><?= $saldo_awal ?> liter</p>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label style="font-weight: bold;">Jarak Tempuh Per Liter Mobil</label>
										<p id="jartemView"><?= $jarak_tempuh_per_liter ?> km/l</p>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label style="font-weight: bold;">Total Jelajah</label>
										<p id="tojelView"><?= $jarak_tempuh ?> km</p>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label style="font-weight: bold;">Total BBM Terpakai</label>
										<p id="tobemTerView"><?= $total_bbm_terpakai ?> liter</p>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label style="font-weight: bold;">Total Pengeluaran (Rp)</label>
										<p id="topengView">Rp. <?= number_format($biaya_bbm, 0, '.', '.') ?></p>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="profile-tab">
							<table class="table" id="tbl_history_mobil">
								<thead>
									<tr>
										<th>Aktivitas</th>
										<th>Jumlah</th>
										<th>Keterangan</th>
										<th>Tanggal</th>
									</tr>
								</thead>
							</table>
						</div>
						<div class="tab-pane fade" id="perjalanan" role="tabpanel" aria-labelledby="profile-tab">
							<table class="table table-striped" id="tbl_activity">
								<thead>
									<th>Supir</th>
									<th>Jarak Tempuh</th>
									<th>BBM Terpakai</th>
									<th>Tanggal</th>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!-- /main charts -->

		</div>
		<!-- /content area -->
		<?php $this->load->view('layoutsV2/footer'); ?>

	</div>
	<!-- /main content -->

</div>
<!-- /page content -->
<?php $this->load->view('script/mobil_detail_script'); ?>
<?php $this->load->view('layoutsV2/end_html'); ?>
