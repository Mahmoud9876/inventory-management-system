@extends('layouts.tabler')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <x-alert/>

        <div class="row row-cards">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">
                            {{ __('Detection Result') }}
                        </h3>

                        <div class="row">
                            <div class="col-md-6">
                                <h5>Original Image</h5>
                                <img class="img-fluid" src="{{ $original_image }}" alt="Original Image">
                            </div>

                            <div class="col-md-6">
                                <h5>Processed Image</h5>
                                @if($processed_image)
                                    <img class="img-fluid" src="{{ $processed_image }}" alt="Processed Image">
                                @else
                                    <p class="text-danger">No processed image available.</p>
                                @endif
                            </div>
                        </div>

                        <h4 class="mt-4">Detected Objects</h4>
                        <ul class="list-group">
                            @if($inventory && count($inventory) > 0)
                                @foreach($inventory as $item => $count)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ ucfirst($item) }}
                                        <span class="badge bg-primary rounded-pill">{{ $count }}</span>
                                    </li>
                                @endforeach
                            @else
                                <p class="text-warning">No objects detected.</p>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end mt-3">
            <a class="btn btn-primary" href="{{ route('detections.create') }}">Try Another Image</a>
        </div>
    </div>
</div>
@endsection
