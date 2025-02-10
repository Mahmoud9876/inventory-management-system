@extends('layouts.tabler')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <h3 class="mb-4">Gestion du Stock</h3>

        <table class="table">
            <thead>
                <tr>
                    <th>Nom du Produit</th>
                    <th>Quantité</th>
                    <th>Stock Minimum</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr class="{{ $product->quantity < $product->stock_min ? 'table-danger' : 'table-success' }}">
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->stock_min }}</td>
                    <td>
                        <form action="{{ route('stock.update', $product->id) }}" method="POST">
                            @csrf
                            @method('POST')
                            <input type="number" name="stock_min" value="{{ $product->stock_min }}" min="1">
                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
@endsection
