<?php

/**
 * @param int $affiliate_id
 * @return string|bool
 */
function awp_s2m_pro_cc_get_affiliate_user_login( $affiliate_id ) {
	if ( ! $affiliate_id ) {
		return false;
	}

	$user_id = affwp_get_affiliate_user_id( $affiliate_id );
	$user    = get_userdata( $user_id );
	return $user ? $user->user_login : false;
}

/**
 * @param int $user_login
 * @return int|bool
 */
function awp_s2m_pro_cc_get_affiliate_by_user_login( $user_login ) {
	if ( ! $user_login ) {
		return false;
	}

	$user = get_user_by( 'login', $user_login );
	if ( ! $user ) {
		return false;
	}

	$affiliate_id = affwp_get_affiliate_id( $user->ID );
	if ( ! affiliate_wp()->tracking->is_valid_affiliate( $affiliate_id ) ) {
		return false;
	}

	return $affiliate_id;
}

/**
 * Get affiliate by coupon code
 * @param string @coupon
 * @return int|bool
 */
function awp_s2m_pro_cc_get_affiliate( $coupon ) {
	$coupons = $GLOBALS['WS_PLUGIN__']['s2member']['o']['pro_coupon_codes'];

	if ( empty( $coupons ) || empty( $coupon ) ) {
		return false;
	}

	$_coupons = new awp_s2m_pro_cc_coupons();
	if ( ! isset( $_coupons->coupons[ $coupon ], $_coupons->coupons[ $coupon ]['affiliate'] ) ) {
		return false;
	}

	$affiliate_id = awp_s2m_pro_cc_get_affiliate_by_user_login( $_coupons->coupons[ $coupon ]['affiliate'] );
	if ( ! $affiliate_id ) {
		return false;
	}

	return $affiliate_id;
}

/**
 * Set referral for coupon used on checkout
 * @param array $vars
 * @return array
 */
function awp_s2m_pro_cc_set_referral_variable( $vars ) {
	if ( ! isset( $vars['coupon'] ) ) {
		return $vars;
	}

	$affiliate_id = awp_s2m_pro_cc_get_affiliate( $vars['coupon'] );

	if ( ! $affiliate_id ) {
		return $vars;
	}

	$custom_attrs = explode( '|', $vars['custom'] );

	$custom_attrs[1] = $affiliate_id;

	$vars['custom'] = implode( '|', $custom_attrs );

	return $vars;
}
