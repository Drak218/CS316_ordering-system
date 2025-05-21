<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    public function index() { 
        return Order::all(); 
    } 
    public function store(Request $request) { 
        $validated = $request->validate([ 
            'staff_id' => 'required|integer|exists:users,id',
            'customer_name' => 'required|max:255',
            'address' => 'required|max:255',
            'city' => 'required|min:2|max:100',
            'zip_code' => 'required|max:4',
            'tax_exempt' => 'required|boolean',
            'product_name' => 'required|min:2|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'weight' => 'required|numeric|min:0',
            'shipping_method' => 'required|max:255',
            'sales_tax' => 'required|numeric|min:0',
            'shipping_fee' => 'required|numeric|min:0',
            'handling_fee' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0'
        ]); 

         
         
        return Order::create($validated); 
    } 
    public function show($id) { 
        return Order::findOrFail($id); 
    } 
    public function update(Request $request, $id) { 
        $product = Order::findOrFail($id); 
        $product->update($request->all()); 
        return $product; 
    } 
    public function destroy($id) { 
        return Order::destroy($id); 
    } 
}
