@extends('layouts.app')

@section('title', 'Wall of shame')

@section('content')

    <h1>{{ trans('battlemetrics::user.banlist.title') }}</h1>

    <div class="row">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th scope="col">{{ trans('battlemetrics::user.banlist.steamid') }}</th>
                        <th scope="col">{{ trans('battlemetrics::user.banlist.reason') }}</th>
                        <th scope="col">{{ trans('battlemetrics::user.banlist.timestamp') }}</th>
                        <th scope="col">{{ trans('battlemetrics::user.banlist.expires_at') }}</th>
                        <th scope="col">{{ trans('battlemetrics::user.banlist.organization_wide') }}</th>
                    </tr>
                    </thead>

                    @foreach($bans as $ban)
                        <tr>
                            <td>
                                <a href='https://steamid.io/lookup/{{$ban->steam_id}}' target="_blank">
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
                                    {{ trans('battlemetrics::user.banlist.permanent_ban') }}
                                @endif
                            </td>
                            <td>
                                <span class="badge @if($ban->organization_wide) bg-danger @else bg-success @endif">
                                    @if ($ban->organization_wide)
                                        {{ trans('battlemetrics::user.banlist.yes') }}
                                    @else
                                        {{ trans('battlemetrics::user.banlist.no') }}
                                    @endif
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <p>&nbsp;</p>
        <div class="pagination-outer">
            <div class="col-lg-12">
                {{ $bans->links() }}
            </div>
        </div>
    </div>
@endsection
