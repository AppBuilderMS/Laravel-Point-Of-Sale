@extends('layouts.dashboard.app')
@section('content')
<section class="content-header" style="margin-bottom: 20px">
    <h1>
        @lang('site.categories')
    </h1>
    <ol class="breadcrumb">
        <li><i class="fa fa-dashboard"></i> <a href="{{route('dashboard.welcome')}}">@lang('site.dashboard')</a></li>
        <li><a href="{{route('dashboard.categories.index')}}">@lang('site.categories')</a></li>
        <li class="active">@lang('site.edit')</li>
    </ol>
</section>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title" style="margin-bottom: 10px">@lang('site.edit')</h3>
    </div><!-- /end of box-header -->

    <div class="box-body">
        @include('partials._errors')

        <form action="{{route('dashboard.categories.update', $category->id)}}" method="POST">
            @csrf
            @method('PUT')

            @foreach (config('translatable.locales') as $locale)
                <div class="form-goup" style="margin-bottom: 10px">
                    <label for="name">@lang('site.'.$locale.'.name')</label>
                    <input type="text" name="{{$locale}}[name]" class="form-control" value="{{$category->translate($locale)->name}}">
                </div>
            @endforeach

            <div class="form-group" style="margin-bottom: 10px">
                <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> @lang('site.edit')</button>
            </div>
        </form>
    </div><!-- end of box-body -->
</div>
@endsection
