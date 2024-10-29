
jQuery(document).ready(function($) {
	
	$('#AuthorizePay #card-type').html('<img src="http://localhost/demo/wp-content/plugins/authorize-donation/assets/images/nocard.png">');
	$('#cc_pay_amt').click(function(){
		var donate_amt = $('.amount-cont #amt_donate').val();
		if(donate_amt == ""){
			swal("Please enter the amount");
			$('.amount-cont #amt_donate').focus();
		}else{
			$('#AuthorizePay #table1 #ccprice').val(donate_amt);
			$('.amount-cont').hide('slow');
			$('#AuthorizePay').show('slow');
		}
		

	});	
    //card validation on input fields


    $('#card_number').keyup(function(){
    	var card_number = $(this).val();
		$('#card_number').validateCreditCard(function(result) {
			console.log(result);
		    if(result.card_type == null){
		  		$('#AuthorizePay #card-type').addClass('nocard');
		  		$('#AuthorizePay #card-type').html('<img src="http://localhost/demo/wp-content/plugins/authorize-donation/assets/images/nocard.png">');
		    }else{
			  	if(card_number > 0){
			  		$('#AuthorizePay #card-type').addClass(result.card_type.name);
			  		$('#AuthorizePay #card-type').removeClass('nocard');
			  		if(result.card_type.name == "visa"){
			  			$('#AuthorizePay #card-type').html('<img src="http://localhost/demo/wp-content/plugins/authorize-donation/assets/images/visa.png">');
			  		}else if(result.card_type.name == "amex"){
			  			$('#AuthorizePay #card-type').html('<img src="http://localhost/demo/wp-content/plugins/authorize-donation/assets/images/amex.png">');
			  		}else if(result.card_type.name == "discover"){
			  			$('#AuthorizePay #card-type').html('<img src="http://localhost/demo/wp-content/plugins/authorize-donation/assets/images/discover.png">');	
			  		}else if(result.card_type.name == "maestro"){
			  			$('#AuthorizePay #card-type').html('<img src="http://localhost/demo/wp-content/plugins/authorize-donation/assets/images/maestro.png">');	
			  		}else if(result.card_type.name == "mastercard"){
			  			$('#AuthorizePay #card-type').html('<img src="http://localhost/demo/wp-content/plugins/authorize-donation/assets/images/master.png">');
			  		}else if(result.card_type.name == "jcb"){
			  			$('#AuthorizePay #card-type').html('<img src="http://localhost/demo/wp-content/plugins/authorize-donation/assets/images/jcv.png">');
			  		}else if(result.card_type.name == "dankort"){
			  			$('#AuthorizePay #card-type').html('<img src="http://localhost/demo/wp-content/plugins/authorize-donation/assets/images/dankort.png">');
			  		}else if(result.card_type.name == "uatp"){
			  			$('#AuthorizePay #card-type').html('<img src="http://localhost/demo/wp-content/plugins/authorize-donation/assets/images/uatp.png">');		

			  		}else{
			  			$('#AuthorizePay #card-type').html('<img src="http://localhost/demo/wp-content/plugins/authorize-donation/assets/images/nocard.png">');
			  		}
			  		
			  	}else{
			  		$('#AuthorizePay #card-type').attr('class','');
			  	}
		    }
		    if(result.valid == true){
		    	$("#card_number").css('border','solid 1px #ccc');
		    	$('#cc_pay').click(function(){


		    		if( $("#emailid").val() == "" ){
		    			swal("Oops !! ","Please put valid email address","warning");
		    		}else if( $("#expiry_month").val() == "" ){
		    			swal("Oops !! ","Please put valid expiry date","warning");	
		    		}else if($("#expiry_year").val() == "" ){
		    			swal("Oops !! ","Please put valid expiry date","warning");
		    		}else if($("#cvv").val() == "" ){
		    			swal("Oops !! ","Please put valid cvv","warning");	
		    			
		    		}else{

		    			jQuery('#ajx_load').show();
					    var donate_amt = $('.amount-cont #amt_donate').val();
						var serial = jQuery('#AuthorizePay').serialize();
						var data = {'serial':serial,'action':'upgrade_payment_by_ajax_handler'};

							swal("$"+donate_amt," Are you sure want to donate?", {
							  buttons: {
							     cancel: "Cancel",
							     catch: {
							      text: "Pay",
							      value: "paid",
							    }
							  },
							})
							.then((value) => {
							  switch (value) {
							 
							    case "paid":
							    	accd_payment(data);
							      break;  
							 
							    case "cancel":
							      break;
							 
							  }
						});

		    		}
				    
				});
		    }else{
		    	$("#card_number").css('border','1px solid red');
		    }	
		});	
	});

    function accd_payment(data){
    	$('.loader').show();
    	jQuery.ajax({
	        url: custom.ajaxurl,     
	        data: data,
	        type : 'POST',          
	        success:function(data) {
	        	jQuery('#ajx_load').hide();
	          	console.log(data);
	          	var jsonData = jQuery.parseJSON(data);
	          	var status = jsonData.approved;
	          	if( status === false ){
	          		swal("Oops !! ",jsonData.response_reason_text,"error");
	          		$('.loader').hide();
	          		
	          	}else{
	          		
	          		swal("Done","Your transation has been successfully completed", "success");
	          		$('.loader').hide();
					
	          	}
	        }
	    });
    }
});
