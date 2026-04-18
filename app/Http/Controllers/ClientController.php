<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function home() {
        $products = Product::orderBy('id_san_pham','desc')->take(8)->get();
        $categories = Category::all();
        return view('client.home', compact('products','categories'));
    }

    public function products(Request $request) {
        $query = Product::query();
        if ($request->filled('q')) {
            $query->where('ten_san_pham','like','%'.$request->q.'%');
        }
        $products = $query->paginate(12);
        $categories = Category::all();
        return view('client.products', compact('products','categories'));
    }

    public function product($id) {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('client.product', compact('product','categories'));
    }

    public function category($id) {
        $products = Product::where('id_danh_muc',$id)->paginate(12);
        $categories = Category::all();
        return view('client.category', compact('products','categories'));
    }

    public function cart() {
        $categories = Category::all();
        return view('client.cart', compact('categories'));
    }

    public function orderslist() {
        $categories = Category::all();
        return view('client.orderslist', compact('categories'));
    }

    public function profile() {
        $categories = Category::all();
        return view('client.profile', compact('categories'));
    }
}

