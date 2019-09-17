<?php namespace App\Services;

use App\Models\Cart;
use App\Models\Deliveries;
use App\Models\Distance;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CartService
{
    private $deliveryService;
    private $user_id;
    private $session_id;
    private $product_id;
    private $quantity;
    private $cart;
    private $department_id;
    private $delivery_id;


    public function __construct(Request $request, Cart $cart, DeliveryService $deliveryService)
    {
        $this->deliveryService = $deliveryService;
        $this->user_id = $request->user() ? $request->user()->id : null;
        $this->product_id = $request->product_id;
        $this->department_id = $request->department_id;
        $this->delivery_id = $request->delivery_id;

        $this->quantity = $request->quantity ?? 1;

        $this->session_id = Session::get('session_key') ?? $this->setSession();
        $this->cart = $cart;

        $userCart = (!is_null($this->user_id))
            ? $this->cart->getCartByUser($this->user_id)
            : null;

        $sessionCart = $this->cart->getCartBySession($this->session_id);

        if ((!is_null($sessionCart) && !is_null($userCart)) && $sessionCart->diffAssoc($userCart)) {
            $this->mergeCarts($userCart, $sessionCart);
        }

    }

    private function setSession()
    {
        $session_id = Str::random(40);
        Session::put('session_key', $session_id);
        return $session_id;
    }

    public function mergeCarts($userCart, $sessionCart): void
    {
        $sessionCartItems = $sessionCart->cartItems()->get();
        $userCartItems = $userCart->cartItems()->with('products')->get();

        $updates = [];
        $creates = [];
        $sessionCartItems->map(function ($cartItem) use (&$updates, &$creates, $userCartItems) {
            $duplicateProduct = $userCartItems->firstWhere('product_id', $cartItem->product_id);

            if ($duplicateProduct) {
                $updates[] = [
                    'qty' => $duplicateProduct->qty + $cartItem->qty,
                    'price' => $cartItem->products->price,
                ];
            } else {

                $creates[] = [
                    'qty' => $cartItem->qty,
                    'price' => $cartItem->products->price,
                ];
            }
        });

        foreach ($updates as $update) {
            $update->save();
        }

        $userCart->cartItems()->createMany($creates);
        $userCart->update('session', $this->session_id);
        $sessionCart->delete();
    }

    public function getCart()
    {
        return Cart::where('session', $this->session_id)
            ->with('cartItems', 'shipping')
            ->latest('created_at')
            ->first();
    }

    public function setContacts(array $contacts)
    {
        $cart = $this->checkUnexistingCart();

        $cart->contact()->updateOrCreate(['cart_id' => $cart->id], $contacts);

        return true;
    }

    public function setDelivery()
    {
        $cart = $this->checkUnexistingCart();

        $delivery = Deliveries::findOrFail($this->delivery_id);

        $contacts = $cart->contact()->first();
        $cartItems = $cart->cartItems()->get();
        $productIds = $cartItems->map(function ($item) {
            return $item->product_id;
        });
        $distance = Distance::whereCityFrom(1)->whereCityTo($contacts->city_id)->first();
        $productsWeight = Product::find($productIds)->sum('weight');

        $deliveryCost = $this->deliveryService->getDeliveryCost($delivery, $distance, $productsWeight);

        $cart->shipping()->updateOrCreate(
            ['cart_id' => $cart->id],
            [
                'delivery_id' => $delivery->id,
                'price' => $deliveryCost,
                'department_id' => null,
            ]);

        return true;
    }

    public function setDepartment()
    {
        $cart = $this->checkUnexistingCart();

        $cart->shipping()->updateOrCreate(
            ['cart_id' => $cart->id],
            [
                'department_id' => $this->department_id,
            ]);

        return true;
    }

    public function changeCartItemQuantity()
    {
        $cart = $this->checkUnexistingCart();

        $item = $cart->whereHas('cartItems', function ($query) {
            $query->where('product_id', $this->product_id);
        })->first();

        if ($item) {
            return $item->cartItems()->where('product_id', $this->product_id)->update(['quantity' => $this->quantity]);
        }

        $product = Product::find($this->product_id);

        $cart->cartItems()->create(
            [
                'product_id' => $product->id,
                'price' => $product->price,
                'quantity' => $this->quantity,
                'preview' => $product->preview,
                'title' => $product->title,
            ]
        );
        return true;
    }

    private function checkUnexistingCart()
    {
        if (!$cart = $this->cart->getCartByUserOrSession($this->user_id, $this->session_id)->first()) {
            $cart = Cart::create([
                'user_id' => ($this->user_id) ?? null,
                'session' => $this->session_id,
            ]);
        }

        return $cart;
    }

    public function removeCartItem($productId)
    {
        $cart = Cart::whereSession($this->session_id)->first();

        if ($cart->cartItems()->count() === 1) {
            $this->removeCart();

        } else {
            $cart->cartItems()->where('product_id', $productId)->delete();
        }
        return true;
    }

    public function removeCart()
    {
        return Cart::whereSession($this->session_id)->delete();
    }

    public function buy()
    {
        $cart = $this->checkUnexistingCart();

        if (empty($cart->cartItems)) {

            throw GeneralException('Cart is empty');
        }
        if (empty($cart->contact)) {

            throw GeneralException('Contact is empty');
        }
        if (empty($cart->shipping)) {

            throw GeneralException('Shipping is empty');
        }

        $order = Order::create([
            'user_id' => $this->user_id,
            'session' => $cart->session,
            'status_id' => OrderStatus::whereName('ordered')->first()->id
        ]);

        $order->contact()->create($cart->contact->toArray());

        $order->items()->createMany($this->clearCartItem($cart->cartItems)->toArray());

        $order->shipping()->create($cart->shipping->toArray());

        $this->removeCart();

        return true;
    }

    protected function clearCartItem($cartItems)
    {
        return $cartItems->transform(function ($item) {
            return $item->only([
                'product_id',
                'price',
                'total_price',
                'quantity',
                'preview',
                'title'
            ]);
        });
    }
}
