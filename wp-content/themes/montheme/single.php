<?php get_header() ?>

    <ul class="row">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <li class="col">
            <article>
                <h1>Titre : <?= the_title()?></h1>
                <h1>Id :<?= the_ID()?></h1>
                <p><?= the_content()?></p>
                <p><?= the_excerpt()?></p>
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

    <?php get_footer() ?>
