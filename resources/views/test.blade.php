@extends('layouts.admin')
@section('content')
    <div class="main-content">
        <div class="main-content-inner">
            <div class="main-content-wrap">
                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                    <h3>Product information</h3>
                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                        <li>
                            <a href="#">
                                <div class="text-tiny">Dashboard</div>
                            </a>
                        </li>
                        <li>
                            <i class="icon-chevron-right"></i>
                        </li>
                        <li>
                            <a href="#">
                                <div class="text-tiny">Products</div>
                            </a>
                        </li>
                        <li>
                            <i class="icon-chevron-right"></i>
                        </li>
                        <li>
                            <div class="text-tiny">New Product</div>
                        </li>
                    </ul>
                </div>
                <div class="wg-box">
                    <form class="form-new-product form-style-1" action="{{route('admin.product.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <fieldset class="name">
                            <div class="body-title">Product Name <span class="tf-color-1">*</span></div>
                            <input class="flex-grow" type="text" placeholder="Product name" name="name"
                                   tabindex="0" value="{{old('name')}}" aria-required="true" required="">
                        </fieldset>
                        @error('name') <span class="alert alert-danger text-center">{{$message}}</span>@enderror
                        <fieldset class="description">
                            <div class="body-title">Product  Description<span class="tf-color-1">*</span></div>
                            <input class="flex-grow" type="text" placeholder="Product Description" name="description"
                                   tabindex="0" value="{{old('description')}}">
                        </fieldset>
                        @error('description') <span class="alert alert-danger text-center">{{$message}}</span>@enderror

                        <fieldset class="short_description">
                            <div class="body-title">Product  Short Description<span class="tf-color-1">*</span></div>
                            <input class="flex-grow" type="text" placeholder="Product Short Description" name="short_description"
                                   tabindex="0" value="{{old('short_description')}}">
                        </fieldset>
                        @error('short_description') <span class="alert alert-danger text-center">{{$message}}</span>@enderror
                        <fieldset class="slug">
                            <div class="body-title">Product  Slug<span class="tf-color-1">*</span></div>
                            <input class="flex-grow" type="text" placeholder="Product Slug" name="slug"
                                   tabindex="0" value="{{old('slug')}}">
                        </fieldset>
                        @error('slug') <span class="alert alert-danger text-center">{{$message}}</span>@enderror
                        <fieldset class="regular_price">
                            <div class="body-title">Product Price <span class="tf-color-1">*</span></div>
                            <input class="flex-grow" type="number" step="0.01" placeholder="Product regular_price" name="regular_price"
                                   tabindex="0" value="{{old('regular_price')}}" aria-required="true"  >
                        </fieldset>
                        @error('regular_price') <span class="alert alert-danger text-center">{{$message}}</span>@enderror<fieldset class="sale_price">
                            <div class="body-title">Product Sale Price <span class="tf-color-1">*</span></div>
                            <input class="flex-grow" type="number" step="0.01" placeholder="Product sale_price" name="sale_price"
                                   tabindex="0" value="{{old('sale_price')}}" >
                        </fieldset>
                        @error('sale_price') <span class="alert alert-danger text-center">{{$message}}</span>@enderror
                        <fieldset class="featured">
                            <div class="body-title">Product featured  <span class="tf-color-1">*</span></div>
                            <input class="flex-grow" type="checkbox" placeholder="featured" name="featured"
                                   tabindex="0" value="" >
                        </fieldset>
                        @error('featured') <span class="alert alert-danger text-center">{{$message}}</span>@enderror

                        <fieldset class="warehouse_price">
                            <div class="body-title">Product Warehouse_price <span class="tf-color-1">*</span></div>
                            <input class="flex-grow" type="number" step="0.01" placeholder="Product Warehouse_price" name="warehouse_price"
                                   tabindex="0" value="{{old('warehouse_price')}}" aria-required="true" >
                        </fieldset>
                        @error('warehouse_price') <span class="alert alert-danger text-center">{{$message}}</span>@enderror
                        <fieldset class="quantity">
                            <div class="body-title">Product Warehouse_price <span class="tf-color-1">*</span></div>
                            <input class="flex-grow" type="number" step="1" placeholder="Product quantity" name="quantity"
                                   tabindex="0" value="{{old('quantity')}}" aria-required="true" >
                        </fieldset>
                        @error('quantity') <span class="alert alert-danger text-center">{{$message}}</span>@enderror
                        <fieldset class="brand_id">
                            <div class="body-title">Product Brand_id <span class="tf-color-1">*</span></div>
                            <input class="flex-grow" type="number" placeholder="Product Brand_id" name="brand_id"
                                   tabindex="0" value="{{old('brand_id')}}" aria-required="true" >
                        </fieldset>
                        @error('brand_id') <span class="alert alert-danger text-center">{{$message}}</span>@enderror
                        <fieldset class="category_id">
                            <div class="body-title">Product Category_id <span class="tf-color-1">*</span></div>
                            <input class="flex-grow" type="number" placeholder="Product Category_id" name="category_id"
                                   tabindex="0" value="{{old('category_id')}}" aria-required="true" >
                        </fieldset>
                        @error('category_id') <span class="alert alert-danger text-center">{{$message}}</span>@enderror
                        <fieldset>
                            <div class="body-title">Upload images <span class="tf-color-1">*</span>
                            </div>
                            <div class="upload-image flex-grow">
                                <div class="item" id="imgpreview" style="display:none">
                                    <img src="upload-1.html" class="effect8" alt="">
                                </div>
                                <div id="upload-file" class="item up-load">
                                    <label class="uploadfile" for="myFile">
                                                        <span class="icon">
                                                            <i class="icon-upload-cloud"></i>
                                                        </span>
                                        <span class="body-text">Drop your images here or select <span
                                                class="tf-color">click to browse</span></span>
                                        <input type="file" id="myFile" name="image" accept="image/*">
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                        @error('image') <span class="alert alert-danger text-center">{{$message}}</span>@enderror


                        <div class="bot">
                            <div></div>
                            <button class="tf-button w208" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="bottom-page">
            <div class="body-text">>Copyright ©2025 KARA</div>
        </div>
    </div>
@endsection




// ✅ حفظ المنتج مع أسماء الصور
Product::create([
'name'   => $request->name,
]);

return back()->with('success', 'تمت إضافة المنتج بنجاح!')
