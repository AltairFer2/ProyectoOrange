<?php

namespace App\Http\Controllers;

use App\Services\ApiService; // Asegúrate de tener este servicio definido y el namespace correcto
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
public function index($no_post)
{
    // Primero, obtienes los detalles del post específico usando su identificador.
    $postResponse = Http::get("http://localhost:3000/posts/{$no_post}");
    // Asegúrate de que tu API devuelve correctamente los detalles para un solo post.
    // Si la respuesta es un array, incluso con un solo elemento, puedes necesitar acceder al primer elemento.
    $postDetails = $postResponse->json();



    // Luego, obtienes los comentarios. Aquí asumo que tu API necesita el número de post para filtrar los comentarios.
    // Es posible que necesites ajustar esta URL si tu API espera un parámetro diferente para filtrar por post.
    $commentsResponse = Http::get("http://localhost:3000/comments");
    // Igual que antes, asegúrate de manejar la respuesta correctamente.
    $comments = $commentsResponse->json();



    // Pasar los datos a la vista. Asegúrate de que los nombres aquí coincidan con los que usas en tu vista.
    return view('orange.admin.comments.index', ['post' => $postDetails, 'comments' => $comments]);
}

public function store(Request $request)
{
    $input = $request->all();

    $validatedData = Validator::make($input, [
        'commenter' => 'required|max:255',
        'comment' => 'required',
        'no_post' => 'required|integer',
    ]);

    if ($validatedData->fails()) {
        return response()->json(['errors' => $validatedData->errors()], 422);
    }

    $client = new Client();

    try {
        $response = $client->request('POST', 'http://localhost:3000/comments', [
            'json' => $input
        ]);

        if ($response->getStatusCode() == 200) {
            // Aquí manejas la respuesta exitosa
            return response()->json(['success' => 'Comentario agregado con éxito'], 200);
        }
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al agregar el comentario: ' . $e->getMessage()], 500);
    }
}


public function destroy($no_post)
{
    // Lógica para eliminar el comentario de la base de datos.
    $comment = Http::delete("http://localhost:3000/posts/{$no_post}");
    if ($comment) {
        $comment->delete();
        return response()->json(['success' => 'Comentario eliminado con éxito.']);
    } else {
        return response()->json(['error' => 'Comentario no encontrado.'], 404);
    }
}

public function update(Request $request, $no_comment)
{
    $input = $request->all();

    // Validación de los datos entrantes
    $validatedData = Validator::make($input, [
        'commenter' => 'sometimes|required|max:255', // 'sometimes' permite la actualización parcial de recursos
        'comment' => 'sometimes|required',
        // Añade aquí más campos según sea necesario
    ]);

    if ($validatedData->fails()) {
        return response()->json(['errors' => $validatedData->errors()], 422);
    }

    try {
        // Enviar solicitud PATCH a tu API para actualizar el comentario
        $response = Http::patch("http://localhost:3000/comments/{$no_comment}", $input);

        // Comprobar el estado de la respuesta
        if ($response->successful()) {
            // Manejar respuesta exitosa
            return response()->json(['success' => 'Comentario actualizado con éxito'], 200);
        } else {
            // Manejar posibles errores de la API, como comentario no encontrado
            return response()->json(['error' => 'Error al actualizar el comentario'], $response->status());
        }
    } catch (\Exception $e) {
        // Manejar excepciones, como errores de conexión
        return response()->json(['error' => 'Error al actualizar el comentario: ' . $e->getMessage()], 500);
    }
}


}