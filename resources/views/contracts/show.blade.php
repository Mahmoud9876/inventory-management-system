@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center mb-3">
            <div class="col">
                <h2 class="page-title">
                    Contract {{ $contract->id }}
                </h2>
            </div>

            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ route('contracts.edit', $contract->id) }}" class="btn btn-warning d-none d-sm-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
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
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __('Contract Details') }}</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered card-table table-vcenter text-nowrap datatable">
                                <tbody>
                                    <tr>
                                        <td>NO</td>
                                        <td>Contract {{ $contract->id }}</td>
                                    </tr>
                                    <tr>
                                        <td>Start Date</td>
                                        <td>{{ $contract->start_date }}</td>
                                    </tr>
                                    <tr>
                                        <td><span class="text-secondary">End Date</span></td>
                                        <td>{{ $contract->end_date }}</td>
                                    </tr>
                                    <tr>
                                        <td>Contract Terms</td>
                                        <td>{{ $contract->contract_terms }}</td>
                                    </tr>
                                    <tr>
                                        <td>Payment Terms</td>
                                        <td>{{ $contract->contract_terms }}</td>
                                    </tr>
                                    <tr>
                                        <td>Ordered Quantity</td>
                                        <td>{{ $contract->ordered_quantitys }}</td>
                                    </tr>
                                    <tr>
                                        <td>Unit Price</td>
                                        <td>{{ $contract->unit_price }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer text-end">
                            <a class="btn btn-info" href="{{ url()->previous() }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M5 12l14 0" />
                                    <path d="M5 12l6 6" />
                                    <path d="M5 12l6 -6" />
                                </svg>
                                {{ __('Back') }}
                            </a>
                            <a class="btn btn-warning" href="{{ route('contracts.edit', $contract->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                    <path d="M13.5 6.5l4 4" />
                                </svg>
                                {{ __('Edit') }}
                            </a>
                        </div>
                    </div>
                    <a href="{{ route('contracts.pdf', ['id' => $contract->id]) }}" class="btn btn-primary">Download PDF</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
