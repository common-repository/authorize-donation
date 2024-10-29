/* JS here */


	jQuery(document).ready(function($){
		$('.main-panel .form-table').addClass('active');
		$('.blog_section').addClass('deactive');
		$(".form-table").eq(1).addClass('deactive');
		$('#api_sec').addClass('current');

		$('#api_sec').click(function(){
			$(this).addClass('current');
			$('#blog_sec').removeClass('current');
			$('.main-panel .form-table').addClass('active');
			$('.main-panel .form-table').removeClass('deactive');

			$('.blog_section').removeClass('active');
			$(".form-table").eq(1).removeClass('active');

			$('.blog_section').addClass('deactive');
			$(".form-table").eq(1).addClass('deactive');
		});
		$('#blog_sec').click(function(){
			$(this).addClass('current');
			$('#api_sec').removeClass('current');
			$('.main-panel .form-table').removeClass('active');

			$('.main-panel .form-table').addClass('deactive');

			$('.blog_section').addClass('active');
			$(".form-table").eq(1).addClass('active');
			
			$('.blog_section').removeClass('deactive');
			$(".form-table").eq(1).removeClass('deactive');
		});

		$('#get_sCode').click(function(){
			//$('#shortCodeSec').show();
			if(hsvars.status == false ){
				swal(hsvars.msg, "Please try again", "warning");
			}
			if(hsvars.status == true ){
				swal(hsvars.msg,"<?php echo do_shortcode('[accd]'); ?>", "success");
			}

		});
		$('.shortcode-inner span').click(function(){
			$('#shortCodeSec').hide();
		});

		
		
	});


