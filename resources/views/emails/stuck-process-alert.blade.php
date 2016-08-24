@extends('layouts.client-email')


@section('top_content')
    <br/>
    <h3>{{ $process }} ALERT</h3>
    <br/>
    <p>
        <b>Processor has been running for {{ (int) ($process_time / 60) }} hours and {{ $process_time % 60 }} minutes.</b>
    </p>
    <p>
        {{ $process }} processor has been locked for {{ (int) ($process_time / 60) }} hours and {{ $process_time % 60 }} minutes.
    </p>

    <p>Last timestamp is <b>{{ $timestamp }}</b>.</p>
    <p>Please check server.</p>

@endsection