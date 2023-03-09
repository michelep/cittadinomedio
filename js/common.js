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

    $("#quizForm").submit(function(e) {
	e.preventDefault(); 
	var form = $(this);
	$.ajax({
	    type: "POST",
	    url: "/ajax/quiz",
	    data: form.serialize(),
	    dataType: "json",
	    success: function(data) {
		if(data.error == 0) { // Success!
		    $("#alert-success").html(data.message);
		    $("#alert-success").fadeIn();
		    $("#quizForm input").attr("disabled", true);
		    $("#quizForm").fadeOut();
		    $("#quizAfter").fadeIn();
		}
		if(data.error == 1) { // Warning
		    $("#alert-warning").html(data.message);
		    $("#alert-warning").fadeIn().delay(5000).fadeOut();
		}
		if(data.error == 2) { // Error
		    $("#alert-error").html(data.message);
		    $("#alert-error").fadeIn();
		    $("#quizForm input").attr("disabled", true);
		    $("#quizForm").fadeOut();
		    $("#quizAfter").fadeIn();
		}
	    }
	});
    });
});

