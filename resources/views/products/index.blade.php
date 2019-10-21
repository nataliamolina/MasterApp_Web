@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-10">
        <table class="table table-condensed">
            <thead>
                <tr>
                    <td>Foto</td>
                    <td>Titulo</td>
                    <td>Descripción</td>
                    <td>Precio</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $item)
                <tr>
                    <td><img src="/{{$item->url_image}}" width="10%"/></td>
                    <td>{{$item->title}}</td>
                    <td>{{$item->description}}</td>
                    <td>{{$item->price}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<script src="/js/orders/index.js"></script>
@endsection
