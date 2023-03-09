$(document).ready(function() {
    $("#rate_like").click(function() {
	$.post({
    	    url: "/ajax/like",
	    success: function(data) {
		$("#rate_like_count").html(data);
	    },
	    timeout: 1000
	});
    });
    $("#rate_dislike").click(function() {
	$.post({
    	    url: "/ajax/dislike",
	    success: function(data) {
		$("#rate_dislike_count").html(data);
	    },
	    timeout: 1000
	});
    });
    (function ($) {
        $('#filter').keyup(function () {

            var rex = new RegExp($(this).val(), 'i');
            $('.searchable tr').hide();
            $('.searchable tr').filter(function () {
                return rex.test($(this).text());
            }).show();

        })
    }(jQuery));
});

