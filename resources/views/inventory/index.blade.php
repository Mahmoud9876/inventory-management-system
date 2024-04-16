@extends('layouts.tabler')

@section('content')
<div class="page-body">
    <div class="container-xl">
        @if($inventoryItems->isEmpty())
            <x-empty title="Aucun produit trouvé" message="Essayez d'ajuster votre recherche ou vos filtres pour trouver ce que vous cherchez."
                button_label="{{ __('Ajouter votre premier produit') }}" button_route="{{ route('inventory.create') }}" />

            <div style="text-center" style="padding-top:-25px">
                <center>
                    <a href="{{ route('inventory.import.view') }}" class="">
                        {{ __('Importer des produits') }}
                    </a>
                </center>
            </div>
        @else
            <x-alert />
            <div class="card">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">
                            Inventory
                        </h3>
                    </div>
                                        
                    <div class="card-actions btn-group">
                        <div class="dropdown">
                            <a href="#" class="btn-action dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <svg class="icon">
                                    <!-- Your SVG code for vertical dots icon -->
                                </svg>
                            </a>
                            <div class="card-actions btn-group">
                                <a href="{{ route('inventory.create') }}" class="btn btn-primary">Create</a>
                            </div>
                            <div class="dropdown-menu dropdown-menu-end" style="">
                                <a href="{{ route('inventory.create') }}" class="dropdown-item">
                                    <svg class="icon">
                                        <!-- Your SVG code for plus icon -->
                                    </svg>
                                    Créer un produit
                                </a>
                                <a href="{{ route('inventory.import.view') }}" class="dropdown-item">
                                    <svg class="icon">
                                        <!-- Your SVG code for plus icon -->
                                    </svg>
                                    Importer des produits
                                </a>
                                <a href="{{ route('inventory.export.store') }}" class="dropdown-item">
                                    <svg class="icon">
                                        <!-- Your SVG code for plus icon -->
                                    </svg>
                                    Exporter des produits
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body border-bottom py-3">
                    <div class="d-flex">
                        <div class="text-secondary">
                            Show
                            <div class="mx-2 d-inline-block">
                                <select class="form-select form-select-sm" aria-label="result per page">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="25">25</option>
                                </select>
                            </div>
                            entries
                        </div>
                        <div class="ms-auto text-secondary">
                            Search:
                            <div class="ms-2 d-inline-block">
                                <input type="text" class="form-control form-control-sm"
                                    aria-label="Search invoice">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Spinner component (loading-spinner) goes here -->

                <div class="table-responsive">
                    <table class="table table-bordered card-table table-vcenter text-nowrap datatable">
                        <!-- Table headers -->
                        <thead class="thead-light">
                            <tr>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Stock Physical</th>
                                <th>Total price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inventoryItems as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->code }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->selling_price }}</td>
                                <td>{{ $item->stock_phy }}</td>
                                <td>{{ $item->quantity * $item->selling_price }}</td>
                                <!-- Include action buttons for each item -->
                                <td>
                                    <a href="{{ route('inventory.edit', $item->uuid) }}" class="btn btn-sm btn-primary">Modify</a>
                                    <form action="{{ route('inventory.destroy', $item->uuid) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <p>Total quantity: {{ $totalQuantity }}</p>
            <p>Total price: {{ $totalPrice }}</p>
            <form action="{{ route('inventory.report') }}" method="post">
                @csrf
                <button type="submit" class="btn btn-primary">Generate report</button>
            </form>
        @endif

    </div>
</div>
@endsection
