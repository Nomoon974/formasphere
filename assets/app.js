import './bootstrap.js';
import { createApp } from 'vue'; // Import Vue.js

import QuilEditor from "./js/QuilEditor.vue";
import DeletePost from './js/DeletePost.vue';
import AddDocBtn from "./js/AddDocBtn.vue";
const app = createApp({});

app.component('DeletePost', DeletePost);
app.component('QuilEditor', QuilEditor);
app.component('AddDocBtn', AddDocBtn);
app.mount('#vue-app'); // Montez l'application sur une div spécifique
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


import "./controllers/QuilEditor";
import "./controllers/toggleReadMore.js";
import "./controllers/adjustTextArea";
import "./controllers/editPost";
import "./controllers/deletePost";
import toggleComments from "./controllers/toggleComments";
import "./controllers/closeFlashMessage";
import "./controllers/addDocBtn";
import "./controllers/settingsIcon";


document.addEventListener('DOMContentLoaded', () => {
    // initializeQuill();
    // toggleReadMore();
    // adjustTextArea();
    // editPost();
    // deletePost();
    // // toggleComments();
    // closeFlashMessages();
    // addDocBtn();
    // settingsIcon();
});