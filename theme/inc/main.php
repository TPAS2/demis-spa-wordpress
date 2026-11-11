<?php
/**
 * Demi's Spa theme: main code.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ------------------------------------------------------------------
 * Opening hours (24-hour clock). Used by the booking form checks.
 * To change the hours, edit this list AND the hours written in front-page.php.
 * ---------------------------------------------------------------- */
function demis_hours() {
	return array(
		'Mon' => array( 8, 17 ),
		'Tue' => array( 8, 17 ),
		'Wed' => array( 8, 17 ),
		'Thu' => array( 8, 17 ),
		'Fri' => array( 8, 17 ),
		'Sat' => array( 10, 14 ),
	);
}

function demis_treatment_categories() {
	return array(
		'face'    => 'Skin care',
		'brows'   => 'Eyebrows',
		'massage' => 'Massage',
		'laser'   => 'Laser',
	);
}

function demis_booking_treatments() {
	return array( 'Skin care', 'Eyebrows', 'Laser hair removal', 'Massage', 'Not sure yet' );
}

/* ------------------------------------------------------------------
 * Theme set-up and files
 * ---------------------------------------------------------------- */
add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'title-tag' );
		add_theme_support( 'html5', array( 'style', 'script' ) );
	}
);

add_filter( 'show_admin_bar', '__return_false' );

add_action(
	'wp_enqueue_scripts',
	function () {
		$uri = get_template_directory_uri();
		$ver = defined( 'DEMIS_VERSION' ) ? DEMIS_VERSION : '1.0.0';

		wp_enqueue_style(
			'demis-fonts',
			'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Jost:wght@300;400;500&family=Noto+Serif:ital,wght@0,400;0,500;1,400&family=Noto+Sans:wght@300;400;500&display=swap',
			array(),
			null
		);
		wp_enqueue_style( 'demis-site', $uri . '/assets/css/site.css', array( 'demis-fonts' ), $ver );
		wp_enqueue_script( 'demis-i18n', $uri . '/assets/js/i18n.js', array(), $ver, true );
		wp_enqueue_script( 'demis-site', $uri . '/assets/js/site.js', array( 'demis-i18n' ), $ver, true );
		wp_add_inline_script(
			'demis-site',
			'window.DEMIS_CONFIG = ' . wp_json_encode( array( 'hours' => demis_hours() ) ) . ';',
			'before'
		);
	}
);

add_action(
	'wp_head',
	function () {
		echo '<meta name="description" content="' . esc_attr( 'Boutique beauty and wellness spa: skin care, laser hair removal, eyebrows and massage.' ) . '">' . "\n";
		echo '<link rel="icon" href="' . esc_url( get_template_directory_uri() . '/assets/logo-mark.svg' ) . '" type="image/svg+xml">' . "\n";
	},
	5
);

/* ------------------------------------------------------------------
 * Contact details (Appearance > Customize > Demi's Spa details)
 * ---------------------------------------------------------------- */
function demis_details() {
	return array(
		'phone'     => trim( (string) get_theme_mod( 'demis_phone', '' ) ),
		'email'     => trim( (string) get_theme_mod( 'demis_email', '' ) ),
		'address'   => trim( (string) get_theme_mod( 'demis_address', '' ) ),
		'instagram' => trim( (string) get_theme_mod( 'demis_instagram', '' ) ),
		'facebook'  => trim( (string) get_theme_mod( 'demis_facebook', '' ) ),
	);
}

add_action(
	'customize_register',
	function ( $wp_customize ) {
		$wp_customize->add_section(
			'demis_details',
			array(
				'title'       => "Demi's Spa details",
				'priority'    => 30,
				'description' => 'These show on the Book & visit page and in the footer. Leave a box empty to hide it.',
			)
		);
		$fields = array(
			'demis_phone'         => array( 'Phone number', 'text', 'sanitize_text_field' ),
			'demis_email'         => array( 'Public email address (optional)', 'text', 'sanitize_text_field' ),
			'demis_address'       => array( 'Address', 'textarea', 'sanitize_textarea_field' ),
			'demis_instagram'     => array( 'Instagram link', 'url', 'esc_url_raw' ),
			'demis_facebook'      => array( 'Facebook link', 'url', 'esc_url_raw' ),
			'demis_booking_email' => array( 'Send booking requests to this email', 'text', 'sanitize_text_field' ),
		);
		foreach ( $fields as $id => $field ) {
			$wp_customize->add_setting(
				$id,
				array(
					'default'           => '',
					'sanitize_callback' => $field[2],
				)
			);
			$wp_customize->add_control(
				$id,
				array(
					'label'   => $field[0],
					'section' => 'demis_details',
					'type'    => $field[1],
				)
			);
		}
	}
);

/* ------------------------------------------------------------------
 * Treatments and booking requests (admin menus)
 * ---------------------------------------------------------------- */
add_action(
	'init',
	function () {
		register_post_type(
			'demis_treatment',
			array(
				'labels'          => array(
					'name'               => 'Treatments',
					'singular_name'      => 'Treatment',
					'menu_name'          => 'Treatments',
					'all_items'          => 'All treatments',
					'add_new'            => 'Add treatment',
					'add_new_item'       => 'Add treatment',
					'edit_item'          => 'Edit treatment',
					'search_items'       => 'Search treatments',
					'not_found'          => 'No treatments yet',
					'not_found_in_trash' => 'Nothing in the bin',
				),
				'public'          => false,
				'show_ui'         => true,
				'show_in_menu'    => true,
				'menu_position'   => 20,
				'menu_icon'       => 'dashicons-heart',
				'supports'        => array( 'title', 'excerpt', 'page-attributes' ),
				'capability_type' => 'post',
				'show_in_rest'    => false,
			)
		);
		register_post_type(
			'demis_booking',
			array(
				'labels'          => array(
					'name'               => 'Booking requests',
					'singular_name'      => 'Booking request',
					'menu_name'          => 'Bookings',
					'all_items'          => 'All booking requests',
					'edit_item'          => 'Booking request',
					'search_items'       => 'Search booking requests',
					'not_found'          => 'No booking requests yet',
					'not_found_in_trash' => 'Nothing in the bin',
				),
				'public'          => false,
				'show_ui'         => true,
				'show_in_menu'    => true,
				'menu_position'   => 21,
				'menu_icon'       => 'dashicons-calendar-alt',
				'supports'        => array( 'title' ),
				'capability_type' => 'post',
				'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
				'map_meta_cap'    => true,
				'show_in_rest'    => false,
			)
		);
	}
);

add_action(
	'add_meta_boxes',
	function () {
		add_meta_box( 'demis_treatment_box', 'Treatment details', 'demis_treatment_box', 'demis_treatment', 'normal', 'high' );
		add_meta_box( 'demis_booking_box', 'Booking details', 'demis_booking_box', 'demis_booking', 'normal', 'high' );
	}
);

function demis_treatment_box( $post ) {
	wp_nonce_field( 'demis_treatment_save', 'demis_treatment_nonce' );
	$cat   = get_post_meta( $post->ID, '_demis_category', true );
	$dur   = get_post_meta( $post->ID, '_demis_duration', true );
	$price = get_post_meta( $post->ID, '_demis_price', true );

	echo '<p><label for="demis_category"><strong>Section on the website</strong></label><br><select name="demis_category" id="demis_category">';
	foreach ( demis_treatment_categories() as $slug => $label ) {
		printf( '<option value="%s"%s>%s</option>', esc_attr( $slug ), selected( $cat, $slug, false ), esc_html( $label ) );
	}
	echo '</select></p>';
	printf( '<p><label for="demis_duration"><strong>Duration</strong> (for example 60 min)</label><br><input type="text" id="demis_duration" name="demis_duration" value="%s" class="regular-text"></p>', esc_attr( $dur ) );
	printf( '<p><label for="demis_price"><strong>Price</strong> (for example €65. Leave empty to hide the price)</label><br><input type="text" id="demis_price" name="demis_price" value="%s" class="regular-text"></p>', esc_attr( $price ) );
	echo '<p class="description">The title above is the treatment name. Write the short description in the Excerpt box below. Use the Order box on the right to move it up or down (smaller numbers show first).</p>';
}

add_action(
	'save_post_demis_treatment',
	function ( $post_id ) {
		if ( ! isset( $_POST['demis_treatment_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['demis_treatment_nonce'] ) ), 'demis_treatment_save' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		$cats = demis_treatment_categories();
		$cat  = isset( $_POST['demis_category'] ) ? sanitize_key( wp_unslash( $_POST['demis_category'] ) ) : 'face';
		update_post_meta( $post_id, '_demis_category', isset( $cats[ $cat ] ) ? $cat : 'face' );
		update_post_meta( $post_id, '_demis_duration', isset( $_POST['demis_duration'] ) ? sanitize_text_field( wp_unslash( $_POST['demis_duration'] ) ) : '' );
		update_post_meta( $post_id, '_demis_price', isset( $_POST['demis_price'] ) ? sanitize_text_field( wp_unslash( $_POST['demis_price'] ) ) : '' );
	}
);

add_filter(
	'manage_demis_treatment_posts_columns',
	function ( $cols ) {
		return array(
			'cb'          => isset( $cols['cb'] ) ? $cols['cb'] : '',
			'title'       => 'Treatment',
			'demis_cat'   => 'Section',
			'demis_price' => 'Price',
		);
	}
);

add_action(
	'manage_demis_treatment_posts_custom_column',
	function ( $col, $id ) {
		if ( 'demis_cat' === $col ) {
			$cats = demis_treatment_categories();
			$cat  = get_post_meta( $id, '_demis_category', true );
			echo esc_html( isset( $cats[ $cat ] ) ? $cats[ $cat ] : '' );
		} elseif ( 'demis_price' === $col ) {
			$price = get_post_meta( $id, '_demis_price', true );
			echo esc_html( '' !== $price ? $price : '(hidden)' );
		}
	},
	10,
	2
);

add_action(
	'pre_get_posts',
	function ( $query ) {
		if ( is_admin() && $query->is_main_query() && 'demis_treatment' === $query->get( 'post_type' ) && ! $query->get( 'orderby' ) ) {
			$query->set( 'orderby', array( 'menu_order' => 'ASC', 'title' => 'ASC' ) );
		}
	}
);

/* Treatments grouped for the price guide */
function demis_treatment_groups() {
	$groups = array();
	foreach ( demis_treatment_categories() as $slug => $label ) {
		$groups[ $slug ] = array();
	}
	$q = new WP_Query(
		array(
			'post_type'      => 'demis_treatment',
			'post_status'    => 'publish',
			'posts_per_page' => 200,
			'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
			'no_found_rows'  => true,
		)
	);
	foreach ( $q->posts as $p ) {
		$cat = get_post_meta( $p->ID, '_demis_category', true );
		if ( ! isset( $groups[ $cat ] ) ) {
			$cat = 'face';
		}
		$desc = trim( wp_strip_all_tags( $p->post_excerpt ) );
		$dur  = trim( (string) get_post_meta( $p->ID, '_demis_duration', true ) );
		$groups[ $cat ][] = array(
			'title' => $p->post_title,
			'desc'  => trim( $desc . ( '' !== $dur ? ' ' . $dur : '' ) ),
			'price' => trim( (string) get_post_meta( $p->ID, '_demis_price', true ) ),
		);
	}
	return $groups;
}

/* First-time treatment list (added once, in the admin) */
function demis_seed_treatments() {
	if ( get_option( 'demis_seeded' ) || ! post_type_exists( 'demis_treatment' ) ) {
		return;
	}
	$items = array(
		array( 'face', 'Signature Deep-Cleanse Facial', 'Cleanse, exfoliate, extract, mask and massage.', '60 min' ),
		array( 'face', 'Oxygen Glow Therapy', 'Hydrating oxygen infusion for tired, dull skin.', '50 min' ),
		array( 'face', 'Diamond Microdermabrasion', 'Smooths texture, softens lines and fades marks.', '45 min' ),
		array( 'face', 'Anti-Ageing Skin Renewal', 'Targets fine lines, firmness and dark spots.', '75 min' ),
		array( 'face', 'Clear Skin Acne Programme', 'Deep cleanse and calming therapy for blemish-prone skin.', '60 min' ),
		array( 'brows', 'Brow Shape & Tint', 'Shaping to suit your face, with a tint to define.', '40 min' ),
		array( 'brows', 'Brow Shaping', 'Waxing or threading to a clean, balanced arch.', '20 min' ),
		array( 'brows', 'Brow Tint', 'Colour matched to your hair and skin tone.', '20 min' ),
		array( 'brows', 'Brow Lamination', 'Brushed-up, fuller-looking brows that last up to 6 weeks.', '50 min' ),
		array( 'brows', 'Lamination & Tint', 'Our full brow makeover.', '60 min' ),
		array( 'massage', 'Relaxing Aromatherapy Massage', 'Slow, flowing strokes with calming essential oils.', '60 min' ),
		array( 'massage', 'Deep Tissue Massage', 'Firm pressure to release tight, aching muscles.', '60 min' ),
		array( 'massage', 'Hot Stone Massage', 'Heated stones melt tension and warm the body.', '75 min' ),
		array( 'massage', 'Pregnancy Massage', 'Gentle, supportive care for expectant mums.', '50 min' ),
		array( 'massage', 'Couples Massage', 'Side-by-side relaxation in a private suite.', '60 min' ),
		array( 'laser', 'Upper Lip / Chin', 'Quick session, per visit.', '10 min' ),
		array( 'laser', 'Underarms', 'Per visit.', '15 min' ),
		array( 'laser', 'Half Legs', 'Per visit.', '30 min' ),
		array( 'laser', 'Full Legs', 'Per visit.', '45 min' ),
		array( 'laser', 'Full Body', 'Course packages available.', '90 min' ),
	);
	foreach ( $items as $i => $item ) {
		$id = wp_insert_post(
			array(
				'post_type'    => 'demis_treatment',
				'post_status'  => 'publish',
				'post_title'   => $item[1],
				'post_excerpt' => $item[2],
				'menu_order'   => $i,
			)
		);
		if ( $id && ! is_wp_error( $id ) ) {
			update_post_meta( $id, '_demis_category', $item[0] );
			update_post_meta( $id, '_demis_duration', $item[3] );
			update_post_meta( $id, '_demis_price', '' );
		}
	}
	update_option( 'demis_seeded', 1 );
}
add_action( 'admin_init', 'demis_seed_treatments' );

/* ------------------------------------------------------------------
 * Booking form: saves each request in WordPress and emails a copy
 * ---------------------------------------------------------------- */
add_action(
	'rest_api_init',
	function () {
		register_rest_route(
			'demis/v1',
			'/booking',
			array(
				'methods'             => 'POST',
				'callback'            => 'demis_handle_booking',
				'permission_callback' => '__return_true',
			)
		);
	}
);

function demis_valid_slot( $date, $time ) {
	$dt = DateTime::createFromFormat( 'Y-m-d', $date, wp_timezone() );
	if ( ! $dt || $dt->format( 'Y-m-d' ) !== $date ) {
		return false;
	}
	$dt->setTime( 0, 0, 0 );
	$today = new DateTime( 'today', wp_timezone() );
	if ( $dt < $today ) {
		return false;
	}
	$hours = demis_hours();
	$day   = $dt->format( 'D' );
	if ( ! isset( $hours[ $day ] ) ) {
		return false;
	}
	if ( ! preg_match( '/^(\d{2}):(00|30)$/', $time, $m ) ) {
		return false;
	}
	$mins = (int) $m[1] * 60 + (int) $m[2];
	return $mins >= $hours[ $day ][0] * 60 && $mins <= $hours[ $day ][1] * 60 - 30;
}

function demis_handle_booking( $request ) {
	$p = $request->get_json_params();
	if ( ! is_array( $p ) ) {
		$p = $request->get_params();
	}
	$get = function ( $key ) use ( $p ) {
		return isset( $p[ $key ] ) && is_string( $p[ $key ] ) ? $p[ $key ] : '';
	};

	// Hidden field that only robots fill in: pretend it worked and drop it.
	if ( '' !== $get( 'botcheck' ) ) {
		return new WP_REST_Response( array( 'success' => true ), 200 );
	}

	// At most six requests an hour from one visitor.
	$ip    = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
	$key   = 'demis_rl_' . md5( $ip );
	$count = (int) get_transient( $key );
	if ( $count >= 6 ) {
		return new WP_Error( 'too_many', 'Too many requests', array( 'status' => 429 ) );
	}
	set_transient( $key, $count + 1, HOUR_IN_SECONDS );

	$name      = sanitize_text_field( $get( 'name' ) );
	$phone     = sanitize_text_field( $get( 'phone' ) );
	$email     = sanitize_email( $get( 'email' ) );
	$treatment = sanitize_text_field( $get( 'treatment' ) );
	$date      = sanitize_text_field( $get( 'date' ) );
	$time      = sanitize_text_field( $get( 'time' ) );
	$notes     = sanitize_textarea_field( $get( 'notes' ) );
	$language  = sanitize_key( $get( 'language' ) );

	$problem = '';
	if ( '' === $name || strlen( $name ) > 100 ) {
		$problem = 'name';
	} elseif ( strlen( $phone ) < 5 || strlen( $phone ) > 30 || ! preg_match( '/\d/', $phone ) ) {
		$problem = 'phone';
	} elseif ( '' !== $get( 'email' ) && ! is_email( $email ) ) {
		$problem = 'email';
	} elseif ( ! in_array( $treatment, demis_booking_treatments(), true ) ) {
		$problem = 'treatment';
	} elseif ( ! demis_valid_slot( $date, $time ) ) {
		$problem = 'time';
	} elseif ( strlen( $notes ) > 1000 ) {
		$problem = 'notes';
	}
	if ( '' !== $problem ) {
		return new WP_Error( 'invalid_' . $problem, 'Please check the ' . $problem, array( 'status' => 400 ) );
	}

	$id = wp_insert_post(
		array(
			'post_type'   => 'demis_booking',
			'post_status' => 'publish',
			'post_title'  => $name . ' - ' . $date . ' ' . $time,
		)
	);
	if ( ! $id || is_wp_error( $id ) ) {
		return new WP_Error( 'save_failed', 'Could not save the request', array( 'status' => 500 ) );
	}
	update_post_meta( $id, '_b_name', $name );
	update_post_meta( $id, '_b_phone', $phone );
	update_post_meta( $id, '_b_email', $email );
	update_post_meta( $id, '_b_treatment', $treatment );
	update_post_meta( $id, '_b_date', $date );
	update_post_meta( $id, '_b_time', $time );
	update_post_meta( $id, '_b_notes', $notes );
	update_post_meta( $id, '_b_language', $language );

	// Email a copy. If the server cannot send mail the request is still saved above.
	$to = trim( (string) get_theme_mod( 'demis_booking_email', '' ) );
	if ( ! is_email( $to ) ) {
		$to = get_option( 'admin_email' );
	}
	$body = "New booking request\n\n"
		. "Name: $name\nPhone: $phone\nEmail: " . ( '' !== $email ? $email : '-' ) . "\n"
		. "Treatment: $treatment\nDate: $date\nTime: $time\n"
		. 'Notes: ' . ( '' !== $notes ? $notes : '-' ) . "\nLanguage: $language\n\n"
		. 'See all requests: ' . admin_url( 'edit.php?post_type=demis_booking' ) . "\n";
	$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
	if ( '' !== $email ) {
		$headers[] = 'Reply-To: ' . $email;
	}
	wp_mail( $to, 'New booking request from ' . $name, $body, $headers );

	return new WP_REST_Response( array( 'success' => true ), 200 );
}

function demis_booking_box( $post ) {
	$rows = array(
		'Name'      => '_b_name',
		'Phone'     => '_b_phone',
		'Email'     => '_b_email',
		'Treatment' => '_b_treatment',
		'Date'      => '_b_date',
		'Time'      => '_b_time',
		'Notes'     => '_b_notes',
		'Language'  => '_b_language',
	);
	echo '<table class="form-table"><tbody>';
	foreach ( $rows as $label => $meta ) {
		$value = get_post_meta( $post->ID, $meta, true );
		printf( '<tr><th scope="row">%s</th><td>%s</td></tr>', esc_html( $label ), '' !== $value ? nl2br( esc_html( $value ) ) : '-' );
	}
	echo '</tbody></table><p class="description">This request was sent from the website. You can move it to the bin once you have dealt with it.</p>';
}

add_filter(
	'manage_demis_booking_posts_columns',
	function () {
		return array(
			'cb'            => '<input type="checkbox">',
			'title'         => 'Request',
			'demis_phone'   => 'Phone',
			'demis_treat'   => 'Treatment',
			'demis_when'    => 'Appointment',
			'date'          => 'Received',
		);
	}
);

add_action(
	'manage_demis_booking_posts_custom_column',
	function ( $col, $id ) {
		if ( 'demis_phone' === $col ) {
			echo esc_html( get_post_meta( $id, '_b_phone', true ) );
		} elseif ( 'demis_treat' === $col ) {
			echo esc_html( get_post_meta( $id, '_b_treatment', true ) );
		} elseif ( 'demis_when' === $col ) {
			echo esc_html( get_post_meta( $id, '_b_date', true ) . ' ' . get_post_meta( $id, '_b_time', true ) );
		}
	},
	10,
	2
);
