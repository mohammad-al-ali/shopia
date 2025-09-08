@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Category</h3>
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
                        <div class="text-tiny">Category</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">

                    <a class="tf-button style-1 w208" href="{{route('admin.category.create')}}"><i
                            class="icon-plus"></i>Add new</a>
                </div>
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        @if(\Illuminate\Support\Facades\Session::has('status'))
                            <p class="alert alert-success">{{\Illuminate\Support\Facades\Session::get('status')}}</p>
                        @endif

                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Parent_Category_Id</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{$category->id}}</td>
                                    <td>{{$category->parent_category_id}}</td>
                                    <td class="image">
                                        <div class="name">
                                            <a href="#" class="body-title-2">{{$category->name}}</a>
                                        </div>
                                    </td>
                                    <td>{{$category->description}}</td>
                                    <td>
                                        <div class="list-icon-function">
                                            <a href="{{route('admin.category.edit',['id'=>$category->id])}}">
                                                <div class="item edit">
                                                    <i class="icon-edit-3"></i>
                                                </div>
                                            </a>
                                            <form action="{{ route('admin.category.delete', ['id' => $category->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE') <!-- ✅ تحديد نوع الطلب كـ DELETE -->

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

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

