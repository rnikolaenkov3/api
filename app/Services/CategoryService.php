<?php


namespace App\Services;


use App\Models\Category;

class CategoryService extends Service
{
    protected $mCategory;

    public function __construct(Category $category)
    {
        parent::__construct();
        $this->mCategory = $category;
    }

    public function getCategories(array $data)
    {
        $query = $this->mCategory;

        if (isset($data['title'])) {
            $query = $query->where('title', $data['title']);
        }

        $query = $this->limit($query, $data);

        return $query->get();
    }

    public function getCategoryById(int $id)
    {
        return $this->mCategory->find($id);
    }

    public function create($data)
    {
        return $this->mCategory->create($data);
    }

    public function delete(int $id)
    {
        $category = $this->mCategory->with('products')->find($id);

        if (is_null($category)) {
            throw new \DomainException('Категория не найдена');
        }

        if (count($category->products) != 0) {
            throw new \DomainException('Невозможно удалить, есть привязанные продукты');
        }

        return $category->delete();
    }
}
