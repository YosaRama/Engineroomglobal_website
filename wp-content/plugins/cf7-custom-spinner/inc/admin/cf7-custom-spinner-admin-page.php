<div class="wrap pp-admin-page-wrapper" id="pp-cf7-custom-spinner-settings">
  <h1>
    <span><?php echo $this->_core->get_plugin_name(); ?></span>
    <nav>
      <?php $this->show_nav_icons( array(
        array( 
          'link'  => 'https://wordpress.org/support/plugin/' . $this->_core->get_plugin_slug() . '/reviews/',
          'title' => __( 'Please rate Plugin', 'cf7-custom-spinner' ),
          'icon'  => 'dashicons-star-filled'
        ),
        array( 
          'link'  => 'https://wordpress.org/plugins/' . $this->_core->get_plugin_slug(),
          'title' => __( 'WordPress.org Plugin Page', 'cf7-custom-spinner' ),
          'icon'  => 'dashicons-wordpress'
        ),
        array( 
          'link'  => 'https://wordpress.org/support/plugin/' . $this->_core->get_plugin_slug(),
          'title' => __( 'Support', 'cf7-custom-spinner' ),
          'icon'  => 'dashicons-editor-help'
        ),
        array( 
          'link'  => 'https://petersplugins.com/',
          'title' => __( 'Authors Website', 'cf7-custom-spinner' ),
          'icon'  => 'dashicons-admin-home'
        ),
        array( 
          'link'  => 'https://www.facebook.com/petersplugins/',
          'title' => __( 'Authors Facebook Page', 'cf7-custom-spinner' ),
          'icon'  => 'dashicons-facebook-alt'
        )
        
      ) ); ?>
    </nav>
  </h1>
    <?php settings_errors(); ?>
    
    <div class="postbox">
      <div class="inside">
        <?php if ( ! $this->_core->is_cf7_active() )  { ?>
          <p><?php _e( 'This plugin needs the <a href="https://wordpress.org/plugins/contact-form-7/">Contact Form 7</a> plugin to be active!', 'cf7-custom-spinner' ); ?></p>
        <?php } else { ?>
        
          <form method="POST" action="options.php">
            <ul id="cf7-custom-spinner-admin" style="display: none">
              
              <li id="cf7-custom-spinner-admin-type">
              
                <h2><?php _e( 'Select Spinner Type', 'cf7-custom-spinner' ); ?></h2>
                
                <div class="container">
                  <?php echo $this->get_spinner_list_html(); ?>
                </div>
                
              </li>
              
              <li id="cf7-custom-spinner-admin-color">
              
                <h2><?php _e( 'Select Spinner Color', 'cf7-custom-spinner' ); ?></h2>
                
                <?php echo $this->get_colors_list_html(); ?>
                
              </li>
              
              <li id="cf7-custom-spinner-admin-size">
                
                <h2><?php _e( 'Select Spinner Size', 'cf7-custom-spinner' ); ?></h2>
                
                <?php echo $this->get_sizes_list_html(); ?>
              
              </li>
              
            </ul>
            
            <?php settings_fields( $this->_core->get_option_name_settings() ); ?>
            <?php do_settings_sections( $this->_core->get_plugin_slug() ); ?>
            <?php submit_button(); ?>
            
            <p><?php _e( '<strong>Note:</strong> the displayed background color is only for preview, on your website the spinner  is displayed with transparent background', 'cf7-custom-spinner' ); ?></p>
            
          </form>
            
        <?php } ?>
      </div>
    </div>
    
    <div class="postbox">
      <div class="inside">
        <h2><?php _e( 'Test current setting', 'cf7-custom-spinner' ); ?></h2>
        <p><?php _e( '<strong>Note:</strong> you have to save your changes before', 'cf7-custom-spinner' ); ?></p>
        <p><?php wp_dropdown_pages( array( 'id' => 'cf7-custom-spinner-test', 'show_option_none' => '[ ' . __( 'Select your contact page to test with', 'cf7-custom-spinner' ) . ' ]', 'option_none_value' => -1 ) ); ?></p>
        <p><?php _e( 'This opens the page you select and shows the spinner animation immediately without the need to click the submit button on your form', 'cf7-custom-spinner' ); ?></p>
      </div>
    </div>
</div>