<?php
/**
 * The one-page site. Written to show even if the helper code failed to load.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! function_exists( 'demis_details' ) ) {
	function demis_details() {
		return array( 'phone' => '', 'email' => '', 'address' => '', 'instagram' => '', 'facebook' => '' );
	}
}
$demis = demis_details();
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php if ( function_exists( 'wp_body_open' ) ) { wp_body_open(); } ?>
<div class="intro" id="intro" role="dialog" aria-label="Welcome to Demi's Spa">
  <video class="intro-video" id="intro-video" muted playsinline preload="auto" poster="<?php echo esc_url( get_template_directory_uri() . '/assets/media/intro-poster.jpg' ); ?>">
    <source src="<?php echo esc_url( get_template_directory_uri() . '/assets/media/intro.mp4' ); ?>" type="video/mp4">
  </video>
  <div class="intro-shade"></div>
  <div class="intro-copy">
    <svg class="intro-mark" aria-hidden="true"><use href="#logo-mark"/></svg>
    <p class="intro-name">demi's <span>spa</span></p>
    <p class="intro-tag" data-i18n>Skin care · Laser · Eyebrows · Massage</p>
  </div>
  <button class="intro-skip" id="intro-skip" type="button" data-i18n>Skip intro</button>
</div>
<script>try{if(sessionStorage.getItem('intro-seen')==='1')document.getElementById('intro').hidden=true}catch(e){}</script>


<svg width="0" height="0" style="position:absolute" aria-hidden="true"><symbol id="logo-mark" viewBox="0 0 48 56"><path d="M4 52V24C4 12.4 12.95 4 24 4s20 8.4 20 20v28z" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linejoin="round"/><circle cx="24" cy="14.5" r="2.4" fill="currentColor"/><path d="M24 47c-7.5-6-8.5-14 0-24 8.5 10 7.5 18 0 24z" fill="currentColor"/><path d="M23 47c-9.5 0-15-5.5-16-13 8.5.2 14.5 4.8 16 13z" fill="currentColor" fill-opacity=".55"/><path d="M25 47c9.5 0 15-5.5 16-13-8.5.2-14.5 4.8-16 13z" fill="currentColor" fill-opacity=".55"/></symbol></svg>

<svg width="0" height="0" style="position:absolute" aria-hidden="true">
<symbol id="art-face" viewBox="0 0 300 210" preserveAspectRatio="xMidYMid slice"><rect width="300" height="210" fill="#ecd3c4"/><circle cx="150" cy="118" r="128" fill="#f2dfd2"/><circle cx="150" cy="118" r="92" fill="#f8ebe1"/><circle cx="150" cy="118" r="56" fill="#fff6ee"/><path d="M150 82c-20 26-26 42-26 54a26 26 0 0 0 52 0c0-12-6-28-26-54z" fill="#c58b74"/><path d="M139 124a12 12 0 0 0 8 14" stroke="#fff" stroke-width="3" stroke-linecap="round" fill="none" opacity=".75"/><path d="M52 176c-4-14 4-24 16-28 4 14-2 24-16 28zM250 52c4 14-4 24-16 28-4-14 2-24 16-28z" fill="#9aa88c"/></symbol>
<symbol id="art-body" viewBox="0 0 300 210" preserveAspectRatio="xMidYMid slice"><rect width="300" height="210" fill="#d3dbc8"/><circle cx="218" cy="66" r="32" fill="#f6f0e3"/><path d="M0 118C50 88 100 148 150 118S250 88 300 116V210H0z" fill="#b2bfa5"/><path d="M0 148C60 120 110 178 170 148S260 126 300 144V210H0z" fill="#8a9c7e"/><path d="M0 180C70 158 120 203 190 180S270 168 300 178V210H0z" fill="#667a5c"/></symbol>
<symbol id="art-brow" viewBox="0 0 300 210" preserveAspectRatio="xMidYMid slice"><rect width="300" height="210" fill="#e6d4c8"/><circle cx="150" cy="112" r="118" fill="#efdfd3"/><circle cx="150" cy="112" r="78" fill="#f7ebe1"/><path d="M42 124C72 86 114 76 142 96C112 92 78 100 50 134z" fill="#4d352d"/><path d="M258 124C228 86 186 76 158 96C188 92 222 100 250 134z" fill="#4d352d"/><path d="M118 150c10 8 24 8 32 0 8 8 22 8 32 0" stroke="#c58b74" stroke-width="3" stroke-linecap="round" fill="none"/><path d="M52 184c-4-14 4-24 16-28 4 14-2 24-16 28zM248 40c4 14-4 24-16 28-4-14 2-24 16-28z" fill="#9aa88c"/></symbol>
<symbol id="art-laser" viewBox="0 0 300 210" preserveAspectRatio="xMidYMid slice"><rect width="300" height="210" fill="#e8d9c6"/><g stroke="#b99a7c" stroke-width="2" stroke-linecap="round" opacity=".7"><line x1="196.0" y1="105.0" x2="320.0" y2="105.0"/><line x1="193.2" y1="120.7" x2="309.7" y2="163.1"/><line x1="185.2" y1="134.6" x2="280.2" y2="214.3"/><line x1="173.0" y1="144.8" x2="235.0" y2="252.2"/><line x1="158.0" y1="150.3" x2="179.5" y2="272.4"/><line x1="142.0" y1="150.3" x2="120.5" y2="272.4"/><line x1="127.0" y1="144.8" x2="65.0" y2="252.2"/><line x1="114.8" y1="134.6" x2="19.8" y2="214.3"/><line x1="106.8" y1="120.7" x2="-9.7" y2="163.1"/><line x1="104.0" y1="105.0" x2="-20.0" y2="105.0"/><line x1="106.8" y1="89.3" x2="-9.7" y2="46.9"/><line x1="114.8" y1="75.4" x2="19.8" y2="-4.3"/><line x1="127.0" y1="65.2" x2="65.0" y2="-42.2"/><line x1="142.0" y1="59.7" x2="120.5" y2="-62.4"/><line x1="158.0" y1="59.7" x2="179.5" y2="-62.4"/><line x1="173.0" y1="65.2" x2="235.0" y2="-42.2"/><line x1="185.2" y1="75.4" x2="280.2" y2="-4.3"/><line x1="193.2" y1="89.3" x2="309.7" y2="46.9"/></g><circle cx="150" cy="105" r="70" fill="none" stroke="#c9ad90" stroke-width="2"/><circle cx="150" cy="105" r="44" fill="#fbefe3"/><circle cx="150" cy="105" r="22" fill="#c58b74"/><circle cx="150" cy="105" r="8" fill="#fbefe3"/></symbol>
<symbol id="art-massage" viewBox="0 0 300 210" preserveAspectRatio="xMidYMid slice"><rect width="300" height="210" fill="#dcbdac"/><ellipse cx="150" cy="176" rx="92" ry="12" fill="#8a5f50" opacity=".3"/><ellipse cx="150" cy="154" rx="64" ry="21" fill="#553a31"/><ellipse cx="150" cy="122" rx="50" ry="18" fill="#76503f"/><ellipse cx="150" cy="95" rx="35" ry="14" fill="#98695a"/><path d="M122 70c-10-12 10-20 0-34M150 66c-10-12 10-20 0-34M178 70c-10-12 10-20 0-34" stroke="#fbefe3" stroke-width="3" fill="none" stroke-linecap="round" opacity=".85"/><path d="M246 182c-22-4-34-19-32-38 22 4 34 17 32 38z" fill="#86987a"/><path d="M54 182c22-4 34-19 32-38-22 4-34 17-32 38z" fill="#9aa88c"/></symbol>
<symbol id="art-arch-face" viewBox="0 0 360 440" preserveAspectRatio="xMidYMid slice"><rect width="360" height="440" fill="#e8c9b8"/><g fill="none" stroke="#f6e3d6" stroke-width="2"><path d="M30 440V190a150 150 0 0 1 300 0v250"/><path d="M62 440V190a118 118 0 0 1 236 0v250"/></g><circle cx="180" cy="190" r="104" fill="#f6e9df"/><circle cx="180" cy="190" r="66" fill="#efd5c3"/><path d="M180 128c-24 30-30 48-30 62a30 30 0 0 0 60 0c0-14-6-32-30-62z" fill="#c58b74"/><g fill="#fff" fill-opacity=".92" transform="translate(180 424) scale(3.4) translate(-24 -47)"><path d="M24 47c-7.5-6-8.5-14 0-24 8.5 10 7.5 18 0 24z"/><path d="M23 47c-9.5 0-15-5.5-16-13 8.5.2 14.5 4.8 16 13z" fill-opacity=".6"/><path d="M25 47c9.5 0 15-5.5 16-13-8.5.2-14.5 4.8-16 13z" fill-opacity=".6"/></g></symbol>
<symbol id="art-arch-massage" viewBox="0 0 360 440" preserveAspectRatio="xMidYMid slice"><rect width="360" height="440" fill="#c9d3be"/><g fill="none" stroke="#e6ecde" stroke-width="2"><path d="M30 440V190a150 150 0 0 1 300 0v250"/><path d="M62 440V190a118 118 0 0 1 236 0v250"/></g><circle cx="180" cy="150" r="64" fill="#f4efe4"/><ellipse cx="180" cy="390" rx="110" ry="14" fill="#4e6044" opacity=".3"/><ellipse cx="180" cy="364" rx="84" ry="26" fill="#3f4f37"/><ellipse cx="180" cy="324" rx="64" ry="22" fill="#586a4d"/><ellipse cx="180" cy="290" rx="44" ry="17" fill="#74876a"/><path d="M150 262c-12-14 12-24 0-42M180 258c-12-14 12-24 0-42M210 262c-12-14 12-24 0-42" stroke="#fff" stroke-width="3.5" fill="none" stroke-linecap="round" opacity=".85"/></symbol>
<symbol id="ico-sparkle" viewBox="0 0 28 28"><path d="M14 3l2.5 8.5L25 14l-8.5 2.5L14 25l-2.5-8.5L3 14l8.5-2.5z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></symbol>
<symbol id="ico-target" viewBox="0 0 28 28"><g fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="14" cy="14" r="11"/><circle cx="14" cy="14" r="5.5"/></g><circle cx="14" cy="14" r="1.6" fill="currentColor"/></symbol>
<symbol id="ico-heart" viewBox="0 0 28 28"><path d="M14 24C5 17.500 3 11.500 7.500 7.500 10.500 5.500 13 7 14 9.500 15 7 17.500 5.500 20.500 7.500 25 11.500 23 17.500 14 24z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></symbol>
<symbol id="ico-drop" viewBox="0 0 28 28"><path d="M14 3C9 10 6 14 6 18a8 8 0 0 0 16 0c0-4-3-8-8-15z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></symbol>
</svg>

<div class="site-top" id="top">
<div class="topbar">
  <div class="wrap topbar-inner">
    <span data-i18n>Mon–Fri 8am–5pm · Sat 10am–2pm</span>
    <span class="topbar-links">
      <a href="#contact" data-i18n>Contact</a>
    </span>
  </div>
</div>

<header class="site-header">
  <div class="wrap header-inner">
    <a href="#home" class="logo" aria-label="Demi's Spa home">
      <svg class="logo-mark" aria-hidden="true"><use href="#logo-mark"/></svg>
      <span class="logo-text"><span class="logo-name">demi's</span><span class="logo-sub">Spa</span></span>
    </a>
    <button class="nav-toggle" aria-label="Open menu" aria-expanded="false" aria-controls="nav">
      <span></span><span></span><span></span>
    </button>
    <nav id="nav" class="nav">
      <a href="#about" data-i18n>About</a>
      <a href="#treatments" data-i18n>Treatments</a>
      <a href="#menu" data-i18n>Price guide</a>
      <a href="#contact" data-i18n>Contact</a>
      <a href="#book" class="btn btn-small" data-i18n>Book now</a>
    </nav>
    <div class="lang" id="lang">
      <button class="lang-btn" id="lang-btn" type="button" aria-haspopup="listbox" aria-expanded="false" aria-label="Language">
        <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true"><g fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"><circle cx="12" cy="12" r="9.5"/><path d="M2.5 12h19M12 2.500c3 3 3 16.500 0 19M12 2.500c-3 3-3 16.500 0 19"/></g></svg>
        <span id="lang-code">EN</span>
      </button>
      <ul class="lang-menu" id="lang-menu" role="listbox" aria-label="Language" hidden></ul>
    </div>
  </div>
</header>
</div>

<main>

<!-- HERO -->
<div class="snap snap-home" id="home" data-label="Home">
<section class="hero">
  <div class="wrap hero-inner">
    <div class="hero-copy">
      <p class="eyebrow" data-i18n>Boutique beauty &amp; wellness</p>
      <h1 data-i18n>Where you come to <em>feel beautiful</em>, inside and out.</h1>
      <p class="lead" data-i18n>Skin care, laser, eyebrows and massage, delivered with care in a calm, private space made for you.</p>
      <div class="hero-actions">
        <a href="#book" class="btn" data-i18n>Book an appointment</a>
        <a href="#treatments" class="btn btn-ghost" data-i18n>Explore treatments</a>
      </div>
      
    </div>
    <div class="hero-art"><div class="hero-frame">
      <div class="hero-chip"><span class="dot"></span><span><strong id="open-state">Open today</strong><small id="open-hours">Mon–Fri 8:00–17:00</small></span></div>
    </div></div>
  </div>
</section>

<!-- FEATURES -->
<section class="features">
  <div class="wrap feature-grid">
    <article>
      <svg class="icon" aria-hidden="true"><use href="#ico-sparkle"/></svg>
      <h3 data-i18n>Wide treatment range</h3>
      <p data-i18n>Skin care, laser, eyebrows and massage, all in one place.</p>
    </article>
    <article>
      <svg class="icon" aria-hidden="true"><use href="#ico-target"/></svg>
      <h3 data-i18n>Modern technology</h3>
      <p data-i18n>Professional-grade devices chosen for safe, visible results.</p>
    </article>
    <article>
      <svg class="icon" aria-hidden="true"><use href="#ico-heart"/></svg>
      <h3 data-i18n>Personal care</h3>
      <p data-i18n>Warm, unhurried treatments tailored to you.</p>
    </article>
    <article>
      <svg class="icon" aria-hidden="true"><use href="#ico-drop"/></svg>
      <h3 data-i18n>Quality products</h3>
      <p data-i18n>Skin-loving formulas and natural oils, never rushed, never generic.</p>
    </article>
  </div>
</section>
</div>

<!-- ABOUT -->
<section class="about section snap" id="about" data-label="About">
  <div class="wrap split">
    <div class="about-art" aria-hidden="true">
      <svg viewBox="0 0 440 520">
        <defs>
          <linearGradient id="g3" x1="0" y1="0" x2="1" y2="1">
            <stop offset="0" stop-color="#d9c9b4"/><stop offset="1" stop-color="#a98d72"/>
          </linearGradient>
        </defs>
        <rect width="440" height="520" rx="220" fill="url(#g3)"/>
        <ellipse cx="220" cy="270" rx="120" ry="150" fill="#f4ebe0" opacity=".8"/>
        <path d="M220 130c40 50 40 130 0 200-40-70-40-150 0-200z" fill="#8c9b80" opacity=".8"/>
        <path d="M150 300c40 10 70 40 70 80-45-5-75-35-70-80zM290 300c-40 10-70 40-70 80 45-5 75-35 70-80z" fill="#a9b79c" opacity=".9"/>
      </svg>
    </div>
    <div>
      <p class="eyebrow" data-i18n>About Demi's Spa</p>
      <h2 data-i18n>A quiet place to <em>slow down</em></h2>
      <p data-i18n>Demi's Spa was created for people who want real results without the rush. Every visit begins with a conversation about your skin, your body and what you want to feel when you leave.</p>
      <p data-i18n>We combine proven treatments with a gentle, personal touch, so whether it's a monthly facial, a post-work massage or a full course of laser, you are always looked after properly.</p>
      <ul class="ticks">
        <li data-i18n>Personal consultation with every first visit</li>
        <li data-i18n>Treatment plans tailored to your skin and goals</li>
        <li data-i18n>Clean, calm and fully private treatment rooms</li>
      </ul>
      <a href="#book" class="link-arrow" data-i18n>Meet us — book a visit →</a>
    </div>
  </div>
</section>

<!-- TREATMENT RANGE -->
<section class="treatments section tinted snap" id="treatments" data-label="Treatments">
  <div class="wrap">
    <div class="section-head">
      <p class="eyebrow" data-i18n>Our treatments</p>
      <h2 data-i18n>Something for <em>every</em> need</h2>
    </div>
    <div class="card-grid">
      <a class="card" href="#menu" data-tab="face">
        <svg class="card-art c1" aria-hidden="true"><use href="#art-face"/></svg>
        <h3 data-i18n>Skin care</h3>
        <p data-i18n>Cleansing, oxygen therapy, microdermabrasion and anti-ageing care.</p>
        <span class="link-arrow" data-i18n>View skin care →</span>
      </a>
      <a class="card" href="#menu" data-tab="brows">
        <svg class="card-art c2" aria-hidden="true"><use href="#art-brow"/></svg>
        <h3 data-i18n>Eyebrows</h3>
        <p data-i18n>Shaping, tinting and lamination for brows that frame your face.</p>
        <span class="link-arrow" data-i18n>View eyebrows →</span>
      </a>
      <a class="card" href="#menu" data-tab="laser">
        <svg class="card-art c3" aria-hidden="true"><use href="#art-laser"/></svg>
        <h3 data-i18n>Laser hair removal</h3>
        <p data-i18n>Long-lasting smoothness for face and body.</p>
        <span class="link-arrow" data-i18n>View laser →</span>
      </a>
      <a class="card" href="#menu" data-tab="massage">
        <svg class="card-art c4" aria-hidden="true"><use href="#art-massage"/></svg>
        <h3 data-i18n>Massage</h3>
        <p data-i18n>Deep tissue, hot stone, aromatherapy and more, tailored to you.</p>
        <span class="link-arrow" data-i18n>View massage →</span>
      </a>
    </div>
  </div>
</section>

<!-- MENU -->
<section class="menu section snap" id="menu" data-label="Price guide">
  <div class="wrap">
    <div class="section-head">
      <p class="eyebrow" data-i18n>Price guide</p>
      <h2 data-i18n>Treatment <em>menu</em></h2>
      <p class="muted" data-i18n>Ask us about availability and prices. Everything is confirmed at your consultation.</p>
    </div>

    <div class="tabs" role="tablist" aria-label="Treatment categories">
      <button role="tab" class="tab is-active" data-tab="face" aria-selected="true" data-i18n>Skin care</button>
      <button role="tab" class="tab" data-tab="brows" aria-selected="false" data-i18n>Eyebrows</button>
      <button role="tab" class="tab" data-tab="massage" aria-selected="false" data-i18n>Massage</button>
      <button role="tab" class="tab" data-tab="laser" aria-selected="false" data-i18n>Laser</button>
    </div>

    <?php
    $demis_groups = function_exists( 'demis_treatment_groups' ) ? demis_treatment_groups() : array();
    $demis_first  = true;
    foreach ( array( 'face', 'brows', 'massage', 'laser' ) as $demis_slug ) :
    ?>
    <div class="panel<?php echo $demis_first ? ' is-active' : ''; $demis_first = false; ?>" data-panel="<?php echo esc_attr( $demis_slug ); ?>" role="tabpanel">
      <ul class="menu-list">
<?php foreach ( ( isset( $demis_groups[ $demis_slug ] ) ? $demis_groups[ $demis_slug ] : array() ) as $demis_t ) : ?>
        <li><div><h4 data-i18n><?php echo esc_html( $demis_t['title'] ); ?></h4><p data-i18n><?php echo esc_html( $demis_t['desc'] ); ?></p></div><?php if ( '' !== $demis_t['price'] ) : ?><span><?php echo esc_html( $demis_t['price'] ); ?></span><?php endif; ?></li>
<?php endforeach; ?>
      </ul>
    </div>
    <?php endforeach; ?>

    <p class="center"><a href="#book" class="btn" data-i18n>Book your treatment</a></p>
  </div>
</section>

<!-- FEATURE SPOTLIGHT -->
<section class="spotlight section snap" id="facials" data-label="Facials">
  <div class="wrap split reverse">
    <div>
      <p class="eyebrow" data-i18n>Facials</p>
      <h2 data-i18n>Skin that looks <em>rested, clear</em> and glowing</h2>
      <p data-i18n>Our facials start with a skin analysis, then build a plan around you: hydration, texture, pigmentation or simply a well-earned hour of calm.</p>
      <a href="#book" class="link-arrow" data-i18n>Book a facial →</a>
    </div>
    <svg class="spot-art s1" aria-hidden="true"><use href="#art-arch-face"/></svg>
  </div>
</section>

<section class="spotlight section snap" id="massage" data-label="Massage">
  <div class="wrap split spot-row">
    <svg class="spot-art s2" aria-hidden="true"><use href="#art-arch-massage"/></svg>
    <div>
      <p class="eyebrow" data-i18n>Massage</p>
      <h2 data-i18n>Switch off. <em>Truly.</em></h2>
      <p data-i18n>Warm towels, soft light and skilled hands. Choose a massage designed to ease your muscles, quiet your mind, or both.</p>
      <a href="#book" class="link-arrow" data-i18n>Book a massage →</a>
    </div>
  </div>
</section>

<!-- TESTIMONIALS -->


<!-- VOUCHER -->


<!-- JOURNAL -->


<!-- BOOK & CONTACT -->
<section class="book section snap" id="book" data-label="Book &amp; visit">
  <span id="contact" class="anchor"></span>
  <div class="wrap split book-split">
    <div class="book-copy">
      <p class="eyebrow" data-i18n>Book &amp; visit</p>
      <h2 data-i18n>Ready when <em>you are</em></h2>
      <p class="lead-sm" data-i18n>Choose a treatment and a time that suits you. We will confirm your appointment shortly.</p>
      <dl class="info">
        <dt data-i18n>Address</dt><?php if ( $demis['address'] ) : ?><dd><?php echo nl2br( esc_html( $demis['address'] ) ); ?></dd><?php else : ?><dd data-i18n>Coming soon</dd><?php endif; ?>
        <dt data-i18n>Phone</dt><?php if ( $demis['phone'] ) : ?><dd><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $demis['phone'] ) ); ?>"><?php echo esc_html( $demis['phone'] ); ?></a></dd><?php else : ?><dd data-i18n>Coming soon</dd><?php endif; ?>
        <?php if ( $demis['email'] ) : ?><dt data-i18n>Email</dt><dd><a href="mailto:<?php echo esc_attr( $demis['email'] ); ?>"><?php echo esc_html( $demis['email'] ); ?></a></dd><?php endif; ?>
        <dt data-i18n>Hours</dt><dd data-i18n>Mon–Fri 8:00–17:00<br>Sat 10:00–14:00<br>Sun closed</dd>
      </dl>
    </div>
    <form class="form booking" id="booking-form" novalidate data-endpoint="<?php echo esc_url( rest_url( 'demis/v1/booking' ) ); ?>">
      <h3 data-i18n>Request an appointment</h3>
      <div class="row2">
        <label class="field"><span data-i18n>Name</span><input id="b-name" name="name" type="text" autocomplete="name" required></label>
        <label class="field"><span data-i18n>Phone</span><input id="b-phone" name="phone" type="tel" autocomplete="tel" required></label>
      </div>
      <div class="row2">
        <label class="field"><span data-i18n>Email (optional)</span><input id="b-email" name="email" type="email" autocomplete="email"></label>
        <label class="field"><span data-i18n>Treatment</span><select id="b-treatment" name="treatment" required>
          <option value="" data-i18n>Choose a treatment</option>
          <option value="Skin care" data-i18n>Skin care</option>
          <option value="Eyebrows" data-i18n>Eyebrows</option>
          <option value="Laser hair removal" data-i18n>Laser hair removal</option>
          <option value="Massage" data-i18n>Massage</option>
          <option value="Not sure yet" data-i18n>Not sure yet</option>
        </select></label>
      </div>
      <div class="row2">
        <label class="field"><span data-i18n>Date</span><input id="b-date" name="date" type="date" required></label>
        <label class="field"><span data-i18n>Time</span><select id="b-time" name="time" required><option value="" id="b-time-ph">Choose a date first</option></select></label>
      </div>
      <label class="field"><span data-i18n>Anything we should know? (optional)</span><textarea id="b-notes" name="notes" rows="2"></textarea></label>
      <label class="check"><input id="b-consent" name="consent" type="checkbox" required><span data-i18n>I agree to be contacted about this request.</span></label>
      <input class="hp" id="b-hp" type="text" name="botcheck" tabindex="-1" autocomplete="off" aria-hidden="true">
      <button type="submit" class="btn" data-i18n>Request booking</button>
      <p class="form-note" id="booking-note" role="status"></p>
    </form>
  </div>
</section>

</main>

<footer class="site-footer">
  <div class="wrap footer-grid">
    <div>
      <a href="#top" class="logo light">
        <svg class="logo-mark" aria-hidden="true"><use href="#logo-mark"/></svg>
        <span class="logo-text"><span class="logo-name">demi's</span><span class="logo-sub">Spa</span></span>
      </a>
      <p data-i18n>Skin care, laser, eyebrows and massage in a calm, private space.</p>
    </div>
    <div>
      <h4 data-i18n>Explore</h4>
      <a href="#about" data-i18n>About</a>
      <a href="#treatments" data-i18n>Treatments</a>
      <a href="#menu" data-i18n>Price guide</a>
    </div>
    <div>
      <h4 data-i18n>Opening hours</h4>
      <span data-i18n>Mon–Fri 8:00–17:00</span>
      <span data-i18n>Sat 10:00–14:00</span>
      <span data-i18n>Sun closed</span>
    </div>
    <div>
      <h4 data-i18n>Contact</h4>
      <?php
      if ( $demis['phone'] ) { echo '<a href="tel:' . esc_attr( preg_replace( '/[^0-9+]/', '', $demis['phone'] ) ) . '">' . esc_html( $demis['phone'] ) . '</a>'; }
      if ( $demis['email'] ) { echo '<a href="mailto:' . esc_attr( $demis['email'] ) . '">' . esc_html( $demis['email'] ) . '</a>'; }
      if ( $demis['address'] ) { echo '<span>' . nl2br( esc_html( $demis['address'] ) ) . '</span>'; }
      if ( ! $demis['phone'] && ! $demis['email'] && ! $demis['address'] ) { echo '<span data-i18n>Phone, address and booking link coming soon</span>'; }
      if ( $demis['instagram'] || $demis['facebook'] ) { echo '<span class="follow" data-i18n>Follow</span>'; }
      if ( $demis['instagram'] ) { echo '<a href="' . esc_url( $demis['instagram'] ) . '" target="_blank" rel="noopener">Instagram</a>'; }
      if ( $demis['facebook'] ) { echo '<a href="' . esc_url( $demis['facebook'] ) . '" target="_blank" rel="noopener">Facebook</a>'; }
      ?>
    </div>
  </div>
  <div class="wrap footer-base">© <span id="year">2026</span> <span data-i18n>Demi's Spa. All rights reserved.</span></div>
</footer>

<nav class="side-nav" id="side-nav" aria-label="Page sections"><ul></ul></nav>
<?php wp_footer(); ?>
</body>
</html>
