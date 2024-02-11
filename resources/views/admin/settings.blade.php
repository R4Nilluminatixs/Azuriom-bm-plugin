@extends('admin.layouts.admin')

@include('admin.elements.editor')

@section('title', trans('battlemetrics::admin.settings.title'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('battlemetrics.admin.settings') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="tokenInput">{{ trans('battlemetrics::admin.settings.token') }}
                        *</label>
                    <input type="text" class="form-control @error('token') is-invalid @enderror" id="tokenInput"
                           name="token" placeholder="-" value="{{ old('token', setting('battlemetrics.token')) }}"
                           aria-describedby="tokenInfo" required>

                    @error('token')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror

                    <small id="tokenInfo"
                           class="form-text">{{ trans('battlemetrics::admin.settings.token_info') }}</small>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> {{ trans('messages.actions.save') }}
                </button>
            </form>

        </div>
    </div>
@endsection
