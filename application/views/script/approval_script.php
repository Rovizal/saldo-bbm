<script>
	var tbl_approval;

	function loadApproval() {
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

			"serverSide": true,
			"processing": true,
			"pageLength": 10,
			// "columnDefs": [{
			//     orderable: false,
			//     targets: [0, 1]
			// }],
			// "rowReorder": {
			//     "selector": 'td:nth-child(2)'
			// },
			// "responsive": true,
			"ajax": {
				url: "<?= base_url('admin/approval/get_approval_datatable') ?>",
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
					`${data.approved_by} `
				);
				$('td:eq(6)', row).html(
					(() => {
						if (data.status == 'pending') {
							return `<div class="d-flex justify-content-start">
											<button data-id="${data.request_id}" class="btn btn-sm btn-info mr-1 approveRequest">Approve</button>
											<button data-id="${data.request_id}" class="btn btn-sm btn-danger rejectRequest">Reject</button>
										</div>
										`;
						} else {
							return `-`
						}
					})()
				);
			}
		});
	}

	loadApproval();

	$(document).ready(function() {
		$('#statusFilter').on('change', function() {
			$('#statusVal').val($(this).val());
			loadApproval(); // Reload data dengan parameter filter
		});
	});

	$(document).on('click', '.approveRequest', async function(e) {
		e.preventDefault();

		const request_id = $(this).data('id');

		const confirmation = await Swal.fire({
			title: 'Apakah Anda yakin?',
			text: 'Setujui request untuk isi BBM',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, Lanjutkan!',
			cancelButtonText: 'Batal',
			allowOutsideClick: false,
			reverseButtons: true,
		});

		if (!confirmation.isConfirmed) {
			return;
		}
		const form = new FormData();
		form.append('request_id', request_id);
		try {
			const url = `<?= base_url('admin/approval/approve_request') ?>`;
			const response = await fetch(url, {
				method: 'POST',
				body: form
			});

			if (!response.ok) {
				toastr.error('Gagal. Silakan coba lagi.');
				return;
			}

			const dataRespon = await response.json();

			if (dataRespon.statusCode === 200) {
				loadApproval();
				toastr.success('Data berhasil disetujui.');
			} else {
				toastr.error(dataRespon.message || 'Terjadi kesalahan.');
			}
		} catch (error) {
			console.error('Error:', error);
			toastr.error('Gagal. Silakan coba lagi.');
		}
	});

	$(document).on('click', '.rejectRequest', async function(e) {
		e.preventDefault();

		const request_id = $(this).data('id');

		const confirmation = await Swal.fire({
			title: 'Apakah Anda yakin?',
			text: 'Permintaan yang sudah ditolak tidak dapat dikembalikan!',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, tolak!',
			cancelButtonText: 'Batal',
			allowOutsideClick: false,
			reverseButtons: true,
		});

		if (!confirmation.isConfirmed) {
			return; // Tidak melakukan apa pun jika pengguna membatalkan
		}
		const form = new FormData();
		form.append('request_id', request_id);
		try {
			const url = `<?= base_url('admin/approval/reject_request') ?>`;
			const response = await fetch(url, {
				method: 'POST',
				body: form
			});

			if (!response.ok) {
				toastr.error('Gagal menolak data. Silakan coba lagi.');
				return;
			}

			const dataRespon = await response.json();

			if (dataRespon.statusCode === 200) {
				loadApproval();
				toastr.success('Data berhasil ditolak.');
			} else {
				toastr.error(dataRespon.message || 'Terjadi kesalahan saat menolak data.');
			}
		} catch (error) {
			console.error('Error:', error);
			toastr.error('Gagal menolak data. Silakan coba lagi.');
		}
	});
</script>
