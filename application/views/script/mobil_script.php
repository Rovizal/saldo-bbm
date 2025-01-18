<script>
	document.getElementById('gambar_mobil').addEventListener('change', function(event) {
		const file = event.target.files[0]; // Ambil file pertama dari input
		const preview = document.getElementById('preview');
		const errorMessage = document.getElementById('error-message');

		// Reset error message dan preview
		errorMessage.textContent = '';
		preview.innerHTML = '<p>Pratinjau Gambar</p>';

		if (file) {
			// Cek format file
			const validTypes = ['image/jpeg', 'image/png'];
			if (!validTypes.includes(file.type)) {
				errorMessage.textContent = 'Hanya file JPG atau PNG yang diizinkan.';
				return;
			}

			// Gunakan FileReader untuk membaca file
			const reader = new FileReader();
			reader.onload = function(e) {
				// Tampilkan gambar di elemen div
				preview.innerHTML = `<img src="${e.target.result}" alt="Pratinjau Gambar">`;
			};

			reader.readAsDataURL(file); // Membaca file sebagai Data URL
		}
	});

	document.getElementById('gambar_mobil_edit').addEventListener('change', function(event) {
		const file = event.target.files[0]; // Ambil file pertama dari input
		const preview = document.getElementById('previewEdit');
		const errorMessage = document.getElementById('error-message-edit');

		// Reset error message dan preview
		errorMessage.textContent = '';
		preview.innerHTML = '<p>Pratinjau Gambar</p>';

		if (file) {
			// Cek format file
			const validTypes = ['image/jpeg', 'image/png'];
			if (!validTypes.includes(file.type)) {
				errorMessage.textContent = 'Hanya file JPG atau PNG yang diizinkan.';
				return;
			}

			// Gunakan FileReader untuk membaca file
			const reader = new FileReader();
			reader.onload = function(e) {
				// Tampilkan gambar di elemen div
				preview.innerHTML = `<img src="${e.target.result}" alt="Pratinjau Gambar">`;
			};

			reader.readAsDataURL(file); // Membaca file sebagai Data URL
		}
	});

	var tbl_mobil;

	function loadMobil() {
		tbl_mobil = $('#tbl_mobil').DataTable({
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
				url: "<?= base_url('admin/mobil/get_mobil_datatable') ?>",
				dataType: "json",
				type: "GET",
				dataSrc: "data",
			},
			// order: [
			//     [0, 'asc']
			// ],
			bDestroy: true,

			columns: [
				// mengambil & menampilkan kolom sesuai tabel database
				{
					data: 'nomor_plat'
				},
				{
					data: 'merk'
				},
				{
					data: 'type'
				},
				{
					data: 'saldo'
				},
				{
					data: 'jarak_tempuh_per_liter'
				},
				{
					data: 'jarak_tempuh'
				},
				{
					data: 'bbm_terpakai'
				},
				{
					data: 'saldo'
				}
			],
			createdRow: function(row, data, index) {},
			rowCallback: function(row, data) {
				$('td:eq(0)', row).html(
					`${data.nomor_plat}`
				);
				$('td:eq(1)', row).html(
					`${data.merk}`
				);
				$('td:eq(2)', row).html(
					`${data.type}`
				);
				$('td:eq(3)', row).html(
					`${data.saldo} liter`
				);
				$('td:eq(4)', row).html(
					`${data.jarak_tempuh_per_liter} km/ltr`
				);
				$('td:eq(5)', row).html(
					`${data.jarak_tempuh} km`
				);
				$('td:eq(6)', row).html(
					`${data.bbm_terpakai}`
				);
				$('td:eq(7)', row).html(
					`<div class="d-flex justify-content-start">
						<button data-id="${data.mobil_id}" class="btn btn-sm btn-info mr-1 viewDetail"><icon class="icon-eye"></icon></button>
						<button data-id="${data.mobil_id}" class="btn btn-sm btn-danger mr-1 deleteData"><icon class="icon-trash"></icon></button>
						<button data-id="${data.mobil_id}" class="btn btn-sm btn-warning editData"><icon class="icon-pencil"></icon></button>
					</div>
					`
				);
			}
		});
	}

	loadMobil();

	$(document).ready(function() {
		$('#btnSubmitMobil').on('click', async function() {
			// Ambil elemen form
			const form = $('#formTambahMobil')[0];
			const formData = new FormData(form);

			const merk = formData.get('merek');
			const tipe = formData.get('tipe');
			const nomorPlat = formData.get('nomor_plat');
			const jarak_tempuh_perliter = formData.get('jarak_tempuh_perliter');
			const saldoAwal = formData.get('saldo_awal');
			const fileInput = $('#gambar_mobil')[0].files[0];

			if (fileInput) {
				const validExtensions = ['image/jpeg', 'image/png'];
				const maxFileSize = 2 * 1024 * 1024;

				if (!validExtensions.includes(fileInput.type)) {
					toastr.error('Hanya file dengan format JPG atau PNG yang diizinkan.');
					return;
				}

				if (fileInput.size > maxFileSize) {
					toastr.error('Ukuran file maksimal 2MB!');
					return;
				}

				formData.append('gambar_mobil', fileInput);
			} else {
				toastr.error('Harap pilih file gambar.');
				return;
			}

			if (!merk || !tipe || !nomorPlat || !saldoAwal) {
				toastr.error('Harap isi semua data yang diperlukan.');
				return;
			}

			try {
				const url = "<?= base_url('admin/mobil/save_mobil') ?>";
				const response = await fetch(url, {
					method: 'POST',
					body: formData
				});

				if (!response.ok) {
					toastr.error('Gagal menyimpan data. Silakan coba lagi.');
				}

				const dataRespon = await response.json();
				if (dataRespon.statusCode === 200) {
					toastr.success(dataRespon.message || 'Data berhasil disimpan!');

					$('#preview').empty();
					$('#formTambahMobil')[0].reset();
					$('#modalTambahMobil').modal('hide');
					loadMobil();
				} else {
					toastr.error('Terjadi kesalahan: ' + (dataRespon.message || 'Tidak diketahui.'));
				}
			} catch (error) {
				console.error('Error:', error);
				toastr.error('Gagal menyimpan data. Silakan coba lagi.');
			}
		});

		$('#merkMobil').change(function() {
			const idMerek = $(this).val();

			// Kosongkan dropdown tipe mobil jika merek tidak dipilih
			if (!idMerek) {
				$('#tipe').html('<option value="">-- Pilih Tipe --</option>');
				return;
			}

			// Ajax untuk mendapatkan tipe mobil
			$.ajax({
				url: "<?= base_url('admin/mobil/get_tipe_mobil'); ?>",
				type: "POST",
				data: {
					id_merek: idMerek
				},
				dataType: "json",
				success: function(response) {
					let options = '<option value="">-- Pilih Tipe --</option>';
					response.forEach(function(tipe) {
						options += `<option value="${tipe.nama_tipe}">${tipe.nama_tipe}</option>`;
					});
					$('#tipe').html(options);
				}
			});
		});

		$('#merkMobilEdit').change(function() {
			const idMerek = $(this).val();

			// Kosongkan dropdown tipe mobil jika merek tidak dipilih
			if (!idMerek) {
				$('#tipeMobilEdit').html('<option value="">-- Pilih Tipe --</option>');
				return;
			}

			// Ajax untuk mendapatkan tipe mobil
			$.ajax({
				url: "<?= base_url('admin/mobil/get_tipe_mobil'); ?>",
				type: "POST",
				data: {
					id_merek: idMerek
				},
				dataType: "json",
				success: function(response) {
					let options = '<option value="">-- Pilih Tipe --</option>';
					response.forEach(function(tipe) {
						options += `<option value="${tipe.nama_tipe}">${tipe.nama_tipe}</option>`;
					});
					$('#tipeMobilEdit').html(options);
				}
			});
		});
	});

	$(document).on('click', '.viewDetail', async function(e) {
		e.preventDefault();
		const mobil_id = $(this).data('id');
		if (!mobil_id) {
			Swal.fire('Not found')
		}
		window.location.href = "<?= base_url('admin/mobil/detail?data=') ?>" + base64UrlSafeEncode(mobil_id)
	});

	$(document).on('click', '.deleteData', async function(e) {
		e.preventDefault();

		const mobil_id = $(this).data('id');

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
			return; // Tidak melakukan apa pun jika pengguna membatalkan
		}

		try {
			const url = `<?= base_url('admin/mobil/delete_mobil') ?>?id=${btoa(mobil_id)}`;
			const response = await fetch(url, {
				method: 'DELETE'
			});

			if (!response.ok) {
				toastr.error('Gagal menghapus data. Silakan coba lagi.');
				return;
			}

			const dataRespon = await response.json();

			if (dataRespon.statusCode === 200) {
				loadMobil();
				toastr.success('Data berhasil dihapus.');
			} else {
				toastr.error(dataRespon.message || 'Terjadi kesalahan saat menghapus data.');
			}
		} catch (error) {
			console.error('Error:', error);
			toastr.error('Gagal menghapus data. Silakan coba lagi.');
		}
	});

	$(document).on('click', '.editData', async function(e) {
		e.preventDefault();

		let idMobil = $(this).data('id');

		try {
			const url = "<?= base_url('admin/mobil/get_edit_request?data=') ?>" + base64UrlSafeEncode(idMobil);
			const response = await fetch(url, {
				method: 'GET'
			});

			if (response.ok) {
				const result = await response.json();
				if (result.statusCode === 200) {
					const data = result.data;
					const tipe = result.tipe_mobil;
					const merkId = result.merk_id;

					$('#merkMobilEdit').val(merkId).trigger('change');

					$('#nomor_plat_edit').val(data.nomor_plat);
					$('#jarak_tempuh_perliter_edit').val(data.jarak_tempuh_per_liter);
					$('#saldo_awal_edit').val(data.saldo_awal);
					$('#previewEdit').html(`<img src="<?= base_url('uploads/') ?>${data.gambar_mobil}" alt="Pratinjau Gambar">`);
					$('#idMobilEdit').val(data.mobil_id);

					setTimeout(() => {
						$('#tipeMobilEdit').val(data.type).trigger('change');
					}, 1000);

					$('#modalEditMobil').modal('show');
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

	$(document).on('click', '#btnSubmitMobilEdit', async function(e) {
		// Ambil elemen form
		const form = $('#formEditMobil')[0];
		const formData = new FormData(form);

		const merk = formData.get('merek');
		const tipe = formData.get('tipe');
		const nomorPlat = formData.get('nomor_plat');
		const jarak_tempuh_perliter = formData.get('jarak_tempuh_perliter');
		const fileInput = $('#gambar_mobil_edit')[0].files[0];

		if (fileInput) {
			const validExtensions = ['image/jpeg', 'image/png'];
			const maxFileSize = 2 * 1024 * 1024;

			if (!validExtensions.includes(fileInput.type)) {
				toastr.error('Hanya file dengan format JPG atau PNG yang diizinkan.');
				return;
			}

			if (fileInput.size > maxFileSize) {
				toastr.error('Ukuran file maksimal 2MB!');
				return;
			}

			formData.append('gambar_mobil', fileInput);
		}

		if (!merk || !tipe || !nomorPlat) {
			toastr.error('Harap isi semua data yang diperlukan.');
			return;
		}
		formData.append('mobil_id', $('#idMobilEdit').val());
		try {
			const url = "<?= base_url('admin/mobil/update_mobil') ?>";
			const response = await fetch(url, {
				method: 'POST',
				body: formData
			});

			if (!response.ok) {
				toastr.error('Gagal menyimpan data. Silakan coba lagi.');
			}

			const dataRespon = await response.json();
			if (dataRespon.statusCode === 200) {
				toastr.success(dataRespon.message || 'Data berhasil diupdate!');

				$('#previewEdit').empty();
				$('#formEditMobil')[0].reset();
				$('#modalEditMobil').modal('hide');
				loadMobil();
			} else {
				toastr.error('Terjadi kesalahan: ' + (dataRespon.message || 'Tidak diketahui.'));
			}
		} catch (error) {
			console.error('Error:', error);
			toastr.error('Gagal update data. Silakan coba lagi.');
		}
	})
</script>
