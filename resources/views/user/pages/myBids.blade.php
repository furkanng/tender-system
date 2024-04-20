@extends('user.layout.app')

@section('title', 'Home Page')
@section('content')
@if(session('message'))
<script>
    $(document).ready(function () {
        $('#successModal').modal('show');
    });
</script>
@endif
<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-center row">
        <div class="col-md-11">
<div class="table-responsive text-nowrap">
    <table class="table table-hover">
        <thead>
        <tr>
            <th>İhale No</th>
            <th>Durum</th>
            <th>Resim</th>
            <th>İhale Kapanış Tarihi</th>
            <th>Piyasa Bedeli</th>
            <th>Verdiğim Teklif</th>
           
            <th>İşlemler</th>
        </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            @foreach ($bids as $bid)
           
            <tr>
                <td>{{$bid->tender->tender_no}}</td>
                <td>{{$bid->status}}</td>
                <td><img style="max-width:80px"
                    class="img-fluid img-responsive rounded product-image"
                    src="{{json_decode($bid->tender["images"],true)[0]}}"></td>
                <td>  {{\Carbon\Carbon::createFromTimestamp($bid->tender->closed_date)->format('d.m.Y')}}
                </td>
                <td>-</td>
                <td>{{$bid->bid_price}}</td>
            </tr>
                 
            @endforeach
        </tbody>
    </table>
    </div>
</div>
</div>
</div>
@endsection