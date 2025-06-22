// import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
// Modification du app.css en app.scss
import './styles/app.scss'; 


document.addEventListener('DOMContentLoaded', () => {

    const form = document.querySelector('#filter-form');
    const resultsContainer = document.getElementById('pizzas');

    if(form){
        const submitForm = (event) => {
            event.preventDefault();// Empêche le rechargement de la page
            const formData = new FormData(form); // Récupère les données du formulaire
            const queryString = new URLSearchParams(formData).toString(); // Convertit en chaîne de requête

            fetch(`/filter?${queryString}`, {
                method: 'GET', // Requête GET pour Symfony
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(response => response.json())
                .then(data => {
                    resultsContainer.innerHTML = data.html; // Mettre à jour les résultats
                })
                .catch(error => console.error('Erreur:', error));
            
    }
        form.querySelectorAll('input, select').forEach(field => {
            field.addEventListener('change', submitForm); // Appeler la fonction sur "change"
            field.addEventListener('input', submitForm); // Optionnel : Pour les sliders ou champs texte
        });
        };
})
