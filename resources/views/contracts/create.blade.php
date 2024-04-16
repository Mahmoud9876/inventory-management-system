@extends('layouts.tabler')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-alert/>

            <div class="row row-cards">
                <form action="{{ route('contracts.index') }}" method="POST">
                    @csrf

                    <div class="table-responsive">
                        <table class="table card-table table-vcenter">
                            <tbody>
                                <tr>
                                    <td>{{ __('Supplier') }}</td>
                                    <td>
                                        <select name="supplier_id" id="supplier_id" class="form-select">
                                            @foreach($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('Start Date') }}</td>
                                    <td>
                                        <x-input type="date"
                                                 label="Start Date"
                                                 name="start_date"
                                                 id="start_date"
                                                 value="{{ old('start_date') }}"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('End Date') }}</td>
                                    <td>
                                        <x-input type="date"
                                                 label="End Date"
                                                 name="end_date"
                                                 id="end_date"
                                                 value="{{ old('end_date') }}"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('Product') }}</td>
                                    <td>
                                        <select name="product_id" id="product_id" class="form-select">
                                            @foreach($products as $prod)
                                                <option value="{{ $prod->id }}">{{ $prod->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('Payment Terms') }}</td>
                                    <td>
                                        <x-input type="text"
                                                 label="Payment Terms"
                                                 name="payment_terms"
                                                 id="payment_terms"
                                                 value="{{ old('payment_terms') }}"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('Ordered Quantity') }}</td>
                                    <td>
                                        <x-input type="number"
                                                 label="Ordered Quantity"
                                                 name="ordered_quantity"
                                                 id="ordered_quantity"
                                                 value="{{ old('ordered_quantity') }}"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('Unit Price') }}</td>
                                    <td>
                                        <x-input type="number"
                                                 label="Unit Price"
                                                 name="unit_price"
                                                 id="unit_price"
                                                 value="{{ old('unit_price') }}"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('Contract Terms') }}</td>
                                    <td>
                                        <x-input type="text"
                                                 label="Contract Terms"
                                                 name="contract_terms"
                                                 id="contract_terms"
                                                 value="{{ old('contract_terms') }}"
                                        />
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('Notes') }}</td>
                                    <td>
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
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-end">
                        <x-button.save type="submit">
                            {{ __('Save Contract') }}
                        </x-button.save>

                        <a class="btn btn-warning" href="{{ url()->previous() }}">
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
