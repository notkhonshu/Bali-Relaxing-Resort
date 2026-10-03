<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessage;
use App\Support\DetailPage;
use App\Support\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    private const ANCHOR = '#contact_form';

    public function index()
    {
        return view('pages.landings.contact-us', [
            'detail' => DetailPage::contact(),
            'seo'    => Seo::page('contact-us'),
        ]);
    }

    public function send(Request $request)
    {
        $back = route('contact-us.index') . self::ANCHOR;
        $done = redirect($back)->with('contact_status', 'Thank you! Your message has been sent. We will get back to you shortly.');

        if (filled($request->input('website'))) {
            return $done;
        }

        $validator = Validator::make($request->all(), [
            'name'    => ['required', 'string', 'max:100'],
            'email'   => ['required', 'email:rfc', 'max:150'],
            'phone'   => ['nullable', 'regex:/^[0-9+\-\s()]{6,30}$/'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ], [
            'phone.regex' => 'Please enter a valid phone number.',
            'message.min' => 'Please write at least 10 characters.',
        ]);

        if ($validator->fails()) {
            return redirect($back)->withErrors($validator)->withInput();
        }

        $to = trim((string) config('socials.customer_service.email', ''));

        if ($to === '') {
            Log::warning('Contact form: no recipient email configured in socials.customer_service.email');

            return redirect($back)
                ->with('contact_error', 'Sorry, we cannot send your message right now. Please contact us by phone or WhatsApp.')
                ->withInput();
        }

        try {
            Mail::to($to)->send(new ContactMessage($validator->validated()));
        } catch (\Throwable $e) {
            Log::error('Contact form mail failed: ' . $e->getMessage());

            return redirect($back)
                ->with('contact_error', 'Sorry, your message could not be sent. Please try again or contact us by phone or WhatsApp.')
                ->withInput();
        }

        return $done;
    }
}