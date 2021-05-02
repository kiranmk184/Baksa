<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\BrandContract;
use App\Contracts\CategoryContract;
use App\Contracts\ProductContract;
use App\Http\Requests\StoreProductFormRequest;

class ProductController extends BaseController
{
    protected $brandRepository;

    protected $categoryRepositoy;

    protected $productRepository;

    public function __construct(
        BrandContract $brandRepository,
        CategoryContract $categoryRepositoy,
        ProductContract $productRepository
    )
    {
        $this->brandRepository = $brandRepository;
        $this->categoryRepositoy = $categoryRepositoy;
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $products = $this->productRepository->listProducts();

        $this->setPageTitle('Products','Products List');

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $brands = $this->brandRepository->listBrands('name','asc');
        $categories = $this->categoryRepositoy->listCategories('name','asc');

        $this->setPageTitle('Products','Create Products');

        return view('admin.products.create',compact('brands','categories'));
    }

    public function store(StoreProductFormRequest $request)
    {
        $params = $request->except('_token');

        $products = $this->productRepository->createProduct($params);

        if(!$products){
            return $this->responseRedirectBack('Error occurred while creating product','error',ture,true);
        }

        return $this->responseRedirect('admin.products.index','Product created successfully','success',false,false);
    }

    public function edti($id)
    {
        $product = $this->productRepository->findProductById($id);
        $brands = $this->brandRepository->listBrands('name','asc');
        $categories = $this->categoryRepositoy->listCategories('name','asc');

        $this->setPageTitle('Products','Edit products');
        return view('admin.products.edit',compact('product','brands','categories'));
    }

    public function update(StoreProductFormRequest $request)
    {
        $params = $request->except('_token');

        $product = $this->productRepository->updateProduct($params);

        if (!$product){
            return $this->responseRedirectBack('Error occurred while updating product','error',ture,true);
        }

        return $this->responseRedirect('admin.products.index','Product updated successfully','success',false,false);
    }


}
