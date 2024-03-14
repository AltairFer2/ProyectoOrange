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
        <form id="createPostForm" method="post">
            @csrf
            @if(session('success'))
                <br><br>
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <br><br>
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" class="form-control" id="author" name="author" required>
            </div>
            <div class="form-group">
                <label for="content">Content:</label>
                <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image (URL):</label>
                <input type="text" class="form-control" id="image" name="image">
            </div>
            <div class="form-group">
                <label for="created_at">Fecha de Creación:</label>
                <input type="date" id="created_at" name="created_at">
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <input type="text" class="form-control" id="category" name="category" required>
            </div>
            <button type="submit" class="btn btn-primary">Create Post</button>
        </form>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        var hoy = new Date();
        var fecha = hoy.getFullYear() + '-' + (hoy.getMonth() + 1).toString().padStart(2, '0') + '-' + hoy.getDate().toString().padStart(2, '0');
        document.getElementById('created_at').value = fecha;
    });
</script>
<script>
    $(document).ready(function(){
    $('#createPostForm').on('submit', function(e){
    e.preventDefault();


        // Crear un objeto JavaScript con los datos del formulario.
        var postData = {
            title: $('#title').val(),
            author: $('#author').val(),
            content: $('#content').val(),
            image: $('#image').val(),
            created_at: $('#created_at').val(),
            category: $('#category').val(),
        };

        $.ajax({
            type: "POST",
            url: "http://localhost:3000/posts", // Asegúrate de que esta URL es correcta y accesible
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            contentType: "application/json", // Especifica el tipo de contenido
            dataType: 'json',
            success: function(response){
                $('#messageContainer').html('<div class="alert alert-success">Post creado con éxito!</div>');
                $('#createPostForm').trigger("reset");
            },
            error: function(error){
                $('#messageContainer').html('<div class="alert alert-danger">Hubo un error al crear el post. Por favor, intenta de nuevo.</div>');
            }
        });
    });
});

    </script>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


@endsection
