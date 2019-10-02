<?php
use Illuminate\Support\Str;
$model = strtolower($Model);
$models = Str::plural($model);
$Models = Str::plural($Model);
?>
@extends('layouts.app')

@section('title', '<?= $Models ?>')

@section('content')
<div class="container">
    <h1><?= $Models ?></h1>
    <p>
        <a href="{{ action('<?= $Model ?>Controller@create') }}" class="btn btn-primary">
            <?= $icons['new'] ?> New
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
                <a class="btn btn-primary btn-sm"
                   href="{{ action('<?= $Model ?>Controller@show', ['<?= $Model ?>' => $<?= $model ?>]) }}">
                    <?= $icons['show'] ?> Show
                </a>

                <a class="btn btn-primary btn-sm"
                   href="{{ action('<?= $Model ?>Controller@edit', ['<?= $Model ?>' => $<?= $model ?>]) }}">
                    <?= $icons['edit'] ?> Edit
                </a>

                <form method="POST"
                      action="{{ action('<?= $Model ?>Controller@destroy', ['<?= $Model ?>' => $<?= $model ?>]) }}"
                      style="display: inline-block">
                    {{ csrf_field() }}
                    {{ method_field("DELETE") }}
                    <button class="btn btn-danger btn-sm">
                        <?= $icons['delete'] ?> Delete
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
