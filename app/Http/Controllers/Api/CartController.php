<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\CartService;
use Illuminate\Http\Request;


class CartController extends Controller
{

    public function index(Request $request, CartService $cartService)
    {
        return $this->successApiResponse(null, new CartResource($cartService->getCart()));
    }

    public function store(Request $request, CartService $cartService)
    {
        try {
            $cartService->changeCartItemQuantity($request->only(['product_id', 'quantity']));
        } catch (GeneralException $exception) {
            return $this->errorApiByException($exception);
        }


        return $this->successApiResponse(null, new CartResource($cartService->getCart()));
    }

    public function update(Request $request, CartService $cartService)
    {
        try {
            $cartService->changeCartItemQuantity($request->only(['product_id', 'quantity']));
        } catch (GeneralException $exception) {
            return $this->errorApiByException($exception);
        }

        return $this->successApiResponse(null, new CartResource($cartService->getCart()));
    }

    public function setDepartment(Request $request, CartService $cartService)
    {
        try {
            $cartService->setDepartment($request->only(['department_id']));
        } catch (GeneralException $exception) {
            return $this->errorApiByException($exception);
        }

        return $this->successApiResponse(null, new CartResource($cartService->getCart()));
    }

    public function setDelivery(Request $request, CartService $cartService)
    {
        try {
            $cartService->setDelivery($request->only(['delivery_id']));
        } catch (GeneralException $exception) {
            return $this->errorApiByException($exception);
        }

        return $this->successApiResponse(null, new CartResource($cartService->getCart()));
    }

    public function removeCartItem(Request $request, $productId, CartService $cartService)
    {
        try {
            $cartService->removeCartItem($productId);
        } catch (GeneralException $exception) {
            return $this->errorApiByException($exception);
        }

        return $this->successApiResponse(null, new CartResource($cartService->getCart()));
    }

    public function removeCart(Request $request, $productId, CartService $cartService)
    {
        try {
            $cartService->removeCart($productId);
        } catch (GeneralException $exception) {
            return $this->errorApiByException($exception);
        }

        return $this->successApiResponse(null, new CartResource($cartService->getCart()));
    }

    public function setContacts(Request $request, CartService $cartService)
    {
        try {
            $cartService->setContacts($request->only(['email', 'phone', 'name', 'city_id']));
        } catch (GeneralException $exception) {
            return $this->errorApiByException($exception);
        }

        return $this->successApiResponse(null, new CartResource($cartService->getCart()));
    }

    public function buy(Request $request, Order $order, CartService $cartService)
    {
//        try {
            $cartService->buy();
//        } catch (GeneralException $exception) {
//            return $this->errorApiByException($exception);
//        }

//        return $this->successApiResponse(null, new OrderResource($order->getLastOrder()));
    }
}
