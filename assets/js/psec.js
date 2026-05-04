(function ($) { // Avoid conflicts with other libraries
	'use strict';

	var elems = Array.prototype.slice.call(document.querySelectorAll('.psec-switch'));

	elems.forEach(function (html) {
		if (typeof Switchery !== 'undefined') {
			var switchery = new Switchery(html, { secondaryColor: 'red' });
		}
	});

	// Hover tooltips
	$(function () {
		if ($.fn.tooltip) {
			$('[data-toggle="tooltip"]').tooltip();
		}
	});

	$(function () {
		var settings = {
			min: 200,
			scrollSpeed: 400
		},
			toTop = $('.scroll-btn'),
			toTopHidden = true;

		$(window).scroll(function () {
			var pos = $(this).scrollTop();
			if (pos > settings.min && toTopHidden) {
				toTop.stop(true, true).fadeIn();
				toTopHidden = false;
			} else if (pos <= settings.min && !toTopHidden) {
				toTop.stop(true, true).fadeOut();
				toTopHidden = true;
			}
		});

		toTop.bind('click touchstart', function () {
			$('html, body').animate({
				scrollTop: 0
			}, settings.scrollSpeed);
		});
	});

	$(document).ready(function () {

		if ($.fn.select2) {
			$(".select2").select2();
		}

		if ($.fn.dataTable) {
			$('#dt-basic').dataTable({
				"responsive": true,
				"order": [[1, "desc"]],
				"language": {
					"paginate": {
						"previous": '<i class="fas fa-angle-left"></i>',
						"next": '<i class="fas fa-angle-right"></i>'
					}
				}
			});

			$('#dt-basicphpconf').dataTable({
				"responsive": true,
				"order": [],
				"language": {
					"paginate": {
						"previous": '<i class="fas fa-angle-left"></i>',
						"next": '<i class="fas fa-angle-right"></i>'
					}
				}
			});

			$('#dt-basicloghist').dataTable({
				"responsive": true,
				"order": [[2, "desc"]],
				"language": {
					"paginate": {
						"previous": '<i class="fas fa-angle-left"></i>',
						"next": '<i class="fas fa-angle-right"></i>'
					}
				}
			});

			$('#dt-basiclogs').dataTable({
				"responsive": true,
				"order": [[2, "desc"]],
				dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				buttons: [
					'excelHtml5',
					'csvHtml5',
					'pdfHtml5'
				],
				"language": {
					"paginate": {
						"previous": '<i class="fas fa-angle-left"></i>',
						"next": '<i class="fas fa-angle-right"></i>'
					}
				}
			});

			$('#dt-basicbans').dataTable({
				"responsive": true,
				"order": [[1, "desc"]],
				dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				buttons: [
					'excelHtml5',
					'csvHtml5',
					'pdfHtml5'
				],
				"language": {
					"paginate": {
						"previous": '<i class="fas fa-angle-left"></i>',
						"next": '<i class="fas fa-angle-right"></i>'
					}
				}
			});

			$('#dt-basiclivetraff').dataTable({
				"responsive": true,
				"order": [[6, "desc"]],
				dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				buttons: [
					'excelHtml5',
					'csvHtml5',
					'pdfHtml5'
				],
				"language": {
					"paginate": {
						"previous": '<i class="fas fa-angle-left"></i>',
						"next": '<i class="fas fa-angle-right"></i>'
					}
				}
			});

			$('#dt-basic2').dataTable({
				"responsive": true,
				"language": {
					"paginate": {
						"previous": '<i class="fas fa-angle-left"></i>',
						"next": '<i class="fas fa-angle-right"></i>'
					}
				}
			});

			$('#dt-basic3').dataTable({
				"responsive": true,
				"language": {
					"paginate": {
						"previous": '<i class="fas fa-angle-left"></i>',
						"next": '<i class="fas fa-angle-right"></i>'
					}
				}
			});

			$('#dt-basic4').dataTable({
				"responsive": true,
				"language": {
					"paginate": {
						"previous": '<i class="fas fa-angle-left"></i>',
						"next": '<i class="fas fa-angle-right"></i>'
					}
				}
			});

			$('#dt-basicbadwords').dataTable({
				"responsive": true,
				"order": [[0, "asc"]],
				"language": {
					"paginate": {
						"previous": '<i class="fas fa-angle-left"></i>',
						"next": '<i class="fas fa-angle-right"></i>'
					}
				}
			});
		}

		if (window.location.href.indexOf("dashboard.php") > -1) {
			$.ajax({
				url: "chart_dashboard.php",
				type: "GET",
				dataType: "text",
				success: function (data) {
					try {
						var threats_count = JSON.parse(data);
						var sqli_count = threats_count["SQLi"];
						var badbots_count = threats_count["Bad Bot"];
						var proxies_count = threats_count["Proxies"];
						var spammers_count = threats_count["Spammers"];

						var isDark = document.documentElement.getAttribute('data-theme') === 'dark';
						var gridColor = isDark ? 'rgba(255,255,255,0.04)' : 'rgba(0,0,0,0.04)';
						var tickColor = isDark ? '#8A96A8' : '#666';
						var legendColor = isDark ? '#8A96A8' : '#555';

						var T = window.ShieldChartTokens || {
							brand: '#00B8E6',
							critical: '#EF4444',
							success: '#22C55E',
							warning: '#F59E0B'
						};

						var ctx = document.getElementById("log-stats");
						if (!ctx) { console.warn("Shield: #log-stats canvas not found"); return; }
						var ctx2d = ctx.getContext("2d");

						function createGrad(colorHex) {
							var hex = colorHex.replace('#', '');
							if (hex.length === 3) hex = hex.split('').map(function (c) { return c + c; }).join('');
							var r = parseInt(hex.substring(0, 2), 16) || 0;
							var g = parseInt(hex.substring(2, 4), 16) || 0;
							var b = parseInt(hex.substring(4, 6), 16) || 0;
							var grad = ctx2d.createLinearGradient(0, 0, 0, 280);
							grad.addColorStop(0, 'rgba(' + r + ',' + g + ',' + b + ', 0.30)');
							grad.addColorStop(1, 'rgba(' + r + ',' + g + ',' + b + ', 0.0)');
							return grad;
						}

						var chartData = {
							labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'],
							datasets: [{
								label: 'SQLi',
								backgroundColor: createGrad(T.brand),
								borderColor: T.brand,
								data: sqli_count,
								fill: true,
								tension: 0.35,
								borderWidth: 2,
								pointRadius: 0,
								pointHoverRadius: 5
							}, {
								label: 'Bad Bot',
								backgroundColor: createGrad(T.critical),
								borderColor: T.critical,
								data: badbots_count,
								fill: true,
								tension: 0.35,
								borderWidth: 2,
								pointRadius: 0,
								pointHoverRadius: 5
							}, {
								label: 'Proxies',
								backgroundColor: createGrad(T.success),
								borderColor: T.success,
								data: proxies_count,
								fill: true,
								tension: 0.35,
								borderWidth: 2,
								pointRadius: 0,
								pointHoverRadius: 5
							}, {
								label: 'Spammers',
								backgroundColor: createGrad(T.warning),
								borderColor: T.warning,
								data: spammers_count,
								fill: true,
								tension: 0.35,
								borderWidth: 2,
								pointRadius: 0,
								pointHoverRadius: 5
							}]
						};

						new Chart(ctx, {
							type: 'line',
							data: chartData,
							options: {
								responsive: true,
								maintainAspectRatio: false,
								plugins: {
									legend: {
										position: 'bottom',
										labels: { color: legendColor, padding: 16, boxWidth: 10, usePointStyle: true, pointStyle: 'circle' }
									},
									tooltip: {
										mode: 'index',
										intersect: false
									}
								},
								interaction: {
									mode: 'nearest',
									axis: 'x',
									intersect: false
								},
								scales: {
									x: {
										grid: { color: gridColor, drawBorder: false, drawTicks: false },
										ticks: { color: tickColor, padding: 8 }
									},
									y: {
										grid: { color: gridColor, drawBorder: false, drawTicks: false },
										ticks: { color: tickColor, padding: 8 },
										beginAtZero: true
									}
								}
							}
						});
					} catch (e) {
						console.error("Shield Charts: Failed to parse chart_dashboard.php response.", e);
						console.log("Raw response:", data.substring(0, 300));
					}
				},
				error: function (xhr, status, error) {
					console.error("Shield Charts: AJAX request failed.", status, error);
				}
			});
		}



		if (window.location.href.indexOf("visit-analytics.php") > -1) {
			$.get("chart_visitanalytics.php", function (data) {

				var analytics_data = JSON.parse(data);

				// Browser Stats
				var bcount1 = analytics_data["bcount1"];
				var bcount2 = analytics_data["bcount2"];
				var bcount3 = analytics_data["bcount3"];
				var bcount4 = analytics_data["bcount4"];
				var bcount5 = analytics_data["bcount5"];
				var bcount6 = analytics_data["bcount6"];
				var bcount7 = analytics_data["bcount7"];

				// OS Stats
				var ocount1 = analytics_data["ocount1"];
				var ocount2 = analytics_data["ocount2"];
				var ocount3 = analytics_data["ocount3"];
				var ocount4 = analytics_data["ocount4"];
				var ocount5 = analytics_data["ocount5"];
				var ocount6 = analytics_data["ocount6"];

				// Platform Stats
				var pcount1 = analytics_data["pcount1"];
				var pcount2 = analytics_data["pcount2"];
				var pcount3 = analytics_data["pcount3"];

				// Total and Unqiue Visits
				var dateFY = analytics_data["dateFY"];
				var v_labels = analytics_data["v_labels"];
				var total_visits = analytics_data["total_visits"];
				var unique_visits = analytics_data["unique_visits"];

				var config = {
					type: 'pie',
					data: {
						datasets: [{
							data: [bcount1, bcount2, bcount3, bcount4, bcount5, bcount6, bcount7],
							backgroundColor: (typeof ShieldChartPalette !== 'undefined') ? ShieldChartPalette : [
								'#32CD32',
								'#FFD700',
								'#FF0000',
								'#00BFFF',
								'#1E90FF',
								'#B0C4DE',
								'#000000'
							]
						}],
						labels: [
							'Google Chrome',
							'Firefox',
							'Opera',
							'Edge',
							'Internet Explorer',
							'Safari',
							'Other'
						]
					},
					options: {
						responsive: true
					}
				};

				var config2 = {
					type: 'pie',
					data: {
						datasets: [{
							data: [ocount1, ocount2, ocount3, ocount4, ocount5, ocount6],
							backgroundColor: [
								'#1E90FF',
								'#FFD700',
								'#7CFC00',
								'#D3D3D3',
								'#B0C4DE',
								'#000000'
							]
						}],
						labels: [
							'Windows',
							'Linux',
							'Android',
							'iOS',
							'Mac OS X',
							'Other'
						]
					},
					options: {
						responsive: true
					}
				};

				var config3 = {
					type: 'pie',
					data: {
						datasets: [{
							data: [pcount2, pcount3, pcount1],
							backgroundColor: [
								'#00BFFF',
								'#FFD700',
								'#FF0000'
							]
						}],
						labels: [
							'Mobile',
							'Tablet',
							'Computer'
						]
					},
					options: {
						responsive: true
					}
				};

				var config4 = {
					type: 'line',
					data: {
						labels: v_labels,
						datasets: [{
							label: 'Total Visits',
							backgroundColor: '#1E90FF',
							borderColor: '#1E90FF',
							data: total_visits,
							fill: false
						}, {
							label: 'Unique Visits',
							fill: false,
							backgroundColor: '#3CB371',
							borderColor: '#3CB371',
							data: unique_visits
						}]
					},
					options: {
						responsive: true,
						bezierCurve: false,
						tooltips: {
							mode: 'index',
							intersect: false
						},
						hover: {
							mode: 'nearest',
							intersect: true
						},
						elements: {
							line: {
								tension: 0
							}
						},
						scales: {
							xAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: dateFY
								}
							}],
							yAxes: [{
								display: true,
								scaleLabel: {
									display: true,
									labelString: 'Visits'
								}
							}]
						}
					}
				};

				if (typeof Chart !== 'undefined') {
					var ctx = document.getElementById('browser-graph').getContext('2d');
					window.browsergraph = new Chart(ctx, config);
					var ctx2 = document.getElementById('os-graph').getContext('2d');
					window.osgraph = new Chart(ctx2, config2);
					var ctx3 = document.getElementById('device-graph').getContext('2d');
					window.devicegraph = new Chart(ctx3, config3);
					var ctx4 = document.getElementById('visits-chart').getContext('2d');
					window.visitschart = new Chart(ctx4, config4);
				}

			});
		}
	});

	// --- Global Shield UI Layout Refactoring ---
	$(document).ready(function() {
		if ($('html').attr('data-ui-engine') === 'shield') {
			// Extract title and move to navbar
			var pageTitle = $('.content-header h1').first().text().trim();
			if (pageTitle) {
				// Inject after the search form in the navbar
				$('.main-header .navbar-start').append('<span class="shield-global-page-title d-none d-sm-inline-block ml-3" style="font-weight: 600; font-size: 1.1rem; color: var(--text-primary); margin-right: 15px;">' + pageTitle + '</span>');
			}
		}
	});

})(jQuery);