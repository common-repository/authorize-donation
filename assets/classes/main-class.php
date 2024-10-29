<?php 

class BlogType{

		public $accd_field_api; 
		public $accd_transc_key;
		function __construct(){
			$options 					    = $this->_option_data();
			$this->accd_field_api 			= $options['accd_field_api'];
			$this->accd_transc_key 			= $options['accd_transc_key'];
		}

		function _option_data(){
			return get_option( 'accd_options' );
		}	
	
		function accd_credit_card_form(){ 
			$options  = get_option( 'accd_options' );
			if(is_user_logged_in()){
				$current_user = get_current_user_id();
				$userData = get_user_by('ID',$current_user);
				$email = $userData->user_email;
				$html2 =		 '<input type="hidden" name="customer_id" value="'.$current_user.'"><input type="hidden" name="email" value="'.$email.'">';
			}else{
				$html2 = '<tr>  
				              <td  align="right" class="style1">Email:</td>  
				              <td class="style1"><input type="email" id="emailid" name="email"  value="" placeholder="user@wordpress.com" class="form-control" required></td>
					       </tr> ';
			}
			
	    	$html = '<div class="loader" style="text-align:center; display:none"><img src="'.plugin_dir_url( __FILE__ ) . 'load.gif'.'"></div><div class="AuthorizeForm cc_form" id="paymentForm">
					<form id="AuthorizePay" runat="server" style="display:none">  
					   <h2 align="center"> Credit card payment:</h2>  
					    <table id="table1"; cellspacing="5px" cellpadding="5%"; align="center"> 
					    	<div align="center" id="donatAmt"></div> 
					    	<input type="hidden" id="ccprice" name="chk-price" value="">
					    	<input type="hidden" name="first_name" value="">
					    	<input type="hidden" name="last_name" value="">
					    	<tr>  
				              <td  align="right" class="style1">Card number:</td>  
				              <td class="style1"><input type="text" id="card_number" name="card_no" maxlength="16" value="" placeholder="1234 5678 9012 3456" class="form-control" required><div id="card-type"></td>
					       </tr> '.$html2.' 
					       <tr>  
				              <td align="right">Exp date:</td>  
				              <td>
				              	<input type="text" id="expiry_month" size="2" name="mm_field_cc_exp_month" maxlength="2" value="" class="form-control" placeholder="MM" required>&nbsp;
				              	<input type="text" id="expiry_year" size="2" name="mm_field_cc_exp_year" maxlength="2" value="" class="form-control" placeholder="YY" required>
				              </td>  
					       </tr>  
					       <tr>  
				              <td align="right">Cvv:</td>  
				              <td><input type="text" maxlength="3" id="cvv" placeholder="123"> </td>  
					       </tr> 
					       
					    </table> 

					    <p align="center"><input type="button" id="cc_pay" value="Donate" class="obtn btn_orange cp-fixed-color form-control"></p>
					</form>
					<div class="amount-cont">
					<h2 align="center">Donate with Credit card :</h2> 
					<table id="table2"; cellspacing="5px" cellpadding="5%"; align="center"> 
					    <tr>  
				              <td align="right">Amount:</td>  
				              <td><input type="number" id="amt_donate" placeholder="0000"> </td>  
					       </tr> 
					      
					    </table>
					     <p align="center"><input type="button" id="cc_pay_amt" value="Donate" class="obtn btn_orange cp-fixed-color form-control"></p> 
					</div>     
				</div>';
				return $html;
			

		}
		 

	    
}

