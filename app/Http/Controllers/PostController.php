<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index(){
        $response = Http::get("http://localhost:3000/posts");
        $add = $response->object();
        return view("orange.admin.posts.index", compact('posts'));
    }

    public function add(){
        $response = Http::get("http://localhost:3000/posts");
        $add = $response->object();
        return view("orange.admin.posts.add");
    }



    public function store(Request $request)
    {
        $input = $request->all();

        $validatedData = Validator::make($input, [
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|max:255',
            'created_at' => 'required|date',
            'category' => 'required|max:255',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors()], 422);
        }

        $client = new Client();

        try {
            $response = $client->request('POST', 'http://localhost:3000/posts', [
                'json' => $input
            ]);

            if ($response->getStatusCode() == 200) {
                $responseBody = json_decode($response->getBody(), true);
                // Puedes modificar la respuesta según lo que devuelva tu servicio Node.js
                return redirect()->back()->with('success', 'Post creado con éxito!');
            }
        } catch (\Exception $e) {
            // Manejar los casos de error, por ejemplo, si el servicio Node.js no está disponible
            return response()->json(['error' => 'Error al crear el post: ' . $e->getMessage()], 500);
        }
    }



}