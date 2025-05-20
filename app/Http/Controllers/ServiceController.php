<?php
// filepath: app/Http/Controllers/ServiceController.php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $services = Service::when($request->category, function ($query, $category) {
            return $query->where('category_id', $category);
        })->get();

        return view('services.index', compact('categories', 'services'));
    }
}