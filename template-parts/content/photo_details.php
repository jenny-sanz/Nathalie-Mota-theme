<?php

//* //* Récupérer les champs ACF
$reference = get_field('reference');
$types = get_field('type_dappareil');

// Vérifier si le champ ACF a des valeurs
if ($types) {
    foreach ($types as $type) {
        // Récupérer le nom de chaque type qu'on stocke dans la $type_name
        $type_name = $type;
    }
}
$annee = get_field('annee');


//* Récupérer les termes de la taxonomie "catégorie"
$categories = get_the_terms(get_the_ID(), 'categorie');
// Vérifier si des catégories existent
if ($categories && !is_wp_error($categories)) {
    foreach ($categories as $categorie) {
        // Récupérer le nom de chaque catégorie dans $categorie_name
        $categorie_name = $categorie->name;
    }
}
//* Récupérer les termes de la taxonomie "format"
$formats = get_the_terms(get_the_ID(), 'format');
// Vérifier si des formats existent
if ($formats && !is_wp_error($formats)) {
    foreach ($formats as $format) {
        // Récupérer le nom de chaque format dans $format_name
        $format_name = $format->name;
    }
}


?>
<!-- descriptif photo -->
<section class="container">
    <article class="content">
        <div class="meta">
            <h2 class="title-photo"><?php the_title(); ?></h2>
            <p>Référence : <?php echo $reference; ?></p>
            <p>Catégorie : <?php echo $categorie_name; ?> </p>
            <p>Format : <?php echo $format_name; ?> </p>
            <p>Type : <?php echo $type_name; ?> </p>
            <p>Année : <?php echo $annee; ?></p>
        </div>
        <!-- photo -->
        <div class="photo-container">
            <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">

        </div>
        <!-- bouton contact -->
        <div class="contact">
            <p>Cette photo vous intéresse ?</p>
            <button class="btn btn-contact " data-reference="<?php echo $reference; ?>">Contact</button>
        </div>
        <!-- slider miniature -->
        <div class="navigation-miniature">
            <?php
            $current_post_id = get_the_ID();

            $args_thumbnails_slider = array(
                'post_type' => 'photos',
                'posts_per_page' => -1,
                'post__not_in' => array($current_post_id), // Exclure l'id de la publication actuelle
            );

            $thumbnails_slider = new WP_Query($args_thumbnails_slider);

            if ($thumbnails_slider->have_posts()) {
                while ($thumbnails_slider->have_posts()) {
                    $thumbnails_slider->the_post();

                    // récupere les infos : image mise en avant par rapport à l'id (thumbnail_url), url du post, titre
                    $thumbnail_url_id = get_the_post_thumbnail_url(get_the_ID());
                    $post_title = get_the_title();
                    $post_permalink = get_permalink();
            ?>
                    <a href="<?php echo $post_permalink; ?>">
                        <img class="thumbnails" src="<?php echo $thumbnail_url_id; ?>" alt="<?php echo $post_title; ?>">
                    </a>
            <?php
                }
                wp_reset_postdata();
            }
            ?>


            <div class="arrows">
                <svg class="arrow-left" xmlns="http://www.w3.org/2000/svg" width="26" height="8" viewBox="0 0 26 8" fill="none">
                    <path d="M0.646447 3.64645C0.451184 3.84171 0.451184 4.15829 0.646447 4.35355L3.82843 7.53553C4.02369 7.7308 4.34027 7.7308 4.53553 7.53553C4.7308 7.34027 4.7308 7.02369 4.53553 6.82843L1.70711 4L4.53553 1.17157C4.7308 0.976311 4.7308 0.659728 4.53553 0.464466C4.34027 0.269204 4.02369 0.269204 3.82843 0.464466L0.646447 3.64645ZM1 4.5H26V3.5H1V4.5Z" fill="black" />
                </svg>

                <svg class="arrow-right" xmlns="http://www.w3.org/2000/svg" width="26" height="8" viewBox="0 0 26 8" fill="none">
                    <path d="M25.3536 3.64645C25.5488 3.84171 25.5488 4.15829 25.3536 4.35355L22.1716 7.53553C21.9763 7.7308 21.6597 7.7308 21.4645 7.53553C21.2692 7.34027 21.2692 7.02369 21.4645 6.82843L24.2929 4L21.4645 1.17157C21.2692 0.976311 21.2692 0.659728 21.4645 0.464466C21.6597 0.269204 21.9763 0.269204 22.1716 0.464466L25.3536 3.64645ZM25 4.5H0V3.5H25V4.5Z" fill="black" />
                </svg>
            </div>
        </div>

        <!-- photos apparentée à la categorie -->
        <div class="photo-apparentee">
            <h3>Vous aimerez aussi</h3>
            <div class="catalogue-photos">

                <?php
                //* Nouvelle instance de WP_Query pour récupérer 2 posts de la meme catégorie que le post actuel 
                $args_related_photos = array(
                    'post_type' => 'photos',
                    'posts_per_page' => 2,
                    'orderby' => 'rand',
                    'tax_query' => array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'categorie',
                            'field' => 'slug',
                            'terms' => $categorie_name,
                        ),
                    ),
                    'post__not_in' => array(get_the_ID()), // Exclure l'id de la publication actuelle
                );

                $related_photos = new WP_Query($args_related_photos);

                if ($related_photos->have_posts()) {
                    while ($related_photos->have_posts()) {
                        $related_photos->the_post();

                        // structure du catalague
                        get_template_part('template-parts/content/container_photos');
                    }
                    wp_reset_postdata();
                }
                ?>
            </div>
            <a class="btn-photos" href="<?php echo home_url('#catalogue'); ?>" class="btn">Toutes les photos</a>

        </div>
    </article>
</section>