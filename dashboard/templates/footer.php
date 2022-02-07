<?php
?>
<script src="<?= $BASE_URL ?>/assets/plugins/Chart.js-master/dist/Chart.bundle.min.js"></script>
<script src="<?= $BASE_URL ?>/assets/js/popper.min.js"></script>
<script src="<?= $BASE_URL ?>/assets/js/bootstrap.min.js"></script>
<script src="<?= $BASE_URL ?>/assets/js/jquery-3.3.1.min.js"></script>

<script>
	var myChart, myChart2, myChart3, myChart4;
	var tahunRender = new Date();

	$('#type-filter').on('change', function() {
		if ($(this).val() == 1) {
			$('#tahun').hide();
			$('#bulan').hide();
			$('#hari').hide();
			$('#periode').show();
		} else if ($(this).val() == 2) {
			$('#periode').hide()
			$('#bulan').hide();
			$('#hari').hide();
			$('#tahun').show();
		} else if ($(this).val() == 3) {
			$('#periode').hide()
			$('#tahun').hide();
			$('#hari').hide();
			$('#bulan').show();
		}
	});

	function renderChart(data, labels, title = '-', val, elm) {
		var ctx = elm.getContext('2d');
		if (myChart) myChart.destroy();
		myChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: labels,
				datasets: [{
					label: title,
					backgroundColor: 'rgb(13, 110, 253)',
					borderColor: 'rgb(254, 83, 187)',
					data: data,
				}]
			},
			options: {
				tooltips: {
					callbacks: {
						label: function(tooltipItem, data) {
							var label = data.datasets[tooltipItem.datasetIndex].label || '';
							if (label) label += ': ';
							label += val == 'getPelayanan' ? tooltipItem.yLabel : new Intl.NumberFormat('id-ID', {
								style: 'currency',
								currency: 'IDR'
							}).format(tooltipItem.yLabel);
							return label;
						}
					}
				},
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true,
							fontColor: 'white'
						},
						gridLines: {
							display: true,
							color: 'white',
							lineWidth: 1
						},
					}],
					xAxes: [{
						ticks: {
							fontColor: 'white'
						},
						gridLines: {
							display: false,
							color: 'white',
							lineWidth: 1
						},
					}]
				}
			}
		});
	}

	function renderChart2(data, labels, title = '-', val, elm) {
		var ctx = elm.getContext('2d');
		if (myChart2) myChart2.destroy();
		myChart2 = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: labels,
				datasets: [{
					label: title,
					backgroundColor: 'rgb(220, 53, 69)',
					borderColor: 'rgb(254, 83, 187)',
					data: data,
				}]
			},
			options: {
				tooltips: {
					callbacks: {
						label: function(tooltipItem, data) {
							var label = data.datasets[tooltipItem.datasetIndex].label || '';
							if (label) label += ': ';
							label += val == 'getPelayanan' ? tooltipItem.yLabel : new Intl.NumberFormat('id-ID', {
								style: 'currency',
								currency: 'IDR'
							}).format(tooltipItem.yLabel);
							return label;
						}
					}
				},
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true,
							fontColor: 'white'
						},
						gridLines: {
							display: true,
							color: 'white',
							lineWidth: 1
						},
					}],
					xAxes: [{
						ticks: {
							fontColor: 'white'
						},
						gridLines: {
							display: false,
							color: 'white',
							lineWidth: 1
						},
					}]
				}
			}
		});
	}

	function renderChart3(data, labels, title = '-', val, elm) {
		var ctx = elm.getContext('2d');
		if (myChart3) myChart3.destroy();
		myChart3 = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: labels,
				datasets: [{
					label: title,
					backgroundColor: 'rgb(25, 135, 84)',
					borderColor: 'rgb(254, 83, 187)',
					data: data,
				}]
			},
			options: {
				tooltips: {
					callbacks: {
						label: function(tooltipItem, data) {
							var label = data.datasets[tooltipItem.datasetIndex].label || '';
							if (label) label += ': ';
							label += val == 'getPelayanan' ? tooltipItem.yLabel : new Intl.NumberFormat('id-ID', {
								style: 'currency',
								currency: 'IDR'
							}).format(tooltipItem.yLabel);
							return label;
						}
					}
				},
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true,
							fontColor: 'white'
						},
						gridLines: {
							display: true,
							color: 'white',
							lineWidth: 1
						},
					}],
					xAxes: [{
						ticks: {
							fontColor: 'white'
						},
						gridLines: {
							display: false,
							color: 'white',
							lineWidth: 1
						},
					}]
				}
			}
		});
	}

	function renderChart4(data, labels, title = '-', val, elm) {
		var ctx = elm.getContext('2d');
		if (myChart4) myChart4.destroy();
		myChart4 = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: labels,
				datasets: [{
					label: title,
					backgroundColor: 'rgb(255, 193, 7)',
					borderColor: 'rgb(254, 83, 187)',
					data: data,
				}]
			},
			options: {
				tooltips: {
					callbacks: {
						label: function(tooltipItem, data) {
							var label = data.datasets[tooltipItem.datasetIndex].label || '';
							if (label) label += ': ';
							label += val == 'getPelayanan' ? tooltipItem.yLabel : new Intl.NumberFormat('id-ID', {
								style: 'currency',
								currency: 'IDR'
							}).format(tooltipItem.yLabel);
							return label;
						}
					}
				},
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true,
							fontColor: 'white'
						},
						gridLines: {
							display: true,
							color: 'white',
							lineWidth: 1
						},
					}],
					xAxes: [{
						ticks: {
							fontColor: 'white'
						},
						gridLines: {
							display: false,
							color: 'white',
							lineWidth: 1
						},
					}]
				}
			}
		});
	}

	$.ajax({
		url: 'api.php',
		method: 'post',
		data: {
			act: 'getPendapatan',
			tipe: 2,
			tahun: tahunRender.getFullYear(),
		},
		dataType: 'json',
		success: function(data) {
			$('#loading').html('');
			renderChart(data.data, data.label, "Pendapatan Tahun : " + tahunRender.getFullYear(), "getPendapatan", document.getElementById("myChart"));
		}
	});

	$.ajax({
		url: 'api.php',
		method: 'post',
		data: {
			act: 'getBiaya',
			tipe: 2,
			tahun: tahunRender.getFullYear(),
		},
		dataType: 'json',
		success: function(data) {
			$('#loading').html('');
			renderChart2(data.data, data.label, "Biaya Tahun : " + tahunRender.getFullYear(), "getBiaya", document.getElementById("myChartBiaya"));
		}
	});

	$.ajax({
		url: 'api.php',
		method: 'post',
		data: {
			act: 'getLaba',
			tipe: 2,
			tahun: tahunRender.getFullYear(),
		},
		dataType: 'json',
		success: function(data) {
			$('#loading').html('');
			renderChart3(data.data, data.label, "Laba Tahun : " + tahunRender.getFullYear(), "getLaba", document.getElementById("myChartLaba"));
		}
	});

	$.ajax({
		url: 'api.php',
		method: 'post',
		data: {
			act: 'getPelayanan',
			tipe: 2,
			tahun: tahunRender.getFullYear(),
		},
		dataType: 'json',
		success: function(data) {
			$('#loading').html('');
			renderChart4(data.data, data.label, "Pelayanan Tahun : " + tahunRender.getFullYear(), "getPelayanan", document.getElementById("myChartPelayanan"));
		}
	});

	$.ajax({
		url: 'api.php',
		method: 'post',
		data: {
			act: 'getAll',
			tipe: 2,
			tahun: tahunRender.getFullYear(),
		},
		dataType: 'json',
		success: function(data) {
			$('#loading').html('');
			$('#pendapatan-all').html(new Intl.NumberFormat('id-ID', {
				style: 'currency',
				currency: 'IDR'
			}).format(data.pendapatan));
			$('#biaya-all').html(new Intl.NumberFormat('id-ID', {
				style: 'currency',
				currency: 'IDR'
			}).format(data.biaya));
			$('#laba-all').html(new Intl.NumberFormat('id-ID', {
				style: 'currency',
				currency: 'IDR'
			}).format(data.laba));
			$('#pelayanan-all').html(data.pelayanan);

			$('#pendapatan-time').html("Tahun " + tahunRender.getFullYear());
			$('#biaya-time').html("Tahun " + tahunRender.getFullYear());
			$('#laba-time').html("Tahun " + tahunRender.getFullYear());
			$('#pelayanan-time').html("Tahun " + tahunRender.getFullYear());
		}
	});

	$("#renderBtn").click(
		function() {
			let actUrl = $(this).val().split('|');

			$('#loading').html('Mohon Tunggu Sedang Mengambil Data');

			let titleChart;

			if ($('#type-filter').val() == 1) {
				titleChart = actUrl[2] + 'Periode ' + tglC($('#tanggal-awal').val()) + ' S/D ' + tglC($('#tanggal-akhir').val());
			} else if ($('#type-filter').val() == 2) {
				titleChart = actUrl[2] + 'Tahun : ' + $('#tahun-filter').val();
			} else if ($('#type-filter').val() == 3) {
				titleChart = actUrl[2] + 'Bulan ' + $('#bulan-filter option:selected').text() + ' ' + $('#tahun-filter-bulan').val();
			}
			var renderMana = actUrl[2];
			$.ajax({
				url: actUrl[1],
				method: 'post',
				data: {
					act: actUrl[0],
					tipe: $('#type-filter').val(),
					tanggalAwal: $('#tanggal-awal').val(),
					tanggalAkhir: $('#tanggal-akhir').val(),
					tahun: $('#tahun-filter').val(),
					bulan: $('#bulan-filter').val(),
					tahun_filter_bulan: $('#tahun-filter-bulan').val(),
				},
				dataType: 'json',
				success: function(data) {
					$('#loading').html('');
					if (renderMana == 'Pendapatan') {
						renderChart(data.data, data.label, titleChart, actUrl[0], document.getElementById('myChart'));
					} else if (renderMana == 'Biaya') {
						renderChart2(data.data, data.label, titleChart, actUrl[0], document.getElementById('myChartBiaya'));
					} else if (renderMana == 'Laba') {
						renderChart3(data.data, data.label, titleChart, actUrl[0], document.getElementById('myChartLaba'));
					} else if (renderMana == 'Pelayanan') {
						renderChart4(data.data, data.label, titleChart, actUrl[0], document.getElementById('myChartPelayanan'));
					}
				}
			});
		}
	);

	$('#lihatAll').on('click', function() {
		let valData = $(this).val().split('|');
		$.ajax({
			url: valData[1],
			method: 'post',
			data: {
				act: 'getAll',
				tipe: valData[0],
				tahun: $('#tahun-filter-all').val(),
				bulan: $('#bulan-filter-all').val(),
				tahun_filter_bulan: $('#tahun-filter-bulan-all').val()
			},
			dataType: 'json',
			success: function(data) {
				$('#pendapatan-all').html(new Intl.NumberFormat('id-ID', {
					style: 'currency',
					currency: 'IDR'
				}).format(data.pendapatan));
				$('#biaya-all').html(new Intl.NumberFormat('id-ID', {
					style: 'currency',
					currency: 'IDR'
				}).format(data.biaya));
				$('#laba-all').html(new Intl.NumberFormat('id-ID', {
					style: 'currency',
					currency: 'IDR'
				}).format(data.laba));
			}
		});
	});

	$('#lihatAllBukanPt').on('click', function() {
		let valData = $(this).val().split('|');
		$.ajax({
			url: valData[1],
			method: 'post',
			data: {
				act: 'getAll',
				tipe: valData[0],
				tahun: $('#tahun-filter-all').val(),
				bulan: $('#bulan-filter-all').val(),
				tahun_filter_bulan: $('#tahun-filter-bulan-all').val()
			},
			dataType: 'json',
			success: function(data) {
				$('#pendapatan-all').html(new Intl.NumberFormat('id-ID', {
					style: 'currency',
					currency: 'IDR'
				}).format(data.pendapatan));
				$('#biaya-all').html(new Intl.NumberFormat('id-ID', {
					style: 'currency',
					currency: 'IDR'
				}).format(data.biaya));
				$('#laba-all').html(new Intl.NumberFormat('id-ID', {
					style: 'currency',
					currency: 'IDR'
				}).format(data.laba));
				$('#pelayanan-all').html(data.pelayanan);
			}
		});
	});

	function tglC(tgl) {
		let tanggal = tgl.split('-');
		return tanggal[2] + '/' + tanggal[1] + '/' + tanggal[0];
	}

	function filterChart(elm) {
		$('#renderBtn').val(elm);
	}
</script>
</body>

</html>