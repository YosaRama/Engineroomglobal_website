<?php


/**
 * Class - Popups
 */
class wps_ic_popups extends wps_ic {

	public static $options;
	public $api_url;


	public function __construct() {

		if (is_admin()) {
			$response_key = parent::$response_key;

			if ( ! empty($response_key)) {

				delete_transient('wps_ic_count_attachments');
				delete_transient('wps_ic_count_thumbnail_sizes');

				add_action('admin_print_footer_scripts', array(__CLASS__, 'print_popups'));
			}

		}

	}


	public static function print_popups() {

		$screen = get_current_screen();

		if ($screen->base == 'upload' ||
				$screen->base == 'media_page_wpcompress_optimize' ||
				$screen->base == 'media_page_wpcompress_restore') {
			#self::api_offline();
			#self::no_credits();
			#self::no_credits_bulk();
			#self::no_credits_bulk_proceed();
			#self::ic_hidden_compress_started();
			#self::ic_nothing_to_compress();
			#self::ic_hidden_regen_started();
			#self::ic_hidden_restore_started();
			#self::ic_hidden_loading();
			#self::ic_credits_loading();
			#self::ic_confirm_optimize();
			#self::ic_all_compressed();
			#self::ic_confirm_regenerate();
			#self::ic_confirm_restore();

			// Compare
			#self::compare_images();
			#self::compare_loading();

			// Recompress
			#self::recompress_loading();
			#self::recompress_popup();
		}

		if ($screen->base == 'toplevel_page_wpcompress') {
      self::ic_setting_saving();
			/*self::buy_credits();
			self::ic_hidden_compress_started();
			self::ic_nothing_to_compress();
			self::ic_hidden_regen_started();
			self::ic_hidden_restore_started();
			self::ic_hidden_loading();

			self::ic_credits_loading();
			self::ic_all_compressed();*/
			#self::ic_confirm_optimize();
			#self::ic_confirm_regenerate();
			#self::ic_confirm_restore();
			#self::no_credits();

      // Required
      #self::ic_first_run();
		}
	}


	public static function ic_first_run() {
    echo '<div id="wps-ic-first-run" style="display:none;">';
    echo '<div class="ic-popup ic-popup-v2">';

    echo '<img src="' . WPS_IC_URI . 'assets/images/rocket.png" style="height:120px;" />';
    echo '<h3 class="ic-title">You\'re all set!</h3>';
    echo '<h4 class="ic-subtitle">Sit back and relax, we\'ll take it from here!</h4>';
    echo '<a href="#" class="simple-link close-popup">Go To Dashboard</a>';
    echo '</div>';
    echo '</div>';
  }


	public static function ic_confirm_restore() {
		echo '<div id="ic_confirm_restore" style="display:none;">';
		echo '<div class="ic-popup ic-popup-v2 ic-popup-hidden-bulk">';

		echo '<img src="' . WPS_IC_URI . 'assets/images/image-icon.png" />';
		echo '<h1>Ready to restore all images?</h1>';
		echo '</div>';
		echo '</div>';
	}


	public static function ic_confirm_regenerate() {
		global $wpdb;

		$attachments = get_transient('ic_count_total_attachments');
		if ( ! $attachments) {
			$attachments = $wpdb->get_results("SELECT ID FROM " . $wpdb->posts . " WHERE post_type='attachment' AND post_status='inherit'");
			$attachments = count($attachments);
			set_transient('ic_count_total_attachments', $attachments, 10);
		}

		$thumbnail_sizes = get_intermediate_image_sizes();

		echo '<div id="ic_confirm_regen" style="display:none;">';
		echo '<div class="ic-popup ic-popup-v2 ic-popup-hidden-bulk">';

		echo '<img src="' . WPS_IC_URI . 'assets/images/image-icon.png" />';
		echo '<h1>Regenerate all thumbnails?</h1>';

		echo '<h3>You have ' . $attachments . ' compressed images, you will regenerate ' . ($attachments * count($thumbnail_sizes)) . ' thumbnails.</h3>';

		echo '</div>';
		echo '</div>';
	}


	public static function ic_all_compressed() {
		echo '<div id="ic_all_compressed" style="display:none;">';
		echo '<div class="ic-popup ic-popup-v2 ic-popup-hidden-bulk">';

		echo '<img src="' . WPS_IC_URI . 'assets/images/image-icon.png" />';
		echo '<h1>All images are already compressed</h1>';

		#echo '<h3>You have compressed .</h3>';

		echo '</div>';
		echo '</div>';
	}


	public static function ic_confirm_optimize() {
		global $wpdb;

		// Check credits
		$options = get_option(WPS_IC_OPTIONS);

		// Check credits
		$credits = get_transient('ic_credits');
		if ( ! $credits) {
			$check_credits = wp_remote_get(WPS_IC_APIURL . '?apikey=' . $options['api_key'] . '&check_credits=true', array('timeout' => '25', 'sslverify' => false));

			if (wp_remote_retrieve_response_code($check_credits) == 200) {
				$body = wp_remote_retrieve_body($check_credits);
				$body = json_decode($body, true);
			}

			$credits = $body['data']['credits'];
			set_transient('ic_credits', $credits, 10);
		}

		$attachments = get_transient('ic_count_total_attachments');

		if ( ! $attachments) {
			$attachment_list   = $wpdb->get_results("SELECT ID FROM " . $wpdb->posts . " WHERE post_type='attachment' AND post_status='inherit'");
			$attachments_count = count($attachment_list);
			set_transient('ic_count_total_attachments', $attachments_count, 10);
		}

		$already_compressed = $wpdb->get_var($wpdb->prepare("SELECT COUNT(ID) as files FROM " . $wpdb->prefix . "ic_compressed WHERE restored=%s", 0));

		$attachments = $attachments - $already_compressed;

		if ($credits > $attachments) {
			$string = 'your entire media library';
		} else {
			$string = $credits . ' out of ' . $attachments . ' images.';
		}

		echo '<div id="ic_confirm_optimize" style="display:none;">';
		echo '<div class="ic-popup ic-popup-v2 ic-popup-hidden-bulk">';

		if ($credits > 0) {
			echo '<img src="' . WPS_IC_URI . 'assets/images/image-icon.png" />';
			echo '<h1>Ready to optimize all images?</h1>';

			echo '<h3>You have ' . $credits . ' credits left, you can optimize ' . $string . '.</h3>';
		} else {
			echo '<h3 class="ic-title">You have no credits left.</h3>';
			echo '<h5 class="ic-subtitle">You can get more credits by upgrading your existing membership or adding a one-time credit pack.</h5>';

			echo '<div class="options-shadow" style="">';
			echo '<div class="option-container">';
			echo '<div class="left-option">';
			echo '<img src="' . WPS_IC_URI . 'assets/images/image.svg" />';
			echo '<h4>Credit Pack</h4>';

			echo '<p>Compression credits can be shared across multiple websites. Credit Packs stack and never expire.</p>';
			echo '<a href="https://wpcompress.com/credit-packs" target="_blank" class="popup-btn">Get Credits</a>';

			echo '</div>';
			echo '<div class="mid-option"></div>';
			echo '<div class="right-option">';

			echo '<img src="' . WPS_IC_URI . 'assets/images/unlimited.svg" />';
			echo '<h4>Upgrade Membership</h4>';

			echo '<div class="list">';
			echo '<h5>Credits Reset Monthly</h5>';
			echo '<h5>Ideal for Full Automation</h5>';
			echo '<h5>Lowest Price Per Image</h5>';
			echo '</div>';

			echo '<a href="https://wpcompress.com/pricing" class="popup-btn" target="_blank">View Plans</a>';

			echo '</div>';
			echo '</div>'; // option-container

			echo '</div>'; // box shadow

			echo '<div>';
			echo '<h6 class="footertitle">If you\'re seeing this as a client of a digital agency, ask them to increase your quota.</h6>';
			echo '</div>';
			echo '</div>';
		}

		echo '</div>';
		echo '</div>';
	}


	public static function ic_credits_loading() {
		echo '<div id="ic_credits_loading" style="display:none;">';
		echo '<div class="ic-popup ic-popup-v2 ic-popup-hidden-bulk">';

		echo '<img src="' . WPS_IC_URI . 'assets/images/image-icon.png" />';
		echo '<h1>Checking available credits...</h1>';
		echo '<h5>Please wait until we are done.</h5>';
		echo '<hr/>';

		echo '</div>';
		echo '</div>';
	}


	public static function ic_hidden_loading() {
		echo '<div id="ic_hidden_loading" style="display:none;">';
		echo '<div class="ic-popup ic-popup-v2 ic-popup-hidden-bulk">';

		echo '<img src="' . WPS_IC_URI . 'assets/images/image-icon.png" />';
		echo '<h1>Scanning Media Library...</h1>';
		echo '<h5>Please wait until we are done.</h5>';
		echo '<hr/>';

		echo '</div>';
		echo '</div>';
	}


	public static function ic_setting_saving() {
		echo '<div id="ic_setting_saving" style="display:none;">';
		echo '<div class="ic-popup ic-popup-v2 ic-popup-hidden-bulk">';

		echo '<img src="' . WPS_IC_URI . 'assets/images/image-icon.png" />';
		echo '<h1>We\'re Saving your changes</h1>';
		echo '<h5>This window will automatically close once settings are saved.</h5>';
		echo '<hr/>';

		echo '</div>';
		echo '</div>';
	}


	public static function ic_hidden_regen_started() {
		echo '<div id="ic_hidden_regen_started" style="display:none;">';
		echo '<div class="ic-popup ic-popup-v2 ic-popup-hidden-bulk">';

		echo '<img src="' . WPS_IC_URI . 'assets/images/image-icon.png" />';
		echo '<h1>We\'re Regenerating Your Thumbnails</h1>';
		echo '<h5>Sit back and relax, you can track the progress in the top right corner of the dashboard.</h5>';
		echo '<hr/>';

		echo '</div>';
		echo '</div>';
	}


	public static function ic_hidden_compress_started() {
		echo '<div id="ic_hidden_compress_started" style="display:none;">';
		echo '<div class="ic-popup ic-popup-v2 ic-popup-hidden-bulk">';

		echo '<img src="' . WPS_IC_URI . 'assets/images/image-icon.png" />';
		echo '<h1>We\'re Optimizing Your Images</h1>';
		echo '<h5>Sit back and relax, you can track the progress in the top right corner of the dashboard.</h5>';
		echo '<hr/>';

		echo '</div>';
		echo '</div>';
	}


	public static function ic_nothing_to_compress() {
		echo '<div id="ic_nothing_to_compress" style="display:none;">';
		echo '<div class="ic-popup ic-popup-v2 ic-popup-hidden-bulk">';

		echo '<img src="' . WPS_IC_URI . 'assets/images/image-icon.png" />';
		echo '<h1>We have not found any images to compress.</h1>';
		echo '<h5>If you believe this is a bug, please contact WP Compress Support.</h5>';
		echo '<hr/>';

		echo '</div>';
		echo '</div>';
	}


	public static function ic_hidden_restore_started() {
		echo '<div id="ic_hidden_restore_started" style="display:none;">';
		echo '<div class="ic-popup ic-popup-v2 ic-popup-hidden-bulk">';

		$notify = get_option(WPS_IC_SETTINGS);
		if ($notify['notify'] == '1') {
			$emailed = ', you\'ll get emailed a report when it\'s done';
		} else {
			$emailed = '';
		}

		echo '<img src="' . WPS_IC_URI . 'assets/images/image-icon.png" />';
		echo '<h1>We\'re Restoring Your Images</h1>';
		echo '<h5>Sit back and relax, you can track the progress in the top right corner of the dashboard.</h5>';
		echo '<hr/>';

		echo '</div>';
		echo '</div>';
	}


	public static function api_offline() {
		global $wps_ic, $referrals;

		echo '<div id="ic_offline_popup" style="display:none;">';
		echo '<div class="ic-popup">';
		echo '<h3>We are currently upgrading our API, please try again later.</h3><br/>';

		echo '<br/>';

		echo '<div style="display:inline-block;width: 45%;vertical-align: top;border-right: 1px solid #d1d1d1;margin-right: 2%;padding-right: 2%;">';
		echo '<h4>Share WP Compress</h4>';

		if ($referrals->total_referrals < 1) {
			echo '<h5>Get an additional 2,500 credits with your first referral.</h5>';
		} else {
			echo '<h5>Get an additional 500 credits for every friend you refer.</h5>';
		}
		echo '<br/>';
		echo '<br/>';
		echo '<strong>Your Referral Link</strong>';
		echo '<br/>';
		echo '<a href="https://WPCompress.com/?ref=' . $referrals->refID . '">https://WPCompress.com/?ref=' . $referrals->refID . '</a>';

		$share_url = 'https://wpcompress.com/?ref=' . $referrals->refID;
		$share_url = urlencode($share_url);

		echo '<div class="ic-social-shares">';
		echo '<a href="https://www.facebook.com/sharer/sharer.php?u=' . $share_url . '" target="_blank"><i class="fas fa-facebook"></i></a>';
		echo '<a href="https://twitter.com/home?status=' . $share_url . '" target="_blank"><i class="fas fa-twitter"></i></a>';
		echo '<a href="https://www.linkedin.com/shareArticle?mini=true&url=' . $share_url . '&title=WP %20Compress&summary=&source=" target="_blank"><i class="fas fa-linkedin"></i></a>';
		echo '<a href="mailto:?&subject=I\'m saving by using WP Compress, ' . $share_url . ' Join me!" target="_blank"><i class="fas fa-envelope"></i></a>';
		echo '</div>';
		echo '</div>';

		echo '<div style="display:inline-block;width:48%;vertical-align:top;">';
		echo '<h4>Professional License</h4>';
		echo '<h1>$29<span style="font-size:14px;">/year</span></h1>';
		echo '<h5>Unlimited Images, Faster Compression and More...</h5>';
		echo '<a href="https://wpcompress.com/pricing/" class="popup-btn">Upgrade Now</a>';
		echo '</div>';

		echo '<div>';
		echo '<h6>We aim to be reasonable, check out our <a href="https://wpcompress.com/fup" target="_blank">Fair Usage Policy</a>.</h6>';
		echo '</div>';

		echo '</div>';
		echo '</div>';
	}


	public static function no_credits() {
		global $wps_ic, $referrals;

		echo '<div id="ic_no_credits_popup" style="display:none;">';
		echo '<div class="ic-popup ic-popup-v2">';
		echo '<h3 class="ic-title">You have no credits left.</h3>';
		echo '<h5 class="ic-subtitle">You can get more credits by upgrading your existing membership or adding a one-time credit pack.</h5>';

		echo '<div class="options-shadow" style="">';
		echo '<div class="option-container">';
		echo '<div class="left-option">';
		echo '<img src="' . WPS_IC_URI . 'assets/images/image.svg" />';
		echo '<h4>Credit Pack</h4>';

		echo '<p>Compression credits can be shared across multiple websites. Credit Packs stack and never expire.</p>';
		echo '<a href="https://wpcompress.com/credit-packs" target="_blank" class="popup-btn">Get Credits</a>';

		echo '</div>';
		echo '<div class="mid-option"></div>';
		echo '<div class="right-option">';

		echo '<img src="' . WPS_IC_URI . 'assets/images/unlimited.svg" />';
		echo '<h4>Upgrade Membership</h4>';

		echo '<div class="list">';
		echo '<h5>Credits Reset Monthly</h5>';
		echo '<h5>Ideal for Full Automation</h5>';
		echo '<h5>Lowest Price Per Image</h5>';
		echo '</div>';

		echo '<a href="https://wpcompress.com/pricing" class="popup-btn" target="_blank">View Plans</a>';

		echo '</div>';
		echo '</div>'; // option-container

		echo '</div>'; // box shadow

		echo '<div>';
		echo '<h6 class="footertitle">If you\'re seeing this as a client of a digital agency, ask them to increase your quota.</h6>';
		echo '</div>';
		echo '</div>';

		echo '</div>';
		echo '</div>';
	}


	public static function recompress_loading() {
		echo '<div id="ic_recompress_loading" style="display:none;">';
		echo '<div class="ic-popup ic-popup-v2 ic-popup-hidden-bulk">';

		echo '<img src="' . WPS_IC_URI . 'assets/images/image-icon.png" style="margin-top:35px;" />';
		echo '<h1>We are fetching your image...</h1>';
		echo '<h5>Please wait until we are done.</h5>';
		echo '<hr/>';

		echo '</div>';
		echo '</div>';
	}


	public static function compare_loading() {
		echo '<div id="ic_compare_loading" style="display:none;">';
		echo '<div class="ic-popup ic-popup-v2 ic-popup-hidden-bulk">';

		echo '<img src="' . WPS_IC_URI . 'assets/images/image-icon.png" style="margin-top:35px;" />';
		echo '<h1>We are calculating compare results...</h1>';
		echo '<h5>Please wait until we are done.</h5>';
		echo '<hr/>';

		echo '</div>';
		echo '</div>';
	}


	public static function recompress_popup() {
		global $wps_ic;

		$settings = get_option(WPS_IC_SETTINGS);

		echo '<div id="ic_recompress_popup" style="display:none;">';
		echo '<div class="ic-popup ic-popup-v2 ic_compare_popup">';

		echo '<div class="compare-popup-title">';
		echo '<span><img src="' . WPS_IC_URI . 'assets/images/checked-popup.png"/></span>';
		echo '<h3 class="results">You\'ve saved x%</h3>';
		echo '<div class="ic-pill mb-savings">5.98MB savings</div>';
		echo '</div>';

		echo '<div class="recompress-loading" style="display:none;">
		<div class="wps-ic-form-loading">
		<img src="' . WPS_IC_URI . 'assets/images/spinner.svg"/>
		</div>
		</div>';

		echo '<div class="recompress-results">';
		echo '<div class="left-option">';
		echo '<h3>Original</h3>';
		echo '<span class="original"></span>';
		echo '<div class="img-holder-round">';
		echo '<img class="original big" src="">';
		echo '</div>';
		echo '</div>';

		echo '<div class="right-option">';
		echo '<h3>Compressed</h3>';
		echo '<span class="compressed"></span>';
		echo '<div class="img-holder-round">';
		echo '<img class="compressed big" src="">';
		echo '</div>';
		echo '</div>';

		echo '</div>';

		echo '<div class="recompress-form">';
		echo '<h3>Quality:</h3>';
		echo '<div class="wp-ic-select-box" style="padding:20px 0px;">';
		echo '<input type="hidden" name="wp-ic-setting[optimization]" id="wp-ic-setting-optimization" value=""/>
              <ul>
                <li><a href="#" class="wps-ic-change-optimization" data-optimization_level="lossless">Lossless</a></li>
                <li><a href="#" class="wps-ic-change-optimization" data-optimization_level="intelligent">Intelligent</a></li>
                <li><a href="#" class="wps-ic-change-optimization" data-optimization_level="ultra">Ultra</a></li>
              </ul>';
		echo '</div>';
		echo '<a href="#" class="button button-recompress">Recompress</a>';
		echo '</div>';

		echo '</div>';

		echo '</div>';
	}


	public static function compare_images() {
		global $wps_ic, $referrals;

		echo '<div id="ic_compare_popup" style="display:none;">';
		echo '<div class="ic-popup ic-popup-v2 ic_compare_popup">';

		echo '<div class="compare-popup-title">';
		echo '<span><img src="' . WPS_IC_URI . 'assets/images/checked-popup.png"/></span>';
		echo '<h3 class="results">You\'ve saved x%</h3>';
		echo '<div class="ic-pill mb-savings">5.98MB savings</div>';
		echo '</div>';

		echo '<div class="left-option">';
		echo '<h3>Original</h3>';
		echo '<span class="original"></span>';
		echo '<div class="img-holder-round">';
		echo '<img class="original big" src="">';
		echo '</div>';
		echo '</div>';

		echo '<div class="right-option">';
		echo '<h3>Compressed</h3>';
		echo '<span class="compressed"></span>';
		echo '<div class="img-holder-round">';
		echo '<img class="compressed big" src="">';
		echo '</div>';
		echo '</div>';

		echo '</div>';

		echo '</div>';
	}


	public static function no_credits_bulk_proceed() {
		global $wps_ic, $referrals, $wpdb;
		$count_attachments = get_transient('wps_ic_count_attachments');
		$thumbnail_sizes   = get_transient('wps_ic_count_thumbnail_sizes');
		$check_credits     = get_transient('wps_ic_check_credits');

		if ( ! $count_attachments || empty($count_attachments)) {
			// Check if it's a single file clicked or bulk compress button
			#$attachments = get_posts(array('post_type' => 'attachment', 'posts_per_page' => '-1', 'post_status' => 'any', 'orderby' => 'post_date', 'order' => 'DESC'));
			$attachments = $wpdb->get_results("SELECT ID FROM " . $wpdb->posts . " WHERE post_type='attachment' AND post_status='inherit'");

			// Count attachments and check if user has enough credits
			$count_attachments = count($attachments);

			set_transient('wps_ic_count_attachments', $count_attachments, 60 * 10);
		}

		if ( ! $thumbnail_sizes || empty($thumbnail_sizes)) {
			// Count thumbnail variations
			$thumbnail_sizes = get_intermediate_image_sizes();
			$thumbnail_sizes = count($thumbnail_sizes);

			set_transient('wps_ic_count_thumbnail_sizes', $thumbnail_sizes, 60 * 10);
		}
		// Total to compress
		$required_credits = $count_attachments;

		if ( ! $check_credits || empty($check_credits) || $check_credits == 0) {
			// Does user have enough credits?
			$check_credits = wp_remote_get(WPS_IC_APIURL . '?apikey=' . $wps_ic::$api_key . '&check_credits=true', array('timeout' => '10', 'sslverify' => false));

			if (wp_remote_retrieve_response_code($check_credits)) {
				$body = wp_remote_retrieve_body($check_credits);
				$body = json_decode($body, true);

				if ($body['success'] == 'true') {
					// OK
					$credits = $body['data']['credits'];
					set_transient('wps_ic_count_thumbnail_sizes', $credits, 60 * 5);
				}
			}
		}

		$optimization = $credits;

		echo '<div id="ic_no_credits_proceed_popup_bulk" style="display:none;">';
		echo '<div class="ic-popup ic-popup-v2">';
		echo '<h3 class="ic-title">It looks like you don’t have enough credits to bulk compress all images</h3>';
		echo '<h5 class="ic-subtitle">You have ' . $credits . ' credits remaining while optimizing your entire media library will require ' . $required_credits . '.</h5>';

		echo '<div class="options-shadow" style="">';
		echo '<div class="option-container">';
		echo '<div class="left-option">';
		echo '<img src="' . WPS_IC_URI . 'assets/images/image.svg" />';
		echo '<h4>Compress Until Out of Credits</h4>';

		echo '<p>Bulk Optimize your images until you run out of credits.</p>';
		echo '<p>This will optimize an estimated ' . $optimization . ' full sized images and their thumbnails.</p>';

		echo '<a href="#" target="_blank" class="popup-btn continue-bulk">Compress Now</a>';

		echo '</div>';
		echo '<div class="mid-option"></div>';
		echo '<div class="right-option">';

		echo '<img src="' . WPS_IC_URI . 'assets/images/unlimited.svg" />';
		echo '<h4>Purchase a Membership</h4>';

		echo '<div class="list">';
		echo '<h5>Automatically Optimize with Otto</h5>';
		echo '<h5>Faster Compression + Priority Support</h5>';
		echo '<h5>Use Across Unlimited Websites</h5>';
		echo '</div>';

		echo '<h5 class="popup-price unlimited">Starting at <span>$5</span> / month</h5>';

		echo '<a href="https://wpcompress.com/pricing" class="popup-btn" target="_blank">View Plans</a>';

		echo '</div>';
		echo '</div>'; // option-container

		echo '</div>'; // box shadow

		echo '<div>';
		echo '<h6 class="footertitle">You may optimize or exclude individual images in your <a href="' . admin_url('upload.php') . '" target="_blank">media library</a>.</h6>';
		echo '</div>';
		echo '</div>';

		echo '</div>';
		echo '</div>';
	}


	public static function no_credits_bulk() {
		global $wps_ic, $referrals, $wpdb;
		$check_credits = get_transient('wps_ic_check_credits');

		$attachments = get_transient('ic_count_total_attachments');
		if ( ! $attachments) {
			$attachments = $wpdb->get_results("SELECT ID FROM " . $wpdb->posts . " WHERE post_type='attachment' AND post_status='inherit'");

			// Count attachments and check if user has enough credits
			$count_attachments = count($attachments);
			set_transient('ic_count_total_attachments', $count_attachments, 60);
		}

		// Total to compress
		$required_credits = $count_attachments;

		if ( ! $check_credits || empty($check_credits) || $check_credits == 0) {
			// Does user have enough credits?
			$check_credits = wp_remote_get(WPS_IC_APIURL . '?apikey=' . $wps_ic::$api_key . '&check_credits=true', array('timeout' => '10', 'sslverify' => false));

			if (wp_remote_retrieve_response_code($check_credits)) {
				$body = wp_remote_retrieve_body($check_credits);
				$body = json_decode($body, true);

				if ($body['success'] == 'true') {
					// OK
					$credits = $body['data']['credits'];
					set_transient('wps_ic_count_thumbnail_sizes', $credits, 60 * 5);
				}
			}
		}

		/**
		 * Calculate possible packages
		 */
		$pack_price    = 1;
		$selected_pack = 1000;

		echo '<div id="ic_no_credits_popup_bulk" style="display:none;">';
		echo '<div class="ic-popup ic-popup-v2">';
		echo '<h3 class="ic-title">It looks like you don’t have enough credits to bulk compress all images</h3>';
		echo '<h5 class="ic-subtitle">You have ' . $credits . ' credits remaining while optimizing your entire media library will require ' . $required_credits . '.</h5>';

		echo '<div class="options-shadow" style="">';
		echo '<div class="option-container">';
		echo '<div class="left-option">';
		echo '<img src="' . WPS_IC_URI . 'assets/images/image.svg" />';
		echo '<h4>Credit Pack</h4>';

		echo '<p>Compression credits can be shared across multiple websites. Credit Packs stack and never expire.</p>';

		echo '<h5 class="popup-price"><span>$' . $pack_price . ' per ' . $selected_pack . '</span></h5>';

		echo '<a href="https://wpcompress.com/pricing" target="_blank" class="popup-btn">Get Credits</a>';

		echo '</div>';
		echo '<div class="mid-option"></div>';
		echo '<div class="right-option">';

		echo '<img src="' . WPS_IC_URI . 'assets/images/unlimited.svg" />';
		echo '<h4>Purchase a Membership</h4>';

		echo '<div class="list">';
		echo '<h5>Automatically Optimize with Otto</h5>';
		echo '<h5>Faster Compression + Priority Support</h5>';
		echo '<h5>Use Across Unlimited Websites</h5>';
		echo '<h5>Use Across Unlimited Websites</h5>';
		echo '</div>';

		echo '<h5 class="popup-price unlimited">Starting at <span>$15</span> / year</h5>';

		echo '<a href="https://wpcompress.com/pricing" class="popup-btn" target="_blank">View Plans</a>';

		echo '</div>';
		echo '</div>'; // option-container

		echo '<div class="full-option">';
		echo '<div class="third-width">';
		echo '<div class="table-imit">';
		echo '<div class="table-row">';
		echo '<h3>Get Free Membership</h3>';
		echo '<h5>Refer a Friend and Unlock Membership</h5>';
		echo '</div>'; // table row
		echo '</div>'; // table imit
		echo '</div>'; // Third Width

		echo '<div class="third-width">';
		echo '<div class="table-imit">';
		echo '<div class="table-row">';
		echo '<h5>Get 30 days of Gold Membership for Every Friend You Refer to WP Compress.</h5>';
		echo '</div>'; // table row
		echo '</div>'; // table imit
		echo '</div>'; // Third Width

		echo '<div class="third-width text-right">';
		echo '<div class="table-imit">';
		echo '<div class="table-row">';
		echo '<strong style="display:block;">Your Referral Link</strong>';
		echo '<a href="https://wpcompress.com/?ref=' . $referrals->refID . '" class="ref-link">https://wpcompress.com/?ref=' . $referrals->refID . '</a>';

		$share_url = 'https://wpcompress.com/?ref=' . $referrals->refID;
		$share_url = urlencode($share_url);

		echo '<div class="ic-social-shares">';
		echo '<a class="ic-facebook" href="https://www.facebook.com/sharer/sharer.php?u=' . $share_url . '" target="_blank"><i class="fas fa-facebook"></i></a>';
		echo '<a class="ic-twitter" href="https://twitter.com/home?status=' . $share_url . '" target="_blank"><i class="fas fa-twitter"></i></a>';
		echo '<a class="ic-linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=' . $share_url . '&title=WP %20Compress&summary=&source=" target="_blank"><i class="fas fa-linkedin"></i></a>';
		echo '<a class="ic-mail" href="mailto:?body=I\'m saving by using WP Compress, ' . $share_url . ' Join me!" target="_blank"><i class="fas fa-envelope"></i></a>';
		echo '</div>';
		echo '</div>';
		echo '</div>';
		echo '</div>'; // Third Width

		echo '</div>'; // Ful option

		echo '</div>'; // box shadow

		echo '<div>';
		echo '<h6 class="footertitle">You may optimize or exclude individual images in your <a href="' . admin_url('upload.php') . '" target="_blank">media library</a>.</h6>';
		echo '</div>';
		echo '</div>';

		echo '</div>';
		echo '</div>';
	}


	public static function buy_credits() {
		global $wps_ic, $referrals;

		/**
		 * Calculate possible packages
		 */
		$pack_price    = 1;
		$selected_pack = 1000;
		$packs         = array(1 => 1000, 5 => 2500, 10 => 5000, 15 => 10000, 30 => 25000, 50 => 50000, 100 => 100000);
		/*foreach ($packs as $key => $pack) {
			if ($pack <= $required_credits) {
				continue;
			} else {
				$selected_pack = $pack;
				$pack_price    = $key;
				break;
			}
		}*/

		echo '<div id="ic_additional_credits_popup" style="display:none;">';
		echo '<div class="ic-popup ic-popup-v2">';
		echo '<h3 class="ic-title" style="margin-bottom:10px;">Want More Credits?</h3>';
		echo '<h5 class="ic-subtitle">Refer your friends to earn additional image credits and unlock awesome Power Ups, or upgrade to our Professional plan for unlimited images, faster compression and extended backups.</h5>';

		echo '<div class="options-shadow" style="">';
		echo '<div class="option-container">';
		echo '<div class="left-option">';
		echo '<img src="' . WPS_IC_URI . 'assets/images/image.svg" />';
		echo '<h4>Credit Pack</h4>';

		echo '<p>Compression credits can be shared across multiple websites. Credit Packs stack and never expire.</p>';

		echo '<h5 class="popup-price"><span>$' . $pack_price . ' per ' . $selected_pack . '</span></h5>';

		echo '<a href="https://wpcompress.com/pricing" target="_blank" class="popup-btn">Get Credits</a>';

		echo '</div>';
		echo '<div class="mid-option"></div>';
		echo '<div class="right-option">';

		echo '<img src="' . WPS_IC_URI . 'assets/images/unlimited.svg" />';
		echo '<h4>Purchase a Membership</h4>';

		echo '<div class="list">';
		echo '<h5>Automatically Optimize with Otto</h5>';
		echo '<h5>Faster Compression + Priority Support</h5>';
		echo '<h5>Use Across Unlimited Websites</h5>';
		echo '<h5>Use Across Unlimited Websites</h5>';
		echo '</div>';

		echo '<h5 class="popup-price unlimited">Starting at <span>$15</span> / year</h5>';

		echo '<a href="https://wpcompress.com/pricing" class="popup-btn" target="_blank">View Plans</a>';

		echo '</div>';
		echo '</div>'; // option-container

		echo '<div class="full-option">';
		echo '<div class="third-width">';
		echo '<div class="table-imit">';
		echo '<div class="table-row">';
		echo '<h3>Get Free Membership</h3>';
		echo '<h5>Refer a Friend and Unlock Membership</h5>';
		echo '</div>'; // table row
		echo '</div>'; // table imit
		echo '</div>'; // Third Width

		echo '<div class="third-width">';
		echo '<div class="table-imit">';
		echo '<div class="table-row">';
		echo '<h5>Get 30 days of Gold Membership for Every Friend You Refer to WP Compress.</h5>';
		echo '</div>'; // table row
		echo '</div>'; // table imit
		echo '</div>'; // Third Width

		echo '<div class="third-width text-right">';
		echo '<div class="table-imit">';
		echo '<div class="table-row">';
		echo '<strong style="display:block;">Your Referral Link</strong>';
		echo '<a href="https://wpcompress.com/?ref=' . $referrals->refID . '" class="ref-link">https://wpcompress.com/?ref=' . $referrals->refID . '</a>';

		$share_url = 'https://wpcompress.com/?ref=' . $referrals->refID;
		$share_url = urlencode($share_url);

		echo '<div class="ic-social-shares">';
		echo '<a class="ic-facebook" href="https://www.facebook.com/sharer/sharer.php?u=' . $share_url . '" target="_blank"><i class="fas fa-facebook"></i></a>';
		echo '<a class="ic-twitter" href="https://twitter.com/home?status=' . $share_url . '" target="_blank"><i class="fas fa-twitter"></i></a>';
		echo '<a class="ic-linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=' . $share_url . '&title=WP %20Compress&summary=&source=" target="_blank"><i class="fas fa-linkedin"></i></a>';
		echo '<a class="ic-mail" href="mailto:?body=I\'m saving by using WP Compress, ' . $share_url . ' Join me!" target="_blank"><i class="fas fa-envelope"></i></a>';
		echo '</div>';
		echo '</div>';
		echo '</div>';
		echo '</div>'; // Third Width

		echo '</div>'; // Ful option

		echo '</div>'; // box shadow

		echo '<div>';
		echo '<h6 class="footertitle">If you don\'t have enough credits for bulk, you can optimize individual images in your <a href="' . admin_url('upload.php') . '" target="_blank">media library</a>.</h6>';
		echo '</div>';
		echo '</div>';

		echo '</div>';
		echo '</div>';
	}


}