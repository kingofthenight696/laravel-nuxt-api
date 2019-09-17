<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use http\Exception;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Comment $comment)
    {
        try {
            $commentData = $request->only([
                'comment',
                'product_id',
                'rating',
            ]);

            array_push($commentData, [
                'user_id' => $request->user()->id ?? null,
            ]);

            return new CommentResource(Comment::create($commentData));
        } catch (Exception $e) {
            return $this->errorApiByException($e);
        }

    }

    public function index( Request $request)
    {
        return new CommentCollection(Comment::when($request->product_id, function ($query) use ($request){
            $query->whereHas('product', function ($query) use ($request) {
                $query->where('id', $request->product_id)->where('verified', true);
            });
           })->paginate(Comment::PAGINATE_PER_PAGE));
    }
}
