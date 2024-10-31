
<div class="radi-modal" style="display:none">
	<div class="radi-modal-dialog">
		<form action="welcome.php" method="post" name="radidata">
			<div class="radi-modal-header">
				<h4>Quick Feedback</h4>
			</div>
			<div class="radi-modal-body">
				<h3><strong>If you have a moment, please let us know why you are deactivating:</strong></h3>
				<ul id="radi-list">
					<li class="reason">
			            <label>
			                <input type="radio" name="selected-reason" value="I found better plugin">
			                <span for="rad">I found better plugin</span>
			                <span class="input_field">
			                	<label>
					                <span>Alternative Plugin Name:</span>
					                <input type="text" name="plugin_name" id="plugin_name" placeholder="Alternative Plugin Name" value="">
					            </label>
			                </span>
			            </label>
			       	</li>
			       	<li class="reason">
			            <label>
			                <input type="radio" name="selected-reason" value="Plugin does not work on my site">
			                <span>Plugin does not work on my site</span>
			                <span class="input_field">
			                	<label>
					                <input type="text" name="plugin_not_work_name" placeholder="Details" value="">
					                <input type="email" name="plugin_not_work_email" placeholder="Email Address" value="<?php echo wp_get_current_user()->user_email; ?>">
					            </label>
			                </span>
			            </label>
			        </li>
			        <li class="reason">
			            <label>
			                <input type="radio" name="selected-reason" value="It's temporary deactivation">
			                <span>It's temporary deactivation</span>
			            </label>
			        </li>
			        <li class="reason">
			            <label>
			                <input type="radio" name="selected-reason" value="I'm unable to configure it according to my needs">
			                <span>I'm unable to configure it according to my needs</span>
			                <span class="input_field">
			                	<label>
					                <input type="text" name="plugin_configure_name" placeholder="Details" value="">
					                <input type="email" name="plugin_configure_email" placeholder="Email Address" value="<?php echo wp_get_current_user()->user_email; ?>">
					            </label>
			                </span>
			            </label>
			        </li>
			        <li class="reason">
			            <label>
			                <input type="radio" name="selected-reason" value="Design of plugin is outdated">
			                <span>Design of plugin is outdated</span>
			            </label>
			        </li>
			        <li class="reason">
			            <label>
			                <input type="radio" name="selected-reason" value="I do not want to pay for the plugin">
			                <span>I do not want to pay for the plugin</span>
			            </label>
			        </li>
			        <li class="reason">
			            <label>
			                <input type="radio" name="selected-reason" value="I did not find a needed feature in the free version">
			                <span>I did not find a needed feature in the free version</span>
			                <span class="input_field">
			                	<label>
					                <input type="text" name="plugin_feature_name" placeholder="Details" value="">
					                <input type="email" name="plugin_feature_email" placeholder="Email Address" value="<?php echo wp_get_current_user()->user_email; ?>">
					            </label>
			                </span>
			            </label>
			        </li>
			        <li class="reason">
			            <label>
			                <input type="radio" name="selected-reason" value="__other_option__">
			                <span>Other</span>
			                <textarea name="comment"></textarea>
			            </label>
			        </li>
			    </ul>
			</div>
			<div class="radi-modal-footer">
				<input type="submit" class="button button-secondary" name="submit" value="Submit &amp; Deactivate">
				<a href="jQuery:;" class="button button-secondary button-close">Cancel</a>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	jQuery('tr.active[data-slug="redi-restaurant-reservation"] .deactivate a').click(function(e){
		e.preventDefault();

  		jQuery('.radi-modal').show();
  		jQuery('.radi-modal').addClass('active');
		var radisubmit = jQuery(this).attr('href');
		jQuery('.radi-modal form').attr('action', radisubmit);

	});
	jQuery('.radi-modal input[type=radio]').change(function() {
		jQuery(this).parents('.reason').siblings().find('.input_field input').removeAttr("required");
		jQuery(this).siblings(".input_field").find('input').attr('required', 'required');
		if (this.value == '__other_option__') {
			jQuery('.radi-modal input[type="radio"]:checked').siblings('textarea').attr('required', 'required');
		}else{
			jQuery('.radi-modal .reason textarea').removeAttr("required");
		}
	});
	jQuery('.radi-modal .button-close').click(function(e){
		jQuery('.radi-modal').hide();
	});	
	jQuery('body').click(function (e) {
		if(e.target === jQuery('.radi-modal form')['0']) {
		    jQuery('.radi-modal').hide();
		}     
	});
	jQuery(document).on('click',function(e){
	    if(!((jQuery(e.target).closest(".radi-modal form").length > 0 ) || (jQuery(e.target).closest('tr.active[data-slug="redi-restaurant-reservation"] .deactivate a').length > 0))){
	    	jQuery(".radi-modal").hide();
	   }
	});
</script>