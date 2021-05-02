<?php

namespace App\Http\Controllers;

use App\Contracts\CategoryContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class CategoryController extends BaseController
{
    protected $categoryRepository;

    /**
     * @var CategoryContract
     */
    public function __construct(CategoryContract $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $categories = $this->categoryRepository->listCategories();

        $this->setPageTitle('Categories','List of all categories');
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = $this->categoryRepository->listCategories('id','asc');

        $this->setPageTitle('Categoreis','Create Category');
        return view('admin.categories.create',compact('categories'));

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:191',
            'parent_id' => 'required|not_in:0',
            'image' => 'mimes:jpg,jpeg,png|max:1000'
        ]);

        $params = $request->except('_token');

        $category = $this->categoryRepository->createCategory($params);

        if(!$category) {
            return $this->responseRedirectBack('Error occurred while creating category.', 'error', true, true);
        }
        return $this->responseRedirect('admin.categories.index', 'Category added successfully' ,'success',false, false);
    }

    public function edit($id)
    {
        $targetCategory = $this->categoryRepository->findCategoryById($id);

        $categories = $this->categoryRepository->listCategories();

        $this->setPageTitle('Categories', 'Edit Category :'.$targetCategory->name);
        return view('admin.categories.edit', compact('categories','targetCategory'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:191',
            'parent_id' => 'required|not_in:0',
            'image' => 'mimes:jpg,jpeg,png|max:1000',
        ]);

        $params = $request->except('_token');

        $category = $this->categoryRepository->updateCategory($params);

        if(!$category) {
            return $this->responseRedirectBack('Error occurred while updating category.','error',true,true);
        }

        return $this->responseRedirectBack('Category updated successfully.','success',false,false);
    }

    public function delete($id)
    {
        $category = $this->categoryRepository->deleteCategory($id);

        if(!$category){
            return $this->responseRedirectBack('Error occurred while deleting.','error',true,true);
        }

        return $this->responseRedirect('admin.categories.index','Deleted successfully.','success',false,false);
    }
}
