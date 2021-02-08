<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB directory)
 *
 * @category Gentium
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/webdevstudios/Custom-Metaboxes-and-Fields-for-WordPress
 */

/**
 * Conditionally displays a field when used as a callback in the 'show_on_cb' field parameter
 *
 * @param  CMB2_Field object $field Field object
 *
 * @return bool                     True if metabox should show
 */
function cmb2_hide_if_no_cats( $field ) {
	// Don't show this field if not in the cats category
	if ( ! has_tag( 'cats', $field->object_id ) ) {
		return false;
	}

	return true;
}

add_action( 'cmb2_admin_init', 'pixe_metaboxes' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function pixe_metaboxes() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = 'pixe_';

	$pixe_page_cmb = new_cmb2_box( array(
		'id'            => $prefix . 'page_metabox',
		'title'         => esc_html__( 'Page Settings', 'gentium' ),
		'object_types'  => array( 'page', 'portfolio' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
		// 'classes'    => 'extra-class', // Extra cmb2-wrap classes
	) );

	/**
	 * Page Post Type Metaboxes
	 */

	$pixe_page_cmb->add_field( array(
		'name'       => esc_html__( 'Section Title', 'gentium' ),
		'desc'       => esc_html__( 'Show / Hide The Section Title', 'gentium' ),
		'id'      	 => $prefix . 'section_title',
		'type'       => 'select',
		'options' 	 => array(
			'default' => esc_html__( 'Default', 'gentium' ),
			'enable'  => esc_html__( 'Show', 'gentium' ),
			'disable' => esc_html__( 'Hide', 'gentium' ),
		),
	) );

	$pixe_page_cmb->add_field( array(
		'name'       => esc_html__( 'Section Title Background', 'gentium' ),
		'desc'       => esc_html__( 'Upload an image or enter a URL for Section Title', 'gentium' ),
		'id'   		 => $prefix . 'section_title_img',
		'type' 		 => 'file',
	) );

	$pixe_page_cmb->add_field( array(
		'name'       => esc_html__( 'Breadcrumbs', 'gentium' ),
		'desc'       => esc_html__( 'show / Hide The the Breadcrumbs on this page', 'gentium' ),
		'id'   		 => $prefix . 'breadcrumbs_show',
		'type'       => 'select',
		'options' 	 => array(
			'default' => esc_html__( 'Default', 'gentium' ),
			'enable'  => esc_html__( 'Show', 'gentium' ),
			'disable' => esc_html__( 'Hide', 'gentium' ),
		),
	) );

	$pixe_page_cmb->add_field( array(
		'name'       => esc_html__( 'Page Layout', 'gentium' ),
		'desc'       => esc_html__( 'Choose a Layout for Your Page', 'gentium' ),
		'id'      	 => $prefix . 'page_layout',
		'type'       => 'select',
		'options' 	 => array(
			'default' => esc_html__( 'Default', 'gentium' ),
			'boxed' => esc_html__( 'boxed', 'gentium' ),
			'wide' => esc_html__( 'wide', 'gentium' ),
		),
	) );

	$pixe_page_cmb->add_field( array(
		'name'       => esc_html__( 'Page Menu Layout', 'gentium' ),
		'desc'       => esc_html__( 'Choose page menu layout', 'gentium' ),
		'id'      	 => $prefix . 'page_menu_layout',
		'type'       => 'select',
		'options' 	 => array(
			'default' => esc_html__( 'Default', 'gentium' ),
			'white' => esc_html__( 'white', 'gentium' ),
			'phone' => esc_html__( 'With Phone', 'gentium' ),
		),
	) );

	$pixe_page_cmb_side = new_cmb2_box( array(
		'id'            => $prefix . 'page_side_metabox',
		'title'         => esc_html__( 'Sidebar on Default template Pages', 'gentium' ),
		'object_types'  => array( 'page' ), // Post type
		'context'    => 'side',
		'priority'   => 'low',
		'show_names' => true,
	) );

	$pixe_page_cmb_side->add_field( array(
		'name'       => esc_html__( 'Page Layout', 'gentium' ),
		'desc'       => esc_html__( 'Choose a Layout for Your Page', 'gentium' ),
		'id'      	 => $prefix . 'default_page_layout',
		'type'       => 'radio',
		'options'    => array(
			'full' => esc_html__( 'Fullwidth', 'gentium' ),
			'left' => esc_html__( 'Left', 'gentium' ),
			'right' => esc_html__( 'Right', 'gentium' ),
		),
	) );
}
