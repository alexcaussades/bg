<?php 
use Carbon\Carbon;
?>
@extends("exention.header")
@extends("exention.navbar")
@section("content")


<div class="container">
    <div class="row">
        <div class="col-md-12">
           <table class="table table-striped table-inverse table-responsive">
            <thead class="thead-inverse-bordered">
                <tr>
                    <th class="col-1">Date</th>
                    <th scope="col">Type</th>
                    <th scope="col">Équipements</th>
                    <th scope="col">info</th>
                    <th scope="col">Option</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($consignation as $consignation)
                    <tr>
                        <td scope="row">{{Carbon::parse($consignation->created_at)->tz("europe/paris")->format("d/m/Y")}}</td>
                        <td>{{$consignation->type}}</td>
                        <td>{{$consignation->Équipements}}</td>
                        <td>{{$consignation->info}}</td>
                        <td>
                            <a href="{{route('consignation.view', $consignation->id)}}"  class="btn btn-primary">voir</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
           </table>
</div>


@endsection