@extends('layouts.admin')

@section('content')
    <div class="main-content">
        <div class="main-content-inner">
            <div class="main-content-wrap">
                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                    <h3>Category infomation</h3>
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
                                <div class="text-tiny">Category</div>
                            </a>
                        </li>
                        <li>
                            <i class="icon-chevron-right"></i>
                        </li>
                        <li>
                            <div class="text-tiny">New Category</div>
                        </li>
                    </ul>
                </div>
                <!-- new-category -->
                <div class="wg-box">
                    <form class="form-new-product form-style-1" action="{{route('admin.category.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <fieldset class="name">
                            <div class="body-title">Category Name <span class="tf-color-1">*</span></div>
                            <input class="flex-grow" type="text" placeholder="Category name" name="name"
                                   tabindex="0" value="{{old('name')}}" aria-required="true" required="">
                        </fieldset>
                        @error('name') <span class="alert alert-danger text-center">{{$message}}</span>@enderror
                        <fieldset class="slug">
                            <div class="body-title">Parent_Category_Id <span class="tf-color-1">*</span></div>
                            <input class="flex-grow" type="number" placeholder="Parent_Category_Id" name="parent_category_id"
                                   tabindex="0" value="{{old('parent_category_id')}}" >
                        </fieldset>
                        @error('parent_category_id') <span class="alert alert-danger text-center">{{$message}}</span>@enderror

                        <fieldset class="description">
                            <div class="body-title">Category  Description<span class="tf-color-1">*</span></div>
                            <input class="flex-grow" type="text" placeholder="Category Description" name="description"
                                   tabindex="0" value="{{old('description')}}" aria-required="true" required="">
                        </fieldset>
                        @error('description') <span class="alert alert-danger text-center">{{$message}}</span>@enderror


                        <div class="bot">
                            <div></div>
                            <button class="tf-button w208" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="bottom-page">
            <div class="body-text">Copyright ©2025 KARA</div>
        </div>
    </div>
@endsection
