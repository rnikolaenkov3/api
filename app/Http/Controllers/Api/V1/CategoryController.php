<?php


namespace App\Http\Controllers\Api\V1;


use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    protected $sCategory;

    public function __construct(CategoryService $categoryService)
    {
        $this->sCategory = $categoryService;
    }

    public function getCategories(Request $request)
    {
        try {
            $data = $request->all();

            $categories = $this->sCategory->getCategories($data);

            return $this->responseOk($categories->toArray());
        } catch (\DomainException $e) {
            return $this->responseError($e->getMessage());
        } catch (\Exception $e) {
            Log::error($e->getTraceAsString());
            return $this->responseError($e->getMessage());
        }
    }
}
