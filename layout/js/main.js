	$(document).ready(function (page) {
		function load_data(page) {
			$.ajax({
				url: 'pagination.php',
				method: "POST",
				data: {
					page: page
				},
				success: function (data) {
					$('#pagination').html(data);
				}
			});
		}

		$(document).on('click', '.classBotton', function () {
			var page = $(this).attr('id');
			load_data(page);
		});
	});