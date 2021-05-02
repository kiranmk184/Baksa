<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Contracts\AttributeContract;

class AttributeController extends BaseController
{
    protected $attributeRepository;

    public function __construct(AttributeContract $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    public function index()
    {
        $attributes = $this->attributeRepository->listAttributes();

        $this->setPageTitle('Attributes', 'List of all attributes');
        return view('admin.attributes.index', compact('attributes'));
    }

    public function create()
    {
        $this->setPageTitle('Attributes','Create Attributes');

        return view('admin.attributes.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'code' => 'required',
            'name' => 'required',
            'frontend_type' => 'required',
        ]);

        $params = $request->except('_token');

        $attribute = $this->attributeRepository->createAttribute($params);

        if(!$attribute){
            return $this->responseRedirectBack('Error occurred while creating attribute','error',ture,true);
        }
        return $this->responseRedirect('admin.attributes.index','success',true,true);
    }

    public function edit($id)
    {
        $attribute = $this->attributeRepository->findAttributeById($id);

        $this->setPageTitle('Attributes','Edit Attribute : '. $attribute->name);
        return view('admin.attributes.edit',compact('attribute'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
            'name' => 'required',
            'frontend_type' => 'required'
        ]);

        $params = $request->except('_token');

        $attribute = $this->attributeRepository->updateAttribute($params);

        if(!$attribute){
            return $this->responseRedirectBack('Error occurred while updating attribute.','error',true,true);
        }
        return $this->responseRedirectBack('Attribute updated successfully','success',true,true);
    }

    public function delete($id)
    {
        $attribute = $this->attributeRepository->deleteAttribute($id);

        if (!$attribute){
            return $this->responseRedirectBack('Error occurred while deleting attribute','error',true,true);
        }
        return $this->responseRedirect('admin.attributes.index','Attribute deleted successfully','success',false,false);
    }
}
