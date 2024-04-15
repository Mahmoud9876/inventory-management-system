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

        <!-- Assuming you have a partial for breadcrumbs -->
        @include('partials._breadcrumbs', ['model' => $contract])
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">

            <form action="{{ route('contracts.update', $contract->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">
                                    {{ __('Contract Document') }}
                                </h3>

                                <!-- Display contract document preview if necessary -->
                                <!-- Input field for uploading contract document -->
                                <input type="file" accept=".pdf, .docx" id="document" name="contract_document"
                                    class="form-control @error('contract_document') is-invalid @enderror">

                                @error('contract_document')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">
                                    {{ __('Contract Details') }}
                                </h3>

                                <div class="row row-cards">
                                    <div class="col-md-12">
                                        <!-- Input field for contract title -->
                                        <div class="mb-3">
                                            <label for="title" class="form-label">
                                                {{ __('Title') }}
                                                <span class="text-danger">*</span>
                                            </label>

                                            <input type="text" id="title" name="title"
                                                class="form-control @error('title') is-invalid @enderror"
                                                placeholder="Contract title" value="{{ old('title', $contract->title) }}">

                                            @error('title')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Additional contract fields can be added as needed -->

                                    <div class="col-md-6">
                                        <!-- Input field for contract start date -->
                                        <div class="mb-3">
                                            <label for="start_date" class="form-label">
                                                {{ __('Start Date') }}
                                                <span class="text-danger">*</span>
                                            </label>

                                            <input type="date" id="start_date" name="start_date"
                                                class="form-control @error('start_date') is-invalid @enderror"
                                                value="{{ old('start_date', $contract->start_date) }}">

                                            @error('start_date')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Similar fields for end date, description, etc. -->

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