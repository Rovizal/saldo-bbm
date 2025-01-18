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

	#detailGambarPreview {
		max-width: 700px;
		max-height: 700px;
		display: block;
		align-items: center;
		justify-content: center;
		overflow: hidden;
		background-color: #f9f9f9;
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

	<?php $this->load->view('view_sidebar'); ?>

	<!-- Main content -->
	<div class="content-wrapper">

		<!-- Page header -->
		<div class="page-header page-header-light">
			<div class="page-header-content header-elements-md-inline">
				<div class="page-title">
					<h4><i class="icon-clippy"></i>&nbsp;Request</h4>
					<!--<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>-->
				</div>
			</div>
		</div>
		<!-- /page header -->


		<!-- Content area -->
		<div class="content">
			<div class="card">
				<div class="card-header">
					<div class="d-flex">
						<button class="btn btn-sm btn-primary mr-2" data-toggle="modal" data-target="#modalRequest">Tambah Request</button>
						<div>
							<select id="statusFilter" class="form-control select">
								<option value="">-- Semua Status --</option>
								<option value="pending">Pending</option>
								<option value="approved">Approved</option>
								<option value="rejected">Rejected</option>
							</select>
							<input type="hidden" id="statusVal">
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<table class="table table-striped" id="tbl_approval">
								<thead>
									<th>Mobil</th>
									<th>Jenis BBM</th>
									<th>Jumlah</th>
									<th>Harga</th>
									<th>Status</th>
									<th>Approved By</th>
									<th>Date</th>
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
		<div class="modal fade" id="modalRequest" tabindex="-1" role="dialog" aria-labelledby="modalNotif" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title">Request Pengisian BBM</h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form id="formRequestBbm">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Mobil*</label>
										<select name="mobil_id" class="form-control select">
											<option value="">-- Pilih Mobil --</option>
											<?php foreach ($mobil as $car) { ?>
												<option value="<?= $car->mobil_id ?>"><?= $car->merk ?> <?= $car->type ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Jenis BBM*</label>
										<select name="jenis_bbm" class="form-control select">
											<option value="">-- Pilih --</option>
											<option value="pertalite">Pertalite</option>
											<option value="pertamax">Pertamax</option>
											<option value="solar">Solar</option>
											<option value="pertadex">Pertadex</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Jumlah (ltr)*</label>
										<input type="text" maxlength="6" class="form-control" name="jumlah_isi"
											oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class=" modal-footer">
						<button type="button" data-dismiss="modal" class="btn btn-danger">Tutup</button>
						<button type="button" id="btnSubmitRequest" class="btn btn-primary">Simpan</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modalEditRequest" tabindex="-1" role="dialog" aria-labelledby="modalNotif" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title">Edit Request</h3>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form id="formRequestBbmEdit">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Mobil*</label>
										<select name="mobil_id" id="editMobil" class="form-control select">
											<option value="">-- Pilih Mobil --</option>
											<?php foreach ($mobil as $car) { ?>
												<option value="<?= $car->mobil_id ?>"><?= $car->merk ?> <?= $car->type ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Jenis BBM*</label>
										<select name="jenis_bbm" id="editJenis" class="form-control select">
											<option value="">-- Pilih --</option>
											<option value="pertalite">Pertalite</option>
											<option value="pertamax">Pertamax</option>
											<option value="solar">Solar</option>
											<option value="pertadex">Pertadex</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Jumlah (ltr)*</label>
										<input type="text" id="jml_ltr" maxlength="6" class="form-control" name="jumlah_isi"
											oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
									</div>
								</div>
							</div>
							<input type="hidden" id="idRequestEdit" name="idRequest">
						</form>
					</div>
					<div class=" modal-footer">
						<button type="button" data-dismiss="modal" class="btn btn-danger">Tutup</button>
						<button type="button" id="btnSubmitEditRequest" class="btn btn-primary">Simpan</button>
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
<?php $this->load->view('script/request_script'); ?>
<?php $this->load->view('layoutsV2/end_html'); ?>
