function displaySelectedFiles() {
    const input = document.getElementById('file');
    const files = input.files;
    const selectedFilesContainer = document.getElementById('selectedFiles');

    selectedFilesContainer.innerHTML = '';

    for (let i = 0; i < files.length; i++) {
        selectedFilesContainer.innerHTML += `<p>${files[i].name}</p>`;
    }
}
