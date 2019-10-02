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
                <div class="card-header"><?= $Model ?></div>

                <div class="card-body">
                    @if (!$<?= $model ?>->exists)
                    <form method="POST" action="{{ action("<?= $Model ?>Controller@store") }}">
                    @else
                    <form method="POST"
                          action="{{ action("<?= $Model ?>Controller@update", ["<?= $model ?>" => $<?= $model ?>]) }}">
                    {{ method_field("PUT") }}
                    @endif
                        {{ csrf_field() }}

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text"
                                       class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                       name="name"
                                       value="{{ old('name', $<?= $model ?>->name) }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <?= $icons['ok'] ?> Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
