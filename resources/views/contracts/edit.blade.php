@extends('layouts.tabler')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center mb-3">
                <div class="col">
                    <h2 class="page-title">
                        {{ __('Edit Contract') }}
                    </h2>
                </div>
            </div>

            @include('partials._breadcrumbs', ['model' => $contract])
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">
                                {{ __('Edit Contract') }}
                            </h3>

                            <form action="{{ route('contracts.update', $contract->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="table-responsive">
                                    <table class="table card-table table-vcenter">
                                        <tbody>
                                            <tr>
                                                <td>{{ __('Start Date') }}</td>
                                                <td>
                                                    <x-input name="start_date" :value="old('start_date', $contract->start_date)" :required="true" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('End Date') }}</td>
                                                <td>
                                                    <x-input label="End date" name="end_date" :value="old('end_date', $contract->end_date)" :required="true" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('Payment Terms') }}</td>
                                                <td>
                                                    <x-input label="Payment Terms" name="payment_terms" :value="old('payment_terms', $contract->payment_terms)" :required="true" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('Ordered Quantity') }}</td>
                                                <td>
                                                    <x-input label="Ordered Quantity" name="ordered_quantity" :value="old('ordered_quantity', $contract->ordered_quantity)" :required="true" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('Unit Price') }}</td>
                                                <td>
                                                    <x-input label="Unit Price" name="unit_price" :value="old('unit_price', $contract->unit_price)" :required="true" />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer text-end">
                                    <button class="btn btn-primary" type="submit">
                                        {{ __('Update') }}
                                    </button>
                                    <a class="btn btn-outline-warning" href="{{ route('contracts.index') }}">
                                        {{ __('Cancel') }}
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@pushonce('page-scripts')
    <script src="{{ asset('assets/js/img-preview.js') }}"></script>
@endpushonce
