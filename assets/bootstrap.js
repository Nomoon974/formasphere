import { startStimulusApp } from '@symfony/stimulus-bridge';

// Initialise l'application Stimulus
const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!./controllers',
    true,
    /\.[jt]sx?$/
));

// Exporte l'instance app si nécessaire pour l'utiliser ailleurs
export { app };

// Tu peux enregistrer d'autres contrôleurs ici si nécessaire
// app.register('some_controller_name', SomeImportedController);

