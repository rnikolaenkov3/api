<?php


namespace App\Services;


use App\Models\Product;

class ProductService extends Service
{
    protected $mProduct;

    public function __construct(Product $product)
    {
        parent::__construct();
        $this->mProduct = $product;
    }

    public function getProducts(array $data)
    {
        $query = $this->mProduct;

        if (isset($data['with_trash'])) {
            $query = $query->withTrashed();
        }

        if (isset($data['title'])) {
            $query = $query->where('title', $data['title']);
        }

        if (isset($data['published'])) {
            if ($data['published'] == 1) {
                $query = $query->whereNotNull('published_at');
            }

            if ($data['published'] == 0) {
                $query = $query->whereNull('published_at');
            }
        }

        if (isset($data['price_from'])) {
            $query = $query->where('price', '>=', $data['price_from']);
        }

        if (isset($data['price_to'])) {
            $query = $query->where('price', '<=', $data['price_to']);
        }

        if (isset($data['category_id'])) {
            $categoryId = $data['category_id'];
            $query = $query->whereHas('categories', function ($query) use ($categoryId){
                return $query->where('categories.id', $categoryId);
            });
        }

        if (isset($data['category_name'])) {
            $categoryName = $data['category_name'];
            $query = $query->whereHas('categories', function ($query) use ($categoryName){
                return $query->where('categories.title', $categoryName);
            });
        }

        $query = $this->limit($query, $data);

        $query = $query->with('categories');

        $products = $query->get();

        return $products;
    }

    public function getProductById($id)
    {
        return $this->mProduct->withTrashed()->with('categories')->find($id);
    }

    public function create($data)
    {
        $newProduct = $this->mProduct->create($data);
        if (isset($data['categories'])) {
            $newProduct->categories()->attach($data['categories']);
        }
        return $newProduct;
    }

    public function update($data, $id)
    {
        $product = $this->mProduct->withTrashed()->find($id);

        if (is_null($product)) {
            throw new \DomainException('Продукт не найден');
        }

        if (isset($data['categories'])) {
            $product->categories()->detach();
            $product->categories()->attach($data['categories']);
        }

        return $product->update($data);
    }

    public function delete($id)
    {
        $product = $this->mProduct->withTrashed()->find($id);

        if (is_null($product)) {
            throw new \DomainException('Продукт не найден');
        }

        return $product->delete();
    }
}
