@extends('layouts.tabler')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <x-alert/>

        <div class="row row-cards">
            <form action="{{ route('contracts.index') }}" method="POST">
                @csrf

                <div class="row">
                  

                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <div>
                                    <h3 class="card-title">
                                        {{ __('Create Contract') }}
                                    </h3>
                                </div>

                                <div class="card-actions">
                                    <a href="{{ route('contracts.index') }}" class="btn-action">
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row row-cards">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="supplier_id" class="form-label">
                                                {{ __('Supplier') }}
                                            </label>

                                            <select name="supplier_id" id="supplier_id" class="form-select">
                                                @foreach($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <x-input type="date"
                                                 label="Start Date"
                                                 name="start_date"
                                                 id="start_date"
                                                 value="{{ old('start_date') }}"
                                        />
                                    </div>
                                    <div class="col-md-6">
                                        
                                        <x-input type="date"
                                                 label="End Date"
                                                 name="end_date"
                                                 id="end_date"
                                                 value="{{ old('end_date') }}"
                                        />
                                    </div>
                                   

                                    
                                    <div class="col-md-6">
                                            <label for="Product_id" class="form-label">
                                                {{ __('Product') }}
                                            </label>

                                            <select name="product_id" id="product_id" class="form-select">
                                                
                                                @foreach($products as $prod)
                                                    <option value="{{ $prod->id }}">{{ $prod->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    </div>

                                    
                                    <div class="col-md-6">
                                        <x-input type="text"
                                                 label="Payment Terms"
                                                 name="payment_terms"
                                                 id="payment_terms"
                                                 value="{{ old('payment_terms') }}"
                                        />
                                    </div>

                                    
                                    <div class="col-md-6">
                                        <x-input type="number"
                                                 label="Ordered Quantity"
                                                 name="ordered_quantity"
                                                 id="ordered_quantity"
                                                 value="{{ old('ordered_quantity') }}"
                                        />
                                    </div>

                                    
                                    <div class="col-md-6">
                                        <x-input type="number"
                                                 label="Unit Price"
                                                 name="unit_price"
                                                 id="unit_price"
                                                 value="{{ old('unit_price') }}"
                                        />
                                    </div>

                                    <div class="col-md-12">
                                        <x-input type="text"
                                                 label="Contract Terms"
                                                 name="contract_terms"
                                                 id="contract_terms"
                                                 value="{{ old('contract_terms') }}"
                                        />
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="notes" class="form-label">
                                                {{ __('Notes') }}
                                            </label>

                                            <textarea name="notes"
                                                      id="notes"
                                                      rows="5"
                                                      class="form-control @error('notes') is-invalid @enderror"
                                                      placeholder="Contract notes"
                                            ></textarea>

                                            @error('notes')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer text-end">
                                <x-button.save type="submit">
                                    {{ __('Save Contract') }}
                                </x-button.save>

                                <a class="btn btn-warning" href="{{ url()->previous() }}">
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