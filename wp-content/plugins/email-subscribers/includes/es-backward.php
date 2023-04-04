<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class es_cls_dbquery {

	public static function es_view_subscriber_group() {
		$res = ES_DB_Lists::get_list_id_name_map();
		foreach ( $res as $id => $name ) {
			$list['id']             = $id;
			$list['es_email_group'] = $name;
			$es_lists[]             = $list;
		}

		return $es_lists;
	}

	public static function es_view_subscriber_ins( $data = array(), $action = "insert" ) {

		$last_name = '';
		if ( ! empty( $data['es_email_name'] ) ) {
			$name       = trim( $data['es_email_name'] );
			$name_parts = ES_Common::prepare_first_name_last_name( $name );
			$first_name = $name_parts['first_name'];
			$last_name  = $name_parts['last_name'];
		} else {
			$first_name = ES_Common::get_name_from_email( $data['es_email_mail'] );
		}

		$sub_data = array(
			'first_name' => $first_name,
			'last_name'  => $last_name,
			'email'      => $data['es_email_mail'],
			'source'     => 'api',
			'status'     => 'verified',
			'hash'       => ES_Common::generate_guid(),
			'created_at' => ig_get_current_date_time(),
		);

		$added             = ES_DB_Contacts::add_subscriber( $sub_data );
		$optin_type        = get_option( 'ig_es_optin_type', true );
		$optin_type        = ( $optin_type === 'double_opt_in' ) ? 2 : 1;
		$list_data         = ES_DB_Lists::get_list_by_name( $data['es_email_group'] );
		$list_id           = ! empty( $list_data['id'] ) ? $list_data['id'] : 1;
		$list_contact_data = array(
			'list_id'       => array( $list_id ),
			'contact_id'    => $added,
			'status'        => 'subscribed',
			'optin_type'    => $optin_type,
			'subscribed_at' => ig_get_current_date_time(),
			'subscribed_ip' => ES_Subscription_Throttaling::getUserIP()
		);
		$result            = ES_DB_Lists_Contacts::add_lists_contacts( $list_contact_data );

	}

}

?>