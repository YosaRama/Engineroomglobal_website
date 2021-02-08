<?php


/**
 * Class - Tests
 */
class wps_ic_tests extends wps_ic {


	public function __construct() {
		if ( ! empty($_GET['img'])) {
			$this->image_upload();
		}

		$this->listener();
	}


	public function listener() {

		if ( ! empty($_POST['test']) && ! empty($_POST['apikey'])) {
			update_option('wps_ic_test', 'true');
			$apikey  = sanitize_text_field($_POST['apikey']);
			$test    = sanitize_text_field($_POST['test']);
			$value   = sanitize_text_field($_POST['value']);
			$setting = sanitize_text_field($_POST['setting']);

			$tmp_key = get_option('wps_ic_tmp_apikey');
			if ($tmp_key != $apikey) {
				wp_send_json_error('#36');
			}

			wp_send_json_success();
		}

	}


	public function call_test($test_name) {
		sleep(2);
		$this->$test_name();
	}






	public function image_upload() {
		global $wpdb;

		// Remove on upload
		$options      = get_option(WPS_IC_SETTINGS);
		$old_settings = $options;
		delete_option(WPS_IC_SETTINGS);

		require_once(ABSPATH . 'wp-admin/includes/media.php');
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/image.php');

		// Test Image
		$image = 'https://plugin.wpcompress.xyz/test-image.jpg';

		// Was it already uploaded?
		$test_image = get_option('wps_ic_test_image');

		if ( ! empty($test_image)) {
			delete_option('wps_ic_test_image');
			wp_delete_attachment($test_image, true);
			$test_image = false;
		}

		$overrides = array('test_form'=>false);
		$time = current_time( 'mysql' );

		$file_array             = array();
		$file_array['name']     = basename($image);
		$file_array['tmp_name'] = download_url($image);
		$file                   = wp_handle_sideload($file_array, $overrides, $time);

		$url = $file['url'];
		$type = $file['type'];
		$file = $file['file'];

		// Construct the attachment array.
		$attachment = array_merge( array(
																 'post_mime_type' => $type,
																 'guid' => $url,
																 'post_parent' => 0,
																 'post_title' => 'wpcompress-test',
																 'post_content' => '',
															 ), array() );

		// This should never be set as it would then overwrite an existing attachment.
		unset( $attachment['ID'] );

		// Save the attachment metadata
		$id = wp_insert_attachment($attachment, $file, 0);

		$gen = $this->wp_generate_attachment_metadata( $id, $file );
		var_dump($gen);
		die();
		$metadata = wp_update_attachment_metadata( $id , $gen);
		var_dump($file);
		var_dump($id);
		var_dump($metadata);
		die();

		if (empty($test_image) || ! $test_image) {
			$media = media_sideload_image($image, 0, '', 'id');
			update_option('wps_ic_test_image', $media);
		}

		if ( ! empty($media) && ! is_wp_error($media)) {
			update_option(WPS_IC_SETTINGS, $old_settings);

			return true;
		} else {
			update_option(WPS_IC_SETTINGS, $old_settings);

			return false;
		}
	}


	public function wp_generate_attachment_metadata( $attachment_id, $file ) {
		$attachment = get_post( $attachment_id );

		$metadata = array();
		$support = false;
		$mime_type = get_post_mime_type( $attachment );

		if ( preg_match( '!^image/!', $mime_type ) && file_is_displayable_image( $file ) ) {
			$imagesize = getimagesize( $file );
			$metadata['width'] = $imagesize[0];
			$metadata['height'] = $imagesize[1];

			// Make the file path relative to the upload dir.
			$metadata['file'] = _wp_relative_upload_path($file);

			// Make thumbnails and other intermediate sizes.
			$_wp_additional_image_sizes = wp_get_additional_image_sizes();


			$sizes = array();
			foreach ( get_intermediate_image_sizes() as $s ) {
				$sizes[$s] = array( 'width' => '', 'height' => '', 'crop' => false );
				if ( isset( $_wp_additional_image_sizes[$s]['width'] ) ) {
					// For theme-added sizes
					$sizes[$s]['width'] = intval( $_wp_additional_image_sizes[$s]['width'] );
				} else {
					// For default sizes set in options
					$sizes[$s]['width'] = get_option( "{$s}_size_w" );
				}

				if ( isset( $_wp_additional_image_sizes[$s]['height'] ) ) {
					// For theme-added sizes
					$sizes[$s]['height'] = intval( $_wp_additional_image_sizes[$s]['height'] );
				} else {
					// For default sizes set in options
					$sizes[$s]['height'] = get_option( "{$s}_size_h" );
				}

				if ( isset( $_wp_additional_image_sizes[$s]['crop'] ) ) {
					// For theme-added sizes
					$sizes[$s]['crop'] = $_wp_additional_image_sizes[$s]['crop'];
				} else {
					// For default sizes set in options
					$sizes[$s]['crop'] = get_option( "{$s}_crop" );
				}
			}

			/**
			 * Filters the image sizes automatically generated when uploading an image.
			 *
			 * @since 2.9.0
			 * @since 4.4.0 Added the `$metadata` argument.
			 *
			 * @param array $sizes    An associative array of image sizes.
			 * @param array $metadata An associative array of image metadata: width, height, file.
			 */
			$sizes = apply_filters( 'intermediate_image_sizes_advanced', $sizes, $metadata );


			if ( $sizes ) {
				$editor = wp_get_image_editor( $file );

				#if ( ! is_wp_error( $editor ) )
					#$metadata['sizes'] = $editor->multi_resize( $sizes );

				var_dump($sizes);
				var_dump($editor->multi_resize( $sizes ));
				die();
			} else {
				$metadata['sizes'] = array();
			}

			var_dump($sizes);
			die();

			// Fetch additional metadata from EXIF/IPTC.
			$image_meta = wp_read_image_metadata( $file );
			if ( $image_meta )
				$metadata['image_meta'] = $image_meta;

		} elseif ( wp_attachment_is( 'video', $attachment ) ) {
			$metadata = wp_read_video_metadata( $file );
			$support = current_theme_supports( 'post-thumbnails', 'attachment:video' ) || post_type_supports( 'attachment:video', 'thumbnail' );
		} elseif ( wp_attachment_is( 'audio', $attachment ) ) {
			$metadata = wp_read_audio_metadata( $file );
			$support = current_theme_supports( 'post-thumbnails', 'attachment:audio' ) || post_type_supports( 'attachment:audio', 'thumbnail' );
		}

		if ( $support && ! empty( $metadata['image']['data'] ) ) {
			// Check for existing cover.
			$hash = md5( $metadata['image']['data'] );
			$posts = get_posts( array(
														'fields' => 'ids',
														'post_type' => 'attachment',
														'post_mime_type' => $metadata['image']['mime'],
														'post_status' => 'inherit',
														'posts_per_page' => 1,
														'meta_key' => '_cover_hash',
														'meta_value' => $hash
													) );
			$exists = reset( $posts );

			if ( ! empty( $exists ) ) {
				update_post_meta( $attachment_id, '_thumbnail_id', $exists );
			} else {
				$ext = '.jpg';
				switch ( $metadata['image']['mime'] ) {
					case 'image/gif':
						$ext = '.gif';
						break;
					case 'image/png':
						$ext = '.png';
						break;
				}
				$basename = str_replace( '.', '-', basename( $file ) ) . '-image' . $ext;
				$uploaded = wp_upload_bits( $basename, '', $metadata['image']['data'] );
				if ( false === $uploaded['error'] ) {
					$image_attachment = array(
						'post_mime_type' => $metadata['image']['mime'],
						'post_type' => 'attachment',
						'post_content' => '',
					);
					/**
					 * Filters the parameters for the attachment thumbnail creation.
					 *
					 * @since 3.9.0
					 *
					 * @param array $image_attachment An array of parameters to create the thumbnail.
					 * @param array $metadata         Current attachment metadata.
					 * @param array $uploaded         An array containing the thumbnail path and url.
					 */
					$image_attachment = apply_filters( 'attachment_thumbnail_args', $image_attachment, $metadata, $uploaded );

					$sub_attachment_id = wp_insert_attachment( $image_attachment, $uploaded['file'] );
					add_post_meta( $sub_attachment_id, '_cover_hash', $hash );
					$attach_data = wp_generate_attachment_metadata( $sub_attachment_id, $uploaded['file'] );
					wp_update_attachment_metadata( $sub_attachment_id, $attach_data );
					update_post_meta( $attachment_id, '_thumbnail_id', $sub_attachment_id );
				}
			}
		}
		// Try to create image thumbnails for PDFs
		else if ( 'application/pdf' === $mime_type ) {
			$fallback_sizes = array(
				'thumbnail',
				'medium',
				'large',
			);

			/**
			 * Filters the image sizes generated for non-image mime types.
			 *
			 * @since 4.7.0
			 *
			 * @param array $fallback_sizes An array of image size names.
			 * @param array $metadata       Current attachment metadata.
			 */
			$fallback_sizes = apply_filters( 'fallback_intermediate_image_sizes', $fallback_sizes, $metadata );

			$sizes = array();
			$_wp_additional_image_sizes = wp_get_additional_image_sizes();

			foreach ( $fallback_sizes as $s ) {
				if ( isset( $_wp_additional_image_sizes[ $s ]['width'] ) ) {
					$sizes[ $s ]['width'] = intval( $_wp_additional_image_sizes[ $s ]['width'] );
				} else {
					$sizes[ $s ]['width'] = get_option( "{$s}_size_w" );
				}

				if ( isset( $_wp_additional_image_sizes[ $s ]['height'] ) ) {
					$sizes[ $s ]['height'] = intval( $_wp_additional_image_sizes[ $s ]['height'] );
				} else {
					$sizes[ $s ]['height'] = get_option( "{$s}_size_h" );
				}

				if ( isset( $_wp_additional_image_sizes[ $s ]['crop'] ) ) {
					$sizes[ $s ]['crop'] = $_wp_additional_image_sizes[ $s ]['crop'];
				} else {
					// Force thumbnails to be soft crops.
					if ( 'thumbnail' !== $s ) {
						$sizes[ $s ]['crop'] = get_option( "{$s}_crop" );
					}
				}
			}

			// Only load PDFs in an image editor if we're processing sizes.
			if ( ! empty( $sizes ) ) {
				$editor = wp_get_image_editor( $file );

				if ( ! is_wp_error( $editor ) ) { // No support for this type of file
					/*
					 * PDFs may have the same file filename as JPEGs.
					 * Ensure the PDF preview image does not overwrite any JPEG images that already exist.
					 */
					$dirname = dirname( $file ) . '/';
					$ext = '.' . pathinfo( $file, PATHINFO_EXTENSION );
					$preview_file = $dirname . wp_unique_filename( $dirname, wp_basename( $file, $ext ) . '-pdf.jpg' );

					$uploaded = $editor->save( $preview_file, 'image/jpeg' );
					unset( $editor );

					// Resize based on the full size image, rather than the source.
					if ( ! is_wp_error( $uploaded ) ) {
						$editor = wp_get_image_editor( $uploaded['path'] );
						unset( $uploaded['path'] );

						if ( ! is_wp_error( $editor ) ) {
							$metadata['sizes'] = $editor->multi_resize( $sizes );
							$metadata['sizes']['full'] = $uploaded;
						}
					}
				}
			}
		}

		// Remove the blob of binary data from the array.
		if ( $metadata ) {
			unset( $metadata['image']['data'] );
		}

		/**
		 * Filters the generated attachment meta data.
		 *
		 * @since 2.1.0
		 *
		 * @param array $metadata      An array of attachment meta data.
		 * @param int   $attachment_id Current attachment ID.
		 */
		return apply_filters( 'wp_generate_attachment_metadata', $metadata, $attachment_id );
	}


	public function image_compress() {
		global $wpdb, $wps_ic;
		$wps_ic = new wps_ic();

		$upload = $this->image_upload();

		if ( ! $upload) {
			delete_option('wps_ic_test_image');
			wp_send_json_error(array('code' => 'unable_upload'));
		}

		// API Key
		$tmp_key = get_option('wps_ic_tmp_apikey');
		$apikey  = sanitize_text_field($tmp_key);
		$site    = urlencode(site_url());

		if ( ! empty($_POST['fail_test'])) {
			if ($_POST['fail_test'] == '3') {
				wp_send_json_error(array('code' => 'unable_compress'));
			}
		}

		$compress_test = get_option('wps_ic_test_image');
		#$queue = $wps_ic->queue->add_queue($compress_test, mt_rand(1000, 9999), 'hidden_compress_bulk');
		$wps_ic->compress->bulk(array('attachments' => array($compress_test)), $apikey, false);

		$data = get_post_meta($compress_test, 'wps_ic_data', true);

		if ( ! empty($data)) {
			wp_send_json_success(array('attachment_id' => $compress_test));
		} else {
			wp_delete_attachment($compress_test);
			delete_option('wps_ic_test_image');
			wp_send_json_error(array('code' => 'unable_compress', 'attachment_id' => $compress_test, 'apikey' => $apikey));
		}

		delete_option('wps_ic_test_image');
		wp_send_json_error(array('code' => 'no_attachments'));
	}


	public function image_restore() {
		global $wps_ic;
		$wps_ic = new wps_ic();

		// API Key
		$test_image = get_option('wps_ic_test_image');

		if ( ! empty($_POST['fail_test'])) {
			if ($_POST['fail_test'] == '4') {
				wp_send_json_error(array('code' => 'unable_restore'));
			}
		}

		if ($test_image) {
			$queue   = $wps_ic->queue->add_queue($test_image, 'hidden_restore_bulk');
			$restore = $wps_ic->compress->bulk_restore(array('attachments' => array($test_image)));
			$data    = get_post_meta($test_image, 'wps_ic_data', true);
			wp_delete_attachment($test_image, true);
			delete_option('wps_ic_test_image');

			if ( ! empty($data)) {
				wp_send_json_error(array('code' => 'unable_restore', 'data' => $data, 'attID' => $test_image, 'restore' => print_r($restore, true)));
			} else {
				wp_send_json_success(array('ID' => $test_image));
			}

		}

		delete_option('wps_ic_test_image');
		wp_send_json_error(array('code' => 'test_image_not_found'));
	}

}