@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Slides</h3>
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
                        <div class="text-tiny">Sliders</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">

                    <a class="tf-button style-1 w208" href="{{route('admin.slide.create')}}"><i
                            class="icon-plus"></i>Add new</a>
                </div>
                <div class="wg-table table-all-user">
                    <table class="table table-striped table-bordered">
                        @if(\Illuminate\Support\Facades\Session::has('status'))
                            <p class="alert alert-success">{{\Illuminate\Support\Facades\Session::get('status')}}</p>
                        @endif
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Tagline</th>
                            <th>Title</th>
                            <th>Subtitle</th>
                            <th>Link</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($slides as $slide)
                        <tr>
                            <td>{{$slide->id}}</td>
                            <td class="pname">
                                <div class="image">
                                    <img src="{{asset('storage/slides_image/'. $slide->image)}}" alt="{{$slide->title}}" class="image">
                                </div>
                            </td>
                            <td>{{$slide->tagline}}</td>
                            <td>{{$slide->title}}</td>
                            <td>{{$slide->subtitle}}</td>
                            <td>{{$slide->link}}</td>
                            <td>
                                <div class="list-icon-function">
                                    <a href="{{route('admin.slide.edit',['id'=>$slide->id])}}">
                                        <div class="item edit">
                                            <i class="icon-edit-3"></i>
                                        </div>
                                    </a>
                                    <form action="{{ route('admin.slide.delete', ['id' => $slide->id]) }}" method="POST">
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
                    {{ $slides->links('pagination::bootstrap-5') }}

                </div>
            </div>
        </div>
    </div>
@endsection
