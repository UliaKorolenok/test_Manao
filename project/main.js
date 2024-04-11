
$(document).ready(function () {
    
    $('#registrationForm').submit(function (e) {
        e.preventDefault();
        $('.error').remove();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: 'project/signUp.php',
            dataType: 'json',
            data: formData,
            success: function (response) {
                if (response.success) {
                    alert('Регистрация прошла успешно!');
                    $(".active").removeClass('active');
                    $("#reg").removeClass('show active');
                    $("#auth").addClass('show active');
                } else {
                    $.each(response.errors, function (key, value) {
                        $(`input[name="${key}"]`).after(`<p class="error">${value}</p>`);
                    });
                }

            }
        });
    });

    $('#authorizationForm').submit(function (e) {
        e.preventDefault();
        $('.error').remove();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: 'project/signIn.php',
            dataType: 'json',
            data: formData,
            success: function (response) {
                if (response.success) {
                    document.location.href = 'project/profile.php';
                } else {
                    $.each(response.errors, function (key, value) {
                        $(`input[name="${key}"]`).after(`<p class="error">${value}</p>`);
                    });
                }

            }
        });
    });
});



