@extends('layouts.main')

@section('content')

        <p>{{ $client->clientName }}</p>
        <ul>
        @foreach ($client->clientFiles as $file)
            <li>{{ $file->fileName }}</li>
        @endforeach
        </ul>

@endsection
