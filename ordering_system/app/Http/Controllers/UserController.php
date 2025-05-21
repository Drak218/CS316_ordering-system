<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function index() { 
        return User::all(); 
    } 
    public function store(Request $request) { 
        $request->validate([ 
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6' 
        ]); 

        return User::create($request->all()); 
    } 
    public function show($id) { 
        return User::findOrFail($id); 
    } 
    public function update(Request $request, $id) { 
        $product = User::findOrFail($id); 
        $product->update($request->all()); 
        return $product; 
    } 
    public function destroy($id) { 
        return User::destroy($id); 
    } 
}
