<?php get_header(); ?>

<main id="main" class="site-main" role="main">

    <?php

    $args = array(
        'post_type' => 'photos',
        'p' => get_the_ID(),

    );

    $custom_query_single_photo = new WP_Query($args);

    if ($custom_query_single_photo->have_posts()) {
        while ($custom_query_single_photo->have_posts()) {
            $custom_query_single_photo->the_post();

            get_template_part('template-parts/content/photo_details');
        }
        wp_reset_postdata(); // Réinitialise les données originales de la requête 
    }
    ?>
</main>

<?php get_footer(); ?>