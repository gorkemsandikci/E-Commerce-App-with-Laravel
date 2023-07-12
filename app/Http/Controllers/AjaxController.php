<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContentFormRequest;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AjaxController extends Controller
{
    public function iletisimkaydet(ContentFormRequest $request)
    {
        $contact_data = [
            'name' => Str::title($request->name),
            'phone' => $request->phone,
            'email' => $request->email,
            'message' => $request->message,
            'subject' => $request->subject,
            'ip' => request()->ip(),
        ];

        Contact::create($contact_data);

        return back()->with([
            'message' => 'Başarıyla Gönderildi'
        ]);

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('anasayfa');
    }
}
