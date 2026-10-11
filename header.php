<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="top"><div class="wrap">
  <a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><span class="mini-stamp">№ 0001</span><span>Morph<b>Print</b></span></a>
  <nav aria-label="ניווט ראשי"><?php $h = is_front_page() ? '' : esc_url( home_url( '/' ) ); ?>
    <a href="<?php echo $h; ?>#products">מה מדפיסים</a><a href="<?php echo $h; ?>#features">יכולות</a><a href="<?php echo $h; ?>#download">הורדה</a><a href="<?php echo $h; ?>#license">רישיון</a><a href="<?php echo $h; ?>#contact">צור קשר</a>
  </nav>
</div></header>
