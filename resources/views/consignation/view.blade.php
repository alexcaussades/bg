@extends("exention.header")
@extends("exention.navbar")
@section("content")





<div class="container">
    <div class="row">
        <div class="col-md-12">
         <div class="fs-3">Équipements: {{ $consignation->Équipements }}</div>
        <div class="fs-5 mt-2">Type: {{ $consignation->type }}</div>
        <div class="fs-5 mt-2">info: {{ $consignation->info }}</div>
        <div class="fs-6">date: {{ $consignation->created_at }}</div>
        
        Storage file : <img src="{{ Storage::path($img) }}" alt="" width="100" height="100">
</div>


@endsection