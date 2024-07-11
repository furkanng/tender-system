@extends('panel.layout.app')

@section('title', 'Home Page')
@section('content')
    @if(session('error'))
        <div class="alert alert-danger" role="alert">{!! session('error') !!}</div>
    @endif
    @if(session('message'))
        <div class="alert alert-success" role="alert">{!! session('message') !!}</div>
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
    .form-check{
        font-size: 18px;
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        margin-left: 60px;
    }
    .form-check-input{

        margin-top: 0px !important;
    }
    .modal-dialog{
        max-width: 350px;
    }
</style>

    <div class="card">
        <div class="row">



            <div class="col-4">
                <h5 class="card-header">Tüm Teklifler</h5>
            </div>
            <div class="col-8 d-flex justify-content-end">
                <form action="{{ route('panel.bid.index') }}" method="GET" class="d-flex align-items-center mx-3">
                    <button type="submit" class="btn p-0">
                        <i class="bx bx-search fs-4 lh-0"></i>
                    </button>
                    <input
                        type="text"
                        class="form-control border-0 shadow-none"
                        placeholder="Marka, Model, İhale No vb."
                        aria-label="Marka, Model,İhale No vb."
                        name="filter"
                        value="{{ request('filter') }}"
                    />
                </form>
            </div>
        </div>


        <div class="table-responsive text-nowrap">
            <form action="{{ route('panel.transferCheckBids') }}" method="post">
                @csrf
                @method('PUT')
                <button type="submit"  class="btn btn-primary" style="margin-left: 10px" id="transferCheckBids" name="transferCheckBids" >
                    <i class="bx bx-transfer-alt me-1"></i>
                    Seçilen İhaleleri Aktar
                </button>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th style="width: 5% !important;"><input class="form-check-input" type="checkbox" id="selectAll"></th>
                    <th style="width: 10% !important;">İhale No</th>
                    <th>Resim</th>
                    <th style="width: 15% !important;">Araç İsmi</th>
                    <th>Firma İsmi</th>
                    <th>İhale Bitiş Tarihi</th>
                    <th>İl/İlçe</th>
                    <th class="teklif-veren-isim">Teklif Veren İsim</th>
                    <th class="teklif-veren-numara">Teklif Veren Numarası</th>
                    <th>Teklif Miktarı</th>
                    <th>İşlemler</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">

                @foreach($bids as $bid)
                    <tr>
                        <td><input class="form-check-input bidCheckbox" type="checkbox" id="bidCheck" value="{{ $bid->id }}" name="bid_ids[]"></td>
                        <td class="tender-no">{{$bid->tender->tender_no}}</td>
                        <td>
                            <a href="@if($bid->tender->company_id == 1)
                                   {{\App\Service\Autogong\AutogongService::ALL_CARS_DETAIL_URL}}{{ $bid->tender->tender_no }}
                                @elseif($bid->tender->company_id == 2)
                                    {{\App\Service\Otopert\OtopertService::CARS_DETAILS}}{{ $bid->tender->tender_no }}
                                @elseif($bid->tender->company_id == 3)
                                    {{\App\Service\SovtajYeri\SovtajyeriService::URL}}{{ $bid->tender->tender_url }}
                                @endif" target="_blank">
                                <img style="max-width:80px"
                                     class="img-fluid img-responsive rounded product-image"
                                     src="{{json_decode($bid->tender["images"],true)[0]}}">
                             </a>
                        </td>
                        <td class="tender-name">
                            {{$bid->tender->name}}
                        </td>
                        <td>
                            {{$bid->company->name}}
                        </td>
                        <td>

                            {{\Carbon\Carbon::createFromTimestamp($bid->tender->closed_date)->format('d.m.Y')}}
                        </td>
                        <td>
                            {{$bid->tender->city}}
                        </td>
                        <td>
                            {{$bid->user->name ?? ""}}
                        </td>
                        <td>
                            {{$bid->user->phone ?? ""}}
                        </td>
                        <td>
                            {{$bid->bid_price}}
                        </td>


                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#bidEditModal{{ $bid->id }}">
                                        <i class="bx bx-edit-alt me-1"></i>Düzenle
                                    </a>
                                    <input type="hidden" name="transfer_status">

                                    <a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#bidDeleteModal{{ $bid->id }}">
                                        <i class="bx bx-trash me-1"></i>Sil
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <form action="{{ route('panel.bid.destroy', ['id' => $bid->id]) }}" method="post" id="deleteForm">
                        @csrf
                        @method('DELETE')
                    <div class="modal fade" id="bidDeleteModal{{$bid->id}}" tabindex="-1" role="document" aria-labelledby="bidDeleteModal"
                         aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header justify-content-center">
                                    <h5 class="model-title">İhaleyi Sil</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="display: flex;justify-content: center;">
                                    <div class="row">
                                        <div class="col mb-3 text-center">
                                            <p class="text-center" style="font-size: 16px">Silme işlemini onaylıyorsanız 'Evet' seçiniz.</p>
                                            <div class="form-check" style="">
                                                <label class="form-check-label" for="exampleRadios1" style="">
                                                    Evet
                                                </label>
                                                <input class="form-check-input" type="radio" name="deleteInput" style="margin-left: 40px !important" id="yesDeleteInput" value="yesDeleteInput" >
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="exampleRadios2">

                                                    Hayır
                                                </label>
                                                <input class="form-check-input" type="radio" name="deleteInput" style="margin-left: 34px !important" id="noDeleteInput" value="noDeleteInput">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Kapat</button>
                                    <button type="submit" class="btn btn-primary">Sil</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                    <form action="{{ route("panel.bid.update", ['id' => $bid->id]) }}" method="post">
                        @csrf
                        @method('PUT')
                    <div class="modal fade" id="bidEditModal{{$bid->id}}" tabindex="-1" role="document" aria-labelledby="bidEditModal"
                        aria-hidden="true">
                       <div class="modal-dialog modal-dialog-centered">
                           <div class="modal-content">
                               <div class="modal-header justify-content-center">
                                <h5 class="model-title">İhale Düzenle</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                               </div>
                               <div class="modal-body">
                                   <div class="row">
                                     <div class="col mb-3 text-center">
                                        <img style="width:340px"
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
            </form>
        </div>

    </div>

    {{-- {{ $tenders->links('pagination') }} --}}
    <script>
        $(document).ready(function() {
            // Tümünü seç checkbox'ına tıklanma olayını dinleyin
            $('#selectAll').click(function() {
                if (this.checked) {
                    $('.bidCheckbox').each(function() {
                        this.checked = true;
                    });
                } else {
                    $('.bidCheckbox').each(function() {
                        this.checked = false;
                    });
                }
            });

            // Bireysel checkbox'lara tıklanma olayını dinleyin
            $('.bidCheckbox').click(function() {
                if ($('.bidCheckbox:checked').length == $('.bidCheckbox').length) {
                    $('#selectAll').prop('checked', true);
                } else {
                    $('#selectAll').prop('checked', false);
                }
            });
        });

    </script>
@endsection

