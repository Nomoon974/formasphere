import './bootstrap.js';
import {createApp} from 'vue'; // Import Vue.js

import QuilEditor from "./js/QuilEditor.vue";
import DeletePost from './js/DeletePost.vue';
import AddDocBtn from "./js/AddDocBtn.vue";
import PostShow from "./js/PostShow.vue";
import TestComponent from "./js/TestComponent.vue";
import FileItem from "./js/FileItem.vue";
import EditPostButton from "./js/EditPostButton.vue";
import CommentSection from "./js/CommentSection.vue";
import UserDropdown from "./js/UserDropdown.vue";
import ScrollButton from "./js/ScrollButton.vue";
import Notification from "./js/Notification.vue";
import DarkModeButton from "./js/DarkModeButton.vue";
import CloseFlashMessage from "./js/CloseFlashMessage.vue";

const app = createApp({});

app.component('DeletePost', DeletePost);
app.component('QuilEditor', QuilEditor);
app.component('AddDocBtn', AddDocBtn);
app.component('PostShow', PostShow);
app.component('TestComponent', TestComponent);
app.component('FileItem', FileItem);
app.component('EditPostButton', EditPostButton);
app.component('CommentSection', CommentSection);
app.component('UserDropdown', UserDropdown);
app.component('ScrollButton', ScrollButton);
app.component('Notification', Notification);
app.component('DarkModeButton', DarkModeButton);
app.component('CloseFlashMessage', CloseFlashMessage);
app.mount('#vue-app');
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
import "./controllers/LineEllipsis";


document.addEventListener('DOMContentLoaded', () => {
    LineEllipsis();
});