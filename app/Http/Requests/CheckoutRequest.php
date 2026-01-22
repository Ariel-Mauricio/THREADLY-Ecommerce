<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:100|regex:/^[\pL\s\-]+$/u',
            'last_name' => 'required|string|max:100|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|email:rfc,dns|max:255',
            'phone' => 'required|string|max:20|regex:/^[\+]?[0-9\s\-\(\)]+$/',
            'address' => 'required|string|min:10|max:500',
            'address_reference' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'payment_method' => 'required|in:card,transfer,cash',
            'payment_voucher' => 'required_if:payment_method,transfer|nullable|file|mimes:jpeg,jpg,png,gif,webp,pdf|max:5120',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'El nombre es obligatorio',
            'first_name.regex' => 'El nombre solo puede contener letras, espacios y guiones',
            'first_name.max' => 'El nombre no puede superar los 100 caracteres',
            'last_name.required' => 'El apellido es obligatorio',
            'last_name.regex' => 'El apellido solo puede contener letras, espacios y guiones',
            'last_name.max' => 'El apellido no puede superar los 100 caracteres',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'Ingresa un email válido',
            'email.max' => 'El email no puede superar los 255 caracteres',
            'phone.required' => 'El teléfono es obligatorio',
            'phone.regex' => 'Ingresa un número de teléfono válido',
            'phone.max' => 'El teléfono no puede superar los 20 caracteres',
            'address.required' => 'La dirección es obligatoria',
            'address.min' => 'La dirección debe tener al menos 10 caracteres',
            'address.max' => 'La dirección no puede superar los 500 caracteres',
            'address_reference.max' => 'La referencia no puede superar los 255 caracteres',
            'city.required' => 'La ciudad es obligatoria',
            'city.max' => 'La ciudad no puede superar los 100 caracteres',
            'province.required' => 'La provincia es obligatoria',
            'province.max' => 'La provincia no puede superar los 100 caracteres',
            'payment_method.required' => 'Selecciona un método de pago',
            'payment_method.in' => 'Método de pago no válido',
            'payment_voucher.required_if' => 'Debes subir el comprobante de transferencia',
            'payment_voucher.mimes' => 'El comprobante debe ser una imagen (JPG, PNG, GIF, WEBP) o PDF',
            'payment_voucher.max' => 'El comprobante no debe superar los 5MB',
            'notes.max' => 'Las notas no pueden superar los 1000 caracteres',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'first_name' => 'nombre',
            'last_name' => 'apellido',
            'email' => 'correo electrónico',
            'phone' => 'teléfono',
            'address' => 'dirección',
            'address_reference' => 'referencia',
            'city' => 'ciudad',
            'province' => 'provincia',
            'payment_method' => 'método de pago',
            'payment_voucher' => 'comprobante de pago',
            'notes' => 'notas',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Sanitizar datos antes de validar
        $this->merge([
            'first_name' => $this->first_name ? trim($this->first_name) : null,
            'last_name' => $this->last_name ? trim($this->last_name) : null,
            'email' => $this->email ? strtolower(trim($this->email)) : null,
            'phone' => $this->phone ? preg_replace('/\s+/', ' ', trim($this->phone)) : null,
            'address' => $this->address ? trim($this->address) : null,
            'address_reference' => $this->address_reference ? trim($this->address_reference) : null,
            'city' => $this->city ? trim($this->city) : null,
            'province' => $this->province ? trim($this->province) : null,
            'notes' => $this->notes ? trim($this->notes) : null,
        ]);
    }
}
