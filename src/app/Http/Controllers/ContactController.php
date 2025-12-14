<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Contact;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function index() {
        $categories=Category::all();
        return view('index', compact('categories'));
    }

    public function confirm(ContactRequest $request) {
        $contents = $request->all();
        $category = Category::find($contents['category_id']);
        return view('confirm', compact('contents', 'category'));
    }

    public function store(Request $request) {
        if($request->input('back') == 'back'){
            return redirect('/')->withInput();
        }

        $contact = $request->all();
        $contact['tel'] = $contact['tel1'] . $contact['tel2'] . $contact['tel3'];
        unset($contact['_token']);
        Contact::create($contact);
        return view('thanks');
    }

}
