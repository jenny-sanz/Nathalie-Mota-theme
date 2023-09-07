<?php get_header(); ?>

<main id="main" class="site-main" role="main">

    <!-- Banner -->
    <section class="banner">
        <?php
        $post_id = 92; // ID du post pour afficher son image dans la bannière
        $thumbnail_banner = get_the_post_thumbnail_url($post_id);

        if ($thumbnail_banner) {
        ?>
            <img src="<?php echo $thumbnail_banner; ?>" alt="<?php echo  get_the_title($post_id); ?>">

        <?php } ?>

        <h1 class="title">Photographe event</h1>
    </section>


    <!-- filtres + catalague -->
    <section class="container">
        <?php
        //* Nouvelle instance wp_query pour recuperer les filtres (taxonomies et champs ACF année)
        $args_filters = array(
            'post_type' => 'photos',
            'posts_per_page' => -1,
        );
        $get_custom_filtres = new WP_Query($args_filters);

        // Récupérer les termes de la taxonomie "catégorie" qui renvoie un tableau
        $categories = get_terms('categorie');

        // Récupérer les termes de la taxonomie "format" qui renvoie un tableau
        $formats = get_terms('format');

        // on définit un tableau pour les années
        $annees = array();

        if ($get_custom_filtres->have_posts()) {
            while ($get_custom_filtres->have_posts()) {
                $get_custom_filtres->the_post();

                // Récupére la valeur du champ ACF "année" pour chaque post dans la boucle
                $annee = get_field('annee');
                // si la variable n'est pas vide et n'existe pas dans le tableau années
                if (!empty($annee) && !in_array($annee, $annees)) {
                    // on ajoute les valeurs année au tableau
                    $annees[] = $annee;
                }
                // Trier les années par ordre croissant
                sort($annees);
            }
            wp_reset_postdata();
        }
        ?>

        <!-- Filtres -->
        <div class="filter">
            <form action="" method="post" id="filters-posts">
                <div class="select-wrapper">
                    <div class="categories">
                        <!-- Menu déroulant pour la taxonomie "catégorie"  -->
                        <?php if (!empty($categories)) : ?>
                            <select name="categorie" id="categories" class="js-example-basic-single select2-dropdown-below">
                                <option value="">Catégories</option>
                                <?php foreach ($categories as $categorie) : ?>
                                    <option value="<?php echo $categorie->slug; ?>"><?php echo $categorie->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </div>
                    <div class="formats">
                        <!-- Menu déroulant pour la taxonomie "format  -->
                        <?php if (!empty($formats)) : ?>
                            <select name="format" id="formats" class="js-example-basic-single select2-dropdown-below">
                                <option value="">Formats</option>
                                <?php foreach ($formats as $format) : ?>
                                    <option value="<?php echo $format->slug; ?>"><?php echo $format->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </div>

                    <div class="annee">
                        <!-- Menu déroulant pour la tri par année (champs ACF)"  -->
                        <select name="annee" id="annee" class="js-example-basic-single select2-dropdown-below">
                            <option value="">Trier par</option>
                            <?php foreach ($annees as $annee) : ?>
                                <option value="<?php echo $annee; ?>"><?php echo $annee; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>
            </form>
        </div>

        <!-- Catalogue -->
        <div id="catalogue" class="catalogue-photos" data-page="1">
            <?php

            //* Nouvelle instance de WP_Query pour récupérer les 12 premiers posts pour le catalogue photo
            $paged = get_query_var('paged') ? get_query_var('paged') : 1;
            $args_photos = array(
                'post_type' => 'photos',
                'posts_per_page' => 12,
                'paged' => $paged,
            );

            $custom_catalogue_photos = new WP_Query($args_photos);

            if ($custom_catalogue_photos->have_posts()) {
                while ($custom_catalogue_photos->have_posts()) {
                    $custom_catalogue_photos->the_post();

                    /* $displayed_photos[] = get_the_ID(); */

                    // structure du catalague
                    get_template_part('template-parts/content/container_photos');
                }
                wp_reset_postdata();
            }
            ?>
        </div>
        <!-- bouton charger plus -->
        <div id="load-more-container">
            <button id="load-more-btn" class="btn">Charger plus</button>
        </div>

    </section>

</main>

<?php get_footer(); ?>