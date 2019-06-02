<?php

namespace App\Http\Controllers\Api;

use App\Models\Products;
use App\Transformers\ProductTransformer;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    use Helpers;
    public function index()
    {
        $res = Products::orderBy('sort','desc')->paginate();
        return $this->response->paginator($res,new ProductTransformer());
    }
}
