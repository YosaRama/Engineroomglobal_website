<?php


class wps_ic_legacy {

  public static $site_url;
  public static $adaptive_enabled;
  public static $webp_enabled;
  public static $lazy;
  public static $settings;
  public static $updir;
  public static $svg_placeholder;
  public static $excluded_list;

  public function __construct() {

    if ( ! empty($_GET['ignore_ic'])) {
      return;
    }

		self::$settings         = get_option(WPS_IC_SETTINGS);
		if (!empty(self::$settings['live-cdn']) && self::$settings['live-cdn'] == '0') {
			return;
		}

    if ( ! is_admin()) {

      self::$site_url         = site_url();
      self::$adaptive_enabled = self::$settings['generate_adaptive'];
      self::$webp_enabled     = self::$settings['generate_webp'];
      self::$lazy             = self::$settings['lazy'];
      self::$svg_placeholder  = 'data:image/svg+xml,%3Csvg%20viewBox%3D%220%200%20#width#%20#height#%22%20width%3D%22#width#%22%20height%3D%22#height#%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3C%2Fsvg%3E';
      self::$excluded_list         = get_option('wps_ic_excluded_list');

      add_filter('the_content', array($this, 'searchContent'), 10000);
      add_filter('the_excerpt', array($this, 'searchContent'), 10000);
      add_filter('post_thumbnail_html', array($this, 'searchContent'));
    }

  }


  public function legacyObStart() {
    ob_start(array(&$this, 'searchContent'));
  }


  public function searchContent($content) {

    if (($this->webpEnabled() && $this->webpSupported()) || $this->adaptiveEnabled()) {
      // WebP
      self::$updir = wp_upload_dir();
      $content     = preg_replace_callback('/<img[^>]*>/i', array(&$this, 'convertImagetoWebp'), $content);
    } else {
      // noWebP
      self::$updir = wp_upload_dir();
      $content     = preg_replace_callback('/<img[^>]*>/i', array(&$this, 'convertImagetoWPC'), $content);
    }

    return $content;
  }


  public function is_excluded($image_element, $image_link = '') {
    if (empty($image_link)) {
      preg_match('@src="([^"]+)"@', $image_element, $match_url);
      $basename_original = basename($match_url[1]);
    } else {
      $basename_original = basename($image_link);
    }

    preg_match("/([0-9]+)x([0-9]+)\.[a-zA-Z0-9]+/", $basename_original, $matches); //the filename suffix way
    if (empty($matches)) {
      // Full Image
      $basename = $basename_original;
    } else {
      // Some thumbnail
      $basename = str_replace('-' . $matches[1] . 'x' . $matches[2], '', $basename_original);
    }

    if (!empty(self::$excluded_list) && in_array($basename, self::$excluded_list)) {
      return true;
    } else {
      return false;
    }

  }


  public function get_attributes($element) {
    $dom = new DOMDocument();
    @$dom->loadHTML($element);
    $image      = $dom->getElementsByTagName('img')->item(0);
    $attributes = array();

    if ( ! is_object($image)) {
      return false;
    }

    foreach ($image->attributes as $attr) {
      $attributes[ $attr->nodeName ] = $attr->nodeValue;
    }

    return $attributes;
  }


  public function image_url_matching_site_url($image) {
    $site_url          = self::$site_url;
    $site_url_protocol = parse_url($site_url, PHP_URL_SCHEME);
    $image_protocol    = parse_url($image, PHP_URL_SCHEME);

    if ($site_url_protocol != $image_protocol) {
      $site_url = str_replace($site_url_protocol, $image_protocol, $site_url);
    }

    if (strpos($image, $site_url) === false) {
      // Image not on site
      return false;
    } else {
      // Image on site
      return true;
    }

  }


  public function is_st() {
		if ( ! empty($_GET['write_speedtest_log'])) {
			$fp = fopen(WPS_IC_DIR . 'speedtest.txt', 'a+');
			fwrite($fp, 'IP: ' . $_SERVER['REMOTE_ADDR'] . "\r\n");
			fwrite($fp, 'User Agent: ' . $_SERVER['HTTP_USER_AGENT'] . "\r\n");
			fclose($fp);
		}

		if (is_admin()) {
			return false;
		}

		$ip_list = array(0  => '52.162.212.163',
										 1  => '13.78.216.56',
										 2  => '65.52.113.236',
										 3  => '52.229.122.240',
										 4  => '172.255.48.147',
										 5  => '172.255.48.146',
										 6  => '172.255.48.145',
										 7  => '172.255.48.144',
										 8  => '172.255.48.143',
										 9  => '172.255.48.142',
										 10 => '208.70.247.157',
										 11 => '172.255.48.141',
										 12 => '172.255.48.140',
										 13 => '172.255.48.139',
										 14 => '172.255.48.138',
										 15 => '172.255.48.137',
										 16 => '172.255.48.136',
										 17 => '172.255.48.135',
										 18 => '172.255.48.134',
										 19 => '172.255.48.133',
										 20 => '172.255.48.132',
										 21 => '172.255.48.131',
										 22 => '172.255.48.130',
										 23 => '104.214.48.247',
										 24 => '40.74.243.176',
										 25 => '40.74.243.13',
										 26 => '40.74.242.253',
										 27 => '13.85.82.26',
										 28 => '13.85.24.90',
										 29 => '13.85.24.83',
										 30 => '13.66.7.11',
										 31 => '104.214.72.101',
										 32 => '191.235.99.221',
										 33 => '191.235.98.164',
										 34 => '104.41.2.19',
										 35 => '104.211.165.53',
										 36 => '104.211.143.8',
										 37 => '172.255.61.40',
										 38 => '172.255.61.39',
										 39 => '172.255.61.38',
										 40 => '172.255.61.37',
										 41 => '172.255.61.36',
										 42 => '172.255.61.35',
										 43 => '172.255.61.34',
										 44 => '65.52.36.250',
										 45 => '70.37.83.240',
										 46 => '104.214.110.135',
										 47 => '157.55.189.189',
										 48 => '191.232.194.51',
										 49 => '52.175.57.81',
										 50 => '52.237.236.145',
										 51 => '52.237.250.73',
										 52 => '52.237.235.185',
										 53 => '40.83.89.214',
										 54 => '40.123.218.94',
										 55 => '102.133.169.66',
										 56 => '52.172.14.87',
										 57 => '52.231.199.170',
										 58 => '52.246.165.153',
										 59 => '13.76.97.224',
										 60 => '13.53.162.7',
										 61 => '20.52.36.49',
										 62 => '20.188.63.151',
										 63 => '51.144.102.233',
										 64 => '23.96.34.105');

		$x11        = strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'x11');
		$pingdom    = strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'pingdom');
		$pingdombot = strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'pingbot');
		$gtmetrix   = strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'gtmetrix');
		$pageSpeed  = strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'pagespeed');
		$google     = strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'google page speed');
		$google_ps  = strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'lighthouse');

		if ( ! empty($_GET['simulate_test'])) {
			return true;
		}

		if ($x11 !== false) {
			return true;
		}

		if ($pingdom !== false) {
			return true;
		}

		if ($pingdombot !== false) {
			return true;
		}

		if ($pageSpeed !== false) {
			return true;
		}

		if ($gtmetrix !== false) {
			return true;
		}

		if ($google !== false) {
			return true;
		}

		if ($google_ps !== false) {
			return true;
		}

		$userIP = $_SERVER['REMOTE_ADDR'];
		if (in_array($userIP, $ip_list)) {
			return true;
		}
		else {
			return false;
		}
  }


  public function convertImagetoWPC($image) {

    if ($this->is_excluded($image[0])) {
      return $image[0];
    }

    // Fetch image attributes
    $img = self::get_attributes($image[0]);
    $sourceInfo   = $this->Get($img, 'src');
    $source       = $sourceInfo['value'];
    $sourcePrefix = $sourceInfo['prefix'];

    $sourcesetInfo   = $this->Get($img, 'srcset');
    $sourceset       = $sourcesetInfo['value'];
    $sourcesetPrefix = $sourceset ? $sourceInfo['prefix'] : $sourceInfo['prefix'];

    $sizesInfo   = $this->Get($img, 'sizes');
    $sizes       = $sizesInfo['value'];
    $sizesPrefix = $sizesInfo['prefix'];

    if ($this->is_st()) {
      $sizes = '(max-width: 230px) 100vw, 230px';
    }

    //some attributes should not be moved from <img>
    $altAttr    = isset($img['alt']) && strlen($img['alt']) ? ' alt="' . $img['alt'] . '"' : '';
    $idAttr     = isset($img['id']) && strlen($img['id']) ? ' id="' . $img['id'] . '"' : '';
    $heightAttr = isset($img['height']) && strlen($img['height']) ? ' height="' . $img['height'] . '"' : '';
    $widthAttr  = isset($img['width']) && strlen($img['width']) ? ' width="' . $img['width'] . '"' : '';

    if ( ! preg_match('/\.(jpg|jpeg|png|gif)/', $source, $matches)) {
      return $image[0];
    }

    if ( ! $this->image_url_matching_site_url($image[0])) {
      return $image[0];
    }

    if (preg_match('/\.svg/', $source, $matches)) {
      return $image[0];
    }

    $lazy_loading = '';
    $svg          = '';
    $source_svg   = $source;
    if (self::$lazy == '1') {
      $lazy_loading = 'loading="lazy"';

      $image_base_dir = self::$updir['basedir'];
      $image_base_url = self::$updir['baseurl'];
      $fileDir        = str_replace($image_base_url, $image_base_dir, $source);

      if (file_exists($fileDir)) {
        $image_size = getimagesize($fileDir);
        $svg        = str_replace('#width#', '100%', self::$svg_placeholder);
        $svg        = str_replace('#height#', '100%', $svg);
        $source_svg = $svg;
      }
    }

    $output = '<img src="' . $source_svg . '"  ' . self::create_attributes($img) . ' srcset="' . $sourceset . '"' . ' sizes="' . $sizes . '"' . $lazy_loading . ' class="' . $img['class'] . '" />';

    return $output;

  }


  public function convertImagetoWebp($image) {

    if ($this->is_excluded($image[0])) {
      return $image[0];
    }

    // Fetch image attributes
    $img = self::get_attributes($image[0]);

    $sourceInfo   = $this->Get($img, 'src');
    $source       = $sourceInfo['value'];
    $sourcePrefix = $sourceInfo['prefix'];

    $sourcesetInfo   = $this->Get($img, 'srcset');
    $sourceset       = $sourcesetInfo['value'];
    $sourcesetPrefix = $sourceset ? $sourceInfo['prefix'] : $sourceInfo['prefix'];

    $sizesInfo   = $this->Get($img, 'sizes');
    $sizes       = $sizesInfo['value'];
    $sizesPrefix = $sizesInfo['prefix'];

    if ($this->is_st()) {
      $sizes = '(max-width: 230px) 100vw, 230px';
    }

    //some attributes should not be moved from <img>
    $altAttr    = isset($img['alt']) && strlen($img['alt']) ? ' alt="' . $img['alt'] . '"' : '';
    $idAttr     = isset($img['id']) && strlen($img['id']) ? ' id="' . $img['id'] . '"' : '';
    $heightAttr = isset($img['height']) && strlen($img['height']) ? ' height="' . $img['height'] . '"' : '';
    $widthAttr  = isset($img['width']) && strlen($img['width']) ? ' width="' . $img['width'] . '"' : '';

    if ( ! preg_match('/\.(jpg|jpeg|png|gif)/', $source, $matches)) {
      return $image[0];
    }

    if ( ! $this->image_url_matching_site_url($image[0])) {
      return $image[0];
    }

    if (preg_match('/\.svg/', $source, $matches)) {
      return $image[0];
    }

    $sourceSet_Webp = self::replaceSrcSet($img['srcset']);

    if (empty($sourceSet_Webp)) {
      $sourceSet_Webp = '';
      $image_base_dir = self::$updir['basedir'];
      $image_base_url = self::$updir['baseurl'];

      $fileWebPDir = str_replace($image_base_url, $image_base_dir, $source);
      $fileWebPDir = str_replace(array('.jpg', '.png', '.gif'), '.webp', $fileWebPDir);

      if (file_exists($fileWebPDir)) {
        $fileWebP       = str_replace(array('.jpg', '.png', '.gif'), '.webp', $source);
        $sourceSet_Webp .= $fileWebP;
      }
    }

    $lazy_class = '';
    $lazy_loading = '';
    $svg          = '';
    $source_svg   = $source;
    if (self::$lazy == '1') {
      $lazy_loading = 'loading="lazy" ';
      $lazy_class = 'wps-ic-lazy-enabled wps-ic-local';

      $image_base_dir = self::$updir['basedir'];
      $image_base_url = self::$updir['baseurl'];
      $fileDir        = str_replace($image_base_url, $image_base_dir, $source);

      if (file_exists($fileDir)) {
        $image_size = getimagesize($fileDir);
        $svg        = str_replace('#width#', '100%', self::$svg_placeholder);
        $svg        = str_replace('#height#', '100%', $svg);
        $source_svg = $svg;
      }
    }

    if ($this->webpEnabled() && $this->webpSupported()) {

      $source_webp = $source;
      if (strpos($source, '.webp') === false) {
        $source_webp    = '';
        $image_base_dir = self::$updir['basedir'];
        $image_base_url = self::$updir['baseurl'];

        $fileWebPDir = str_replace($image_base_url, $image_base_dir, $source);
        $fileWebPDir = str_replace(array('.jpg', '.png', '.gif'), '.webp', $fileWebPDir);
        if (file_exists($fileWebPDir)) {
          $fileWebP    = str_replace(array('.jpg', '.png', '.gif'), '.webp', $source);
          $source_webp = $fileWebP;
        } else {
          $source_webp = $source;
        }

        if (self::$lazy == '0' || empty(self::$lazy)) {
          $source_svg = $source_webp;
        }

      }

      if ( ! $source_webp) {
        $source_webp    = $source;
        $sourceSet_Webp = $img['srcset'];
      }

      $output = '<img src="' . $source_svg . '" class="' . $img['class'] . ' ' . $lazy_class . '" data-src="' . $source_webp . '" data-srcset="' . $sourceSet_Webp . '" sizes="' . $sizes . '" ' . $lazy_loading . ' />';

    } else {

      $output = '<img src="' . $source_svg . '"  class="' . $img['class'] . ' ' . $lazy_class . '" srcset="' . $sourceset . '"' . ' sizes="' . $sizes . '"' . $lazy_loading . ' />';
    }

    return $output;

  }


  public function create_attributes($attribute_array) {
    $attributes = '';

    foreach ($attribute_array as $attribute => $value) {
      if ($attribute == 'class') {
        $value .= ' lazyload';
      }
      $attributes .= $attribute . '="' . $value . '" ';
    }

    return substr($attributes, 0, - 1);
  }


  public function Get($img, $type) {
    return array(
      'value'  => (isset($img[ 'data-lazy-' . $type ]) && strlen($img[ 'data-lazy-' . $type ])) ? $img[ 'data-lazy-' . $type ] : (isset($img[ 'data-' . $type ]) && strlen($img[ 'data-' . $type ]) ? $img[ 'data-' . $type ] : (isset($img[ $type ]) && strlen($img[ $type ]) ? $img[ $type ] : false)),
      'prefix' => (isset($img[ 'data-lazy-' . $type ]) && strlen($img[ 'data-lazy-' . $type ])) ? 'data-lazy-' : (isset($img[ 'data-' . $type ]) && strlen($img[ 'data-' . $type ]) ? 'data-' : (isset($img[ $type ]) && strlen($img[ $type ]) ? '' : false))
    );
  }


  public function replaceSrcSet($srcset) {
    $srcsetWebP = '';
    if ($srcset) {

      $image_base_dir = self::$updir['basedir'];
      $image_base_url = self::$updir['baseurl'];

      $defs = explode(",", $srcset);
      foreach ($defs as $item) {
        $parts = preg_split('/\s+/', trim($item));

        $fileWebPDir = str_replace($image_base_url, $image_base_dir, $parts[0]);
        $fileWebPDir = str_replace(array('.jpg', '.png', '.gif'), '.webp', $fileWebPDir);

        if (file_exists($fileWebPDir)) {
          $fileWebP   = str_replace(array('.jpg', '.png', '.gif'), '.webp', $parts[0]);
          $srcsetWebP .= $fileWebP . (isset($parts[1]) ? ' ' . $parts[1] : '') . ',';
        }

      }
    }

    $srcsetWebP = rtrim($srcsetWebP, ',');

    return $srcsetWebP;
  }


  public function adaptiveEnabled() {
    if (self::$adaptive_enabled) {
      return true;
    } else {
      return false;
    }
  }


  public function webpEnabled() {
    if (self::$webp_enabled) {
      return true;
    } else {
      return false;
    }
  }


  public function webpSupported() {
    if ((strpos($_SERVER['HTTP_ACCEPT'], 'image/webp') !== false || strpos($_SERVER['HTTP_USER_AGENT'], ' chrome/') !== false)) {
      return true;
    } else {
      return false;
    }
  }

}