console.log("custom-ajax chargé");

jQuery(function ($) {
  //* Fonction pour gérer les changements de filtres

  function handleFilterChange() {
    // Collecte des valeurs des filtres sélectionnés
    const categorie = $("#categories").val();
    const format = $("#formats").val();
    const annee = $("#annee").val();

    // Requête AJAX pour récupérer les articles filtrés
    $.ajax({
      url: myAjax.ajaxurl,
      type: "POST",
      data: {
        action: "filtre_load_photos_ajax",
        categorie: categorie,
        format: format,
        annee: annee,
      },
      success: function (response) {
        // Supprime les articles existants du catalogue
        $("#catalogue .post-container").remove();

        // Ajoute les nouveaux articles filtrés
        $("#catalogue").append(response);

        // Réinitialise la page à 1 après avoir appliqué les filtres
        $("#catalogue").data("page", 1);

        // Affiche à nouveau le bouton "Charger plus"
        $("#load-more-btn").show().text("Charger plus");
      },
    });
  }

  //* Fonction pour charger plus d'articles

  function loadMorePosts() {
    const catalogue = $("#catalogue");
    const currentPage = parseInt(catalogue.data("page"));
    const categorie = $("#categories").val();
    const format = $("#formats").val();
    const annee = $("#annee").val();

    // Effectuer la requête Ajax
    $.ajax({
      url: myAjax.ajaxurl,
      type: "POST",
      dataType: "html",
      data: {
        action: "filtre_load_photos_ajax",
        page: currentPage,
        categorie: categorie,
        format: format,
        annee: annee,
      },

      success: function (response) {
        if (response) {
          // Ajouter les nouvelles images au catalogue
          catalogue.append(response);
          // Mettre à jour le numéro de page dans le conteneur
          catalogue.data("page", currentPage + 1);
          // Rétablir le texte du bouton "Charger plus"
          $("#load-more-btn").text("Charger plus");
        } else {
          // Aucune nouvelle image disponible, cacher le bouton
          $("#load-more-btn").hide();
        }
      },
      error: function () {
        // Gérer les erreurs
        $("#load-more-btn").text("Erreur lors du chargement");
      },
    });
  }

  // Attachez les écouteurs d'événements une fois que le DOM est prêt
  $(document).ready(function () {
    // Écoute des changements de valeur des filtres
    $("#categories, #formats, #annee").on("change", handleFilterChange);

    // Écoute du clic sur le bouton "Charger plus"
    $("#load-more-btn").on("click", function () {
      loadMorePosts();
    });
  });
});
