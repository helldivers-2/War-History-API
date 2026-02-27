<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: 'Helldivers 2 War History API',
    version: '0.0.6',
    contact: new OA\Contact(
        name: 'Kejax',
        email:'kejax@kejax.net',
    ),
    /*license: new OA\License(
        name: 'MIT License',
        identifier: 'MIT',
        url: 'https://localhost:8000', // TODO
    )*/
)]
class SwaggerInfo extends Controller
{
    //
}
