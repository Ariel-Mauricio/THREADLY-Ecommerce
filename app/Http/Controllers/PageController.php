<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function terms()
    {
        return view('pages.terms');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:50',
            'order_number' => 'nullable|string|max:50',
            'message' => 'required|string|max:2000',
        ], [
            'name.required' => 'El nombre es obligatorio',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'Ingresa un email válido',
            'subject.required' => 'Selecciona un asunto',
            'message.required' => 'El mensaje es obligatorio',
        ]);

        // Aquí puedes enviar el email o guardar en base de datos
        // Mail::to('soporte@threadly.ec')->send(new ContactFormMail($validated));

        // Por ahora solo log para desarrollo
        Log::info('Contact Form Submission', $validated);

        return back()->with('success', '¡Mensaje enviado correctamente! Te responderemos pronto.');
    }
}
