<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        return new ProductCollection(Product::when(!empty($request->slug), function($query) use ($request){
            $query->whereHas('categories' , function ($query) use ($request){
                $query->where('slug', $request->slug);
            });
        })->paginate(Product::PAGINATE_PER_PAGE));
    }

    public function show($slug)
    {
        $product = Product::whereSlug($slug)->first();

        $comments = (new CommentCollection($product->comments()->paginate(Comment::PAGINATE_PER_PAGE)))->response()->getData();

        return  [
            'product' => (new ProductResource($product))->response()->getData() ?? [],
            'comments' => $comments ?? [],
        ];
    }
}
