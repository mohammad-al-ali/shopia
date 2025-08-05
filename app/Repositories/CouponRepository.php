<?php
namespace App\Repositories;

use App\Models\Coupon;

class CouponRepository
{

    // استرجاع الكوبونات مع ترقيم (pagination)
    public function getAllPaginated($perPage = 12)
    {
        return Coupon::orderBy('expiry_date', 'DESC')->paginate($perPage);
    }

    // إنشاء كوبون جديد
    public function create(array $data)
    {
        return Coupon::create($data);
    }

    // إيجاد كوبون حسب الـ ID
    public function find($id)
    {
        return Coupon::findOrFail($id);
    }

    // تحديث بيانات كوبون موجود
    public function update(Coupon $coupon, array $data)
    {
        $coupon->update($data);
        return $coupon;
    }

    // حذف كوبون
    public function delete(Coupon $coupon)
    {
        return $coupon->delete();
    }

    // البحث عن كوبون صالح
    public function findValidByCode(string $code, $cartSubtotal)
    {
        return Coupon::where('code', $code)
            ->where('expiry_date', '>=', now())
            ->where('cart_value', '<=', $cartSubtotal)
            ->first();
    }
}
