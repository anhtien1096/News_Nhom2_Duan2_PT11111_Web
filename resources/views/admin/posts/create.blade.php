@extends('layouts.admin')

@section('title', trans('admin.post.create'))

@section('styles')
    {!! Html::style('plugins/select2/select2.css') !!}
@endsection

@section('scripts')

{!! Html::script('plugins/select2/select2.full.min.js') !!}
{!! Html::script('/js/select2_edit.js') !!}

{!! Html::script('plugins/laravel-ckfinder/ckfinder.js') !!}
{!! Html::script('plugins/laravel-ckeditor/ckeditor.js') !!}
{!! Html::script('plugins/laravel-ckeditor/adapters/jquery.js') !!}
{!! Html::script('js/ckeditor-custom.js') !!}
<script>
    $('#description').ready(function(){
        ckeditor("description");
    });
    $('#content').ready(function(){
        ckeditor("content");
    });
    $('#thumbnail').click(function(){
        BrowseServer();
    });
</script>
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">@lang('admin.post.create')</h3>
        </div>
        <div class="box-body">
        {!! Form::model($posts, ['method' => is_active('posts.create') ? 'POST' : 'PUT', 'autocomplete' => 'off', 'route' => is_active('posts.create') ? 'posts.store': ['posts.update', $posts->id]]) !!}

            <div class="col-md-8">
                    <div class="form-group {!! $errors->has('title') ? 'has-error' : '' !!}">
                        {!! Form::label('title', trans('admin.post.title')) !!}
                        {!! Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => trans('admin.post.title')]) !!}
                        @if($errors->has('title'))
                            <span class="help-block">{!! $errors->first('title') !!}</span>
                        @endif
                    </div>
                    <div class="form-group {!! $errors->has('description') ? 'has-error' : '' !!}">
                        {!! Form::label('description', trans('admin.post.description')) !!}
                        {!! Form::textarea('description', old('description'), ['class' => 'form-control', 'id' => 'description', 'placeholder' => trans('admin.post.description')]) !!}
                        @if($errors->has('description'))
                            <span class="help-block">{!! $errors->first('description') !!}</span>
                        @endif
                    </div>
                    <div class="form-group {!! $errors->has('content') ? 'has-error' : '' !!}">
                        {!! Form::label('content', trans('admin.post.content')) !!}
                        {!! Form::textarea('content', old('content'), ['class' => 'form-control', 'id' => 'content', 'content' => trans('admin.post.content')]) !!}
                        @if($errors->has('content'))
                            <span class="help-block">{!! $errors->first('content') !!}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group {!! $errors->has('cate_id') ? 'has-error' : '' !!}">
                        {!! Form::label('cate_id', trans('admin.post.cate')) !!}
                        {!! Form::select('cate_id', $categories, null ,['class' => 'form-control', 'placeholder' => '--CHỌN CHUYÊN MỤC--']) !!}
                        @if($errors->has('cate_id'))
                            <span class="help-block">{!! $errors->first('cate_id') !!}</span>
                        @endif
                    </div>
                    <div class="form-group {!! $errors->has('type') ? 'has-error' : '' !!}">
                        {!! Form::label('type', trans('admin.post.type')) !!}
                        {!! Form::select('type', ['Văn bản', 'Hình ảnh', 'Video'], 0 ,['class' => 'form-control']) !!}
                        @if($errors->has('type'))
                            <span class="help-block">{!! $errors->first('type') !!}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-6">
                            {!! Form::label('thumbnail', trans('admin.post.thumbnail')) !!}
                            </div>
                            <div class="col-xs-6">
                                <div class="pull-right">
                                {!! Form::text('click', 'Chọn ảnh...', ['class' => 'btn btn-xs btn-default', 'id' => 'thumbnail']) !!}
                                {!! Form::text('thumbnail', old('thumbnail'), ['class' => 'hidden', 'id' => 'urlimg']) !!}
                                </div>
                            </div>
                        </div>

                        {!! Form::image(is_active('posts.create') ? '/uploads/img/default-thumbnail.jpg' : $posts->thumbnail,'',['class' => 'img-responsive', 'id' => 'url']) !!}

                        @if($errors->has('thumbnail'))
                            <span class="help-block">{!! $errors->first('thumbnail') !!}</span>
                        @endif
                    </div>

                    <div class="form-group pull-right">
                        {!! Form::submit(trans('admin.post.submit'), ['class' => 'btn btn-lg btn-primary']) !!}
                    </div>
                </div>    
            {!! Form::close() !!}
        </div>
    </div>
@endsection

