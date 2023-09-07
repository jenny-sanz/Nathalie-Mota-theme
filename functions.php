<?php
//* Configuration du thème

if (!function_exists('nathalie_mota_theme_setup')) {
    function nathalie_mota_theme_setup()
    {
        // Ajouter la prise en charge des images mises en avant
        add_theme_support('post-thumbnails');

        // Ajouter automatiquement le titre du site dans l'en-tête du site
        add_theme_support('title-tag');

        // Déclarer deux emplacements de menu : menu principal et footer
        register_nav_menus(array(
            'main' => 'Menu principal',
            'footer' => 'Bas de page',
        ));

        // Activer la prise en charge des formats
        add_theme_support('post-formats', array('aside', 'gallery', 'quote', 'image', 'video',));
    }
    add_action('after_setup_theme', 'nathalie_mota_theme_setup');
};

//* Chargement css et scripts

function theme_scripts()
{
    // CSS
    wp_enqueue_style('theme-style', get_template_directory_uri() . '/style.css', array(), filemtime(get_template_directory() . '/style.css'));

    // JS
    wp_enqueue_script('theme-script', get_template_directory_uri() . '/assets/js/index.js', array('jquery'), '1.0', true);

    // script personnalisé pour la pagination Ajax
    wp_enqueue_script('custom-ajax', get_template_directory_uri() . '/assets/js/custom-ajax.js', array('jquery'), '1.0', true);
    wp_localize_script('custom-ajax', 'myAjax', array('ajaxurl' => admin_url('admin-ajax.php')));

    // script lightbox
    wp_enqueue_script('lightbox', get_template_directory_uri() . '/assets/js/lightbox.js', array('jquery'), '1.0', true);

    // Bibliothèque Font Awesome
    wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array());

    // Bibliothèque Select2 pour les selects de tri
    wp_enqueue_script('select2-js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array('jquery'), '4.0.13', true);
    wp_enqueue_style('select2-css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css', array());
}
add_action('wp_enqueue_scripts', 'theme_scripts');


//* Fonction chargement supplémentaire des posts et filtrage

function filtre_load_photos_ajax()
{
    $paged = isset($_POST['page']) ? intval($_POST['page']) + 1 : 1;

    // Vérifier et sécuriser les valeurs des filtres
    $cat_filter = isset($_POST['categorie']) ? sanitize_text_field($_POST['categorie']) : '';
    $format_filter = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $annee_filter = isset($_POST['annee']) ? sanitize_text_field($_POST['annee']) : '';

    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 12,
        'paged' => $paged,
        'tax_query' => array(),
        'meta_query' => array(),
    );

    if (!empty($cat_filter)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => $cat_filter,
        );
    }

    if (!empty($format_filter)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format_filter,
        );
    }

    if (!empty($annee_filter)) {
        $args['meta_query'][] = array(
            'key' => 'annee',
            'value' => $annee_filter,
            'compare' => '=',
        );
    }

    $photos_query = new WP_Query($args);

    ob_start();

    if ($photos_query->have_posts()) {
        while ($photos_query->have_posts()) {
            $photos_query->the_post();
            // Structure du catalogue
            get_template_part('template-parts/content/container_photos');
        }
    }

    wp_reset_postdata();

    $response = ob_get_clean();
    echo $response;
    exit;
}

// Action WordPress pour la requête AJAX
add_action('wp_ajax_filtre_load_photos_ajax', 'filtre_load_photos_ajax');
add_action('wp_ajax_nopriv_filtre_load_photos_ajax', 'filtre_load_photos_ajax');




