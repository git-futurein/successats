
document.addEventListener('DOMContentLoaded', function () {
    var avatarInput = document.getElementById('avatar-input');
    var avatarPreview = document.getElementById('avatar-preview');

    avatarInput.addEventListener('change', function () {
        // Check if a file is selected
        if (avatarInput.files && avatarInput.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                // Set the preview image source
                avatarPreview.src = e.target.result;
            };

            // Read the selected file as a data URL
            reader.readAsDataURL(avatarInput.files[0]);
        }
    });
});
