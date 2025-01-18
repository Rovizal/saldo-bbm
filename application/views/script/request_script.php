<script>
	var tbl_approval;

	function loadRequest() {
		tbl_approval = $('#tbl_approval').DataTable({
			dom: "<'row'" +
				"<'col-sm-6 heading align-self-center'" + ">" +
				"<'col-sm-6 d-flex align-items-center justify-content-end gap-2 flex-wrap flex-sm-nowrap filter_tabs'fl>" +
				">" +

				"<'table-responsive'tr>" +

				"<'row'" +
				"<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
				"<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
				">",
			language: {
				"lengthMenu": "_MENU_",
				"search": "",
				"searchPlaceholder": "Cari ...",
				"emptyTable": "Tidak ada data"
			},
			columnDefs: [{
				"defaultContent": "-",
				"targets": "_all"
			}],
			"serverSide": true,
			"processing": true,
			"pageLength": 10,
			"ajax": {
				url: "<?= base_url('sopir/request/get_request_datatable') ?>",
				dataType: "json",
				type: "GET",
				dataSrc: "data",
				data: function(d) {
					d.status = $('#statusVal').val();
				}
			},
			// order: [
			//     [0, 'asc']
			// ],
			bDestroy: true,

			columns: [
				// mengambil & menampilkan kolom sesuai tabel database
				{
					data: 'nama_mobil'
				},
				{
					data: 'jenis_bbm'
				},
				{
					data: 'jumlah_liter'
				},
				{
					data: 'harga'
				},
				{
					data: 'status'
				},
				{
					data: 'approved_by'
				},
				{
					data: 'approved_by'
				},
				{
					data: 'status'
				},
			],
			createdRow: function(row, data, index) {},
			rowCallback: function(row, data) {
				$('td:eq(0)', row).html(
					`${data.nama_mobil}`
				);
				$('td:eq(1)', row).html(
					`${data.jenis_bbm}`
				);
				$('td:eq(2)', row).html(
					`${data.jumlah_liter} liter`
				);
				$('td:eq(3)', row).html(
					`${data.harga}`
				);
				$('td:eq(4)', row).html(
					(() => {
						switch (data.status) {
							case 'pending':
								return `<span class="badge badge-warning">Pending</span>`;
							case 'approved':
								return `<span class="badge badge-success">Approved</span>`;
							case 'rejected':
								return `<span class="badge badge-danger">Rejected</span>`;
							default:
								return `<span class="badge badge-secondary">Unknown</span>`;
						}
					})()
				);
				$('td:eq(5)', row).html(
					`${data.approved_by || '-'} `
				);

				$('td:eq(6)', row).html(
					`${data.created_at || '-'} `
				);

				let btn;

				if (data.status === 'approved') {
					btn = `<div class="d-flex justify-content-start">
								<button data-id="${data.request_id}" class="btn btn-sm btn-info disabled" disabled><i class="icon-pencil"></i></button>
								<button data-id="${data.request_id}" class="btn btn-sm btn-danger disabled" disabled><i class="icon-trash"></i></button>
							</div>
							`;
				} else {
					btn = `<div class="d-flex justify-content-start">
								<button data-id="${data.request_id}" class="btn btn-sm btn-info editRequest"><i class="icon-pencil"></i></button>
								<button data-id="${data.request_id}" class="btn btn-sm btn-danger deleteRequest"><i class="icon-trash"></i></button>
							</div>
							`;
				}

				$('td:eq(7)', row).html(btn);
			}
		});
	}

	loadRequest();

	$(document).ready(function() {
		$('#statusFilter').on('change', function() {
			$('#statusVal').val($(this).val());
			loadRequest(); // Reload data dengan parameter filter
		});
	});

	$(document).on('click', '#btnSubmitRequest', async function(e) {
		e.preventDefault();

		const form = document.getElementById('formRequestBbm');
		const formData = new FormData(form);

		const mobilId = formData.get('mobil_id');
		const jenisBbm = formData.get('jenis_bbm');
		const jumlahIsi = formData.get('jumlah_isi');

		if (!mobilId || !jenisBbm || !jumlahIsi) {
			toastr.error('Harap isi semua kolom yang wajib diisi.');
			return;
		}

		try {
			const url = "<?= base_url('sopir/request/submit_bbm') ?>";
			const response = await fetch(url, {
				method: 'POST',
				body: formData,
			});

			if (response.ok) {
				const result = await response.json();
				if (result.statusCode === 200) {
					toastr.success('Request BBM berhasil dikirim.');
					form.reset();
					$('#modalRequest').modal('hide');
					loadRequest();
				} else {
					toastr.error(result.message || 'Gagal mengirim request.');
				}
			} else {
				const error = await response.json();
				toastr.error(error.message || 'Terjadi kesalahan pada server.');
			}
		} catch (err) {
			console.error('Error:', err);
			toastr.error('Gagal mengirim request. Silakan coba lagi.');
		}
	});

	$(document).on('click', '.editRequest', async function(e) {
		e.preventDefault();

		let idRequest = $(this).data('id');

		try {
			const url = "<?= base_url('sopir/request/get_edit_request?data=') ?>" + base64UrlSafeEncode(idRequest);
			const response = await fetch(url, {
				method: 'GET'
			});

			if (response.ok) {
				const result = await response.json();
				if (result.statusCode === 200) {
					const data = result.data;
					$('#editMobil').val(data.mobil_id).trigger('change');
					$('#editJenis').val(data.jenis_bbm).trigger('change');
					$('#jml_ltr').val(data.jumlah_liter);
					$('#idRequestEdit').val(data.request_id);
					$('#modalEditRequest').modal('show');
				} else {
					toastr.error(result.message || 'Gagal mengirim request.');
				}
			} else {
				const error = await response.json();
				toastr.error(error.message || 'Terjadi kesalahan pada server.');
			}
		} catch (err) {
			console.error('Error:', err);
			toastr.error('Gagal mengirim request. Silakan coba lagi.');
		}
	});

	$(document).on('click', '#btnSubmitEditRequest', async function(e) {
		e.preventDefault();

		const form = document.getElementById('formRequestBbmEdit');
		const formData = new FormData(form);

		const mobilId = formData.get('mobil_id');
		const jenisBbm = formData.get('jenis_bbm');
		const jumlahIsi = formData.get('jumlah_isi');

		if (!mobilId || !jenisBbm || !jumlahIsi) {
			toastr.error('Harap isi semua kolom yang wajib diisi.');
			return;
		}

		try {
			const url = "<?= base_url('sopir/request/update_request') ?>";
			const response = await fetch(url, {
				method: 'POST',
				body: formData,
			});

			if (response.ok) {
				const result = await response.json();
				if (result.statusCode === 200) {
					toastr.success('Request berhasil di-update.');
					form.reset();
					$('#modalEditRequest').modal('hide');
					loadRequest();
				} else {
					toastr.error(result.message || 'Gagal mengirim request.');
				}
			} else {
				const error = await response.json();
				toastr.error(error.message || 'Terjadi kesalahan pada server.');
			}
		} catch (err) {
			console.error('Error:', err);
			toastr.error('Gagal mengirim request. Silakan coba lagi.');
		}
	});

	$(document).on('click', '.deleteRequest', async function(e) {
		e.preventDefault();

		const request_id = $(this).data('id');

		const confirmation = await Swal.fire({
			title: 'Apakah Anda yakin?',
			text: 'Data yang sudah dihapus tidak dapat dikembalikan!',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3085d6',
			confirmButtonText: 'Ya, hapus!',
			cancelButtonText: 'Batal',
			allowOutsideClick: false,
			reverseButtons: true,
		});

		if (!confirmation.isConfirmed) {
			return;
		}

		try {
			const url = `<?= base_url('sopir/request/delete_request') ?>?id=${btoa(request_id)}`;
			const response = await fetch(url, {
				method: 'DELETE'
			});

			if (!response.ok) {
				toastr.error('Gagal menghapus data. Silakan coba lagi.');
				return;
			}

			const dataRespon = await response.json();

			if (dataRespon.statusCode === 200) {
				loadRequest();
				toastr.success('Data berhasil dihapus.');
			} else {
				toastr.error(dataRespon.message || 'Terjadi kesalahan saat menghapus data.');
			}
		} catch (error) {
			console.error('Error:', error);
			toastr.error('Gagal menghapus data. Silakan coba lagi.');
		}
	});
</script>
