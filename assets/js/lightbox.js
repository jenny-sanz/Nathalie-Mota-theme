console.log('lightbox chargée')
//* Lightbox

document.addEventListener("DOMContentLoaded", function () {
  const lightboxContainer = document.querySelector(".lightbox");
  const lightboxImage = lightboxContainer.querySelector(".lightbox-image");
  const lightboxReference = lightboxContainer.querySelector(".reference");
  const lightboxCategorie = lightboxContainer.querySelector(".categorie");
  const lightboxClose = lightboxContainer.querySelector(".close");
  const cataloguePhotosContainer = document.querySelector(".catalogue-photos");
  const prevButton = lightboxContainer.querySelector(".previous");
  const nextButton = lightboxContainer.querySelector(".next");

  // Vérifier si les éléments existent avant d'executer le code'
  if (
    lightboxContainer &&
    lightboxImage &&
    lightboxReference &&
    lightboxCategorie &&
    lightboxClose &&
    cataloguePhotosContainer &&
    prevButton &&
    nextButton
  ) {
    // Obtenir tous les conteneurs des posts(images) du catalogue
    const allPostContainers = Array.from(
      cataloguePhotosContainer.querySelectorAll(".post-container")
    );
    let currentImageIndex;

    function openLightbox(element) {
      lightboxContainer.classList.add("open");

      // Récupérer les attributs des éléments de l'image
      const reference = element
        .querySelector(".icon")
        .getAttribute("data-reference");
      const categorie = element
        .querySelector(".icon")
        .getAttribute("data-categorie");
      const imageUrl = element
        .querySelector(".icon")
        .getAttribute("data-thumbnail-url");

      // Mettre à jour les éléments de la Lightbox avec les valeurs récupérées
      lightboxImage.src = imageUrl;
      lightboxReference.textContent = reference;
      lightboxCategorie.textContent = categorie;

      // Récupérer l'index de l'image actuellement affichée
      currentImageIndex = allPostContainers.indexOf(element);
    }

    function showPrevImage() {
      // Décrémenter l'index de l'image actuelle
      currentImageIndex--;
      // Si l'index devient inférieur à zéro, revenir à la dernière image du catalogue
      if (currentImageIndex < 0) {
        currentImageIndex = allPostContainers.length - 1;
      }
      // Récupérer le conteneur de l'image précédente
      const prevImageContainer = allPostContainers[currentImageIndex];
      // Afficher l'image précédente dans la Lightbox
      openLightbox(prevImageContainer);
    }

    function showNextImage() {
      // Incrémenter l'index de l'image actuelle
      currentImageIndex++;

      // Si l'index dépasse la dernière image du catalogue, revenir à la première image
      if (currentImageIndex >= allPostContainers.length) {
        currentImageIndex = 0;
      }
      // Récupérer le conteneur de l'image suivante
      const nextImageContainer = allPostContainers[currentImageIndex];
      // Afficher l'image suivante dans la Lightbox
      openLightbox(nextImageContainer);
    }

    // Ajouter un gestionnaire d'événement pour ouvrir la Lightbox lorsque l'utilisateur clique sur une icône d'image
    cataloguePhotosContainer.addEventListener("click", function (event) {
      if (event.target.closest(".icon")) {
        event.preventDefault();
        // Récupérer le conteneur de l'image correspondant à l'icône cliquée
        const postContainer = event.target.closest(".post-container");
        // Afficher l'image dans la Lightbox
        openLightbox(postContainer);
      }
    });

    // Ajouter des gestionnaires d'événements pour les boutons "Prev" et "Next" de navigation
    prevButton.addEventListener("click", showPrevImage);
    nextButton.addEventListener("click", showNextImage);

    // Ajouter un gestionnaire d'événement pour fermer la Lightbox lorsque l'utilisateur clique sur le bouton de fermeture
    lightboxClose.addEventListener("click", function () {
      lightboxContainer.classList.remove("open");
    });
  }
});
