@extends('layouts.tabler')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <x-alert/>

        <div class="row row-cards">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Résultat de la Détection</h3>

                        <div class="row">
                            <div class="col-md-6">
                                <h5>Image Originale</h5>
                                <img class="img-fluid" src="{{ session('original_image') }}" alt="Original Image">
                            </div>
                            <div class="col-md-6">
                                <h5>Image Annotée</h5>
                                <img class="img-fluid" src="{{ session('processed_image') }}" alt="Processed Image">
                            </div>
                        </div>

                        <h4 class="mt-4">Inventaire Détecté</h4>
                        <ul class="list-group">
                            @foreach(session('inventory', []) as $item => $count)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $item }}
                                    <span class="badge bg-primary rounded-pill">{{ $count }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <div class="mt-4">
                        
                    </div>


                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
