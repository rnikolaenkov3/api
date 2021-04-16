<?php


namespace App\Services;


use App\Models\Product;

class ProductService
{
    protected $mProduct;

    public function __construct(Product $product)
    {
        $this->mProduct = $product;
    }

    public function getProducts(array $data)
    {
        $products = $this->mProduct->get();

        return $products;
    }
}
