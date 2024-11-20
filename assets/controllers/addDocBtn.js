document.addEventListener('DOMContentLoaded', function () {
    function addDocBtn() {
        const addButton = document.querySelector('.add-doc-btn');
        const fileInput = document.getElementById('document-input');
        const fileList = document.getElementById('file-list');

        let selectedFiles = [];

        if (addButton && fileInput) {
            addButton.addEventListener('click', function () {
                fileInput.click();
            });

            fileInput.addEventListener('change', function () {
                Array.from(fileInput.files).forEach(file => {
                    if (!selectedFiles.some(f => f.name === file.name && f.size === file.size)) {
                        selectedFiles.push(file);
                        updateFileList();
                    }
                });
                // fileInput.value = ''; // Réinitialiser la sélection
            });
        }


        function updateFileList() {
            fileList.innerHTML = ''; // Réinitialiser la liste

            selectedFiles.forEach((file, index) => {
                const listItem = document.createElement('li');
                const fileType = file.type;

                // Détermine l'icône selon le type de fichier
                let iconHtml = '';
                if (fileType.includes('image')) {
                    iconHtml = `<svg class="icon icon-image" xmlns="http://www.w3.org/2000/svg" width="1.1em" height="1.1em" viewBox="0 0 24 24"><path fill="currentColor" d="M2 2h20v20H2zm2 18h13.586L9 11.414l-5 5zm16-.414V4H4v9.586l5-5zM15.547 7a1 1 0 1 0 0 2a1 1 0 0 0 0-2m-3 1a3 3 0 1 1 6 0a3 3 0 0 1-6 0"/></svg>`;
                } else if (fileType.includes('pdf')) {
                    iconHtml = `<svg class="icon icon-pdf" xmlns="http://www.w3.org/2000/svg" width="1.1em" height="1.1em" viewBox="0 0 15 15"><path fill="currentColor" d="M2.5 6.5V6H2v.5zm4 0V6H6v.5zm0 4H6v.5h.5zm7-7h.5v-.207l-.146-.147zm-3-3l.354-.354L10.707 0H10.5zM2.5 7h1V6h-1zm.5 4V8.5H2V11zm0-2.5v-2H2v2zm.5-.5h-1v1h1zm.5-.5a.5.5 0 0 1-.5.5v1A1.5 1.5 0 0 0 5 7.5zM3.5 7a.5.5 0 0 1 .5.5h1A1.5 1.5 0 0 0 3.5 6zM6 6.5v4h1v-4zm.5 4.5h1v-1h-1zM9 9.5v-2H8v2zM7.5 6h-1v1h1zM9 7.5A1.5 1.5 0 0 0 7.5 6v1a.5.5 0 0 1 .5.5zM7.5 11A1.5 1.5 0 0 0 9 9.5H8a.5.5 0 0 1-.5.5zM10 6v5h1V6zm.5 1H13V6h-2.5zm0 2H12V8h-1.5zM2 5V1.5H1V5zm11-1.5V5h1V3.5zM2.5 1h8V0h-8zm7.646-.146l3 3l.708-.708l-3-3zM2 1.5a.5.5 0 0 1 .5-.5V0A1.5 1.5 0 0 0 1 1.5zM1 12v1.5h1V12zm1.5 3h10v-1h-10zM14 13.5V12h-1v1.5zM12.5 15a1.5 1.5 0 0 0 1.5-1.5h-1a.5.5 0 0 1-.5.5zM1 13.5A1.5 1.5 0 0 0 2.5 15v-1a.5.5 0 0 1-.5-.5z"/></svg>`;
                } else {
                    iconHtml = `<svg class="icon icon-document" xmlns="http://www.w3.org/2000/svg" width="1.1em" height="1.1em" viewBox="0 0 24 24"><path fill="currentColor" d="M15 4H6v16h12V7h-3zM6 2h10l4 4v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2m2 9h8v2H8zm0 4h8v2H8z"/></svg>`;
                }

                // Conteneur pour l'icône et le nom du fichier
                const fileInfo = document.createElement('div');
                fileInfo.classList.add('file-name');
                fileInfo.innerHTML = `<span class="file-icon">${iconHtml}</span> ${file.name}`;

                // Bouton de suppression
                const removeButton = document.createElement('span');
                removeButton.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24" fill="red"><path fill="currentColor" d="M12 21a9 9 0 1 0 0-18a9 9 0 0 0 0 18m11-9c0 6.075-4.925 11-11 11S1 18.075 1 12S5.925 1 12 1s11 4.925 11 11M7.403 15.182L10.586 12L7.403 8.818l1.415-1.415L12 10.586l3.182-3.182l1.414 1.414L13.414 12l3.182 3.182l-1.414 1.414L12 13.414l-3.182 3.182z"/></svg>`;
                removeButton.classList.add('remove-file-btn');
                removeButton.addEventListener('click', () => {
                    selectedFiles.splice(index, 1);
                    updateFileList();
                });

                // Ajoute les éléments à l'élément de liste
                listItem.appendChild(fileInfo);
                listItem.appendChild(removeButton);
                fileList.appendChild(listItem);
            });
        }
    }

    addDocBtn();
});
