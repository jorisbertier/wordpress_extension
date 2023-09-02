<?php get_header() ?>


<div class="container">
<h1 class="text-center mb-5 mt-3">Toutes les recettes</h1>
<div class="row d-flex">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <div class="col-12 d-flex justify-content-center mb-5">
        <article>
            <h2><?= the_title()?></h2>
            <!-- <p><?= the_content()?></p>--><br> 
            <p><?= the_excerpt()?></p>
            <p><?= the_post_thumbnail('medium') ?></p>
            <small>Par <?= the_author()?></small>
            <time> le <?= the_date()?></time>
            <time datetime="<?php the_date(); ?>"> à <?= the_time()?></time><br><br>
            <!-- <?= the_shortlink( 'lire la suite') ?> -->
            <!-- <a href="<?php the_permalink();?>"><button type="submit" class="btn btn-success">Lire la suite</button></a> -->
            <a href="<?php the_permalink();?>"><button type="submit" class="btn" style="background-color : <?= get_field('bg_color') ?>; color : <?= get_field('color_text'); ?>"><?= get_field('content_button') ?></button></a>
        </article>
        <!-- <summary>
            <details>
            </details>
        </summary> -->
    </div>

    <?php endwhile; endif; ?>
</div>
</div>



<?php get_footer() ?>
