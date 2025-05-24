<?php

namespace StealthRatings;

class Settings {
	public static function init() {
		add_action( 'admin_init', [ __CLASS__, 'register_settings' ] );
		add_action( 'admin_menu', [ __CLASS__, 'add_menu' ] );
	}

	public static function register_settings() {
		register_setting('stealth_ratings_settings', 'stealth_ratings_email', [
			'type' => 'string',
			'sanitize_callback' => 'sanitize_email',
			'default' => get_option('admin_email'),
		]);

        add_settings_section(
            'stealth_ratings_section',
            __( 'Stealth Ratings Settings', 'stealth-ratings-block' ),
            [ __CLASS__, 'render_section' ],
            'stealth_ratings'
        );

        add_settings_field(
            'stealth_ratings_email',
            __( 'Feedback Recipient Email', 'stealth-ratings-block' ),
            [ __CLASS__, 'render_field' ],
            'stealth_ratings',
            'stealth_ratings_section'
        );
	}

	public static function add_menu() {
		add_options_page(
			__( 'Stealth Ratings Settings', 'stealth-ratings-block' ),
			__( 'Stealth Ratings', 'stealth-ratings-block' ),
			'manage_options',
			'stealth-ratings-settings',
			[ __CLASS__, 'render_page' ]
		);
	}

	public static function render_page() {
		?>
		<div class="wrap">
			<h1><?php _e( 'Stealth Ratings Settings', 'stealth-ratings-block' ); ?></h1>
			<form method="post" action="options.php">
				<?php
				settings_fields('stealth_ratings_settings');
				do_settings_sections('stealth_ratings_settings');
				?>
				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e( 'Feedback Recipient Email', 'stealth-ratings-block' ); ?></th>
						<td>
							<input type="email" name="stealth_ratings_email" value="<?php echo esc_attr(get_option('stealth_ratings_email', get_option('admin_email'))); ?>" class="regular-text" required />
							<p class="description"><?php _e( 'Feedback from the ratings block will be sent to this email address.', 'stealth-ratings-block' ); ?></p>
						</td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}
}
