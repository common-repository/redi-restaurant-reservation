<div id="cancel-reservation-div" style="display: none">
	<h4>
		<?php _e('Cancel reservation', 'redi-restaurant-reservation') ?>
	</h4><a href="#cancel" class="back-to-reservation cancel-reservation">
		<?php _e('Back to reservation page', 'redi-restaurant-reservation') ?>
	</a>
	<br />
	<div id="cancel-reservation-form">
		<form method="post" action="?jquery_fail=true">

			<label for="redi-restaurant-cancelID">
				<?php _e('Reservation number', 'redi-restaurant-reservation') ?>:<span
					class="redi_required">*</span>
			</label>
			<input type="text" name="cancelID" id="redi-restaurant-cancelID" class="redi-rest-id" />

			<div class="redi-restaurant-hideContent">
				<label for="cancelPhone-intlTel">
					<?php _e('Phone', 'redi-restaurant-reservation') ?>:
				</label>
				<input type="text" value="" name="cancelPhone-intlTel" id="cancelPhone-intlTel" class="redi-rest-phone" />
				<input type="hidden" name="redi-restaurant-cancelPhone" id="redi-restaurant-cancelPhone" />
				<br/>
			</div>
			<div class="redi-restaurant-hideContent">
				<label for="redi-restaurant-cancelName">
					<?php _e('Name', 'redi-restaurant-reservation') ?>:
				</label>
				<input type="text" name="cancelName" id="redi-restaurant-cancelName" class="redi-rest-name" />
			</div>

			<div class="redi-restaurant-hideContent">
				<label for="redi-restaurant-cancelEmail">
					<?php _e('Email', 'redi-restaurant-reservation') ?>:
				</label>
				<input type="text" name="cancelEmail" id="redi-restaurant-cancelEmail" class="redi-rest-email" />
			</div>

			<label for="redi-restaurant-cancelReason">
				<?php _e('Reason', 'redi-restaurant-reservation') ?>:<?php if ($mandatoryCancellationReason == true): ?><span class="redi_required">*</span>
				<?php endif; ?>
			</label>
			<textarea maxlength="250" rows="5" name="cancelEmail" id="redi-restaurant-cancelReason" class="redi-restaurant-cancelReason" cols="20"></textarea>

			<div>
				<input class="redi-restaurant-button" type="submit" id="redi-restaurant-cancel" name="action"
					value="<?php _e('Cancel reservation', 'redi-restaurant-reservation') ?>">
			</div>

			<img id="cancel-load" style="display: none;"
				src="<?php echo REDI_RESTAURANT_PLUGIN_URL ?>img/ajax-loader.gif" alt="" />
		</form>
	</div>
	<div id="cancel-errors" style="display: none;" class="redi-reservation-alert-error redi-reservation-alert"></div>
	<div id="cancel-success" style="display: none;" class="redi-reservation-alert-success redi-reservation-alert">
		<strong>
			<?php _e('Reservation has been successfully canceled.', 'redi-restaurant-reservation'); ?>
		</strong>
	</div>
</div>