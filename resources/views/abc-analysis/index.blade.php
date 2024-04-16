@extends('layouts.tabler')

@section('content')
    <div class="container">
        <h1>ABC Analysis</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Percentage</th>
                    <th>Cumulative Percentage</th>
                    <th>Classification</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sortedProducts as $key => $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->percentage }}%</td>
                        <td>{{ $product->cumulativePercentage }}%</td>
                        <td>{{ $product->classification }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection