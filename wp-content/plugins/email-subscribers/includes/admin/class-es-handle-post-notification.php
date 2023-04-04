<?php

class ES_Handle_Post_Notification {

	public function __construct() {
		add_action( 'transition_post_status', array( $this, 'es_post_publish_callback' ), 10, 3 );
	}


	public function es_post_publish_callback( $post_status, $original_post_status, $post_id ) {

		if ( ( $post_status == 'publish' ) && ( $original_post_status != 'publish' ) ) {
			/*
			add entry to DB

			*/
			if ( is_object( $post_id ) ) {
				$post_id = $post_id->ID;
			}

			$notifications = ES_DB_Notifications::get_notifications_by_post_id( $post_id );
			if ( count( $notifications ) > 0 ) {
				foreach ( $notifications as $notification ) {
					$template_id = $notification['base_template_id'];
					$template    = get_post( $template_id );    // to confirm if template exists in ES->Templates
					if ( is_object( $template ) ) {
						$list_id     = $notification['list_ids'];
						$subscribers = ES_DB_Contacts::get_active_subscribers_by_list_id( $list_id );
						//schedule
						if ( count( $subscribers ) > 0 ) {

							/*
							 * Prepare Subject
							 * Prepare Body
							 * Add entry into sent_details table
							 * Add entry into deliverreport table
							 */
							$post = get_post( $post_id );

							if ( is_object( $post ) ) {
								// Prepare subject
								$post_subject = self::prepare_subject( $post, $template );

								// Prepare body
								$template_content = $template->post_content;
								$post_content     = self::prepare_body( $template_content, $post_id, $template_id );

								$guid = ES_Common::generate_guid( 6 );

								$data = array(
									'hash'        => $guid,
									'campaign_id' => $notification['id'],
									'subject'     => $post_subject,
									'body'        => $post_content,
									'count'       => count( $subscribers ),
									'status'      => 'In Queue',
									'start_at'    => '',
									'finish_at'   => '',
									'created_at'  => ig_get_current_date_time(),
									'updated_at'  => ig_get_current_date_time()
								);

								// Add entry into mailing queue table
								$insert = ES_DB_Mailing_Queue::add_notification( $data );
								if ( $insert ) {
									// Add entry into sending queue table
									$delivery_data                     = array();
									$delivery_data['hash']             = $guid;
									$delivery_data['subscribers']      = $subscribers;
									$delivery_data['campaign_id']      = $notification['id'];
									$delivery_data['mailing_queue_id'] = $insert;
									ES_DB_Sending_Queue::do_batch_insert( $delivery_data );

								}

							}
						}
					}
				}
			}
		}
	}

	public static function prepare_subject( $post, $template ) {
		//convert post subject here

		$post_title     = $post->post_title;
		$template_title = $template->post_title;

		$blog_charset = get_option( 'blog_charset' );

		$post_title   = html_entity_decode( $post_title, ENT_QUOTES, $blog_charset );
		$post_subject = str_replace( '{{POSTTITLE}}', $post_title, $template_title );

		$post_link    = get_permalink( $post );
		$post_subject = str_replace( '{{POSTLINK}}', $post_link, $post_subject );

		return $post_subject;

	}

	public static function prepare_body( $es_templ_body, $post_id, $email_template_id ) {
		$post          = get_post( $post_id );
		$post_date     = $post->post_modified;
		$es_templ_body = str_replace( '{{DATE}}', $post_date, $es_templ_body );

		$post_title    = get_the_title( $post );
		$es_templ_body = str_replace( '{{POSTTITLE}}', $post_title, $es_templ_body );

		$post_link = get_permalink( $post_id );

		// Size of {{POSTIMAGE}}
		$post_thumbnail      = "";
		$post_thumbnail_link = "";
		if ( ( function_exists( 'has_post_thumbnail' ) ) && ( has_post_thumbnail( $post_id ) ) ) {
			$es_post_image_size = get_option( 'ig_es_post_image_size', 'full' );
			switch ( $es_post_image_size ) {
				case 'full':
					$post_thumbnail = get_the_post_thumbnail( $post_id, 'full' );
					break;
				case 'medium':
					$post_thumbnail = get_the_post_thumbnail( $post_id, 'medium' );
					break;
				case 'thumbnail':
					$post_thumbnail = get_the_post_thumbnail( $post_id, 'thumbnail' );
					break;
			}
		}

		if ( $post_thumbnail != "" ) {
			$post_thumbnail_link = "<a href='" . $post_link . "' target='_blank'>" . $post_thumbnail . "</a>";
		}
		$es_templ_body = str_replace( '{{POSTIMAGE}}', $post_thumbnail_link, $es_templ_body );

		// Get post description
		$post_description_length = 50;
		$post_description        = $post->post_content;
		$post_description        = strip_tags( strip_shortcodes( $post_description ) );
		$words                   = explode( ' ', $post_description, $post_description_length + 1 );
		if ( count( $words ) > $post_description_length ) {
			array_pop( $words );
			array_push( $words, '...' );
			$post_description = implode( ' ', $words );
		}
		$es_templ_body = str_replace( '{{POSTDESC}}', $post_description, $es_templ_body );

		// Get post excerpt
		$post_excerpt  = get_the_excerpt( $post );
		$es_templ_body = str_replace( '{{POSTEXCERPT}}', $post_excerpt, $es_templ_body );

		// get post author
		$post_author_id = $post->post_author;
		$post_author    = get_the_author_meta( 'display_name', $post_author_id );
		$es_templ_body  = str_replace( '{{POSTAUTHOR}}', $post_author, $es_templ_body );
		$es_templ_body  = str_replace( '{{POSTLINK-ONLY}}', $post_link, $es_templ_body );

		if ( $post_link != "" ) {
			$post_link_with_title = "<a href='" . $post_link . "' target='_blank'>" . $post_title . "</a>";
			$es_templ_body        = str_replace( '{{POSTLINK-WITHTITLE}}', $post_link_with_title, $es_templ_body );
			$post_link            = "<a href='" . $post_link . "' target='_blank'>" . $post_link . "</a>";
		}
		$es_templ_body = str_replace( '{{POSTLINK}}', $post_link, $es_templ_body );

		// Get full post
		$post_full     = $post->post_content;
		$post_full     = wpautop( $post_full );
		$es_templ_body = str_replace( '{{POSTFULL}}', $post_full, $es_templ_body );


		$content = ES_Common::es_process_template_body( $es_templ_body, $email_template_id );

		return $content;
	}

}


add_action( 'plugins_loaded', function () {
	new ES_Handle_Post_Notification();
} );
