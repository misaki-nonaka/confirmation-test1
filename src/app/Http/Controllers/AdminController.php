<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Contact;

class AdminController extends Controller
{
    public function admin() {
        $items = Contact::with('category')->Paginate(7);
        $categories = Category::all();
        return view('admin', compact('items', 'categories'));
    }

    public function search(Request $request) {
        $items = Contact::with('category')->KeywordSearch($request->keyword)->GenderSearch($request->gender)->CategorySearch($request->category_id)->DateSearch($request->date)->Paginate(7)->withQueryString();
        $categories = Category::all();
        return view('admin', compact('items', 'categories'));
    }

    public function reset() {
        return redirect('admin');
    }

    public function destroy(Request $request)
    {
        Contact::find($request->id)->delete();
        return redirect('admin');
    }
}
