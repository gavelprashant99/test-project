// public/js/custom.js

$('#language-selector').on('change', function() {
    var selectedLanguage = $(this).val();
    $.ajax({
        url: '/change-language',
        type: 'POST',
        data: { language: selectedLanguage },
        success: function(response) {
            // Refresh the page or update the UI as needed
        }
    });
});
