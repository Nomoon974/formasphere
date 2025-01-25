import TextEllipsis from 'text-ellipsis';

export default function applyEllipsis() {
    const elements = document.querySelectorAll('.post-text *');

    elements.forEach((element) => {
        TextEllipsis(element, {
            lines: 2, // Nombre de lignes max
            ellipsis: '...', // Texte à afficher pour l'élision
        });
    });
}
