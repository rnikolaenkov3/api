<?php


namespace App\Http\Controllers\Api\V1;


use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    protected $sProduct;

    public function __construct(ProductService $productService)
    {
        $this->sProduct = $productService;
    }

    public function getProducts(Request $request)
    {
        try {
            $data = $request->all();

            $products = $this->sProduct->getProducts($data);

            return $this->responseOk($products->toArray());
        } catch (\DomainException $e) {
            return $this->responseError($e->getMessage());
        } catch (\Exception $e) {
            Log::error($e->getTraceAsString());
            return $this->responseError($e->getMessage());
        }
    }

    public function getProductById(int $id)
    {
        try {
            $product = $this->sProduct->getProductById($id);

            if (is_null($product)) {
                throw new \DomainException('Продукт не найден');
            }

            return $this->responseOk([$product]);
        } catch (\DomainException $e) {
            return $this->responseError($e->getMessage());
        } catch (\Exception $e) {
            Log::error($e->getTraceAsString());
            return $this->responseError($e->getMessage());
        }
    }
}
