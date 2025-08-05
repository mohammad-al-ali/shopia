<?php
namespace App\Http\Requests;

use App\Models\Address;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class OrderRequest extends FormRequest
{
public function authorize(): bool
{
return true;
}
    public function rules()
    {
        $hasAddress = Address::where('user_id', Auth::id())->exists();

        return [
            'mode' => 'required|string|in:cash,paypal,credit_card',
            'transaction_id' => 'nullable|string|max:255',
            // ✅ التحقق من بيانات العنوان فقط إذا لم يكن لدى المستخدم عنوان مسجل مسبقًا
            'name' => $hasAddress ? 'sometimes' : 'required|string|max:100',
            'phone' => $hasAddress ? 'sometimes' : 'required|numeric|digits:10',
            'city' => $hasAddress ? 'sometimes' : 'required|string|max:100',
            'address' => $hasAddress ? 'sometimes' : 'required|string|max:255',
            'locality' => $hasAddress ? 'sometimes' : 'required|string|max:100',
            'landmark' => $hasAddress ? 'sometimes' : 'required|string|max:255',
        ];
    }
}
