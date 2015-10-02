$(document).ready(function () {
		$('#dialog_link').click(function () {
			$('#dialog').dialog('open');
			return false;
		});
	});

	$(function(){
	var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");

	  $('a[data-modal-id]').click(function(e) {
		e.preventDefault();
		$("body").append(appendthis);
		$(".modal-overlay").fadeTo(500, 0.7);
		var modalBox = $(this).attr('data-modal-id');
		$('#'+modalBox).fadeIn($(this).data());
	  });  
	  

	$(".js-modal-close, .modal-overlay").click(function() {
	  $(".modal-box, .modal-overlay").fadeOut(500, function() {
		$(".modal-overlay").remove();
	  });
	});

	$(window).resize(function() {
	  $(".modal-box").css({
		top: ($(window).height() - $(".modal-box").outerHeight()) / 3,
		left: ($(window).width() - $(".modal-box").outerWidth()) / 2
	  });
	});
	 
	$(window).resize();
	 
	});
        
    function onDelete(id){
		if(confirm("You really want to delete this User?"))
			window.location.href = "action.php?action=delete&id="+id;
	}
        