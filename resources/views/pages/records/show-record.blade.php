@extends('layouts.app')

@section('content')
    <div class="record-display">
        <h1 class="page-header">{{$record->name}}</h1>
        <hr><br>
        <p>
            {{$record->about}}
        </p>

    <a href="/atc/{{$record->id}}" class="btn btn-success">Add to cart</a>
    </div>
@endsection
