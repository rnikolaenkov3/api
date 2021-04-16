<?php


namespace App\Services;


use App\Models\Category;

class CategoryService
{
    protected $mCategory;
    protected $limit;
    protected $offset;

    public function __construct(Category $category)
    {
        $this->mCategory = $category;
        $this->limit = config('main.limit');
        $this->offset = config('main.offset');
    }

    public function getCategories(array $data)
    {
        $query = $this->mCategory;

        if (isset($data['title'])) {
            $query = $query->where('title', $data['title']);
        }

        if (isset($data['offset'])) {
            $query = $query->offset($data['offset']);
        } else {
            $query = $query->offset($this->offset);
        }

        if (isset($data['limit'])) {
            $query = $query->limit($data['limit']);
        } else {
            $query = $query->limit($this->limit);
        }

        return $query->get();
    }
}
