$(document).ready(function() {
	if ($('.regionData').length){
		var region = [];
		var OnTime = [];
		var Late = [];
		var Permit = [];
		$('.regionData').each(function() {
			var id = $(this).attr('id');
			var array = $(this).val().split("+n");
			region.push(array[0]);
			OnTime.push(array[1]);
			Late.push(array[2]);
			Permit.push(array[3]);
			$('#' + id).remove();
		});
		var datearray = $('#dt').val().split("+n");
		var DateFrom = datearray[0];
		var DateTo = datearray[1];
		$('#dt').remove();

		/*var now = new Date();
		var prevMonthLastDate = new Date(now.getFullYear(), now.getMonth(), 0);
		var prevMonthFirstDate = new Date(now.getFullYear() - (now.getMonth() > 0 ? 0 : 1), (now.getMonth() - 1 + 12) % 12, 1);
		prevMonthFirstDate = formatDate(prevMonthFirstDate);
		prevMonthLastDate = formatDate(prevMonthLastDate);*/

		var ctx = document.getElementById('regionChart').getContext('2d');
		chartRegion = new Chart(ctx, {
			type: 'horizontalBar',
			data: {
				labels: region,
				datasets: [
				{
					label: "OnTime",
					backgroundColor: "#87CEFA",
					fillColor: "#87CEFA",
					data: OnTime
				},
				{
					label: "Late",
					backgroundColor: "#ff85a2",
					fillColor: "#ff85a2",
					data: Late
				},
				{
					label: "Permit",
					backgroundColor: "#FFFF66",
					fillColor: "#FFFF66",
					data: Permit
				}
				]
			},
			options: {
				legend: {
					labels: {
						fontSize: 20
					}
				},
				title: {
					display: true,
					text: 'Attendance Region Report, From ' + DateFrom + ' to ' + DateTo + ' ( All Region )',
					fontSize: 20
				},
				animation: {
					duration: 500,
					easing: "easeOutQuart",
					onComplete: function () {
						var ctx = this.chart.ctx;
						ctx.font = "bold 12px sans-serif";
						ctx.textAlign = 'center';
						ctx.textBaseline = 'bottom';
						this.data.datasets.forEach(function (dataset) {
							for (var i = 0; i < dataset.data.length; i++) {
								var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
								scale_max = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._yScale.maxHeight;
								ctx.fillStyle = '#444';
								var y_pos = model.y + 6;
								var newdata = dataset.data[i];
								if ((scale_max - model.y) / scale_max >= 0.93)
									y_pos = model.y + 20;

								if (newdata == "0"){
									newdata = "";
								}

								if (model.x >= 100) {
									ctx.fillText(newdata + '%', model.x - 20, y_pos);
								} else if (newdata == "") {
									ctx.fillText(newdata, model.x + 25, y_pos);
								} else {
									ctx.fillText(newdata + '%', model.x + 25, y_pos);
								}
							}
						});               
					}
				}
			}
		});
	} else {
		$('#regionError').html('No data found');
	}

	function formatDateComponent(dateComponent){
		return (dateComponent < 10 ? '0' : '') + dateComponent;
	}

	function formatDate(date){
		return formatDateComponent(date.getMonth() + 1) + '/' + formatDateComponent(date.getDate()) + '/' + date.getFullYear();
	}
});