<script>
	var tbl_activity;

	function loadActivity() {
		tbl_activity = $('#tbl_activity').DataTable({
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
				url: "<?= base_url('sopir/activity/get_activity_datatable') ?>",
				dataType: "json",
				type: "GET",
				dataSrc: "data"
			},
			// order: [
			//     [0, 'asc']
			// ],
			bDestroy: true,

			columns: [{
					data: 'nama_mobil'
				},
				{
					data: 'jarak_tempuh_aktifitas'
				},
				{
					data: 'bbm_terpakai'
				},
				{
					data: 'created_at'
				},
			],
			createdRow: function(row, data, index) {},
			rowCallback: function(row, data) {
				$('td:eq(0)', row).html(
					`${data.nama_mobil}`
				);
				$('td:eq(1)', row).html(
					`${data.jarak_tempuh_aktifitas}`
				);
				$('td:eq(2)', row).html(
					`${data.bbm_terpakai} liter`
				);
				$('td:eq(3)', row).html(
					`${data.created_at}`
				);
			}
		});
	}

	loadActivity();

	$(document).ready(function() {
		$('#statusFilter').on('change', function() {
			$('#statusVal').val($(this).val());
			loadActivity(); // Reload data dengan parameter filter
		});
	});

	$(document).on('click', '#btnSubmitActivity', async function(e) {
		e.preventDefault();

		const form = document.getElementById('formActivity');
		const formData = new FormData(form);

		const mobilId = formData.get('mobil_id');
		const jarak_tempuh_aktifitas = formData.get('jarak_tempuh_aktifitas');

		if (!mobilId || !jarak_tempuh_aktifitas) {
			toastr.error('Harap isi semua kolom yang wajib diisi.');
			return;
		}

		// Konfirmasi jika data tidak bisa diubah atau dihapus
		const confirmation = await Swal.fire({
			title: 'Konfirmasi',
			text: 'Data ini tidak bisa diubah atau dihapus setelah disimpan. Lanjutkan?',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, simpan!',
			cancelButtonText: 'Batal',
			allowOutsideClick: false,
			reverseButtons: true,
			width: '400px'
		});

		if (!confirmation.isConfirmed) {
			toastr.info('Aksi dibatalkan.');
			return;
		}

		try {
			const url = "<?= base_url('sopir/activity/submit_activity') ?>";
			const response = await fetch(url, {
				method: 'POST',
				body: formData,
			});

			if (response.ok) {
				const result = await response.json();
				if (result.statusCode === 200) {
					toastr.success(result.message || 'Aktivitas berhasil disimpan.');
					$('#mobilSelect').val('').trigger('change');
					$('#jartem').val('');
					$('#modalActivity').modal('hide');
					loadActivity(); // Panggil fungsi untuk memuat ulang aktivitas
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
</script>
