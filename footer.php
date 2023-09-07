<?php


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

?>


<!-- coder mon footer  -->
<footer class="site__footer">
    <!-- menu de navigation wordpress footer -->
    <?php wp_nav_menu(
        array(
            'theme_location' => 'footer',
            'container' => 'ul',
            'menu_class' => 'site__footer__menu', // ma classe personnalisée 
        )
    );

    ?>
    <?php
    // integration de la popup de contact
    get_template_part('template-parts/popup_contact') ?>

    <!-- lightbox -->
    <?php
    get_template_part('template-parts/lightbox');
    ?>
</footer>
<?php wp_footer(); ?>

</body>

</html>