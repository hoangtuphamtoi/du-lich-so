<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool 
    { 
        return $this->user() !== null; 
    }

    public function rules(): array
    {
        return [
            'product_id'   => ['required', 'integer', Rule::exists('products', 'id')->where('status', 'published')],
            'service_date' => ['required', 'date_format:Y-m-d', 'after:today', 'before:+1 year'],
            'pax'          => ['required', 'integer', 'min:1', 'max:30'],
            'note'         => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'service_date.after' => 'Ngay khoi hanh phai sau ngay hom nay.',
            'pax.max'            => 'So khach toi da moi lan dat la 30.',
        ];
    }
}
