<?php

namespace App\Http\Controllers;

use App\Traits\UploadAble;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Contracts\ProductContract;

class ProductImageController extends Controller
{
    protected $productRepository;

    public function __construct(ProductContract $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function upload(Request $request)
    {
        $product = $this->productRepository->findProductById($request->product_id);

        if ($request->has('image')){
            $image = $this->uploadOne($request->image, 'products');

            $productImage = new ProductImage([
                'full' => $image,
            ]);

            $product->images()->save($productImage);
        }

        return response()->json(['status' => 'Success']);
    }

    public function delete($id)
    {
        $image = ProductImage::findorFail($id);

        if (!$image->full != '') {
            $this->deleteOne($image->full);
        }
        $image->delete();

        return redirect()->back();
    }
}
