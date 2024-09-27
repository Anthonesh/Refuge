import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

//Carousel Animation

// Attend que le contenu du document soit complètement chargé avant d'exécuter le code
document.addEventListener('DOMContentLoaded', function () {

    // Sélectionne le carrousel et ses éléments internes pour manipulation
    const carousel = document.getElementById('carousel');
    // Convertit la collection d'éléments HTML en un tableau pour faciliter les manipulations
    const items = Array.from(carousel.getElementsByClassName('carousel-img-container'));
    const prevButton = document.getElementById('prevButton');
    const nextButton = document.getElementById('nextButton');

    // Assure qu'un élément est sélectionné par défaut si aucun ne l'est déjà
    if (!carousel.querySelector('.selected')) {
        items[0].classList.add('selected');
    }

    // Fonction pour mettre à jour les positions des éléments du carrousel
    function updateCarouselPositions() {
        // Trouve l'élément actuellement sélectionné
        const selected = carousel.querySelector('.selected');
        // Obtient l'index de l'élément sélectionné dans le tableau
        const selectedIndex = items.indexOf(selected);

        // Applique des classes CSS en fonction de la position relative de chaque élément par rapport à l'élément sélectionné
        items.forEach((item, index) => {
            // Supprime toutes les classes CSS précédemment ajoutées pour la gestion du carrousel
            item.classList.remove('selected', 'prev', 'next', 'hideLeft', 'hideRight', 'prevLeftSecond', 'nextRightSecond');

            // Applique la classe 'selected' à l'élément actuellement sélectionné
            if (index === selectedIndex) {
                item.classList.add('selected');
            } else if (index === selectedIndex - 1 || index === selectedIndex + items.length - 1) {
                // Positionne l'élément précédent immédiat à gauche
                item.classList.add('prev');
            } else if (index === selectedIndex + 1 || index === selectedIndex - items.length + 1) {
                // Positionne l'élément suivant immédiat à droite
                item.classList.add('next');
            } else if (index === selectedIndex - 2 || index === selectedIndex + items.length - 2) {
                // Positionne le deuxième élément précédent encore plus à gauche
                item.classList.add('prevLeftSecond');
            } else if (index === selectedIndex + 2 || index === selectedIndex - items.length + 2) {
                // Positionne le deuxième élément suivant encore plus à droite
                item.classList.add('nextRightSecond');
            } else if (index < selectedIndex) {
                // Cache les éléments situés à gauche de l'élément sélectionné
                item.classList.add('hideLeft');
            } else {
                // Cache les éléments situés à droite de l'élément sélectionné
                item.classList.add('hideRight');
            }
        });
    }

    // Gestion de l'événement de clic sur le bouton précédent
    prevButton.addEventListener('click', () => {
        const selectedIndex = items.findIndex(item => item.classList.contains('selected'));
        const prevIndex = (selectedIndex - 1 + items.length) % items.length;
        items.forEach(item => item.classList.remove('selected'));
        items[prevIndex].classList.add('selected');
        updateCarouselPositions();
    });

    // Gestion de l'événement de clic sur le bouton suivant
    nextButton.addEventListener('click', () => {
        const selectedIndex = items.findIndex(item => item.classList.contains('selected'));
        const nextIndex = (selectedIndex + 1) % items.length;
        items.forEach(item => item.classList.remove('selected'));
        items[nextIndex].classList.add('selected');
        updateCarouselPositions();
    });

    // Initialisation des positions du carrousel lors du chargement de la page
    updateCarouselPositions();


    //Menu Burger

    // Ajouter l'écouteur d'événements au bouton du menu burger
    document.addEventListener('click', function (e) {
        let links = document.querySelector('.navLinks');
        let burgerMenuButton = document.querySelector('.burger-menu');

        // Vérifie si le clic n'était ni sur le burger-menu ni sur un descendant de navLinks
        if (!burgerMenuButton.contains(e.target) && !links.contains(e.target)) {
            // Si navLinks est actif, le désactiver et afficher le burger-menu
            if (links.classList.contains('active')) {
                links.classList.remove('active');
                burgerMenuButton.style.display = 'block';
            }
        }
    });

    //Bouton de dons cliquable
    let donsButton = document.querySelector('.donButton');
    donsButton.addEventListener('click', function () {
        window.location.href = '/donations';
    });


    // Sélection de du calendrier via l'ID
    let calendarElt = document.querySelector("#calendar");
    // Récupération des données des événements stockées dans l'attribut 'data-events' 
    // et conversion de ces données JSON en objet JavaScript.
    let eventsData = JSON.parse(calendarElt.getAttribute('data-events'));

    let isOnEventPage = window.location.pathname.includes('/event/planning');
    let isOnVolunteerPage = window.location.pathname.includes('/volunteer/scheduling');

    // Initialisation de l'instance FullCalendar avec l'élément sélectionné et un objet de configuration.
    let calendar = new FullCalendar.Calendar(calendarElt, {
        // Définition du calendrier en tant que vue mensuelle.
        initialView:'dayGridMonth',
        // Paramétrage de la localisation du calendrier en français.
        locale: 'fr',
        // Configuration de la barre d'outils du calendrier
        headerToolbar: {
            start: 'dayGridMonth,timeGridWeek', // Boutons pour changer entre la vue mensuelle et la vue hebdomadaire.
            center: 'title', // Position du titre au centre.
            end: 'prev,next today' // Boutons pour naviguer entre les mois et revenir au mois courant.
        },

        // Génération des événements du calendrier en mappant les données JSON récupérées,
        // et transformation de chaque événement en un format compatible avec FullCalendar.
        events: eventsData.map(function (event) {
            // Retour d'un objet représentant un événement avec des propriétés personnalisées.
            return {
                id: event.id,
                title: event.title,
                start: event.startTime,
                end: event.endTime || event.startTime,
                description: event.description,
                places: isOnEventPage ? event.places : event.volunteerPlaces,
                volunteerPlaces: event.volunteerPlaces
            };
        }),

        dateClick: function(info) {
            if (isOnVolunteerPage) {
                // Rediriger vers le formulaire de réservation avec la date sélectionnée
                window.location.href = `/volunteer/crud/reserve?date=${info.dateStr}`;
            }
            else if (isOnEventPage) {
                window.location.href = `/calendar/crud/new`;
            }
        },


        eventClick: function (info) {
            const startTime = info.event.start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            const endTime = info.event.end.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

            // Définir le contenu du modal
            let modalBody;
            if (isOnEventPage) {
                modalBody = `
                        <p><strong>Débute à</strong> ${startTime} heures</p>
                        <p><strong>Termine à</strong> ${endTime} heures</p>
                        <p><strong>Description:</strong> ${info.event.extendedProps.description}</p>
                        <p><strong>Places disponibles:</strong> ${info.event.extendedProps.places}</p>
                    `;
                // Définir à nouveau le pied de page du modal
                document.querySelector('#eventDetailsModal .modal-footer').innerHTML = `
                    <button type="button" id="btnReserv" class="btn">Reserver</button>
                    `;
            } else if (isOnVolunteerPage) {
                modalBody = `
                        <p><strong>Débute à</strong> ${startTime} heures</p>
                        <p><strong>Termine à</strong> ${endTime} heures</p>
                        <p><strong>Description:</strong> ${info.event.extendedProps.description}</p>
                        <p><strong>Places disponibles pour les bénévoles:</strong> ${info.event.extendedProps.volunteerPlaces}</p>
                    `;
                                    // Définir à nouveau le pied de page du modal
                document.querySelector('#eventDetailsModal .modal-footer').innerHTML = `
                <button type="button" id="btnReservVolunteer" class="btn">Reserver</button>
                `;

            }

            document.querySelector('#eventDetailsModal .modal-header').innerHTML = `
                <h5 class="modal-title">${info.event.title}</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                </button>`
                ;


            // Insérer le contenu dans le modal
            document.querySelector('#eventDetailsModal .modal-body').innerHTML = modalBody;

            // Sélectionnez le modal en utilisant son ID
            const eventDetailsModal = document.getElementById('eventDetailsModal');

            // Créez une fonction pour afficher le modal
            function showModal() {
                eventDetailsModal.style.display = "block";
            }

            // Utilisez la fonction pour afficher le modal
            showModal();


            const btnReserv = document.getElementById('btnReserv');
            if (btnReserv) {
                btnReserv.onclick = function () {
                    window.location.href = `/reservation/form/crud/new?eventId=${info.event.id}`;
                };
            }
        
            const btnReservVolunteer = document.getElementById('btnReservVolunteer');
            if (btnReservVolunteer) {
                btnReservVolunteer.onclick = function () {
                    window.location.href = `/volunteer/crud/new?eventId=${info.event.id}`;
                };
            }
        

            // Sélectionnez le bouton de fermeture en utilisant son ID
            const btnClose = document.querySelector('.btn-close');

            // Ajoutez un gestionnaire de clic au bouton de fermeture
            btnClose.onclick = function () {
                // Cachez le modal
                eventDetailsModal.style.display = "none";
            };

            // Ajoutez un gestionnaire de clic à la fenêtre
            window.onclick = function (event) {
                // Si l'utilisateur clique en dehors du modal, fermez le modal
                if (event.target == eventDetailsModal) {
                    eventDetailsModal.style.display = "none";
                }
            };
        },
    });

    calendar.render();

    //

});

// Menu Burger

function toggleMenu() {
    let links = document.querySelector('.navLinks');
    links.classList.toggle('active');
    // Ajuste la visibilité du bouton burger en fonction de l'état du menu
    document.querySelector('.burger-menu').style.display = links.classList.contains('active') ? 'none' : 'block';
};

//Toggle Aside
document.addEventListener('click', function (e) {
    // Ajouter l'écouteur d'événements au bouton aside
    let asideToggleButton = document.querySelector('.aside-toggle');
    if (asideToggleButton) {
        asideToggleButton.addEventListener('touchstart', toggleAside);
        asideToggleButton.addEventListener('click', toggleAside); // Pour la compatibilité avec le clic
    }
});


// Aside cliquable

function toggleAside() {

    let aside = document.querySelector('.aside');

    if (aside.style.display === "block") {
        aside.style.display = "none";
    } else {
        aside.style.display = "block";
    }

}


/*Stripe */

// Attend que le contenu DOM de la page soit complètement chargé avant d'exécuter le script.
document.addEventListener('DOMContentLoaded', function () {    
    const stripeDataElement = document.getElementById('stripe-data');
    const stripePublicKey = stripeDataElement.getAttribute('data-stripe-key');
    const clientSecret = stripeDataElement.getAttribute('data-client-secret');

    const stripe = Stripe(stripePublicKey);
    const elements = stripe.elements();

    const cardNumber = elements.create('cardNumber', { style: { base: { color: '#fff' } } });
    const cardExpiry = elements.create('cardExpiry', { style: { base: { color: '#fff' } } });
    const cardCvc = elements.create('cardCvc', { style: { base: { color: '#fff' } } });

    cardNumber.mount('#card-number-element');
    cardExpiry.mount('#card-expiry-element');
    cardCvc.mount('#card-cvc-element');

    cardNumber.addEventListener('change', function(event) {
        const displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    const paymentButton = document.getElementById('submit-payment');
    if (paymentButton) {
        paymentButton.addEventListener('click', function(event) {
            event.preventDefault();

            stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: cardNumber,
                }
            }).then(function(result) {
                if (result.error) {
                    const errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    if (result.paymentIntent.status === 'succeeded') {
                        console.log('Paiement réussi !');
                        window.location.href = '/donations/success';
                    }
                }
            });
        });
    }
});
