<?php


namespace App\Services;


use App\Models\Product;

class ProductService
{
    protected $mProduct;
    protected $limit;
    protected $offset;

    public function __construct(Product $product)
    {
        $this->mProduct = $product;
        $this->limit = config('main.limit');
        $this->offset = config('main.offset');
    }

    public function getProducts(array $data)
    {
        $request = $this->mProduct;

        if (isset($data['offset'])) {
            $request = $request->offset($data['offset']);
        } else {
            $request = $request->offset($this->offset);
        }

        if (isset($data['limit'])) {
            $request = $request->limit($data['limit']);
        } else {
            $request = $request->limit($this->limit);
        }

        $products = $request->get();

        return $products;
    }
}
