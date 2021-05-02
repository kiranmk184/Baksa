<?php

namespace App\Http\Controllers;

use App\Contracts\BrandContract;
use Illuminate\Http\Request;

class BrandController extends BaseController
{
    protected $brandRepository;

    public function __construct(BrandContract $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function index()
    {
        $brands = $this->brandRepository->listBrands();

        $this->setPageTitle('Brands', 'List of all brands');

        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        $this->setPageTitle('Brands','Create Brands');
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:191',
            'image' => 'mimes:jpg;jped,png|max:1000'
        ]);

        $params = $request->except('_token');

        $brand = $this->brandRepository->createBrand($params);

        if(!$brand){
            return $this->responseRedirectBack('Error occurred while creating Brand','error',true,true);
        }

        return $this->responseRedirect('admin.brands.index','Brand created successfully','success',false,false);
    }

    public function edit($id)
    {
        $brand = $this->brandRepository->findBrandById($id);

        $this->setPageTitle('Brands','Edit Brand : '.$brand->name);
        return view('admin.brands.index',compact('brand'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:191',
            'image' => 'mimes:jpg;jped,png|max:1000'
        ]);

        $params = $request->except('_token');

        $brand = $this->brandRepository->updateBrand($params);

        if (!$brand){
            return $this->responseRedirectBack('Error occurred while editing brand','error',true,true);
        }

        return $this->responseRedirect('admin.brands.index','Brand edited successfully','success',true,true);
    }

    public function delete($id)
    {
        $brand = $this->brandRepository->deleteBrand($id);

        if(!$brand){
            return $this->responseRedirectBack('Error occurred while deleting brand','error',true,true);
        }

        return $this->responseRedirect('admin.brands.index','Brand deleted successfully','success',true,true);
    }

}
