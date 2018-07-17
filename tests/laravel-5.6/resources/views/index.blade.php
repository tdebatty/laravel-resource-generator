@extends('layouts.app')

@section('title', 'Posts')

@section('content')
<div class="container pt30 pb30">
    <h1>Blog posts</h1>
    <p>
        <a href="{{ action('PostController@create') }}" class="btn btn-primary">
            <i class="fa fa-plus-circle"></i>New
        </a>
    </p>

    <table class="table table-striped">
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Published on</th>
            <th></th>
        </tr>
        @foreach($posts as $post)
        <tr>
            <td>{{ $post->title }}</td>
            <td>{{ $post->user->name }}</td>
            <td>{{ $post->timeFormatted() }}</td>
            <td class="text-right">
                <a class="btn btn-primary btn-sm" href="{{ $post->getUrl() }}">
                    <i class="fa fa-search"></i> View
                </a>

                <a class="btn btn-primary btn-sm" href="{{ action('PostController@edit', ['id' => $post->id]) }}">
                    <i class="fa fa-edit"></i>Edit
                </a>

                <form method="POST" action="{{ action('PostController@destroy', ['id' => $post->id]) }}" style="display: inline-block">
                    {{ csrf_field() }}
                    {{ method_field("DELETE") }}
                    <button class="btn btn-danger btn-sm">
                        <i class="fa fa-remove"></i> Delete
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection