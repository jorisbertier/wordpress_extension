<?php get_header() ?>

<ul class="row">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <li class="col">
            <article>
                <div>Gamme: <?php 
                $terms = get_terms(['gamme']);
                
                foreach($terms as $term) {
                    echo $term->name;
                }
                ?></div>
                <h1 style=" color : <?= get_field('couleur')?>;">Titre : <?= the_title()?></h1>
                <h1>Id :<?= the_ID()?></h1>
                <p><?= the_content()?></p>
                <p><?= the_excerpt()?></p>
                <small>Par <?= the_author()?></small>
                <time> le <?= the_date()?></time>
                <time datetime="<?php the_date(); ?>"> à <?= the_time()?></time>
                <!-- <?= the_shortlink( 'lire la suite') ?> --><br>
                <?php the_taxonomies()?>

                <?php echo get_field('couleur') ?>

            </article>

            <summary>
                <details>

                </details>
            </summary>
        </li>
    <?php endwhile; endif; ?>

    <?php get_footer() ?>
