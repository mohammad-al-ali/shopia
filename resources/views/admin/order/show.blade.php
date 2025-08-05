@extends('layouts.admin')
@section('content')
    <style>
        .table-transaction>tbody>tr:nth-of-type(odd) {
            --bs-table-accent-bg: #fff !important;
        }
    </style>
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Order Details</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{route('admin.index')}}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Order Details</div>
                    </li>
                </ul>
            </div>
            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <h5>Ordered Details</h5>
                    </div>
                    <a class="tf-button style-1 w208" href="{{route('admin.order.orders')}}">Back</a>
                </div>
                <div class="table-responsive">
                    @if(\Illuminate\Support\Facades\Session::has('status'))
                        <p class="alert alert-success">{{\Illuminate\Support\Facades\Session::get('status')}}</p>
                    @endif
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>Order Number</th>
                               <td>{{$order->id}}</td>
                        </tr>
                        <tr>
                            <th>Order Date</th>
                               <td>{{$order->created_at}}</td>
                            <th>Delivered Date</th>
                               <td>{{$order->delivered_date}}</td>
                            <th>Canceled Date</th>
                               <td>{{$order->canceled_date}}</td>
                        </tr>
                        <tr>
                            <th>Order Status</th>
                            <td colspan="5">
                                @if($order->status ==='delivered')
                                    <span class="badge bg-success">Delivered</span>
                                @elseif($order->status ==='canceled')
                                    <span class="badge bg-danger">Canceled</span>
                                @else
                                    <span class="badge bg-warning">Processing</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                     <th>Payment Status</th>
                            <td colspan="6">
                                @if($order->payment_status ==='completed')
                                    <span class="badge bg-success">Completed</span>
                                @elseif($order->payment_status ==='failed')
                                    <span class="badge bg-danger">Failed</span>
                                @elseif($order->payment_status ==='pending')
                                    <span class="badge bg-warning">Processing</span>
                                @else
                                    <span class="badge bg-warning">Refunded</span>
                                @endif
                            </td>
                            <td>
                            <th>Payment Method</th>
                            <td colspan="5">
                                @if($payment->payment_method ==='card')
                                    <span class="badge bg-success">Debit or Credit Cart</span>
                                @elseif($payment->payment_method ==='paypal')
                                    <span class="badge bg-danger">PayPal</span>
                                @else
                                    <span class="badge bg-warning">Cask on Delivered</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <h5>Ordered Items</h5>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th class="text-center">Unit Price × Quantity =Price</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">Brand</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orderItems as $item)
                        <tr>

                            <td class="pname">
                                <div class="image">
                                    <img src="{{asset('storage/products_image/' . $item->product->image)}}" alt="{{$item->product->name}}" class="image">
                                </div>
                                <div class="name">
                                    <a href="{{route('product.details',['slug'=>$item->product->slug])}}" target="_blank"
                                       class="body-title-2">{{$item->product->name}}</a>
                                </div>
                            </td>
                            <td class="text-center">{{$item->unit_price}}×{{$item->quantity}} = ${{$item->unit_price * $item->quantity}}</td>
                            <td class="text-center">{{$item->product->category->name}}</td>
                            <td class="text-center">{{$item->product->brand->name}}</td>
<td> <a href="{{route('product.details',['slug'=>$item->product->slug])}}" target="_blank">
        <div class="item eye">
            <i class="icon-eye"></i>
        </div>
    </a></td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{ $orderItems->links('pagination::bootstrap-5') }}
                </div>
            </div>

            <div class="wg-box mt-5">
                <h5>Shipping Address</h5>
                <div class="my-account__address-item col-md-6">
                    <div class="my-account__address-item__detail">
                        <p>{{$order->name}}</p>
                        <p>{{$order->address}}</p>
                        <p>{{$order->location}}</p>
                        <p>{{$order->city}}</p>
                        <p>{{$order->landmark}}</p>
                        <br>
                        <p>{{$order->phone}}</p>
                    </div>
                </div>
            </div>

            <div class="wg-box mt-5">
                <h5>Transactions</h5>
                <table class="table table-striped table-bordered table-transaction">
                    <tbody>
                    <tr>
                        <th>Subtotal</th>
                        <td class="text-right">${{$order->subtotal}}</td>
                        <th>Tax</th>
                        <td class="text-right">${{$order->tax}}</td>
                        <th>Discount</th>+
                        <td class="text-right">${{$order->discount}}</td>
                        <th>Total</th>
                        <td class="text-right">${{$payment->amount}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="wg-box mt-5">
                <h2>Order Status</h2>
                <label for="order_status">Select order status:</label>
            <form action="{{route('admin.order.update')}}" method="POST">
                @csrf
                @method('put')
                <input type="hidden" name="order_id" value="{{$order->id}}">
                <div class="row">
                    <div class="col-md-5">
                     <div class="select">
                         <select id="order_status" name="order_status">
                             <option value="processing"  {{$order->status=='processing' ? 'selected' : ''}}>Processing</option>
                             <option value="shipped" {{$order->status=='shipped' ? 'selected' : ''}}>Shipped</option>
                             <option value="delivered"   {{$order->status=='delivered' ? 'selected' : ''}}>Delivered</option>
                             <option value="canceled"    {{$order->status=='canceled' ? 'selected' : ''}}>Canceled</option>
                         </select>
                     </div>
                    </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary tf-button w208">Update</button>
                </div>
                </div>
            </form>
            </div>
{{--            <script>--}}
{{--                function updateStatus() {--}}
{{--                    var status = document.getElementById("order_status").value;--}}
{{--                    alert("Order status updated to: " + status);--}}
{{--                }--}}
{{--            </script>--}}
        </div>
    </div>
@endsection
