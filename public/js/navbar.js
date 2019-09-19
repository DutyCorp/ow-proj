$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$('.sub1:not(:only-child)').click(function(e) {
		//$(this).attr('class', 'aactive');
		$('.sub1').each(function() {
    		if ($(this).hasClass('aactive')){
				$(this).removeClass('aactive');
			}
    	});
    	$('.sub2').each(function() {
    		if ($(this).hasClass('aactive')){
				$(this).removeClass('aactive');
			}
    	});
		if ($(this).hasClass('aactive')){
			$(this).removeClass('aactive');
		} else {
			$(this).addClass('aactive');
		}
	    $(this).siblings('.nav1').toggle();
	    $('.nav1').not($(this).siblings()).hide();
	    e.stopPropagation();
	});

	$('.sub2:not(:only-child)').click(function(e) {
		//$(this).attr('class', 'aactive');
		$('.sub2').each(function() {
    		if ($(this).hasClass('aactive')){
				$(this).removeClass('aactive');
			}
    	});
		if ($(this).hasClass('aactive')){
			$(this).removeClass('aactive');
		} else {
			$(this).addClass('aactive');
		}
	    $(this).siblings('.nav2').toggle();
	    $('.nav2').not($(this).siblings()).hide();
	    e.stopPropagation();
	});

	$(".container").mouseup(function(){ 
    	$('.sub1').each(function() {
    		if ($(this).hasClass('aactive')){
				$(this).removeClass('aactive');
			}
    	});
    	$('.sub2').each(function() {
    		if ($(this).hasClass('aactive')){
				$(this).removeClass('aactive');
			}
    	});
    });

	$('html').click(function() {
	    $('.nav-dropdown').hide();
	});

  	document.querySelector('#nav-toggle').addEventListener('click', function() {
    	this.classList.toggle('active');
  	});

  	$('#nav-toggle').click(function() {
    	$('nav ul').toggle();
  	});

	$('#logout').click(function() {
		if(typeof Storage !== "undefined")
		{
			localStorage.setItem("data", null);
			localStorage.setItem("currentURL", null);
			localStorage.setItem("menuName", null);
		}	
		$('#LogoutModal').modal({
		  backdrop: 'static',
		  keyboard: false
		});
		$.ajax({
			type 		: 'POST',
			url 		: '/Logout',
			dataType 	: 'json',
			success:function(data){
				if(typeof Storage !== "undefined")
				{ 
					localStorage.setItem("profileImg", "");
				}
				//alert(data);
				window.location.replace("/login");
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert("Whoops! Something wrong", 0);
				console.log(xhr.status);
				console.log(xhr.responseText);
				console.log(thrownError);
			}
		});
	});
});