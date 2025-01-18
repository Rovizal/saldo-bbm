<script>
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
				url: "<?= base_url('sopir/mobil/get_mobil_datatable') ?>",
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
						<button data-id="${data.mobil_id}" class="btn btn-sm btn-info viewDetail"><icon class="icon-eye"></icon></button>
					</div>
					`
				);
			}
		});
	}

	loadMobil();

	$(document).on('click', '.viewDetail', async function(e) {
		e.preventDefault();
		const mobil_id = $(this).data('id');
		if (!mobil_id) {
			Swal.fire('Not found')
		}
		window.location.href = "<?= base_url('sopir/mobil/detail?data=') ?>" + base64UrlSafeEncode(mobil_id)
	});
</script>
