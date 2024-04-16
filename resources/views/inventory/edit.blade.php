@extends('layouts.tabler')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center mb-3">
                <div class="col">
                    <h2 class="page-title">
                        {{ __('Edit Product') }}
                    </h2>
                </div>
            </div>

            @include('partials._breadcrumbs', ['model' => $inventory])
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">

                <form action="{{ route('inventory.update', $inventory->uuid) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    

                        <div class="col-lg-8">

                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">
                                        {{ __('Product Details') }}
                                    </h3>

                                    <div class="row row-cards">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">
                                                    {{ __('Name') }}
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="text" id="name" name="name"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    placeholder="Product name" value="{{ old('name', $inventory->name) }}">

                                                @error('name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <div class="mb-3">
                                                <label for="category_id" class="form-label">
                                                    Product category
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <select name="category_id" id="category_id"
                                                    class="form-select @error('category_id') is-invalid @enderror">
                                                    <option selected="" disabled="">Select a category:</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            @if (old('category_id', $inventory->category_id) == $category->id) selected="selected" @endif>
                                                            {{ $category->name }}</option>
                                                    @endforeach
                                                </select>

                                                @error('category_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-sm-6 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="unit_id">
                                                    {{ __('Unit') }}
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <select name="unit_id" id="unit_id"
                                                    class="form-select @error('unit_id') is-invalid @enderror">
                                                    <option selected="" disabled="">
                                                        Select a unit:
                                                    </option>

                                                    @foreach ($units as $unit)
                                                        <option value="{{ $unit->id }}"
                                                            @if (old('unit_id', $inventory->unit_id) == $unit->id) selected="selected" @endif>
                                                            {{ $unit->name }}</option>
                                                    @endforeach
                                                </select>

                                                @error('unit_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                            

                                        <div class="col-sm-6 col-md-6">
                                            <div class="mb-3">
                                                <label for="selling_price" class="form-label">
                                                    Selling price
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="text" id="selling_price" name="selling_price"
                                                    class="form-control @error('selling_price') is-invalid @enderror"
                                                    placeholder="0"
                                                    value="{{ old('selling_price', $inventory->selling_price) }}">

                                                @error('selling_price')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <div class="mb-3">
                                                <label for="quantity" class="form-label">
                                                    {{ __('Quantity') }}
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="number" id="quantity" name="quantity"
                                                    class="form-control @error('quantity') is-invalid @enderror"
                                                    min="0" value="{{ old('quantity', $inventory->quantity) }}"
                                                    placeholder="0">

                                                @error('quantity')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6">
                                            <div class="mb-3">
                                                <label for="stock_phy" class="form-label">
                                                    {{ __('Stock physique') }}
                                                    <span class="text-danger">*</span>
                                                </label>

                                                <input type="number" id="stock_phy" name="stock_phy"
                                                    class="form-control @error('stock_phy') is-invalid @enderror"
                                                    min="0" value="{{ old('stock_phy', $inventory->stock_phy) }}"
                                                    placeholder="0">

                                                @error('stock_phy')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                    

                                        <div class="col-sm-6 col-md-6">
                                            <div class="mb-3">
                                                <label for="tax" class="form-label">
                                                    {{ __('Tax') }}
                                                </label>

                                                <input type="number" id="tax" name="tax"
                                                    class="form-control @error('tax') is-invalid @enderror"
                                                    min="0" placeholder="0"
                                                    value="{{ old('tax', $inventory->tax) }}">

                                                @error('tax')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        

                                        
                                    </div>
                                </div>

                                <div class="card-footer text-end">
                                    <button class="btn btn-primary" type="submit">
                                        {{ __('Update') }}
                                    </button>

                                    <a class="btn btn-danger" href="{{ url()->previous() }}">
                                        {{ __('Cancel') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@pushonce('page-scripts')
    <script src="{{ asset('assets/js/img-preview.js') }}"></script>
@endpushonce

