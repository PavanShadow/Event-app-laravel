<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enquiry;

class EnquiryController extends Controller
{
    public function store(Request $request)
    {
        $item = new Enquiry([
          'name' => $request->get('name'),
          'email' => $request->get('email'),
          'contact' => $request->get('contact'),
          'subject' => $request->get('subject')
        ]);
        
        $item->save();
        return response()->json('Successfully added');
    }

}
