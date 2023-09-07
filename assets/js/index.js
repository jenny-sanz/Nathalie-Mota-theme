console.log("js chargé");

//* Navigation menu burger mobile

const header = document.querySelector('header');
const menuBurger = document.querySelector('.menu-burger');
const nav = document.querySelector('.navigation');
const liens = document.querySelectorAll('.navigation--menu li a')

menuBurger.addEventListener('click', () => {
    header.classList.toggle('open');
    menuBurger.classList.toggle('open');
    nav.classList.toggle('open');

});

//* Slider miniature single custom post

const thumbnails = document.querySelectorAll('.thumbnails');
const arrowLeft = document.querySelector('.arrow-left');
const arrowRight = document.querySelector('.arrow-right');

let currentSlide = 0;
let isHovering = false;

// Fonction pour cacher toutes les diapositives
function hideSlides() {
    thumbnails.forEach((thumbnail) => {
        thumbnail.style.display = 'none';
    });
}
// Cacher les vignettes au chargement de la page
hideSlides();

// Fonction pour afficher la diapositive correspondant à l'index donné
function showSlide() {
    thumbnails.forEach((thumbnail, index) => {
      // condition ternaire
    thumbnail.style.display = index === currentSlide ? "block" : "none";
  });
}
// Fonction pour passer à la diapositive suivante
function nextSlide() {
    currentSlide++;
    if (currentSlide >= thumbnails.length) {
        currentSlide = 0; // Revenir à la première diapositive
    }
    showSlide(currentSlide);
}

// Fonction pour passer à la diapositive précédente
function prevSlide() {
    currentSlide--;
    if (currentSlide < 0) {
        currentSlide = thumbnails.length - 1; // Passer à la dernière diapositive
    }
    showSlide(currentSlide);
    
}
// Gérer l'affichage des vignettes avec les flèches de navigation

// fleche gauche   
if (arrowLeft) {
     //au survol
    arrowLeft.addEventListener('mouseenter', () => {
        isHovering = true;
        prevSlide()
    });  
    //au clic
    arrowLeft.addEventListener('click', prevSlide);
}

// fleche droite
if (arrowRight) {
    //au survol
    arrowRight.addEventListener('mouseenter', () => {
        isHovering = true;
        nextSlide()
    });
    //au clic
    arrowRight.addEventListener('click', nextSlide);
}

//* Popup contact

document.addEventListener('DOMContentLoaded', function () {
    const contactLink = document.querySelector('a[href="#contact"]');
    const contactButton = document.querySelector('.btn-contact');
    const modalContainer = document.querySelector('.modal-container');
    const modalContent = document.querySelector('.modal-content');

    function openModal() {
        modalContainer.classList.add('open')
    }

    function closeModal() {
        modalContainer.classList.remove('open');
    }

    if (contactLink && modalContainer) {
        contactLink.addEventListener('click', function (event) {
            event.preventDefault();
            openModal();
        });
    }

    if (contactButton && modalContainer) {
        contactButton.addEventListener('click', function (event) {
            event.preventDefault();
            openModal();
        });
    }
    // Récupérer la valeur de référence à partir de l'attribut de données et afficher dans le champ du formulaire

    //verifie que contactBtn existe pour executer le code
    if (contactButton) {
        const reference = contactButton.dataset.reference;
        const refPhotoField = document.getElementById('ref-photo'); // Champ de référence de la photo dans le formulaire

        if (reference) {
            refPhotoField.value = reference;
        }
    }

    document.addEventListener('click', function (event) {
        if (!modalContent.contains(event.target)) {
            if (contactLink && contactLink.contains(event.target)) {
                return; // Ne ferme pas la modale si le clic se produit sur le lien "contact"
            }

            if (contactButton && contactButton.contains(event.target)) {
                return; // Ne ferme pas la modale si le clic se produit sur le bouton "contact"
            }
            closeModal();
        }
    });
 
});



//* Déclarer la bibliothèque select2 pour custom les selects du formulaire de ti

jQuery(document).ready(function ($) {
  $(".js-example-basic-single").select2();
});