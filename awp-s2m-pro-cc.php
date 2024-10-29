<?php
/**
 * Plugin Name: Affiliate WP - s2Member Pro Coupon Codes
 * Description: Track your AffiliateWP referrals using s2Member Pro Coupon Codes
 * Version: 1.0.0
 * Author: qfnetwork, rahilwazir
 * Author URI: https://www.qfnetwork.org
 * Text Domain: awp-s2m-pro-cc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_plugin_active( 'affiliate-wp/affiliate-wp.php' ) ) {
	return;
}

require_once 'includes/functions.php';

add_action(
	'ws_plugin__s2member_pro_before_loaded',
	function() {
		require_once 'includes/coupon-menu.php';
		add_filter( 'ws_plugin__s2member_during_add_admin_options_add_divider_2', 'awp_s2m_pro_cc_menu_pages', 9, 2 );
	}
);

add_action(
	'ws_plugin__s2member_pro_loaded',
	function() {
		require_once 'includes/coupons.inc.php';
	}
);

add_action(
	'admin_enqueue_scripts',
	function() {
		wp_enqueue_style(
			'awp-s2m-pro-cc',
			plugins_url( 'assets/css/admin.css', __FILE__ )
		);
	},
	100
);

add_action( 'ws_plugin__s2member_pro_stripe_checkout_post_attr', 'awp_s2m_pro_cc_set_referral_variable', 9 );
add_action( 'ws_plugin__s2member_pro_stripe_sp_checkout_post_attr', 'awp_s2m_pro_cc_set_referral_variable', 9 );
add_action( 'ws_plugin__s2member_pro_paypal_checkout_post_attr', 'awp_s2m_pro_cc_set_referral_variable', 9 );
add_action( 'ws_plugin__s2member_pro_paypal_sp_checkout_post_attr', 'awp_s2m_pro_cc_set_referral_variable', 9 );
add_action( 'ws_plugin__s2member_pro_authnet_checkout_post_attr', 'awp_s2m_pro_cc_set_referral_variable', 9 );
add_action( 'ws_plugin__s2member_pro_authnet_sp_checkout_post_attr', 'awp_s2m_pro_cc_set_referral_variable', 9 );
