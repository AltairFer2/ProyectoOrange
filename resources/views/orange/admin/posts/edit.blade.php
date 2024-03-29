@extends('layout.orange')
@section('main_content')
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
                        <h1>Create a Blog</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<section class="pb-0">
    <div class="container">
        <br>
        <div id="messageContainer"></div> {{-- Contenedor para mensajes --}}
        <form id="createPostForm">
            @csrf
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $post[0]['title'] }}" required>
                <input type="hidden" class="form-control" id="no_post" name="no_post" value="{{ $post[0]['no_post'] }}">
            </div>
            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" class="form-control" id="author" name="author" value="{{ $post[0]['author'] }}" required>
            </div>
            <div class="form-group">
                <label for="content">Content:</label>
                <textarea class="form-control" id="content" name="content" rows="3" required>{{ $post[0]['content'] }}</textarea>
            </div>
            <div class="form-group">
                <label for="image">Image (URL):</label>
                <input type="text" class="form-control" id="image" name="image" value="{{ $post[0]['image'] }}">
            </div>
            <div class="form-group">
                <label for="created_at">Fecha de Creación:</label>
                <input type="date" id="created_at" name="created_at" value="{{ $post[0]['created_at'] }}">
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <input type="text" class="form-control" id="category" name="category" value="{{ $post[0]['category'] }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Post</button>
        </form>
    </div>
</section>
<script>

    $(document).ready(function () {
$('#createPostForm').on('submit', function (e) {
    e.preventDefault();

    // Crear un objeto JavaScript con los datos del formulario.
    var postData = {
        no_post: parseInt($('#no_post').val(), 10),
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
        url: "http://localhost:3000/posts/",
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
</script>
@endsection
