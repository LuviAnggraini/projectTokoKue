<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cake;

class ProductController extends Controller
{
    public function index() {
        $cakes = Cake ::paginate(20);
        return view('products.index', compact ('cakes'));
    }
}
