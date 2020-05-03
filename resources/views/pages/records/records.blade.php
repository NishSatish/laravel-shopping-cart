@extends('layouts.app')

@section('content')
    <div class="records">
        <div class="row">
            @if (count($items) > 0)
                @foreach ($items as $item)
                <div class="col-md-4 record-card">
                    <div class="record-box" style="width: 18rem;">
                        <div class="card-body">
                        <h5 class="card-title">{{$item->name}}</h5><span class="badge badge-secondary">${{$item->price}}</span>
                        <p class="card-text">{{$item->about}}</p>
                        <a href="/records/{{$item->id}}" class="btn btn-primary">VIEW MORE</a>
                        <a href="/atc/{{$item->id}}" class="btn btn-success">ADD TO CART</a>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
            <h1>No records available:(</h1>
            @endif
        </div>
    </div>
@endsection
