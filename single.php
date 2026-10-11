<?php get_header(); ?>
<main class="page-main"><div class="wrap narrow">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
  <article <?php post_class( 'entry' ); ?>>
    <h1><?php the_title(); ?></h1>
    <?php if ( ! is_page() ) : ?><p class="small"><?php echo esc_html( get_the_date() ); ?></p><?php endif; ?>
    <div class="entry-content"><?php the_content(); ?></div>
  </article>
<?php endwhile; the_posts_pagination(); else : ?>
  <article class="entry"><h1>לא נמצא</h1><p>העמוד שחיפשת לא קיים. <a href="<?php echo esc_url( home_url( '/' ) ); ?>">לעמוד הבית</a></p></article>
<?php endif; ?>
</div></main>
<?php get_footer();
