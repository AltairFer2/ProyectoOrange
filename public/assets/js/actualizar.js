$(document).ready(function () {
    $('#createPostForm').on('submit', function (e) {
        e.preventDefault();

        var noPost = 8933

        // Crear un objeto JavaScript con los datos del formulario.
        var postData = {
            title: $('#title').val(),
            author: $('#author').val(),
            content: $('#content').val(),
            image: $('#image').val(),
            created_at: $('#created_at').val(),
            category: $('#category').val(),
        };

        console.log(postData);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "PATCH",
            url: "localhost:3000/posts/" + noPost, // Cambiado para adaptarse a Laravel y asumiendo la corrección de la URL
            data: JSON.stringify(postData),
            contentType: "application/json",
            dataType: 'json',
            success: function (response) {
                console.log("Success response:", response);
                $('#messageContainer').html('<div class="alert alert-success">Post actualizado con éxito!</div>');
            },
            error: function (error) {
                console.log("Error response:", error);
                $('#messageContainer').html('<div class="alert alert-danger">Hubo un error al actualizar el post. Por favor, intenta de nuevo.</div>');
            }
        });
    });
});
