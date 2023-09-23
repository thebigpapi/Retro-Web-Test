/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import './styles/admin.scss';
import './styles/logs.scss';
import './styles/glightbox.min.css';
import GLightbox from './controllers/glightbox/glightbox.js';

const lightbox = GLightbox({
    touchNavigation: true,
    loop: true,
    autoplayVideos: false
});
// start the Stimulus application
//import './bootstrap';
import './controllers/updatecpus.js';
import './controllers/logs.js';
