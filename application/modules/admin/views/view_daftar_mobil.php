<?php
defined('BASEPATH') or exit('No direct script access allowed');
$this->load->view('layoutsV2/begin_html_admin');
$this->load->view('layoutsV2/navbar_admin');
?>

<style>
	#preview {
		max-width: 100%;
		max-height: 350px;
		border: 2px dashed #ccc;
		display: flex;
		align-items: center;
		justify-content: center;
		overflow: hidden;
		background-color: #f9f9f9;
	}

	#previewEdit {
		max-width: 100%;
		max-height: 350px;
		border: 2px dashed #ccc;
		display: flex;
		align-items: center;
		justify-content: center;
		overflow: hidden;
		background-color: #f9f9f9;
	}

	#detailGambarPreview {
		max-width: 700px;
		max-height: 700px;
		display: block;
		align-items: center;
		justify-content: center;
		overflow: hidden;
		background-color: #f9f9f9;
	}

	#previewEdit img {
		max-width: 100%;
		max-height: 100%;
	}

	#preview img {
		max-width: 100%;
		max-height: 100%;
	}

	.error {
		color: red;
		font-size: 14px;
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
					<h4><i class="icon-car"></i>&nbsp;Daftar Mobil</h4>
					<!--<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>-->
				</div>
			</div>
		</div>
		<!-- /page header -->


		<!-- Content area -->
		<div class="content">
			<div class="card">
				<div class="card-header">
					<button class="btn btn-primary" data-toggle="modal" data-target="#modalTambahMobil">Tambah Mobil</button>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<table class="table table-striped" id="tbl_mobil">
								<thead>
									<th>Nomor Plat</th>
									<th>Merk</th>
									<th>Type</th>
									<th>Isi Tangki</th>
									<th>Jarak Tempuh</th>
									<!-- <th>Total Saldo</th> -->
									<th>Total Jelajah</th>
									<th>Total BBM</th>
									<th>Action</th>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!-- /main charts -->

		</div>
		<!-- /content area -->

		<!-- MODAL AREA -->
		<div class="modal fade" id="modalTambahMobil" tabindex="-1" role="dialog" aria-labelledby="modalNotif" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title">Tambah Mobil</h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form id="formTambahMobil">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Merk Mobil*</label>
										<select name="merek" id="merkMobil" class="form-control select">
											<option value="">-- Pilih Merek --</option>
											<option value="1">Toyota</option>
											<option value="2">Honda</option>
											<option value="3">Suzuki</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Tipe Mobil*</label>
										<select id="tipe" name="tipe" class="form-control select">
											<option value="">-- Pilih Tipe --</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Nomor Plat*</label>
										<input type="text" class="form-control" name="nomor_plat">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Jarak Tempuh Perliter (km)*</label>
										<input type="text" maxlength="3" class="form-control" name="jarak_tempuh_perliter" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
									</div>
								</div>
								<div class="col-md-6">
									<div id="preview">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Saldo Awal BBM (ltr)*</label>
										<input type="text" maxlength="3" class="form-control" name="saldo_awal" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Foto*</label>
										<input type="file" class="form-control" id="gambar_mobil" accept=".jpg, .jpeg, .png" capture="environment">
										<small class="error" id="error-message"></small>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class=" modal-footer">
						<button type="button" data-dismiss="modal" class="btn btn-danger">Tutup</button>
						<button type="button" id="btnSubmitMobil" class="btn btn-primary">Simpan</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modalEditMobil" tabindex="-1" role="dialog" aria-labelledby="modalNotif" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title">Edit Mobil</h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form id="formEditMobil">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Merk Mobil*</label>
										<select name="merek" id="merkMobilEdit" class="form-control select">
											<option value="">-- Pilih Merek --</option>
											<option value="1">Toyota</option>
											<option value="2">Honda</option>
											<option value="3">Suzuki</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Tipe Mobil*</label>
										<select name="tipe" id="tipeMobilEdit" class="form-control select">
											<option value="">-- Pilih Tipe --</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Nomor Plat*</label>
										<input type="text" class="form-control" id="nomor_plat_edit" name="nomor_plat">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Jarak Tempuh Perliter (km)*</label>
										<input type="text" maxlength="3" class="form-control" id="jarak_tempuh_perliter_edit" name="jarak_tempuh_perliter" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
									</div>
								</div>
								<div class="col-md-6">
									<div id="previewEdit">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Saldo Awal BBM (ltr)*</label>
										<input type="text" maxlength="3" class="form-control" id="saldo_awal_edit" readonly>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Foto*</label>
										<input type="file" class="form-control" id="gambar_mobil_edit" accept=".jpg, .jpeg, .png" capture="environment">
										<small class="error" id="error-message-edit"></small>
									</div>
								</div>
							</div>
							<input type="hidden" id="idMobilEdit" name="id_mobil_edit">
						</form>
					</div>
					<div class=" modal-footer">
						<button type="button" data-dismiss="modal" class="btn btn-danger">Tutup</button>
						<button type="button" id="btnSubmitMobilEdit" class="btn btn-primary">Simpan</button>
					</div>
				</div>
			</div>
		</div>
		<!-- END MODAL AREA -->
		<?php $this->load->view('layoutsV2/footer'); ?>

	</div>
	<!-- /main content -->

</div>
<!-- /page content -->
<?php $this->load->view('script/mobil_script'); ?>
<?php $this->load->view('layoutsV2/end_html'); ?>
