<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
        $this->middleware("security:auth");
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $search = $request->input('search', '');
        $selected_category = $request->input('category', '');

        $query = Product::query();

        if ($search) {
            $query->where('name', 'like', $search . '%');
        }

        if ($selected_category) {
            $query->where('category_id', $selected_category);
        }

        $products = $query->paginate(20)->withQueryString();
        $categories = \App\Models\Category::withCount('products')->get();

        $view = $user && $user->hasRole('admin') ? 'home-admin' : 'home';

        return view($view, compact('products', 'search', 'categories', 'selected_category'));
    }

    public function admin(Request $request)
    {
        $search = $request->input('search', '');
        $selected_category = $request->input('category', '');

        $productsQuery = Product::query();
        if ($search) {
            $productsQuery->where('name', 'like', $search . '%');
        }
        if ($selected_category) {
            $productsQuery->where('category_id', $selected_category);
        }
        
        $products = $productsQuery->paginate(20)->withQueryString();
        
        $users = \App\Models\User::all(); // Usado para conteos r\u00e1pidos o inicializaci\u00f3n
        $categories = \App\Models\Category::withCount('products')->get();

        return view('home-admin', compact('products', 'search', 'selected_category', 'users', 'categories'));
    }
}
