<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        // نسمح دائمًا بتنفيذ الطلب (يمكنك تخصيصه حسب الصلاحيات)
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('id'); // في حالة التحديث

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug,' . $productId],
            'description' => ['nullable', 'string'],
            'short_description' => ['nullable', 'string'],
            'regular_price' => ['required', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'warehouse_price' => ['required', 'numeric', 'min:0'],
            'featured' => ['nullable', 'boolean'],
            'quantity' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'images' => ['nullable', 'array'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $regular = $this->input('regular_price');
            $warehouse = $this->input('warehouse_price');

            // التحقق من أن السعر الاعتيادي أكبر من سعر المستودع
            if ($regular !== null && $warehouse !== null && $regular < $warehouse) {
                $validator->errors()->add('regular_price', 'السعر الاعتيادي يجب أن يكون أكبر من سعر المستودع.');
            }
        });
    }
}
