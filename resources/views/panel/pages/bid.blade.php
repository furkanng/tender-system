@extends('panel.layout.app')

@section('title', 'Home Page')
@section('content')


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
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>İhale No</th>
                    <th>Resim</th>
                    <th>Araç İsmi</th>
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
                        <td class="tender-no">{{$bid->tender->tender_no}}</td>
                        <td>
                            <a href="#">
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
                            {{$bid->user->name}}
                        </td>
                        <td>
                            {{$bid->user->phone}}
                        </td>
                        <td>
                            {{$bid->bid_price}}
                        </td>

                        
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item"
                                       href="" data-bs-toggle="modal" data-bs-target="#bidEditModal{{$bid->id}}"
                                    ><i class="bx bx-edit-alt me-1"></i>Düzenle</a
                                    >
                                    <form action="{{ route("panel.bid.update", ['id' => $bid->id]) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="dropdown-item" id="transfer_status" name="transfer_status" >
                                            <i class="bx bx-transfer-alt me-1"></i>
                                            İhale Aktar
                                        </button>
                                </form>
                                <form action="{{ route("panel.bid.destroy", ['id' => $bid->id]) }}"method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item" href="javascript:void(0);"
                                    ><i class="bx bx-trash me-1"></i>Sil</button
                                    >
                                         
                                </form>
                                
                                </div>
                            </div>
                        </td>
                    </tr>
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

    {{-- {{ $tenders->links('pagination') }} --}}

@endsection
