import './bootstrap.js';


/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import './images/formasphere.png'
import './images/uifaces-abstract-image.jpg'
import './images/logo.png'


import initializeQuill from "./controllers/QuilEditor";
import toggleReadMore from "./controllers/toggleReadMore.js";
import adjustTextArea from "./controllers/adjustTextArea";
import editPost from "./controllers/editPost";
import deletePost from "./controllers/deletePost";

document.addEventListener('DOMContentLoaded', () => {
    initializeQuill();
    toggleReadMore();
    adjustTextArea();
    editPost();
    deletePost();
});