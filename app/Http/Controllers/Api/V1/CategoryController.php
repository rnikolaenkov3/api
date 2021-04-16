<?php


namespace App\Http\Controllers\Api\V1;


use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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

    public function getCategoryById(int $id)
    {
        try {
            $category = $this->sCategory->getCategoryById($id);

            if (is_null($category)) {
                throw new \DomainException('Категория не найдена');
            }

            return $this->responseOk([$category]);
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

            $this->validateCategory($data);

            $newCategory = $this->sCategory->create($data);

            return $this->responseOk([$newCategory]);
        } catch (\DomainException $e) {
            return $this->responseError($e->getMessage());
        } catch (\Exception $e) {
            Log::error($e->getTraceAsString());
            return $this->responseError($e->getMessage());
        }
    }

    protected function validateCategory($data)
    {
        $valid = Validator::make($data, [
            'title' => 'required',
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
