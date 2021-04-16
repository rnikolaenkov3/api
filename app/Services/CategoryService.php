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
}
