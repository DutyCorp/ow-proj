$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	loadModule();

	var options = {
	    title: "Notification",
	    options: {
	        body: "Hello World!",
	        icon: "/img/O.png",
	    	lang: 'en-US',
	    }
	};

	$("#easyNotify").easyNotify(options);

	function loadModule(){
		var modulelist = [];
		$('.box').each(function() {
			var id = $(this).attr('id');
			modulelist.push(id);
		});

		var i = 0;
		$('.box').each(function(i) {
			setTimeout(function() {
				$('#'+ modulelist[i]).fadeIn("fast");
				var splitted = modulelist[i].split('e');
				var id = splitted[1];
				var moduledata = {
					moduleid: id
				}
				$.ajax({
					type: 'POST',
					url: '/getModule',
					data: moduledata,
					dataType: 'json',
					success:function(data){
						$('#divLoadingmodule'+data['moduleid']).hide();
						$('#module'+id).html(data['returnHTML']);
					},
					error: function (xhr, ajaxOptions, thrownError) {
						showModal("Whoops! Something wrong", 0);
						console.log(xhr.status);
						console.log(xhr.responseText);
						console.log(thrownError);
					}
				});
				i++;
			}, i * 200);
		});	
	}

	let deferredPrompt;

	window.addEventListener('beforeinstallprompt', (e) => {
	  // Prevent Chrome 67 and earlier from automatically showing the prompt
	  e.preventDefault();
	  // Stash the event so it can be triggered later.
	  deferredPrompt = e;
	  // Update UI notify the user they can add to home screen
  	  btnAdd.style.display = 'block';
	});

	btnAdd.addEventListener('click', (e) => {
	  // hide our user interface that shows our A2HS button
	  btnAdd.style.display = 'none';
	  // Show the prompt
	  deferredPrompt.prompt();
	  // Wait for the user to respond to the prompt
	  deferredPrompt.userChoice
	    .then((choiceResult) => {
	      if (choiceResult.outcome === 'accepted') {
	        console.log('User accepted the A2HS prompt');
	      } else {
	        console.log('User dismissed the A2HS prompt');
	      }
	      deferredPrompt = null;
	    });
	});	
});