<?php


namespace App\Http\Controllers\Api\V1;


use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $sProduct;

    public function __construct(ProductService $productService)
    {
        $this->sProduct = $productService;
    }

    public function getProducts(Request $request)
    {
        $data = $request->all();

        $products = $this->sProduct->getProducts($data);

        dd($products);
        return response()->json(['status' => 'ok']);
    }
}
