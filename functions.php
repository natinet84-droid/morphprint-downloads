<?php
/* MorphPrint theme */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function mp_defaults() {
	return array(
		'phone'        => '',
		'whatsapp'     => '',
		'email'        => '',
		'price'        => '',
	);
}
function mp_opt( $key ) {
	$d = mp_defaults();
	$v = get_theme_mod( 'mp_' . $key, $d[ $key ] ?? '' );
	return is_string( $v ) ? trim( $v ) : $v;
}

add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );
} );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'mp-fonts', 'https://fonts.googleapis.com/css2?family=Rubik:wght@500;700;800&family=Heebo:wght@400;500;700&family=IBM+Plex+Mono:wght@500;600&display=swap', array(), null );
	wp_enqueue_style( 'mp-style', get_stylesheet_uri(), array( 'mp-fonts' ), wp_get_theme()->get( 'Version' ) );
} );

add_filter( 'document_title_parts', function ( $t ) {
	if ( is_front_page() ) { $t['title'] = 'MorphPrint'; $t['tagline'] = 'תוכנה להדפסת מספור רץ ומידע משתנה'; }
	return $t;
} );

add_action( 'wp_head', function () {
	if ( is_front_page() ) {
		echo '<meta name="description" content="' . esc_attr( 'MorphPrint: תוכנה ל-Windows ול-Mac להדפסת פנקסים ממוספרים, מדבקות, כרטיסים, שוברים ותגי שם, עם מקור והעתק ממגשים שונים, נתונים מאקסל, ברקודים ובליד.' ) . '">' . "\n";
	}
	echo '<link rel="icon" href="' . esc_url( get_theme_file_uri( 'assets/icon.png' ) ) . '">' . "\n";
}, 1 );

/* Customizer: contact details, price */
add_action( 'customize_register', function ( $c ) {
	$c->add_section( 'mp_site', array( 'title' => 'MorphPrint: פרטי האתר', 'priority' => 30 ) );
	$fields = array(
		'phone'        => array( 'טלפון', 'text' ),
		'whatsapp'     => array( 'וואטסאפ (מספר, למשל 972501234567)', 'text' ),
		'email'        => array( 'מייל להצגה ולקבלת פניות', 'email' ),
		'price'        => array( 'מחיר רישיון (ריק = לא מוצג)', 'text' ),
	);
	$d = mp_defaults();
	foreach ( $fields as $k => $f ) {
		$c->add_setting( 'mp_' . $k, array( 'default' => $d[ $k ], 'sanitize_callback' => $f[1] === 'url' ? 'esc_url_raw' : ( $f[1] === 'email' ? 'sanitize_email' : 'sanitize_text_field' ) ) );
		$c->add_control( 'mp_' . $k, array( 'label' => $f[0], 'section' => 'mp_site', 'type' => $f[1] ) );
	}
} );

/* License request form -> email */
function mp_contact_handler() {
	$back = home_url( '/' );
	if ( ! isset( $_POST['mp_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mp_nonce'] ) ), 'mp_contact' ) ) {
		wp_safe_redirect( add_query_arg( 'sent', '0', $back ) . '#contact' ); exit;
	}
	if ( ! empty( $_POST['mp_web'] ) ) { wp_safe_redirect( add_query_arg( 'sent', '1', $back ) . '#contact' ); exit; } // honeypot
	$name  = sanitize_text_field( wp_unslash( $_POST['mp_name'] ?? '' ) );
	$phone = sanitize_text_field( wp_unslash( $_POST['mp_phone'] ?? '' ) );
	$email = sanitize_email( wp_unslash( $_POST['mp_email'] ?? '' ) );
	$code  = strtoupper( sanitize_text_field( wp_unslash( $_POST['mp_code'] ?? '' ) ) );
	$msg   = sanitize_textarea_field( wp_unslash( $_POST['mp_msg'] ?? '' ) );
	if ( ! $name || ( ! $phone && ! $email ) ) { wp_safe_redirect( add_query_arg( 'sent', '0', $back ) . '#contact' ); exit; }
	$to   = mp_opt( 'email' ) ? mp_opt( 'email' ) : get_option( 'admin_email' );
	$body = "שם: $name\nטלפון: $phone\nמייל: $email\nקוד מחשב: $code\n\n$msg\n";
	$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
	if ( $email ) { $headers[] = 'Reply-To: ' . $name . ' <' . $email . '>'; }
	$ok = wp_mail( $to, 'MorphPrint: פנייה חדשה מ' . $name, $body, $headers );
	wp_safe_redirect( add_query_arg( 'sent', $ok ? '1' : '0', $back ) . '#contact' ); exit;
}
add_action( 'admin_post_nopriv_mp_contact', 'mp_contact_handler' );
add_action( 'admin_post_mp_contact', 'mp_contact_handler' );
