<?php
ob_start();
function order_listings_page() {
?>

<div>
	<h1>Paytm Payment Details</h1>
		<table cellpadding="0" cellspacing="0" bgcolor="#ccc" width="99%">
			<tr>
				<td><table cellpadding="10" cellspacing="1" width="100%">
				<?php
					global $wpdb;
					$table = $wpdb->prefix . "order_authorize_donation";
					$records_per_page = 10;
					$total = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(id) FROM %6s", $table) );
					$page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
					$offset = ( $page * $records_per_page ) - $records_per_page;
					
					$donationEntries = $wpdb->get_results($wpdb->prepare("SELECT * FROM " .$table. " order by date desc limit %6s,%6s ",$offset,$records_per_page));
					
					if (count($donationEntries) > 0) { ?>
					<thead>
						<tr>
							<th width="8%" align="left" bgcolor="#FFFFFF">Transaction Id</th>
							<th width="8%" align="left" bgcolor="#FFFFFF">Amount</th>
							<th width="10%" align="left" bgcolor="#FFFFFF">Customer id</th>
							<th width="8%" align="left" bgcolor="#FFFFFF">Email</th>
							<th width="10%" align="left" bgcolor="#FFFFFF">Card type</th>
							<th width="8%" align="left" bgcolor="#FFFFFF">Method</th>
							<th width="8%" align="left" bgcolor="#FFFFFF">Date</th>
							<th width="8%" align="left" bgcolor="#FFFFFF">Status</th>
						</tr>
						<?php foreach ($donationEntries as $row) { ?>
						<tr>
							<td bgcolor="#FFFFFF"><?php echo $row->transaction_id ?></td>
							<td bgcolor="#FFFFFF"><?php echo $row->amount ?></td>
							<td bgcolor="#FFFFFF"><?php echo $row->customer_id; ?></td>
							<td bgcolor="#FFFFFF"><?php echo $row->email_address; ?></td>
							<td bgcolor="#FFFFFF"><?php echo $row->card_type; ?></td>
							<td bgcolor="#FFFFFF"><?php echo $row->method; ?></td>
							<td bgcolor="#FFFFFF"><?php echo $row->date; ?></td>
							<td bgcolor="#FFFFFF"><?php echo $row->status; ?></td>
						</tr>
						<?php } ?>
					</thead>
					<?php } else { echo "No Record's Found."; } ?>
				</table></td>
			</tr>
		</table>		
		<?php
		$pagination = paginate_links( array(
				'base' => add_query_arg( 'cpage', '%#%' ),
				'format' => '',
				'prev_text' => __('Previous'),
				'next_text' => __('Next'),
				'total' => ceil($total / $records_per_page),
				'current' => $page
		));
		?>		
		<div class="donation-pagination">
			<?php echo $pagination; ?>
		</div>
	</div>
<?php } ?>
