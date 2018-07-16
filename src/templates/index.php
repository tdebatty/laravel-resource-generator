<?php
$model = strtolower($Model);
$models = str_plural($model);
$Models = str_plural($Model);
?>
@extends('layouts.app')

@section('title', '<?= $Models ?>')

@section('content')
<div class="container">
    <h1><?= $Models ?></h1>
    <p>
        <a href="{{ action('<?= $Model ?>Controller@create') }}" class="btn btn-primary">
            New
        </a>
    </p>

    <table class="table table-striped">
        <tr>
            <th>Name</th>
            <th></th>
        </tr>
        @foreach($<?= $models ?> as $<?= $model ?>)
        <tr>
            <td>{{ $<?= $model ?>->name }}</td>
            <td class="text-right">
                <a class="btn btn-primary btn-sm" href="{{ action('<?= $Model ?>Controller@show', ['<?= $Model ?>' => $<?= $model ?>]) }}">
                    Show
                </a>

                <a class="btn btn-primary btn-sm" href="{{ action('<?= $Model ?>Controller@edit', ['<?= $Model ?>' => $<?= $model ?>]) }}">
                    Edit
                </a>

                <form method="POST" action="{{ action('<?= $Model ?>Controller@destroy', ['<?= $Model ?>' => $<?= $model ?>]) }}" style="display: inline-block">
                    {{ csrf_field() }}
                    {{ method_field("DELETE") }}
                    <button class="btn btn-danger btn-sm">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection