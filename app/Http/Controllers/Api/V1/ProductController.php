<?php


namespace App\Http\Controllers\Api\V1;


use Illuminate\Support\Facades\Request;

class ProductController extends Controller
{
    public function __construct()
    {

    }

    public function getProducts(Request $request)
    {
        return response()->json(['status' => 'ok']);
    }
}
