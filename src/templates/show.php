<?php
use Illuminate\Support\Str;

$model = strtolower($Model);
$models = Str::plural($model);
$Models = Str::plural($Model);
?>
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $<?= $model ?>->name }}</div>

                <div class="card-body">
                    <p>Name: {{ $<?= $model ?>->name }}</p>

                    <div>
                        <a class="btn btn-primary"
                           href="{{ action('<?= $Model ?>Controller@edit', ['<?= $model ?>' => $<?= $model ?>]) }}">
                            <?= $icons['edit'] ?> Edit
                        </a>

                        <form method="POST"
                              action="{{ action('<?= $Model ?>Controller@destroy',
                                  ['<?= $model ?>' => $<?= $model ?>]) }}"
                              style="display: inline-block">
                            {{ csrf_field() }}
                            {{ method_field("DELETE") }}
                            <button class="btn btn-danger">
                                <?= $icons['delete'] ?> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
