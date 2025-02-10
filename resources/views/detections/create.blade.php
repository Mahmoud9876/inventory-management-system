@extends('layouts.tabler')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <x-alert/>

        <div class="row row-cards">
            <form action="{{ route('detections.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">
                                    {{ __('Product Image') }}
                                </h3>

                                <img class="img-account-profile mb-2" src="{{ asset('assets/img/products/default.webp') }}" alt="" id="image-preview" />

                                <div class="small font-italic text-muted mb-2">
                                    JPG or PNG no larger than 2 MB
                                </div>

                                <input type="file" accept="image/*" id="image" name="product_image"
                                       class="form-control @error('product_image') is-invalid @enderror"
                                       onchange="previewImage();">

                                @error('product_image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Detect') }}
                        </button>

                        <a class="btn btn-warning" href="{{ url()->previous() }}">
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Affichage des résultats de la détection -->
        @if (isset($original_image) && isset($processed_image))
        <div class="row mt-4">
            <div class="col-md-6">
                <h4>📷 Image Originale</h4>
                <img src="{{ $original_image }}" class="img-fluid" alt="Image originale">
            </div>
            <div class="col-md-6">
                <h4>🔍 Image Détectée</h4>
                <img src="{{ $processed_image }}" class="img-fluid" alt="Image annotée">
            </div>
        </div>

        <h4 class="mt-4">📦 Objets Détectés :</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Objet</th>
                    <th>Quantité</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inventory as $objet => $quantite)
                    <tr>
                        <td>{{ $objet }}</td>
                        <td>{{ $quantite }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection

@pushonce('page-scripts')
<script>
function previewImage() {
    let file = document.getElementById("image").files[0];
    let reader = new FileReader();
    
    reader.onloadend = function () {
        document.getElementById("image-preview").src = reader.result;
    };
    
    if (file) {
        reader.readAsDataURL(file);
    } else {
        document.getElementById("image-preview").src = "{{ asset('assets/img/products/default.webp') }}";
    }
}
</script>
@endpushonce
