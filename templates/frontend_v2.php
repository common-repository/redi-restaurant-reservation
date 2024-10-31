<!-- ReDi Restaurant Reservation plugin version <?php echo $this->version ?> -->
<!-- Revision: 20240220 -->
<div class="redi-reservation-form">
	<div class="redi-step__item">
		<ul class="redi-steps-nav">
			<li class="redi-steps-nav__step">
				<span class="redi-steps-nav__step__line">
					<span class="redi-steps-nav__step__progress"></span>
				</span>
				<span class="redi-steps-nav__step__number">1</span>
				<span class="icon-check"></span>
				<span class="redi-steps-nav__step__description">
					<?php _e('Place', 'redi-restaurant-reservation') ?>
				</span>
			</li>

			<li class="redi-steps-nav__step">
				<span class="redi-steps-nav__step__line">
					<span class="redi-steps-nav__step__progress"></span>
				</span>
				<span class="redi-steps-nav__step__number">2</span>
				<span class="icon-check"></span>
				<span class="redi-steps-nav__step__description">
					<?php _e('Guests', 'redi-restaurant-reservation') ?>
				</span>
			</li>

			<li class="redi-steps-nav__step">
				<span class="redi-steps-nav__step__line">
					<span class="redi-steps-nav__step__progress"></span>
				</span>
				<span class="redi-steps-nav__step__number">3</span>
				<span class="icon-check"></span>
				<span class="redi-steps-nav__step__description">
					<?php _e('Date', 'redi-restaurant-reservation') ?>
				</span>
			</li>

			<li class="redi-steps-nav__step">
				<span class="redi-steps-nav__step__line">
					<span class="redi-steps-nav__step__progress"></span>
				</span>
				<span class="redi-steps-nav__step__number">4</span>
				<span class="icon-check"></span>
				<span class="redi-steps-nav__step__description">
					<?php _e('Time', 'redi-restaurant-reservation') ?>
				</span>
			</li>

			<li class="redi-steps-nav__step">
				<span class="redi-steps-nav__step__line">
					<span class="redi-steps-nav__step__progress"></span>
				</span>
				<span class="redi-steps-nav__step__number">5</span>
				<span class="icon-check"></span>
				<span class="redi-steps-nav__step__description">
					<?php _e('Form', 'redi-restaurant-reservation') ?>
				</span>
			</li>

			<li class="redi-steps-nav__step">
				<span class="redi-steps-nav__step__line">
					<span class="redi-steps-nav__step__progress"></span>
				</span>
				<span class="redi-steps-nav__step__number">6</span>
				<span class="icon-check"></span>
				<span class="redi-steps-nav__step__description">
					<?php _e('Confirmation', 'redi-restaurant-reservation') ?>
				</span>
			</li>
		</ul>
	</div>

	<div class="redi-step__item">
		<h1>Place</h1>
		<div class="redi-place-container">
			<div class="redi-places">
				<span class="selected-place">
					<div class="redi-place place-not-selected">
						<span class="select-place-icon"></span>
						<div>
							<div class="name">Select restaurant</div>
							<div class="address"></div>
						</div>
						<span class="redi-place-dropdown-icon icon-chevron-down"></span>
					</div>
				</span>
				<span class="place-options">
					<div class="redi-place">
						<span class="select-place-option-icon"></span>
						<div>
							<div class="name">Restaurant 1</div>
							<div class="address">Taludevahe 961, Tallinn</div>
						</div>
					</div>
					<div class="redi-place">
						<span class="select-place-option-icon"></span>
						<div>
							<div class="name">Restaurant 2</div>
							<div class="address">Taludevahe 962, Tallinn</div>
						</div>
					</div>
					<div class="redi-place">
						<span class="select-place-option-icon"></span>
						<div>
							<div class="name">Restaurant 3</div>
							<div class="address">Taludevahe 963, Tallinn</div>
						</div>
					</div>
				</span>
			</div>
		</div>
	</div>
	<div>