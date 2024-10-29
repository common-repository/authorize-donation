<?php 

/*
** Plugin functions
*/

function accd_load_custom_wp_admin_style_script() {
    wp_enqueue_style( 'css-admin', plugin_dir_url( __FILE__ ) . 'assets/css/accd_admin.css', false, '1.0.0');
    if (isset($_GET['page']) && $_GET['page'] == 'auth_cc_donation') {

    	
	    wp_enqueue_style( 'css-admin-font-awesome', 'https://use.fontawesome.com/releases/v5.2.0/css/all.css', false, '5.2.0');
	    wp_enqueue_style( 'css', plugins_url('assets/css/accdlink.css', __FILE__), false, '1.0.0');
	    wp_enqueue_style( 'bootstrap', plugin_dir_url( __FILE__ ) . 'assets/css/bootstrap.min.css', false, '3.3.7');
	    wp_enqueue_style( 'fa', plugin_dir_url( __FILE__ ) . 'assets/css/font-awesome.min.css', false, '4.7.0');

	    wp_enqueue_script( 'js', plugins_url('assets/js/accdlink.js', __FILE__), false, '1.0.0' );
	    wp_enqueue_script( 'jstrack', plugins_url('assets/js/accdtrack.js', __FILE__), false, '1.0.3' );

      	$options    = get_option( 'accd_options' );
        $shortcode  = 'Shortcode snippet: [accd] OR ';

        if($options['accd_field_api'] == "" || $options['accd_transc_key'] == "") { 
            $status = false;
            $cus_val = 'Configure properly to get shortcode.';

        }else{
            $cus_val = $shortcode;
            $status = true;
        }   

      	if ($_GET['page'] != '' && $_GET['page'] = 'auth_cc_donation') {
      		wp_enqueue_script( 'sweetalert', plugins_url('assets/js/sweetalert.js', __FILE__), false, '1.0.3' );
	        wp_localize_script( 'jstrack', 'hsvars', array('status'=>$status,'msg' => $cus_val));
    	}
    	
	}

}
add_action( 'admin_enqueue_scripts', 'accd_load_custom_wp_admin_style_script' );

function accd_load_custom_script(){
     $options    = get_option( 'accd_options' );
     $ajaxurl =  admin_url('admin-ajax.php');
     wp_enqueue_script( 'sweetalert', plugins_url('assets/js/sweetalert.js', __FILE__), false, '1.0.3' );
     wp_enqueue_script( 'ccardval', plugins_url('assets/js/jquery.creditCardValidator.js', __FILE__), false, '1.0.1' );
     wp_enqueue_script( 'custom-js', plugins_url('assets/js/accd-custom.js', __FILE__), false, '1.0.1' );
      wp_enqueue_style( 'custom-css', plugins_url('assets/css/accd-custom.css', __FILE__), false, '1.0.1' );
     wp_localize_script( 'custom-js', 'custom', array('ajaxurl'=>$ajaxurl));
     
}
add_action( 'wp_enqueue_scripts', 'accd_load_custom_script' );


add_action( 'admin_init', 'accd_settings_init' );

function accd_settings_init() { 

 register_setting( 'auth_cc_donation', 'accd_options' );


 add_settings_section(
 'accd_section_developers',
 __( '', 'auth_cc_donation' ),
 'accd_section_developers_cb',
 'auth_cc_donation'
 );
add_settings_field(
    'accd_field_sandbox',
    __( 'Authorize sandbox ', 'auth_cc_donation' ),
    'accd_field_sandbox_fn',
    'auth_cc_donation',
    'accd_section_developers',
    array(
        'label_for' => 'accd_field_sandbox',
        'class' => 'accd_row',
        'accd_custom_data' => 'custom',
    )
 );

 add_settings_field(
    'accd_field_api',
    __( 'Api Login id', 'auth_cc_donation' ),
    'accd_field_api_fn',
    'auth_cc_donation',
    'accd_section_developers',
    array(
        'label_for' => 'accd_field_api',
        'class' => 'accd_row',
        'accd_custom_data' => 'custom',
    )
 );

  add_settings_field(
    'accd_transc_key',
    __( 'Transation key', 'auth_cc_donation' ),
    'accd_transc_key_fn',
    'auth_cc_donation',
    'accd_section_developers',
    array(
        'label_for' => 'accd_transc_key',
        'class' => 'accd_row',
        'accd_custom_data' => 'custom',
    )
 );
}

function accdlink_options_page() {
  $page_title = 'Authorize Donation';
  $menu_title = 'Authorize Donation';
  $capability = 'manage_options';
  $menu_slug  = 'auth_cc_donation';
  $function   = 'accdlink_options_page_html';
  $icon_url   = plugins_url( '/assets/images/auth.jpeg', __FILE__ );
  $position   = 1;

  add_menu_page( $page_title,
                 $menu_title, 
                 $capability, 
                 $menu_slug, 
                 $function, 
                 $icon_url, 
                 $position );
  add_submenu_page($menu_slug, 'Payment Details', 'Payment Details', 'manage_options', 'order_listings_page', 'order_listings_page');
  require_once( dirname( __FILE__ ) . '/order-listing.php' );
}
add_action( 'admin_menu', 'accdlink_options_page' );

function accd_section_developers_cb( $args ) {
 ?>
<div class="main-panel">
	<div class="header_section">
		<p id="hubspot_banner"><img src="<?php echo plugins_url( '/assets/images/index.png', __FILE__ ); ?>" /></p>
	</div>	
    <ul class="tabs">
        <li class="tab-link current" id="api_sec" data-tab="tab-1">Settings</li>
        <!-- <li class="tab-link" id="blog_sec" data-tab="tab-2">Googlesheet settings</li> -->
    </ul>

<?php
}

function accd_section_blog_cb( $args ) {
 ?>
    <div id="tab-2" class="tab-content">
        <div class="blog_section"></div>	
    </div>
</div>
<?php
}


function accd_field_api_fn( $args ) {
 $options = get_option( 'accd_options' );
 ?>

 <input value="<?php echo esc_attr( $options['accd_field_api'] ); ?>" placeholder="3LG8v56B6jf" id="<?php echo esc_attr( $args['label_for'] ); ?>"
 data-custom="<?php echo esc_attr( $args['accd_custom_data'] ); ?>"
 name="accd_options[<?php echo esc_attr( $args['label_for'] ); ?>]" />
 
<?php
}



function accd_field_sandbox_fn( $args ) {
 $options = get_option( 'accd_options' );
 //print_r($options); die;
 ?>

<input name="accd_options[<?php echo esc_attr( $args['label_for'] ); ?>]" 
    type="checkbox" id="<?php echo esc_attr( $args['label_for'] ); ?>" 
    value="1" name="accd_options[<?php echo esc_attr( $args['label_for'] ); ?>]" <?php if( isset($options['accd_field_sandbox']) && $options['accd_field_sandbox'] == 1){echo 'checked';}?> />


 <?php
}

function accd_transc_key_fn( $args ) {
 $options = get_option( 'accd_options' );
 ?>

 <input value="<?php echo esc_attr( $options['accd_transc_key'] ); ?>" placeholder="83vV4QZ49zd8bc7x" id="<?php echo esc_attr( $args['label_for'] ); ?>"
 data-custom="<?php echo esc_attr( $args['accd_custom_data'] ); ?>"
 name="accd_options[<?php echo esc_attr( $args['label_for'] ); ?>]" />

 <?php
}

 
function accdlink_options_page_html() {
if ( ! current_user_can( 'manage_options' ) ) {
    return;
}
 
if ( isset( $_GET['settings-updated'] ) ) {
    add_settings_error( 'accd_messages', 'accd_message', __( 'Settings Saved', 'accd' ), 'updated' );
}
 
 settings_errors( 'accd_messages' );
 ?>
 <div class="wrap">
     <form action="options.php" method="post" class="set-sec">
        
           
            <?php 
                settings_fields( 'auth_cc_donation' ); 
               
                do_settings_sections( 'auth_cc_donation' );

                submit_button( 'Save HubSpot settings' ); 
            ?>
            <p class="get-shortcode"><a id="get_sCode" href="javascript:void(0)" class="button button-primary">Get shortcode</a></p>


     </form>
     <div class="hs-jumbotron" id="shortCodeSec" style="display:none;">
        <div class="shortcode-inner">
            <span><i class="fa fa-times"></i></span>
            <?php
                $options    = get_option( 'accd_options' );
                $shortcode  = "[accd]";
                //$shortcode = "[accd-blog id=1234567 limit=10 cols=2 showtext=1]";
            ?>
              <?php if($options['accd_field_api'] == "") { ?>
                <div class="alert alert-warning">
                  <strong>Warning:Connect HubSpot to get shortcode.</strong> 
                </div>
             <?php } else { ?>
                <p>Shortcode snippet: <code><?php echo $shortcode; ?></code></p>
                <p>PHP snippet: <code><?php echo htmlspecialchars('<?php echo do_shortcode(\'' . $shortcode . '\'); ?>'); ?></code></p>
             <?php } ?>
        </div>
    </div>
</div>
 <?php
}


function accdlink_blog_shortcode() {
    //print_r($atts); die;

    $BlogType = new BlogType();
    echo $BlogType->accd_credit_card_form(); 
     
    
}

add_shortcode('accd','accdlink_blog_shortcode');


function accd_truncateHTML($html, $limit = 20) {
    static $wrapper = null;
    static $wrapperLength = 0;
    $html = trim($html);
    $html = preg_replace("~<!--.*?-->~", '', $html);
    if ((strlen(strip_tags($html)) > 0) && strlen(strip_tags($html)) == strlen($html))  {
        return substr($html, 0, $limit);
    }
    elseif (is_null($wrapper)) {
        if (!preg_match("~^\s*<[^\s!?]~", $html)) {
            $wrapper = 'div';
            $htmlWrapper = "<$wrapper></$wrapper>";
            $wrapperLength = strlen($htmlWrapper);
            $html = preg_replace("~><~", ">$html<", $htmlWrapper);
        }
    }
    $totalLength = strlen($html);
    if ($totalLength <= $limit) {
        if ($wrapper) {
            return preg_replace("~^<$wrapper>|</$wrapper>$~", "", $html);
        }
        return strlen(strip_tags($html)) > 0 ? $html : '';
    }
    $dom = new DOMDocument;
    $dom->loadHTML($html,  LIBXML_HTML_NOIMPLIED  | LIBXML_HTML_NODEFDTD);
    $xpath = new DOMXPath($dom);
    $lastNode = $xpath->query("./*[last()]")->item(0);
    if ($totalLength > $limit && is_null($lastNode)) {
        if (strlen(strip_tags($html)) >= $limit) {
            $textNode = $xpath->query("//text()")->item(0);
            if ($wrapper) {
                $textNode->nodeValue = substr($textNode->nodeValue, 0, $limit );
                $html = $dom->saveHTML();
                return preg_replace("~^<$wrapper>|</$wrapper>$~", "", $html);
            } else {
                $lengthAllowed = $limit - ($totalLength - strlen($textNode->nodeValue));
                if ($lengthAllowed <= 0) {
                    return '';
                }
                $textNode->nodeValue = substr($textNode->nodeValue, 0, $lengthAllowed);
                $html = $dom->saveHTML();
                return strlen(strip_tags($html)) > 0 ? $html : '';
            }
        } else {
            $textNode = $xpath->query("//text()")->item(0);
            $textNode->nodeValue = substr($textNode->nodeValue, 0, -(($totalLength - ($wrapperLength > 0 ? $wrapperLength : 0)) - $limit));
            $html = $dom->saveHTML();
            return strlen(strip_tags($html)) > 0 ? $html : '';
        }
    }
    elseif ($nextNode = $lastNode->nextSibling) {
        if ($nextNode->nodeType === 3 /* DOMText */) {
            $nodeLength = strlen($nextNode->nodeValue);
            if (($totalLength - ($wrapperLength > 0 ? $wrapperLength : 0)) - $nodeLength >= $limit) {
                $nextNode->parentNode->removeChild($nextNode);
                $html = $dom->saveHTML();
                return accd_truncateHTML($html, $limit);
            }
            else {
                $nextNode->nodeValue = substr($nextNode->nodeValue, 0, ($limit - (($totalLength - ($wrapperLength > 0 ? $wrapperLength : 0)) - $nodeLength)));
                $html = $dom->saveHTML();
                if ($wrapper) {
                    return preg_replace("~^<$wrapper>|</$wrapper>$~", "", $html);
                }
                return $html;
            } 
        }
    }
    elseif ($lastNode->nodeType === 1 /* DOMElement */) {
        $nodeLength = strlen($lastNode->nodeValue);
        if (($totalLength - ($wrapperLength > 0 ? $wrapperLength : 0)) - $nodeLength >= $limit) {
            $lastNode->parentNode->removeChild($lastNode);
            $html = $dom->saveHTML();
            return accd_truncateHTML($html, $limit);
        }
        else {
            $lastNode->nodeValue = substr($lastNode->nodeValue, 0, ($limit - (($totalLength - ($wrapperLength > 0 ? $wrapperLength : 0)) - $nodeLength)));
            $html = $dom->saveHTML();
            if ($wrapper) {
                return preg_replace("~^<$wrapper>|</$wrapper>$~", "", $html);
            }
            return $html . "...";
        }
    }
}

function accd_html2text($Document) {
    $Rules = array ('@<script[^>]*?>.*?</script>@si',
                    '@<[\/\!]*?[^<>]*?>@si',
                    '@([\r\n])[\s]+@',
                    '@&(quot|#34);@i',
                    '@&(amp|#38);@i',
                    '@&(lt|#60);@i',
                    '@&(gt|#62);@i',
                    '@&(nbsp|#160);@i',
                    '@&(iexcl|#161);@i',
                    '@&(cent|#162);@i',
                    '@&(pound|#163);@i',
                    '@&(copy|#169);@i',
                    '@&(reg|#174);@i',
                    '@&#(d+);@e'
             );
    $Replace = array ('',
                      '',
                      '',
                      '',
                      '&',
                      '<',
                      '>',
                      ' ',
                      chr(161),
                      chr(162),
                      chr(163),
                      chr(169),
                      chr(174),
                      'chr()'
                );
  return preg_replace($Rules, $Replace, $Document);
}

//===== Create table for order record =======
  global $wpdb;
  $newpages = false;

  $table_name = $wpdb->prefix . "order_authorize_donation";
  $sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
        `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
        `transaction_id` varchar(255),
        `amount` varchar(255),
        `method` varchar(255),
        `customer_id` varchar(255),
        `email_address` varchar(255),
        `card_type` varchar(255),
        `status` varchar(255),
        `date` varchar(255)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta($sql);

  if($newpages){
    wp_cache_delete( 'all_page_ids', 'pages' );
    $wp_rewrite->flush_rules();
  }
//===== End section Create table for order record =======

add_action('wp_ajax_upgrade_payment_by_ajax_handler' , 'upgrade_payment_by_ajax_handler');
add_action('wp_ajax_nopriv_upgrade_payment_by_ajax_handler' , 'upgrade_payment_by_ajax_handler') ;
function upgrade_payment_by_ajax_handler(){
  $formdata = $_POST['serial'];
  $id = get_current_user_id();
  $values=  array();             
  parse_str($formdata, $values);
  $response = Authorized_payment($values);
  create_transaction($response);
  echo $response;
  die;
}

function Authorized_payment($requestedDataArray){

  $data = $requestedDataArray ;
  require_once( dirname( __FILE__ ) . '/assets/authorizenet-php-api-master/AuthorizeNet.php' );
  $options    = get_option( 'accd_options' );
  $config = false;
    if(isset($options['accd_field_sandbox']) && $options['accd_field_sandbox'] == 1){
        define("AUTHORIZENET_SANDBOX", true);
    }else{
        define("AUTHORIZENET_SANDBOX", false);
    }
    if(isset($options['accd_field_api']) && $options['accd_field_api'] != "" ){
        define("AUTHORIZENET_API_LOGIN_ID", $options['accd_field_api']);
    }
    if(isset($options['accd_transc_key'])  && $options['accd_transc_key'] != ""){
         define("AUTHORIZENET_TRANSACTION_KEY",$options['accd_transc_key']);
    }
  
    /*define("AUTHORIZENET_API_LOGIN_ID", "3LG8v56B6jf");
    define("AUTHORIZENET_TRANSACTION_KEY", "83vV4QZ49zd8bc7x");*/
  //format will be mmyy
  $month = $data['mm_field_cc_exp_month'];
  $year = $data['mm_field_cc_exp_year'];
  $expire_date = $month.$year;
  $sale = new AuthorizeNetAIM;

  $orderFields = array(
    'amount' => $data['chk-price'],
    'card_num' => $data['card_no'],
    'exp_date' => $expire_date
  );

  $customerInfo = array(
    'first_name' => $data['first_name'],
    'last_name' => $data['last_name'],
    'country' => $data['country'],
    'cust_id' => $data['customer_id'],
    'customer_ip' => $data['customer_ip'],
    'email' => $data['email'],
  );

  $setFields = array_merge( $orderFields , $customerInfo );

  $sale->setFields( $setFields );

  $response = $sale->authorizeAndCapture();
 
  return json_encode($response);
}

function create_transaction($dataArray){
  global $wpdb;
  $dataArray = json_decode($dataArray,true);
  $userid = get_current_user_id();
  $tab = $wpdb->prefix."order_authorize_donation";
  $status = ( $dataArray['transaction_id'] != 0 && $dataArray['error'] != 1  ) ? 'completed' : 'failed' ;

  if($dataArray['error'] != 1){
    $array = array(
      'transaction_id' => $dataArray['transaction_id'],
      'amount' => $dataArray['amount'],
      'method' => $dataArray['method'],
      'customer_id' => $dataArray['customer_id'],
      'email_address' => $dataArray['email_address'],
      'card_type' => $dataArray['card_type'],
      'status' => $dataArray['response_reason_text'],
      'date' => date('Y-M-D H:i:s '),
    );

    $insert = $wpdb->insert( $tab , $array );
    /*-----Start Conformation mail----*/
    $title = get_bloginfo('name');
    $to = $dataArray['email_address'];
    $sub = 'Donate successfull';
    $body = "Dear customer, <br> <br> Your have successfully Donate. </br> Amount'".$dataArray['amount']."'<br>Transaction id : ".$dataArray['transaction_id']." <br><br><br><br> Thanks and Regards,<br>".$title." Team ";
    $headers_adm = "From:  <".$to.">\r\n";
    $headers_adm .= "MIME-Version: 1.0\r\n";
    $headers_adm .= "Content-Type: text/html; charset=UTF-8\r\n";
    wp_mail($to , $sub , $body , $headers_adm );
    /*-----End Conformation mail----*/
  }
}
