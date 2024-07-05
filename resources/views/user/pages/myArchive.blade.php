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
    <style>
        .table-container {
            display: flex;
            justify-content: center;
        }

        .table {
            width: 100%;
            table-layout: fixed;
        }

        .table th, .table td {
            word-wrap: break-word;
            white-space: normal;
        }
    </style>

    <div class="container mt-5 mb-5">
        <div class="d-flex justify-content-center row">
            <div class="col-md-11">
                @if(!empty($archives))
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Araç Fotoğraf</th>
                                <th>İhale No</th>

                                <th>Araç</th>
                                <th>Şehir</th>
                                <th>Tarih</th>
                                <th>Sıra</th>
                                <th>Verdiğim Teklif</th>
                                <th>Kazanan Teklif Tutarı</th>
                                <th>Teklif Durumu</th>
                                <th>Arşiv Oluşturma Tarihi</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @foreach ($archives as $archive)

                                <tr>
                                    @php $tender = \App\Models\Tender::where("tender_no",$archive->tender_no)->first(); @endphp
                                    <td><img style="max-width:80px"
                                             class="img-fluid img-responsive rounded product-image"

                                             src="{{  json_decode($tender["images"],true)[0]}}"></td>
                                    <td>{{$archive->tender_no}}</td>

                                    <td>{{$archive->car}}</td>
                                    <td>{{$archive->city}}</td>
                                    <td> {{\Carbon\Carbon::createFromTimestamp($archive->date)->format('d.m.Y')}}</td>
                                    <td>{{$archive->order}}</td>
                                    <td>{{$archive->my_bid}}</td>
                                    <td>{{$archive->bid_win}}</td>
                                    <td>{{$archive->status}}</td>
                                    <td> {{\Carbon\Carbon::createFromTimestamp($archive->created_at)->format('d.m.Y')}}</td>

                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-secondary d-flex justify-content-center" role="alert">
                        Henüz Arşiviniz bulunmamaktadır ?
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
