<?php


namespace App\Http\Controllers\Api\V1;


use App\Http\Requests\CreateProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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

    public function create(Request $request)
    {
        try {
            $data = $request->all();

            $this->validateProduct($data);

            $newProduct = $this->sProduct->create($data);

            return $this->responseOk([$newProduct]);
        } catch (\DomainException $e) {
            return $this->responseError($e->getMessage());
        } catch (\Exception $e) {
            Log::error($e->getTraceAsString());
            return $this->responseError($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();

            $this->validateProduct($data);

            $result = $this->sProduct->update($data, $id);

            return $this->responseOk([$result]);
        } catch (\DomainException $e) {
            return $this->responseError($e->getMessage());
        } catch (\Exception $e) {
            Log::error($e->getTraceAsString());
            return $this->responseError($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {

            $result = $this->sProduct->delete($id);

            return $this->responseOk([$result]);
        } catch (\DomainException $e) {
            return $this->responseError($e->getMessage());
        } catch (\Exception $e) {
            Log::error($e->getTraceAsString());
            return $this->responseError($e->getMessage());
        }
    }

    protected function validateProduct($data)
    {
        $valid = Validator::make($data, [
            'title' => 'required',
            'description' => 'required',
        ]);

        $errorList = $valid->getMessageBag()->getMessages();

        if (count($errorList) !== 0) {
            $message = '';
            foreach ($errorList as $key => $value) {
                foreach ($value as $desc) {
                    $message .= $desc . ' ';
                }
            }

            throw new \DomainException(trim($message));
        }

        return;
    }
}
