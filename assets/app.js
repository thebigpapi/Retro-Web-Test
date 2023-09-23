/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import './styles/autocomplete.scss';
import GLightbox from './controllers/glightbox.min.js';

const lightbox = GLightbox({
    touchNavigation: true,
    loop: true,
    autoplayVideos: false
});
// start the Stimulus application
//import './bootstrap';
import './controllers/show.js';
import './controllers/datetime.js';
import './controllers/search.js';