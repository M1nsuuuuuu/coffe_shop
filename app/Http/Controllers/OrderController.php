<?php

namespace App\Http\Controllers;

use App\Models\Drink;
use App\Models\Order;
use App\Models\OrderDrink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'drink_id' => 'required|exists:drinks,id',
            'volume' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $drink = Drink::findOrFail($request->drink_id);
        $prices = $drink->prices;
        $volumes = $drink->volumes;
        
        $volumeIndex = array_search($request->volume, $volumes);
        if ($volumeIndex === false) {
            return response()->json(['error' => 'Invalid volume'], 400);
        }
        
        $price = $prices[$volumeIndex];
        
        $cart = session()->get('cart', []);
        
        $cartItemId = $request->drink_id . '-' . $request->volume;
        
        if (isset($cart[$cartItemId])) {
            $cart[$cartItemId]['quantity'] += $request->quantity;
        } else {
            $cart[$cartItemId] = [
                'drink_id' => $request->drink_id,
                'name' => $drink->name,
                'image' => $drink->image,
                'volume' => $request->volume,
                'price' => $price,
                'quantity' => $request->quantity,
            ];
        }
        
        session()->put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'cart' => $cart,
            'total' => $this->getCartTotal(),
            'count' => count($cart)
        ]);
    }

    public function getCart()
    {
        $cart = session()->get('cart', []);
        $total = $this->getCartTotal();
        
        return response()->json([
            'cart' => $cart,
            'total' => $total,
            'count' => count($cart)
        ]);
    }

    public function updateCart(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);
        
        if (isset($cart[$request->cart_item_id])) {
            $cart[$request->cart_item_id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }
        
        return response()->json([
            'success' => true,
            'cart' => $cart,
            'total' => $this->getCartTotal(),
            'count' => count($cart)
        ]);
    }

    public function removeFromCart(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|string',
        ]);

        $cart = session()->get('cart', []);
        
        if (isset($cart[$request->cart_item_id])) {
            unset($cart[$request->cart_item_id]);
            session()->put('cart', $cart);
        }
        
        return response()->json([
            'success' => true,
            'cart' => $cart,
            'total' => $this->getCartTotal(),
            'count' => count($cart)
        ]);
    }

    private function getCartTotal()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return $total;
    }

    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'delivery_address' => 'required|string',
        ]);

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Корзина пуста');
        }
        
        $total = $this->getCartTotal();
        
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $total,
            'delivery_address' => $request->delivery_address,
        ]);
        
        foreach ($cart as $item) {
            OrderDrink::create([
                'order_id' => $order->id,
                'drink_id' => $item['drink_id'],
                'quantity' => $item['quantity'],
                'volume' => $item['volume'],
                'price' => $item['price'],
            ]);
        }
        
        session()->forget('cart');
        
        return redirect()->route('profile')->with('success', 'Заказ успешно оформлен');
    }
}