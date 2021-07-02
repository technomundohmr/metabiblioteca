@extends('layout.main')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <h3 class="text-center mb-3">
                    Bienvenido a nuestra base de datos ORCID 
                </h3>
                <form action="{{url("api/orcid/create")}}" method="post" id="form">
                    <div class="mb-3">
                        <label for="ORCID">Insertar Identificador ORCID</label>
                        <input type="text" id="ORCID" name="ORCID" class="form-control" placeholder="ORCID identifier" required>
                    </div>
                    <input type="hidden" name="Name" id="Name">
                    <input type="hidden" name="Lastname" id="Lastname">
                    <input type="hidden" name="Keywords" id="Keywords">
                    <input type="hidden" name="Email" id="Email">
                    <button type="button" class="btn btn-success" onclick="requestApi()">Insertar</button>
                </form>
            </div>
            <div class="col-md-4"></div>
        </div>
        <div class="row my-5">
            <div class="col">
                @include('lista')
            </div>
        </div>
    </div>
@endsection