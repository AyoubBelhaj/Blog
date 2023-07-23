<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class ContactFormController extends Controller
{
    public $blog_name = 'RivaBlog';

    public function create(){
        $data['page_title'] = 'Contact Us | Blog';
        $data['page_description'] = 'This is my simple blog ';
        $data['blog_name'] = $this->blog_name ;
        return view('contact',$data);
    }

    public function store(Request $request ){
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);
        Mail::send('emails.contact-message',[
            'msg' => $request->message
        ],function($mail) use($request){
            $mail->from($request->email,$request->name);

            $mail->to('ayoubbelhaj2017@gmail.com')->subject('Contact Message');
        });
        return redirect()->back()->with('flash_message','Thank you for your message.');
    }
}
