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
@if(auth()->user()->role != 2)

    <div class="alert alert-danger " role="alert" style="margin-top: 30px">
        VIP üyeliğiniz bulunmadığından teklif düzenleme işlemi kapalı !

    </div>
@endif
@if(session('transferredError'))

    <div class="alert alert-danger " role="alert" style="margin-top: 30px">
        {{session('transferredError')}}
    </div>
@endif

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-center row">
        <div class="col-md-11">
<div class="table-responsive text-nowrap">
    <table class="table table-hover">
        <thead>
        <tr>
            <th>İhale No</th>
            <th>Aktarma Durumu</th>
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
                <td> @if($bid->transfer_status == 1)
                        <span style="background-color: green; color: white; padding: 5px; border-radius: 5px;">Aktarıldı</span>
                    @else
                        <span style="background-color: red; color: white; padding: 5px; border-radius: 5px;">Aktarılmadı</span>
                    @endif</td>
                <td><img style="max-width:80px"
                    class="img-fluid img-responsive rounded product-image"
                    src="{{json_decode($bid->tender["images"],true)[0]}}"></td>
                <td>  {{\Carbon\Carbon::createFromTimestamp($bid->tender->closed_date)->format('d.m.Y')}}
                </td>
                <td>-</td>
                <td>{{$bid->bid_price}}</td>
                <td>
                <a class="btn btn-primary btn-sm  @if(auth()->user()->role != 2 || $bid->transfer_status == 1)disabled @endif
                edit-button" href=""  data-role="{{ auth()->user()->role }}" data-bs-toggle="modal" data-bs-target="#bidEditModal{{ $bid->id }}"><i class="bx bx-edit-alt me-1" ></i>Düzenle</a>
                </td>
            </tr>

            <form action="{{ route("user.bid.update", ['id' => $bid->id]) }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal fade" id="bidEditModal{{$bid->id}}" tabindex="-1" role="document" aria-labelledby="bidEditModal"
                     aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header justify-content-center">
                                <h5 class="model-title">İhale Fiyatını Düzenle</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col mb-3 text-center">
                                        <img style="max-width:340px"
                                             class="img-fluid img-responsive rounded product-image"
                                             src="{{json_decode($bid->tender["images"],true)[0]}}">
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col mb-0">
                                        <label for="bid_price" class="form-label">Teklif Miktarı</label>
                                        <input type="text" id="bid_price" name="bid_price" class="form-control" value="{{$bid->bid_price}}">
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Kapat</button>
                                <button type="submit" class="btn btn-primary">Kaydet</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
</div>
</div>
<script>
    $(document).ready(function() {
        $('.edit-button').on('click', function(event) {
            var userRole = $(this).data('role');
            var targetModal = $(this).attr('data-bs-target');


            if (userRole != 2) {
                event.stopPropagation();
                event.preventDefault();
                alert('Yetkisiz işlem.');
            } else {

                $(targetModal).modal('show');
            }
        });

        $('.modal').on('show.bs.modal', function (event) {
            var userRole = $('.edit-button').data('role');
            if (userRole != 2) {
                event.stopPropagation();
                event.preventDefault();
                return false;
            }
        })
    });
</script>
@endsection
