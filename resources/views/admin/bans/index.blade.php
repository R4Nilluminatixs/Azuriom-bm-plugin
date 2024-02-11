@php use Illuminate\Support\Str; @endphp

@extends('admin.layouts.admin')

@section('title', trans('battlemetrics::admin.nav.ban_list'))

@section('content')
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">{{ trans('battlemetrics::admin.bans.battlemetrics_id') }}</th>
                <th scope="col">{{ trans('battlemetrics::admin.bans.organization_id') }}</th>
                <th scope="col">{{ trans('battlemetrics::admin.bans.user') }}</th>
                <th scope="col">{{ trans('battlemetrics::admin.bans.steam_id') }}</th>
                <th scope="col">{{ trans('battlemetrics::admin.bans.reason') }}</th>
                <th scope="col">{{ trans('battlemetrics::admin.bans.timestamp') }}</th>
                <th scope="col">{{ trans('battlemetrics::admin.bans.expires_at') }}</th>
                <th scope="col">{{ trans('battlemetrics::admin.bans.actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($bans as $ban)
                <tr>
                    <td>
                        <a href="{{ route('battlemetrics.admin.bans.show', ['ban' => $ban->id]) }}">{{ $ban->id }}</a>
                    </td>
                    <td>
                        <a href='https://www.battlemetrics.com/rcon/bans/edit/{{ $ban->battlemetrics_id }}' target="_blank">
                            {{ $ban->battlemetrics_id }}
                        </a>
                    </td>
                    <td>
                        <a href='https://www.battlemetrics.com/rcon/orgs/edit/{{ $ban->organization_id }}' target="_blank">
                            {{ $ban->organization_id }}
                        </a>
                    </td>
                    <td>
                        @if ($ban->user !== null)
                            <a href="{{ route('admin.users.edit', ['user' => $ban->user_id]) }}">{{ $ban->user->name }}</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <a href='https://steamcommunity.com/profiles/{{ $ban->steam_id }}' target="_blank">
                            {{ $ban->steam_id }}
                        </a>
                    </td>
                    <td @if (Str::length($ban->reason) > 30) title="{{$ban->reason}}" @endif>
                        {{ Str::limit($ban->reason, 30) }}
                    </td>
                    <td>
                        {{ $ban->timestamp }}
                    </td>
                    <td>
                        @if ($ban->expires_at !== null)
                            {{ $ban->expires_at }}
                        @else
                            {{ trans('battlemetrics.admin.bans.permanently_banned') }}
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('battlemetrics.admin.bans.show', ['ban' => $ban->id]) }}">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $bans->links() }}
    </div>
    <div class="row">
        <div class="text-right mb-2">
            <a class="btn btn-success" href="{{ route('battlemetrics.admin.bans.sync.all') }}" role="button">
                {{ trans('battlemetrics::admin.ban.links.ban_sync_all') }}
            </a>
        </div>
    </div>
@endsection
