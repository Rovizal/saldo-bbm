<script>
	var tbl_history_mobil;
	var idMobil = '<?= $mobil_id ?>';

	function loadHistory() {
		tbl_history_mobil = $('#tbl_history_mobil').DataTable({
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
			// "columnDefs": [{
			//     orderable: false,
			//     targets: [0, 1]
			// }],
			// "rowReorder": {
			//     "selector": 'td:nth-child(2)'
			// },
			// "responsive": true,
			"ajax": {
				url: "<?= base_url('sopir/mobil/get_history_mobil_datatable?data=') ?>" + base64UrlSafeEncode(idMobil),
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
					data: 'tipe_aktivitas'
				},
				{
					data: 'jumlah_saldo'
				},
				{
					data: 'keterangan'
				},
				{
					data: 'created_at'
				}
			],
			rowCallback: function(row, data) {
				$('td:eq(0)', row).html(data.tipe_aktivitas || '-');
				$('td:eq(1)', row).html((data.jumlah_saldo || 0) + ' liter');
				$('td:eq(2)', row).html(data.keterangan || '-');
				$('td:eq(3)', row).html(data.created_at || '-');
			}
		});
	}
</script>
