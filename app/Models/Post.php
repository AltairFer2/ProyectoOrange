<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Post
{
    protected $connection = 'mongodb'; // Nombre de la conexión si es diferente a la predeterminada
    protected $collection = 'nombreDeTuColeccion'; // Opcional: especifica el nombre de la colección si no coincide con el nombre en plural del modelo

    // Asegúrate de definir los campos que quieres asignar masivamente
    protected $fillable = ['title', 'author', 'content', 'image', 'created_at', 'category'];
}