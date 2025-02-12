@extends('layouts.tabler')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center mb-3">
                <div class="col">
                    <h2 class="page-title">
                        {{ $inventory->name }}
                    </h2>
                </div>

                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('inventory.edit', $inventory->uuid) }}"
                            class="btn btn-warning d-none d-sm-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                <path d="M13.5 6.5l4 4" />
                            </svg>
                            {{ __('Edit') }}
                        </a>
                    </div>
                </div>
            </div>

            @include('partials._breadcrumbs')
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">
                                {{ __('Product Image') }}
                            </h3>

                            <img style="width: 90px;" id="image-preview"
                                src="{{ $product->product_image ? asset('storage/' . $product->product_image) : asset('assets/img/products/default.webp') }}"
                                alt="" class="img-account-profile mb-2">
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                {{ __('Inventory Details') }}
                            </h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered card-table table-vcenter text-nowrap datatable">
                                <tbody>
                                    <tr>
                                        <td>Name</td>
                                        <td>{{ $inventory->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Code</td>
                                        <td>{{ $inventory->code }}</td>
                                    </tr>
                                    <tr>
                                        <td>Quantity</td>
                                        <td>{{ $inventory->quantity }}</td>
                                    </tr>
                                    <tr>
                                        <td>Unit Price</td>
                                        <td>{{ $inventory->selling_price }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Price</td>
                                        <td>{{ $inventory->quantity * $inventoryItem->selling_price }}</td>
                                    </tr>
                                    <tr>
                                        <td>Category</td>
                                        <td>
                                            <a href="{{ route('categories.show', $inventory->category) }}"
                                                class="badge bg-blue-lt">
                                                {{ $inventory->category->name }}
                                            </a>
                                        </td>
                                    </tr>
                                    <!-- Add other inventory details as needed -->
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer text-end">
                            <a class="btn btn-info" href="{{ url()->previous() }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M5 12l14 0" />
                                    <path d="M5 12l6 6" />
                                    <path d="M5 12l6 -6" />
                                </svg>
                                {{ __('Back') }}
                            </a>
                            <a class="btn btn-warning" href="{{ route('inventory.edit', $inventory->uuid) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                    <path d="M13.5 6.5l4 4" />
                                </svg>
                                {{ __('Edit') }}
                            </a>                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection