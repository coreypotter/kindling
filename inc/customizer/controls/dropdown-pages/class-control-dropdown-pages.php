<?php
/**
 * Customizer Control: kindling-dropdown-pages.
 *
 * @package     Kindling Theme
 * @subpackage  Controls
 * @see   		https://github.com/aristath/kirki
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dropdown pages control
 */
class Kindling_Customizer_Dropdown_Pages extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kindling-dropdown-pages';

	/**
	 * Render the control's content.
	 * Allows the content to be overriden without having to rewrite the wrapper in $this->render().
	 *
	 * @access protected
	 */
	protected function render_content() {
		?>
		<label>
			<?php if ( ! empty( $this->label ) ) : ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
			<?php endif; ?>
		</label>

		<?php
		$dropdown = wp_dropdown_pages(
			array(
				'name'              => '_customize-dropdown-pages-' . esc_attr( $this->id ),
				'echo'              => 0,
				'show_option_none'  => '&mdash; '. esc_html__( 'Select', 'kindling' ) .' &mdash;',
				'option_none_value' => '',
				'selected'          => esc_attr( $this->value() ),
			)
		);

		// Hackily add in the data link parameter.
		echo str_replace( '<select', '<select ' . $this->get_link(), $dropdown );

	}
}
