<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderCollection;
use App\Models\Order;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function index(Request $request)
    {

        try{
            $session_id = Session::get('session_key');
//            $user = $request->user();
            $order = Order::whereSession($session_id)
//                ->orWhereUserId($user->id)
                ->get();
                return $this->successApiResponse(null, new OrderCollection($order));
            } catch (Exception $e) {

            return $this->errorApiByException($e);
        }
    }
}
