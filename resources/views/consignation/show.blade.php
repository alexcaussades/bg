@extends("exention.header")
@extends("exention.navbar")
@section("content")


<div class="container">
    <div class="row">
        <div class="col-md-12">
           <table class="table table-striped table-inverse table-responsive">
            <thead class="thead-inverse">
                <tr>
                    <th>Type</th>
                    <th>Équipements</th>
                    <th>info</th>
                    <th>Option</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($consignation as $consignation)
                    <tr>
                        <td scope="row">{{$consignation->type}}</td>
                        <td>{{$consignation->Équipements}}</td>
                        <td>{{Str::limit($consignation->info, 20, '...')}}</td>
                        <td>
                            <a href="{{route('consignation.view', $consignation->id)}}"  class="btn btn-primary">voir</a>
                            <a href="#" class="btn btn-primary">Modifier</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
           </table>
</div>


@endsection