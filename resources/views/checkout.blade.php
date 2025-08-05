@extends('layouts.app')
@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">Shipping and Checkout</h2>
            <div class="checkout-steps">
                <a href="{{route('cart.index')}}" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">01</span>
                    <span class="checkout-steps__item-title">
            <span>Shopping Bag</span>
            <em>Manage Your Items List</em>
          </span>
                </a>
                <a href="javascript:void(0)" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">02</span>
                    <span class="checkout-steps__item-title">
            <span>Shipping and Checkout</span>
            <em>Checkout Your Items List</em>
          </span>
                </a>
                <a href="javascript:void(0)" class="checkout-steps__item">
                    <span class="checkout-steps__item-number">03</span>
                    <span class="checkout-steps__item-title">
            <span>Confirmation</span>
            <em>Review And Submit Your Order</em>
          </span>
                </a>
            </div>
            <form name="checkout-form" method="POST" action="{{route('cart.order.place')}}">
                @csrf

                <div class="checkout-form">
                    <div class="billing-info__wrapper">
                        <div class="row">
                            <div class="col-6">
                                <h4>SHIPPING DETAILS</h4>
                            </div>
                            <div class="col-6">
                            </div>
                        </div>
                        @if($address)
                            <div class="row mt-5">
                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="name"  value="{{ $address->name }}" required="">
                                        <label for="name">Full Name *</label>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                                @error('name') <span class="alert alert-danger text-center">{{$message}}</span>@enderror

                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="phone" required="" value="{{ $address->phone }}">
                                        <label for="phone">Phone Number *</label>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                                @error('phone') <span class="alert alert-danger text-center">{{$message}}</span>@enderror

                                <div class="col-md-4">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="city" value="{{ $address->locality }}" required="" >
                                        <label for="city">Town / City *</label>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                                @error('city') <span class="alert alert-danger text-center">{{$message}}</span>@enderror

                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="address" required="" value="{{ $address->address }}">
                                        <label for="address">House no, Building Name *</label>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                                @error('address') <span class="alert alert-danger text-center">{{$message}}</span>@enderror

                                <div class="col-md-6">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="locality" required="" value="{{ $address->city }}" >
                                        <label for="locality">Road Name, Area, Colony *</label>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                                @error('locality') <span class="alert alert-danger text-center">{{$message}}</span>@enderror

                                <div class="col-md-12">
                                    <div class="form-floating my-3">
                                        <input type="text" class="form-control" name="landmark" required="" value="{{ $address->landmark }}">
                                        <label for="landmark">Landmark *</label>
                                        <span class="text-danger"></span>
                                    </div>
                                </div>
                                @error('landmark') <span class="alert alert-danger text-center">{{$message}}</span>@enderror

                            </div>
                        @else
                            <div class="row mt-5">
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="name"  value="{{old('name')}}" required="">
                                    <label for="name">Full Name *</label>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                                @error('name') <span class="alert alert-danger text-center">{{$message}}</span>@enderror

                                <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="phone" required="" value="{{old('phone')}}">
                                    <label for="phone">Phone Number *</label>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                                @error('phone') <span class="alert alert-danger text-center">{{$message}}</span>@enderror

                                <div class="col-md-4">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="city" value="{{old('city')}}" required="" >
                                    <label for="city">Town / City *</label>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                                @error('city') <span class="alert alert-danger text-center">{{$message}}</span>@enderror

                                <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="address" required="" value="{{old('address')}}">
                                    <label for="address">House no, Building Name *</label>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                                @error('address') <span class="alert alert-danger text-center">{{$message}}</span>@enderror

                                <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="locality" required="" value="{{old('locality')}}" >
                                    <label for="locality">Road Name, Area, Colony *</label>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                                @error('locality') <span class="alert alert-danger text-center">{{$message}}</span>@enderror

                                <div class="col-md-12">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="landmark" required="" value="{{old('landmark')}}">
                                    <label for="landmark">Landmark *</label>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                                @error('landmark') <span class="alert alert-danger text-center">{{$message}}</span>@enderror

                            </div>
                        @endif
                    </div>
                    <div class="checkout__totals-wrapper">
                        <div class="sticky-content">
                            <div class="checkout__totals">
                                <h3>Your Order</h3>
                                <table class="checkout-cart-items">
                                    <thead>
                                    <tr>
                                        <th>PRODUCT</th>
                                        <th class="text-right">SUBTOTAL</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach(\Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->content() as $item)
                                        <tr>
                                        <td>
                                           {{$item->name}} x {{$item->qty}}

                                        </td>
                                        <td class="text-right">
                                            ${{$item->subtotal()}}
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @if(\Illuminate\Support\Facades\Session::has('discounts'))
                                    <table class="checkout-totals">
                                        <tbody>
                                        <tr>
                                            <th>Subtotal</th>
                                            <td class="text-right">${{Cart::instance('cart')->subTotal()}}</td>
                                        </tr>
                                        <tr>
                                            <th>Discount {{\Illuminate\Support\Facades\Session::get('coupon')['code']}}</th>
                                            <td class="text-right">${{\Illuminate\Support\Facades\Session::get('discounts')['discount']}}</td>
                                        </tr>
                                        <tr>
                                            <th>Subtotal After Discount</th>
                                            <td class="text-right">${{\Illuminate\Support\Facades\Session::get('discounts')['subtotal']}}</td>
                                        </tr>

                                        <tr>
                                            <th>Shipping</th>
                                            <td class="text-right">Free</td>
                                        </tr>
                                        <tr>
                                            <th>TAX</th>
                                            <td class="text-right">${{\Illuminate\Support\Facades\Session::get('discounts')['tax']}}</td>
                                        </tr>
                                        <tr>
                                            <th>Total</th>
                                            <td class="text-right">${{\Illuminate\Support\Facades\Session::get('discounts')['total']}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                @else
                                <table class="checkout-totals">
                                    <tbody>
                                    <tr>
                                        <th>SUBTOTAL</th>
                                        <td class="text-right">${{Cart::instance('cart')->subtotal()}}</td>
                                    </tr>
                                    <tr>
                                        <th>SHIPPING</th>
                                        <td class="text-right">Free shipping</td>
                                    </tr>
                                    <tr>
                                        <th>VAT</th>
                                        <td class="text-right">${{Cart::instance('cart')->tax()}}</td>
                                    </tr>
                                    <tr>
                                        <th>TOTAL</th>
                                        <td class="text-right">${{Cart::instance('cart')->total()}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                @endif
                            </div>
                            <div class="checkout__payment-methods">
                                <div class="form-check">
                                    <input class="form-check-input form-check-input_fill" type="radio" name="mode"
                                           id="mode1" value="card">
                                    <label class="form-check-label" for="mode1">
                                        Debit or Credit Cart
                                        <p class="option-detail">
                                            Phasellus sed volutpat orci. Fusce eget lore mauris vehicula elementum gravida nec dui. Aenean
                                            aliquam varius ipsum, non ultricies tellus sodales eu. Donec dignissim viverra nunc, ut aliquet
                                            magna posuere eget.
                                        </p>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input form-check-input_fill" type="radio" name="mode"
                                           id="mode2" value="paypal">
                                    <label class="form-check-label" for="mode2">
                                        Paypal
                                        <p class="option-detail">
                                            Phasellus sed volutpat orci. Fusce eget lore mauris vehicula elementum gravida nec dui. Aenean
                                            aliquam varius ipsum, non ultricies tellus sodales eu. Donec dignissim viverra nunc, ut aliquet
                                            magna posuere eget.
                                        </p>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input form-check-input_fill" type="radio" name="mode"
                                           id="mode3" value="cod">
                                    <label class="form-check-label" for="mode3">
                                        Cash on Delivery
                                        <p class="option-detail">
                                            Phasellus sed volutpat orci. Fusce eget lore mauris vehicula elementum gravida nec dui. Aenean
                                            aliquam varius ipsum, non ultricies tellus sodales eu. Donec dignissim viverra nunc, ut aliquet
                                            magna posuere eget.
                                        </p>
                                    </label>
                                </div>
                                <div class="policy-text">
                                    Your personal data will be used to process your order, support your experience throughout this
                                    website, and for other purposes described in our <a href="terms.html" target="_blank">privacy
                                        policy</a>.
                                </div>
                            </div>
                            <button class="btn btn-primary btn-checkout">PLACE ORDER</button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>
@endsection
