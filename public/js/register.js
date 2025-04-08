document.addEventListener('DOMContentLoaded', function() {
    const uploadButton = document.querySelector('.upload-button');
    const fileInput = document.querySelector('#photo');
    const placeholder = document.querySelector('.profile-pic-placeholder');

    uploadButton.addEventListener('click', function() {
        fileInput.click();
    });

    fileInput.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                placeholder.style.backgroundImage = `url(${e.target.result})`;
                placeholder.style.backgroundSize = 'cover';
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });
});