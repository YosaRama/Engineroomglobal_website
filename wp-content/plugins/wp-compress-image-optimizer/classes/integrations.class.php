<?php


/**
 * Class - Integrations
 */
class wps_ic_integrations {

  private $plugins = false;

  public function __construct() {

  }


  public function getActiveIntegrations() {

    $active_plugins = (array)apply_filters('active_plugins', get_option('active_plugins', array()));

    // Is it a multisite?
    if (is_multisite()) {
      $active_plugins = array_merge($active_plugins, array_keys(get_site_option('active_sitewide_plugins')));
    }

    if (in_array('wp-rocket/wp-rocket.php', $active_plugins)) {
      $path = dirname(dirname(__DIR__)) . '/wp-rocket/wp-rocket.php';
      $wpRocketSettings = get_option('wp_rocket_settings', array());
      $rocket = array( 'lazyload' => (isset($wpRocketSettings['lazyload']) && $wpRocketSettings['lazyload'] == 1),
                       'css-filter' => 'true',
                       'minify-css' => isset($wpRocketSettings['minify_css']) && $wpRocketSettings['minify_css'] == 1);
    } else {
      $rocket = array('lazyload' => false, 'css-filter' => false, 'minify-css' => false);
    }

    $this->plugins = array(
      'wp-rocket' => $rocket,
      'brizy' => in_array('brizy/brizy.php', $active_plugins),
      'nextgen' => in_array('nextgen-gallery/nggallery.php', $active_plugins),
      'modula' => in_array('modula-best-grid-gallery/Modula.php', $active_plugins),
      'elementor' => in_array('elementor/elementor.php', $active_plugins),
      'oxygen' => in_array( 'oxygen/functions.php', $active_plugins),
      'viba-portfolio' => in_array('viba-portfolio/viba-portfolio.php', $active_plugins),
      'elementor-addons' => in_array('essential-addons-for-elementor/essential_adons_elementor.php', $active_plugins) || in_array('essential-addons-for-elementor-lite/essential_adons_elementor.php', $active_plugins),
      'envira' => in_array('envira-gallery/envira-gallery.php', $active_plugins) || in_array('envira-gallery-lite/envira-gallery-lite.php', $active_plugins),
      'wp-bakery' => in_array('js_composer/js_composer.php', $active_plugins),
      'everest' => in_array('everest-gallery/everest-gallery.php', $active_plugins) || in_array('everest-gallery-lite/everest-gallery-lite.php', $active_plugins),
      'woocommerce' => in_array('woocommerce/woocommerce.php' , $active_plugins),
      'slider-revolution' => in_array('revslider/revslider.php', $active_plugins),
      'foo' => in_array('foogallery/foogallery.php', $active_plugins),
      'wp-grid-builder' => in_array('wp-grid-builder/wp-grid-builder.php', $active_plugins),
      'smart-slider' => in_array('smart-slider-3/smart-slider-3.php', $active_plugins) || in_array('nextend-smart-slider3-pro/nextend-smart-slider3-pro.php', $active_plugins),
    );

    return $this->plugins;

  }


  public function isActive($plugin_name) {
    $activePlugins = $this->getActiveIntegrations();
    if (isset($activePlugins[$plugin_name]) && $activePlugins[$plugin_name] == true) {
      return true;
    } else {
      return false;
    }
  }


  public function parse($content) {

  }

}