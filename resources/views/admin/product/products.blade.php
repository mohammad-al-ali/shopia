@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>All Products</h3>
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
                        <div class="text-tiny">All Products</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">

                    <a class="tf-button style-1 w208" href="{{route('admin.product.create')}}"><i
                            class="icon-plus"></i>Add new</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        @if(\Illuminate\Support\Facades\Session::has('status'))
                            <p class="alert alert-success">{{\Illuminate\Support\Facades\Session::get('status')}}</p>
                        @endif
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Sale Price</th>
                            <th>Warehouse Price</th>
                           <th>Category</th>
                            <th>Brand</th>
                            <th>Featured</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{$product->id}}</td>
                            <td class="pname">
                                <div class="image">
                                    <img src="{{asset('storage/products_image/' . $product->image)}}" alt="{{$product->name}}" class="image">
                                </div>
                                <div class="name">
                                    <a href="#" class="body-title-2">{{$product->name}}</a>
                                    <div class="text-tiny mt-3"></div>
                                </div>
                            </td>

                            <td>${{$product->regular_price}}</td>
                            <td>${{$product->sale_price}}</td>
                            <td>${{$product->warehouse_price}}</td>
                            <td>{{$product->category->name}}</td>
                            <td>{{$product->brand->name}}</td>
                            <td>{{$product->featured == 1 ?'YES':'NO'}}</td>
                            <td>{{$product->quantity}}</td>
                            <td>
                                <div class="list-icon-function">
                                    <a href="{{route('product.details',['slug'=>$product->slug])}}" target="_blank">
                                        <div class="item eye">
                                            <i class="icon-eye"></i>
                                        </div>
                                    </a>
                                    <a href="{{route('admin.product.edit',['id' => $product->id])}}">
                                        <div class="item edit">
                                            <i class="icon-edit-3"></i>
                                        </div>
                                    </a>
                                    <form action="{{ route('admin.product.delete', ['id' => $product->id]) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="item text-danger delete">
                                            <i class="icon-trash-2"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{ $products->links('pagination::bootstrap-5') }}

                </div>
            </div>
        </div>
    </div>
@endsection

