function search(e) {
	e.preventDefault();
	let formData = new FormData;
	formData.append("data", $("#input").val());
	$('#button').attr('disabled', true);
	$('#button').html('Loading...');
	document.querySelector("#data").innerHTML = "";
	$.ajax({
		url: 'search.php',
		type: 'post',
		data: formData,
		processData: false,
		contentType: false,

		success: (data) => {
			let name = (data.name != null) ? data.name : "Pasien Tidak Ditemukan";

			$("#name").html(name);

			data.tgl.forEach((dats) => {
				let tr = document.createElement("tr");
				let td = document.createElement("td");
				let tdAksi = document.createElement("td");
				let button = document.createElement("a");

				button.setAttribute("href", "rekap_rm.php?idKunj="+dats.id);
				button.innerHTML = "Lihat";
				button.classList.add('btn', 'btn-success');

				td.innerHTML = dats.tgl;

				tr.append(td);
				tr.append(tdAksi);
				tdAksi.append(button);

				document.querySelector("#data").append(tr);;

			});

			$("#search").modal('show');
		},

		error: (error) => {
			alert("Terjadi Kesalahan Harap Refresh Halaman");
		},
		complete: () => {
			$('#button').attr('disabled', false);
			$('#button').html('Cari Pasien');
		}

	});
};