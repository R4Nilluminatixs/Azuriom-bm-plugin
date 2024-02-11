@extends('admin.layouts.admin')

@section('title', trans('battlemetrics::admin.nav.ban_view'))

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="mb-3">
                <b>{{ trans('battlemetrics::admin.ban.battlemetrics_id') }}:</b>
                <p>
                    <a href='https://www.battlemetrics.com/rcon/bans/edit/{{ $battlemetrics_id }}' target="_blank">
                        {{ $battlemetrics_id }}
                    </a>
                </p>
            </div>
            <div class="mb-3">
                <b>{{ trans('battlemetrics::admin.ban.organization_id') }}:</b>
                <p>
                    <a href='https://www.battlemetrics.com/rcon/orgs/edit/{{ $organization_id }}' target="_blank">
                        {{ $organization_id }}
                    </a>
                </p>
            </div>
            <div class="mb-3">
                <b>{{ trans('battlemetrics::admin.ban.user') }}:</b>
                <p>
                    @if ($user)
                        <a href="{{ route('admin.users.edit', ['user' => $user->id]) }}">{{ $user->name }}</a>
                    @else
                        {{ trans('battlemetrics::admin.ban.no_connected_user') }}
                    @endif
                </p>
            </div>
            <div class="mb-3">
                <b>{{ trans('battlemetrics::admin.ban.steam_id') }}:</b>
                <p>
                    <a href='https://steamcommunity.com/profiles/{{ $steam_id }}'
                       target="_blank">{{ $steam_id }}
                    </a>
                </p>
            </div>
            <div class="mb-3">
                <b>{{ trans('battlemetrics::admin.ban.reason') }}:</b>
                <p>{{ $reason }}</p>
            </div>
            <div class="mb-3">
                <b>{{ trans('battlemetrics::admin.ban.note') }}:</b>
                <p>{{ $note }}</p>
            </div>
            <div class="mb-3">
                <b>{{ trans('battlemetrics::admin.ban.timestamp') }}:</b>
                <p>{{ $timestamp }}</p>
            </div>
            <div class="mb-3">
                <b>{{ trans('battlemetrics::admin.ban.expires_at') }}:</b>
                <p>{{ $expires_at }}</p>
            </div>
            <div class="mb-3">
                <b>{{ trans('battlemetrics::admin.ban.organization_wide') }}:</b>
                <p>@if ($organization_wide) {{ trans('battlemetrics::admin.ban.yes') }} @else {{ trans('battlemetrics::admin.ban.no') }} @endif</p>
            </div>
            <div class="mb-3">
                <b>{{ trans('battlemetrics::admin.ban.auto_add_enabled') }}:</b>
                <p>@if ($auto_add_enabled) {{ trans('battlemetrics::admin.ban.yes') }} @else {{ trans('battlemetrics::admin.ban.no') }} @endif</p>
            </div>
            <div class="mb-3">
                <b>{{ trans('battlemetrics::admin.ban.native_enabled') }}:</b>
                <p>@if ($organization_wide) {{ trans('battlemetrics::admin.ban.yes') }} @else {{ trans('battlemetrics::admin.ban.no') }} @endif</p>
            </div>
            <div class="mb-3">
                <b>{{ trans('battlemetrics::admin.ban.last_sync') }}:</b>
                <p>
                    {{ $last_sync }}
                </p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="text-right mb-2">
            <a class="btn btn-primary" href="https://www.battlemetrics.com/rcon/bans/edit/{{ $battlemetrics_id }}" role="button" target="_blank">
                {{ trans('battlemetrics::admin.ban.links.ban') }}
            </a>
            <a class="btn btn-success" href="{{ route('battlemetrics.admin.bans.sync', ['ban' => $id]) }}" role="button">
                {{ trans('battlemetrics::admin.ban.links.ban_sync') }}
            </a>
        </div>
    </div>
@endsection
inks.ban') }}
            </a>
            <a class="btn btn-success" href="{{ route('battlemetrics.admin.bans.sync', ['ban' => $id]) }}"
               role="button">
                {{ trans('battlemetrics::admin.ban.links.ban_sync') }}
            </a>
        </div>
    </div>
@endsection
