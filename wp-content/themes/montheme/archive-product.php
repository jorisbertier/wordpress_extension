
<?php

// if(have_posts()) {
//     while(have_posts()) {
//         the_post();
        
//         // <h1>the</h1>
//     }
// }

?>
<?php get_header() ?>

<h1>Tous les Produits</h1>
<ul class="row">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <li class="col">
        <article>
            <h2><?= the_title()?></h2>
            <!-- <p><?= the_content()?></p> -->
            <p><?= the_excerpt()?></p>
            <p><?= the_post_thumbnail('medium') ?></p>
            <small>Par <?= the_author()?></small>
            <time> le <?= the_date()?></time>
            <time datetime="<?php the_date(); ?>"> à <?= the_time()?></time>
            <!-- <?= the_shortlink( 'lire la suite') ?> -->
            <a href="<?php the_permalink();?>">view</a>

        </article>

        <summary>
            <details>

            </details>
        </summary>
    </li>
    
<?php endwhile; endif; ?>
</div>

<?php get_footer() ?>