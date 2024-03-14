<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BlogController extends Controller
{
    public function index(){
        $response = Http::get("http://localhost:3000/posts");
        $posts = $response->object(); // Aquí asumimos que la respuesta es un objeto que representa los posts. Puede ser necesario ajustar esto dependiendo de la estructura exacta de la respuesta.

        // Asegúrate de que la ruta de la vista corresponda a la ubicación de tu archivo de vista `blog.blade.php`
        return view("orange.blog", compact('posts')); // Ajusta "tu_ruta_correcta.blog" a la ubicación real de tu vista.
    }

    public function destroy($no_post)
{
    // Enviar solicitud DELETE a la API de Node.js para eliminar el post
    $response = Http::delete("http://localhost:3000/posts/{$no_post}");

    // Verificar si la eliminación fue exitosa
    if ($response->successful()) {
        // Redirigir a la lista de posts con un mensaje de éxito
        return redirect()->back()->with('success', 'Post borrado con éxito!');
    } else {
        // Redirigir a la lista de posts con un mensaje de error
        return back()->with('error', 'Hubo un problema al eliminar el post.');
    }
}

public function edit($no_post)
{
    // Reemplaza 'http://localhost:3000/posts/' con la URL de tu API y asegúrate de que es accesible
    $url = "http://localhost:3000/posts/" . $no_post;

    // Realiza una petición GET a la API para obtener los detalles del post
    $response = Http::get($url);
    $post = $response->json();



    // Comprueba si la API devolvió una respuesta válida
    if($response->successful()) {
        return view('orange.admin.posts.edit', compact('post'));
    } else {
        // Maneja el caso en que la API no devuelva una respuesta exitosa
        return redirect()->back()->with('error', 'No se pudo obtener la información del post.');
    }
}

public function update(Request $request, $no_post)
{
    // Validación de los datos enviados en el formulario
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        // Agrega aquí todas las validaciones necesarias para los campos que pueden ser editados
    ]);

    // Preparar los datos para enviar a la API
    $postData = [
        'title' => $request->title,
        'content' => $request->content,
        // Asegúrate de incluir aquí todos los campos que tu API espera recibir
    ];

    // Enviar la solicitud PATCH/PUT a la API para actualizar el post
    $response = Http::patch("http://localhost:3000/posts/{$no_post}", $postData);

    // Verificar si la actualización fue exitosa y responder adecuadamente
    if ($response->successful()) {
        // Redirigir a una página relevante con un mensaje de éxito
        return redirect()->route('orange.blog')->with('success', 'Post updated successfully!');
    } else {
        // Manejar el caso de error, posiblemente redirigir hacia atrás con un mensaje de error
        return back()->withInput()->with('error', 'There was a problem updating the post.');
    }
}

}