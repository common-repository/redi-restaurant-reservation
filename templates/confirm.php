<div id="confirm-reservation-div">
    <h4>
	<?php _e('Visit confirmation', 'redi-restaurant-reservation')?></h4>
	<p><?php _e('We would like to know if you will be visiting us today. Please confirm or cancel your reservation by clicking the appropriate button below. If the reservation is not confirmed, we reserve the right to cancel it from our side.', 'redi-restaurant-reservation')?> </p>
	<div id="confirm-reservation-form">
	<form method="post">
	<input type="hidden" id="redi-reservation-id" value="<?php echo $reservation['Id']; ?>">
	<input type="hidden" id="redi-phone" value="<?php echo $reservation['Phone']; ?>">		
	<table class="wp-block-table">
  <tbody>
    <tr>
      <td><?php _e('Reservation number', 'redi-restaurant-reservation')?></td>
      <td><?php echo number_format($reservation["Id"], 0, '', ' ') ?></td>
    </tr>
    <tr>
      <td><?php _e('Date', 'redi-restaurant-reservation')?>
	</td>
      <td>
		<?php
            $date_format_setting = $this->GetOption('DateFormat');
            $date_format = RediDateFormats::getPHPDateFormat($date_format_setting);

			echo gmdate($date_format, strtotime($reservation["From"], 0));
		?>
	  </td>
    </tr>
    <tr>
      <td><?php _e('Time', 'redi-restaurant-reservation')?></td>
      <td><?php $time_format = get_option('time_format');
		echo ReDiTime::format_time($reservation["From"], null, $time_format);
		?></td>
    </tr>
    <tr>
      <td><?php _e('Guests', 'redi-restaurant-reservation')?></td>
      <td><?php echo $reservation['Persons']?></td>
    </tr>
  </tbody>
</table>
<div id="redi-confirm-visit-buttons">
			<input class="redi-restaurant-button" type="submit" id="redi-restaurant-confirm-visit" name="action" value="<?php _e('Confirm visit', 'redi-restaurant-reservation')?>">
			<input class="redi-restaurant-button" type="submit" id="redi-restaurant-visit-cancel" name="action" value="<?php _e('Cancel reservation', 'redi-restaurant-reservation')?>">
</div>
		</div>
                <img id="visit-load" style="display: none;" src="<?php echo REDI_RESTAURANT_PLUGIN_URL ?>img/ajax-loader.gif" alt=""/>
		</form>
	</div>
	<div id="confirm-errors" style="display: none;" class="redi-reservation-alert-error redi-reservation-alert"></div>
	<div id="confirm-success" style="display: none;" class="redi-reservation-alert-success redi-reservation-alert">
		<strong>
			<?php _e( 'Visit has been successfully confirmed.', 'redi-restaurant-reservation' ); ?>
		</strong>
	</div>
	<div id="cancel-success" style="display: none;" class="redi-reservation-alert-success redi-reservation-alert">
		<strong>
			<?php _e( 'Reservation has been successfully canceled.', 'redi-restaurant-reservation' ); ?>
		</strong>
	</div>
</div>
