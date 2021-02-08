<?php
/**
 * Local Compress
 * @since 5.00.59
 */


class wps_local_compress {

	private static $allowed_types;
	private static $apiURL;
	private static $settings;
	private static $options;
	private static $zone_name;
	private static $backup_directory;
	public $sizes;
	public $compressed_list;


	public function __construct() {
		$this->sizes = get_intermediate_image_sizes();

		self::$allowed_types    = array('jpg' => 'jpg', 'jpeg' => 'jpeg', 'gif' => 'gif', 'png' => 'png');
		self::$backup_directory = WP_CONTENT_DIR . '/wp-compress-backups/';
		self::$settings         = get_option(WPS_IC_SETTINGS);
		self::$options          = get_option(WPS_IC_OPTIONS);

		if (empty(self::$settings['cname']) || ! self::$settings['cname']) {
			self::$zone_name = get_option('ic_cdn_zone_name');
		}
		else {
			self::$zone_name = get_option('ic_custom_cname');
		}

		self::$apiURL = 'https://' . self::$zone_name . '/local:true/q:' . self::$settings['optimization'] . '/retina:false/webp:false/w:1/url:';
	}


	public function restore($imageID) {
		$backup_images = get_post_meta($imageID, 'ic_backup_images', true);

		if ( ! empty($backup_images) && is_array($backup_images)) {
			$compressed_images = get_post_meta($imageID, 'ic_compressed_images', true);
			// Remove Generated Images
			if ( ! empty($compressed_images)) {
				foreach ($compressed_images as $i => $compressed_image) {
					if ( ! empty($backup_images[ $i ])) {

						// If backup file exists
						if (file_exists($backup_images[ $i ])) {
							unlink($compressed_image);
							// Restore from local backups
							copy($backup_images[ $i ], $compressed_image);
							// Delete the backup
							unlink($backup_images[ $i ]);
						}
						else {
							// Nothing
						}
					}
					else {
						// Image size not in backups, unlink the backup
						if ( ! empty($backup_images[ $i ]) && file_exists($backup_images[ $i ])) {
							unlink($backup_images[ $i ]);
						}

						if ( ! empty($compressed_image) && file_exists($compressed_image)) {
							unlink($compressed_image);
						}
					}

				}
			}

			// Remove meta tags
			delete_post_meta($imageID, 'ic_stats');
			delete_post_meta($imageID, 'ic_compressed_images');
			delete_post_meta($imageID, 'ic_backup_images');
			update_post_meta($imageID, 'ic_status', 'restored');

			return true;
		}
		else {
			return false;
		}
	}


	public function backup_image($imageID) {
		// Image Backup Exists
		if ($this->backup_exists($imageID)) {
			return true;
		}

		// Setup Image Stats
		$stats       = array();
		$backup_list = array();

		// Create backup directory
		$this->create_backup_directory();

		// Add full image size to the list
		$this->sizes[] = 'full';

		foreach ($this->sizes as $i => $size) {

			if ($size == 'full') {
				$image     = wp_get_attachment_image_src($imageID, $size);
				$image_url = $image[0];
			}
			else {
				$image     = image_get_intermediate_size($imageID, $size);
				$image_url = $image['url'];
			}

			if (empty($image) || empty($image_url)) {
				continue;
			}

			// Parse Image url and fetch it's Path
			$parsed_url         = parse_url($image_url);
			$parsed_url['path'] = ltrim($parsed_url['path'], '/');

			// Get filename
			$filename = basename($parsed_url['path']);

			// Define original / backup file paths
			$original_file_location = ABSPATH . $parsed_url['path'];

			$backup_folders = str_replace($filename, '', $parsed_url['path']);
			$backup_folders = rtrim($backup_folders, '/');

			$backup_dir_parsed    = str_replace($filename, '', self::$backup_directory . $parsed_url['path']);
			$backup_dir_location  = $backup_dir_parsed;
			$backup_file_location = self::$backup_directory . $parsed_url['path'];

			/**
			 * If backup directories don't exist, create them
			 */
			if ( ! file_exists($backup_dir_location)) {
				$directories = $this->parse_path($backup_folders);

				$starting_dir = '';
				foreach ($directories as $i => $dir) {
					if ( ! file_exists(self::$backup_directory . $dir)) {
						$starting_dir .= $dir . '/';
						mkdir(self::$backup_directory . $starting_dir, 0755);
					}
				}
			}

			// Stats
			#$stats[ $filename ]['original']['size'] = filesize($original_file_location);
			$stats[ $size ]['original']['size'] = filesize($original_file_location);
			copy($original_file_location, $backup_file_location);
			$backup_list[ $size ] = $backup_file_location;
		}

		update_post_meta($imageID, 'ic_stats', $stats);
		update_post_meta($imageID, 'ic_backup_images', $backup_list);
		update_post_meta($imageID, 'ic_original_stats', $stats);
	}


	public function backup_exists($imageID) {
		$backup_exists = get_post_meta($imageID, 'ic_backup_images', true);
		if ( ! empty($backup_exists) && is_array($backup_exists)) {

			foreach ($backup_exists as $filename => $backup_location) {

				if ( ! empty($backup_location)) {

					// If backup file exists
					if (file_exists($backup_location)) {
					}
					else {
						return false;
					}
				}

			}

			return true;
		}
		else {
			return false;
		}
	}


	public function create_backup_directory() {
		if ( ! file_exists(self::$backup_directory)) {
			mkdir(self::$backup_directory, 0755);
		}
	}


	public function parse_path($file_path) {
		$path_exploded = explode('/', $file_path);

		return $path_exploded;
	}


	public function get_stats($imageID) {
		$stats = get_post_meta($imageID, 'ic_stats', true);

		return $stats;
	}


	public function is_original_better($imageID, $size, $im, $stats, $extension) {
		$original_filesize = $stats[ $size ]['original']['size'];
		$file_location     = tmpfile();

		switch ($extension) {
			case 'jpg':
				imagejpeg($im, $file_location);
				break;
			case 'jpeg':
				imagejpeg($im, $file_location);
				break;
			case 'png':
				imagepng($im, $file_location);
				break;
			case 'gif':
				imagegif($im, $file_location);
				break;
		}

	}


	public function debug_msg($attachmentID, $mesage) {
		if (defined('WPS_IC_DEBUG') && WPS_IC_DEBUG == 'true') {
			$debug_log = get_post_meta($attachmentID, 'ic_debug', true);
			if (!$debug_log) { $debug_log = array(); }
			$debug_log[] = $mesage;
			update_post_meta($attachmentID, 'ic_debug', $debug_log);
		}
	}


	public function compress_image($imageID, $retina = true, $webp = true) {

		// Is the image type supported
		if ( ! $this->is_supported($imageID)) {
			return true;
		}

		// Is the image already Compressed
		if ($this->is_already_compressed($imageID)) {
			return true;
		}

		$bulkStats     = get_option('wps_ic_bulk_stats');
		$backup_images = get_post_meta($imageID, 'ic_backup_images', true);
		$stats         = get_post_meta($imageID, 'ic_stats', true);

		if (empty($stats) || ! $stats) {
			$stats = array();
		}

		if (empty($bulkStats)) {
			$bulkStats['images_compressed']    = 0;
			$bulkStats['thumbs_compressed']    = 0;
			$bulkStats['total']                = array();
			$bulkStats['total']['original']    = 0;
			$bulkStats['total']['compressed']  = 0;
			$bulkStats['total']['thumbs']      = 0;
			$bulkStats['thumbs']['original']   = 0;
			$bulkStats['thumbs']['compressed'] = 0;
			$bulkStats['thumbs']['thumbs']     = 0;
		}

		$bulkStats['images_compressed'] += 1;

		foreach ($this->sizes as $i => $size) {

			if ($size == 'full') {
				$image     = wp_get_attachment_image_src($imageID, $size);
				$image_url = $image[0];
				$this->debug_msg($imageID, 'Full IMG Url: ' . print_r($image, true));
			}
			else {
				$bulkStats['thumbs_compressed'] += 1;
				$image                          = image_get_intermediate_size($imageID, $size);
				$image_url                      = $image['url'];
				$this->debug_msg($imageID, 'IMG Url: ' . print_r($image, true));
			}

			if (empty($image_url)) {
				continue;
			}

			$parsed_url         = parse_url($image_url);
			$parsed_url['path'] = ltrim($parsed_url['path'], '/');

			$tmp_location  = ABSPATH . $parsed_url['path'] . '_tmp';
			$file_location = ABSPATH . $parsed_url['path'];

			$apiURL = self::$apiURL . $image_url;
			$this->debug_msg($imageID, 'API Url: ' . print_r($apiURL, true));
			// Compress Regular Thumbnail
			$call = wp_remote_get($apiURL, array('timeout' => 60, 'sslverify' => false, 'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:20.0) Gecko/20100101 Firefox/20.0'));
			if (wp_remote_retrieve_response_code($call) == 200) {
				$body = wp_remote_retrieve_body($call);
				#clearstatcache();

				if ( ! empty($body)) {
					file_put_contents($tmp_location, $body);
					unset($body);

					#clearstatcache();
					// Check if compressed image is smaller than original image from backup
					$original_filesize   = $stats[ $size ]['original']['size'];
					$compressed_filesize = filesize($tmp_location);

					if ($compressed_filesize >= $original_filesize) {
						if (file_exists($backup_images[ $size ])) {
							// Restore from backup
							unlink($tmp_location);
							// Restore from local backups
							copy($backup_images[ $size ], $file_location);
							// Reset stats for restored image
							$stats[ $size ]['compressed']['size'] = $original_filesize;
						}
					}
					else {
						unlink($file_location);
						copy($tmp_location, $file_location);
						unlink($tmp_location);
						$stats[ $size ]['compressed']['size'] = $compressed_filesize;
					}

					$bulkStats['total']['original']   += $stats[ $size ]['original']['size'];
					$bulkStats['total']['compressed'] += $stats[ $size ]['compressed']['size'];

					if ($size !== 'full') {
						$bulkStats['thumbs']['original']   += $stats[ $size ]['original']['size'];
						$bulkStats['thumbs']['compressed'] += $stats[ $size ]['compressed']['size'];
					}

					$this->compressed_list[ $size ] = $file_location;
				}

			}

		}

		update_post_meta($imageID, 'ic_compressed_images', $this->compressed_list);

		#call_user_func_array(array($this, 'generate_retina'), array($imageID));
		#call_user_func_array(array($this, 'generate_webp'), array($imageID));

		// Compress Retina?
		if ($retina) {
			$return                = $this->generate_retina($imageID);
			$stats                 = array_merge($stats, $return['stats']);
			$this->compressed_list = array_merge($this->compressed_list, $return['compressed']);
		}

		if ($webp) {
			$return                = $this->generate_webp($imageID);
			$stats                 = array_merge($stats, $return['stats']);
			$this->compressed_list = array_merge($this->compressed_list, $return['compressed']);
		}

		#$stats = array_merge($stats, $return['stats']);
		#$compressed = get_post_meta($imageID, 'ic_compressed_images', true);
		#$stats = get_post_meta($imageID, 'ic_stats', true);

		update_post_meta($imageID, 'ic_status', 'compressed');
		update_option('wps_ic_bulk_stats', $bulkStats);
		update_post_meta($imageID, 'ic_stats', $stats);
		update_post_meta($imageID, 'ic_compressed_images', $this->compressed_list);

		return $bulkStats;
	}


	public function is_supported($imageID) {
		$file_data = get_attached_file($imageID);
		$type      = wp_check_filetype($file_data);

		// Is file extension allowed
		if ( ! in_array(strtolower($type['ext']), self::$allowed_types)) {
			return false;
		}
		else {
			return true;
		}
	}


	public function is_already_compressed($imageID) {
		$backup_exists = get_post_meta($imageID, 'ic_status', true);
		if ( ! empty($backup_exists) && $backup_exists == 'compressed') {
			return true;
		}
		else {
			return false;
		}
	}


	public function generate_retina($arg) {
		$imageID    = $arg;
		$return     = array();
		$compressed = array();
		$filename   = '';

		$image_url = wp_get_attachment_image_src($imageID, 'full');
		$image_url = $image_url[0];

		if ($filename == '') {
			if (strpos($image_url, '.jpg') !== false) {
				$extension = 'jpg';
			}
			else if (strpos($image_url, '.jpeg') !== false) {
				$extension = 'jpeg';
			}
			else if (strpos($image_url, '.gif') !== false) {
				$extension = 'gif';
			}
			else if (strpos($image_url, '.png') !== false) {
				$extension = 'png';
			}
			else {
				return true;
			}
		}

		foreach ($this->sizes as $i => $size) {

			if (empty($image_url)) {
				continue;
			}

			$retinaAPIUrl = self::$apiURL . $image_url;

			if ($size == 'full') {
				continue;
			}
			else {
				$image     = image_get_intermediate_size($imageID, $size);
				$image_url = $image['url'];
			}

			if (empty($image['width']) || $image['width'] == '') {
				continue;
			}

			$parsed_url         = parse_url($image_url);
			$parsed_url['path'] = ltrim($parsed_url['path'], '/');
			$file_location      = ABSPATH . $parsed_url['path'];

			// Retina File Path
			$retina_file_location = str_replace('.' . $extension, '-x2.' . $extension, $file_location);
			$retina_Filename      = basename($retina_file_location);

			// Enable Retina
			$retinaAPIUrl = str_replace('retina:false', 'retina:true', $retinaAPIUrl);
			$retinaAPIUrl = str_replace('w:1', 'w:' . $image['width'], $retinaAPIUrl);

			$call = wp_remote_get($retinaAPIUrl, array('timeout' => 60, 'sslverify' => false, 'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:20.0) Gecko/20100101 Firefox/20.0'));
			if (wp_remote_retrieve_response_code($call) == 200) {
				$body = wp_remote_retrieve_body($call);
				if ( ! empty($body)) {

					file_put_contents($retina_file_location, $body);
					clearstatcache();

					$stats[ $size . '-2x' ]['compressed']['size'] = filesize($retina_file_location);
					$compressed[ $size . '-2x' ]                  = $retina_file_location;
				}
			}
		}

		$return['stats']      = $stats;
		$return['compressed'] = $compressed;

		$stats = get_post_meta($imageID, 'ic_stats', true);
		$stats = array_merge($stats, $return['stats']);
		update_post_meta($imageID, 'ic_stats', $stats);

		$compressed = get_post_meta($imageID, 'ic_compressed_images', true);
		$compressed = array_merge($compressed, $return['compressed']);
		update_post_meta($imageID, 'ic_compressed_images', $compressed);

		return $return;
	}


	public function generate_webp($arg) {
		$imageID    = $arg;
		$return     = array();
		$compressed = array();
		$extension  = '';
		$stats      = array();

		$image_url_full = wp_get_attachment_image_src($imageID, 'full');
		$image_url_full = $image_url_full[0];

		$image_filename = basename($image_url_full);

		if (strpos($image_filename, '.jpg') !== false) {
			$extension = 'jpg';
		}
		else if (strpos($image_filename, '.jpeg') !== false) {
			$extension = 'jpeg';
		}
		else if (strpos($image_filename, '.gif') !== false) {
			$extension = 'gif';
		}
		else if (strpos($image_filename, '.png') !== false) {
			$extension = 'png';
		}

		foreach ($this->sizes as $i => $size) {

			if ($size == 'full') {
				$image_url = $image_url_full;
			}
			else {
				$image     = image_get_intermediate_size($imageID, $size);
				$image_url = $image['url'];
			}

			$webpAPIUrl = self::$apiURL . $image_url;

			if (empty($image_url)) {
				continue;
			}

			if (empty($image['width']) || $image['width'] == '') {
				continue;
			}

			$parsed_url         = parse_url($image_url);
			$parsed_url['path'] = ltrim($parsed_url['path'], '/');
			$file_location      = ABSPATH . $parsed_url['path'];

			// WebP File Path
			$webp_file_location = str_replace('.' . $extension, '.webp', $file_location);
			$webp_Filename      = basename($webp_file_location);

			// Enable Retina
			$webpAPIUrl = str_replace('retina:false', 'retina:true', $webpAPIUrl);
			$webpAPIUrl = str_replace('webp:false', 'webp:true', $webpAPIUrl);
			$webpAPIUrl = str_replace('w:1', 'w:' . $image['width'], $webpAPIUrl);

			$call = wp_remote_get($webpAPIUrl, array('timeout' => 60, 'sslverify' => false, 'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:20.0) Gecko/20100101 Firefox/20.0'));
			if (wp_remote_retrieve_response_code($call) == 200) {
				$body = wp_remote_retrieve_body($call);
				if ( ! empty($body)) {

					file_put_contents($webp_file_location, $body);
					clearstatcache();

					$stats[ $size . '-webp' ]['compressed']['size'] = filesize($webp_file_location);
					$compressed[ $size . '-webp' ]                  = $webp_file_location;
				}
			}
		}

		$return['stats']      = $stats;
		$return['compressed'] = $compressed;

		$stats = get_post_meta($imageID, 'ic_stats', true);
		$stats = array_merge($stats, $return['stats']);
		update_post_meta($imageID, 'ic_stats', $stats);

		$compressed = get_post_meta($imageID, 'ic_compressed_images', true);
		$compressed = array_merge($compressed, $return['compressed']);
		update_post_meta($imageID, 'ic_compressed_images', $compressed);

		return $return;
	}

}