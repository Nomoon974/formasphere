document.addEventListener('DOMContentLoaded', function () {
    const settingsIcon = document.querySelector('#cookie-settings-menu button');
    const preferencesLink = document.getElementById('open_preferences_center');

    settingsIcon.addEventListener('click', function () {
        if (preferencesLink) {
            // Simule un clic pour ouvrir les préférences
            preferencesLink.click();
        }
    });
});