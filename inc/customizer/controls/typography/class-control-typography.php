<?php
/**
 * Customizer Control: kindling-typography.
 *
 * @package     Kindling WordPress theme
 * @subpackage  Controls
 * @since       1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Typography control
 */
class Kindling_Customizer_Typography_Control extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kindling-typography';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		wp_enqueue_script( 'kindling-select2', KINDLING_INC_DIR_URI . 'customizer/controls/typography/select2.min.js', array( 'jquery' ), false, true );
		wp_enqueue_style( 'select2-css', KINDLING_INC_DIR_URI . 'customizer/controls/typography/select2.min.css', null );
		wp_enqueue_script( 'kindling-typography', KINDLING_INC_DIR_URI . 'customizer/controls/typography/typography.js', array( 'jquery', 'select2' ), false, true );
		wp_enqueue_style( 'kindling-typography-css', KINDLING_INC_DIR_URI . 'customizer/controls/typography/typography.css', null );
	}

	/**
	 * Render the control's content.
	 * Allows the content to be overriden without having to rewrite the wrapper in $this->render().
	 *
	 * @access protected
	 */
	protected function render_content() {
		$this_val = $this->value(); ?>
		<label>
			<?php if ( ! empty( $this->label ) ) : ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
			<?php endif; ?>

			<select class="kindling-typography-select" <?php $this->link(); ?>>
				<option value="" <?php if ( ! $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Default', 'kindling' ); ?></option>
				<?php
				// Add custom fonts from child themes
				if ( function_exists( 'kindling_add_custom_fonts' ) ) {
					$fonts = kindling_add_custom_fonts();
					if ( $fonts && is_array( $fonts ) ) { ?>
						<optgroup label="<?php esc_html_e( 'Custom Fonts', 'kindling' ); ?>">
							<?php foreach ( $fonts as $font ) { ?>
								<option value="<?php echo $font; ?>" <?php if ( $font == $this_val ) echo 'selected="selected"'; ?>><?php echo $font; ?></option>
							<?php } ?>
						</optgroup>
					<?php }
				}

				// Get Standard font options
				if ( $std_fonts = kindling_standard_fonts() ) { ?>
					<optgroup label="<?php esc_html_e( 'Standard Fonts', 'kindling' ); ?>">
						<?php
						// Loop through font options and add to select
						foreach ( $std_fonts as $font ) { ?>
							<option value="<?php echo $font; ?>" <?php selected( $font, $this_val ); ?>><?php echo $font; ?></option>
						<?php } ?>
					</optgroup>
				<?php }

				// Google font options
				if ( $google_fonts = kindling_google_fonts_array() ) { ?>
					<optgroup label="<?php esc_html_e( 'Google Fonts', 'kindling' ); ?>">
						<?php
						// Loop through font options and add to select
						foreach ( $google_fonts as $font ) { ?>
							<option value="<?php echo $font; ?>" <?php selected( $font, $this_val ); ?>><?php echo $font; ?></option>
						<?php } ?>
					</optgroup>
				<?php } ?>
			</select>

		</label>

		<?php
	}
}
