@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-10">
        <table class="table table-condensed">
            <thead>
                <tr>
                    <td>Proveddor</td>
                    <td>Precio</td>
                    <td>Fecha de Servicio</td>
                    <td>Restriccion Alimentaria</td>
                    <td>Dirección</td>                    
                    <td>Client</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $item)
                <tr>
                    <td>{{$item->supplier}}</td>
                    <td>{{$item->subtotal}}</td>
                    <td>{{$item->date_service}}</td>
                    <td>{{$item->restriction}}</td>
                    <td>{{$item->address}}</td>
                    
                    <td>{{$item->client}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<script src="/js/orders/index.js"></script>
@endsection
