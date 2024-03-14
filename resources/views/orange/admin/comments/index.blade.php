@extends("layout.orange")

@section("main_content")
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<header id="fh5co-header" class="fh5co-cover fh5co-cover-sm" role="banner" style="background-image:url({{asset('assets/images/img_bg_2.jpg')}});">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 text-center">
                <div class="display-t">
                    <div class="display-tc animate-box" data-animate-effect="fadeIn">
                        <h1>{{ $post[0]['title'] }}</h1>
                        <p>Published on {{ $post[0]['created_at'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="container">
    <div class="row">
        <div class="col-md-12 animate-box">


        </div>
        @csrf

        <!-- Formulario para agregar un nuevo comentario -->
        <div class="col-md-12 animate-box" style="margin-bottom: 20px;">
            <h3>Add a Comment</h3>
            <textarea id="newCommentText" class="form-control" placeholder="Your comment here..." rows="4"></textarea>
            <input type="hidden" class="form-control" id="no_post" name="no_post" value="{{ $post[0]['no_post'] }}">
            <button id="submitComment" class="btn btn-primary" style="margin-top: 10px;">Submit Comment</button>
        </div>


        <div class="col-md-12 animate-box" id="comments-section">
            <h3>Comments</h3>
            @php $i = 0; @endphp
            @foreach ($comments as $comment)
                <div class="comment">
                    <p><strong>{{ $comments[$i]['commenter'] }}</strong> {{ $comments[$i]['comment'] }}</p>
                    <span class="comment-actions">
                        <!-- Icono de editar -->
                        <a href="#" class="edit-comment" data-comment-id="{{ $comment['no_comment'] }}"><i class="fas fa-edit"></i></a>
                        <!-- Icono de borrar -->
                        <a href="#" class="delete-comment" data-comment-id="{{ $comment['no_comment'] }}"><i class="fas fa-trash-alt"></i></a>
                    </span>
                </div>
                @php $i++; @endphp
            @endforeach

<script>
                $(document).ready(function() {
                    $('#submitComment').click(function(e) {
                    e.preventDefault();

                    var commentData = {
                        comment: $('#newCommentText').val(),
                        no_post: parseInt($('#no_post').val(), 10),
                    };
                $.ajax({
                    type: "POST",
                    url: "http://localhost:3000/comments", // Asegúrate de que esta es la URL correcta
                    data: JSON.stringify(commentData),
                    contentType: "application/json", // Especifica que estás enviando los datos como JSON
                    dataType: "json", // Esperas recibir una respuesta en JSON
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(response) {
                        console.log("Comentario agregado:", response);
                        var newCommentHTML = '<div class="comment"><p><strong>Anonimo</strong> ' + commentData.comment + '</p><span class="comment-actions"> <a href="#" class="edit-comment" data-comment-id="' + response.id + '"><i class="fas fa-edit"></i></a> <a href="#" class="delete-comment" data-comment-id="' + response.id + '"><i class="fas fa-trash-alt"></i></a></span></div>';
                        $('#comments-section').append(newCommentHTML);
                        $('#newCommentText').val('');
                    },
                    error: function(error) {
                        console.error("Error al agregar comentario:", error);
                    }
                });
            });

        $(document).on('click', '.delete-comment', function(e) {
            e.preventDefault();
            var commentId = $(this).data('comment-id');
            var that = this; // Guarda la referencia al botón que fue clickeado
            $.ajax({
                type: "DELETE",
                url: `http://localhost:3000/comments/${commentId}`,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    console.log("Comentario eliminado:", response);
                    $(that).closest('.comment').remove();
                },
                error: function(error) {
                    console.error("Error al eliminar comentario:", error);
                }
            });
        });
    });

    $(document).on('click', '.edit-comment', function(e) {
        e.preventDefault();
        // Asegúrate de utilizar .data('comment-id') para obtener el valor correcto
        var no_comment = $(this).data('comment-id');
        var commentDiv = $(this).closest('.comment');
        // Tomamos el texto del comentario excluyendo el del commenter
        var commentText = commentDiv.find('p').clone().children().remove().end().text().trim();
        var editInputHtml = '<textarea class="edit-comment-text form-control">' + commentText + '</textarea><button class="save-edit btn btn-success" data-comment-id="' + no_comment + '">Save</button>';
        commentDiv.html(editInputHtml);
    });

    $(document).on('click', '.save-edit', function() {
        var no_comment = $(this).data('comment-id');
        var newCommentText = $(this).prev('.edit-comment-text').val();
        var commentDiv = $(this).closest('.comment');

        $.ajax({
            type: "PATCH",
            url: "http://localhost:3000/comments/" + no_comment, // Asegúrate de que esta URL coincide con la ruta de tu API/Laravel
            data: JSON.stringify({ comment: newCommentText }),
            contentType: "application/json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                console.log("Comentario actualizado:", response);
                // Asumiendo que el backend devuelve el comentario actualizado correctamente
                var updatedCommentHtml = '<p><strong>' + response.commenter + '</strong> ' + response.comment + '</p><span class="comment-actions"> <a href="#" class="edit-comment" data-comment-id="' + no_comment + '"><i class="fas fa-edit"></i></a> <a href="#" class="delete-comment" data-comment-id="' + no_comment + '"><i class="fas fa-trash-alt"></i></a></span>';
                commentDiv.html(updatedCommentHtml);
            },
            error: function(error) {
                console.error("Error al actualizar comentario:", error);
                // Aquí podrías revertir el comentario a su estado original o mostrar un mensaje de error
            }
        });
    });


</script>
        </div>
    </div>
</div>
@endsection

