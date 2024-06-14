@extends('panel.layout.app')

@section('title', 'Home Page')
@section('content')

    <div class="card">
        <div class="row">
            <div class="col-4">
                <h5 class="card-header">Tüm Arşivler</h5>
            </div>
            <div class="col-8 d-flex justify-content-end">
                <form action="{{ route('panel.archive.index') }}" method="GET" class="d-flex align-items-center mx-3">
                    <button type="submit" class="btn p-0">
                        <i class="bx bx-search fs-4 lh-0"></i>
                    </button>
                    <input
                        type="text"
                        class="form-control border-0 shadow-none"
                        placeholder="Firma, Araç, Plaka, Şehir,Durum"
                        aria-label="Firma, Araç, Plaka, Şehir,Durum"
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
                    <th>Firma</th>
                    <th>Araç</th>
                    <th>Resim</th>
                    <th>İhale No</th>
                    <th>Şehir</th>
                    <th>Tarih</th>
                    <th>Durum</th>
                    <th>İşlemler</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach($archives as $archive)
                    <tr>
                        @php $company = \App\Models\Company::where("id",$archive->company_id)->first(); @endphp
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i>{{$company->name}}</td>
                        <td>{{$archive->car}}</td>
                        <td>
                            @if($archive->images)
                            <a href="#">
                            
                            <img style="max-width:80px"
                                 class="img-fluid img-responsive rounded product-image"
                                 src="{{json_decode($archive["images"],true)[0]}}">
                         </a>
                         @endif
                        </td>
                        <td><span class="badge bg-label-primary me-1">{{$archive->tender_no}}</span></td>
                        <td>{{$archive->city}}</td>
                        <td><span class="badge bg-label-secondary me-1">
                            @php
                            
                            $date = Carbon\Carbon::parse((int)$archive->date);

                            // İstediğiniz tarih formatını kullanma
                            $dateFormat = $date->format('Y-m-d');

                            // Sonucu ekrana yazdırma
                            echo $dateFormat;
                            @endphp 
                        
                        
                        </span></td>
                        <td>@if($archive->status == "KAZANDINIZ")
                                <span class="badge bg-label-success me-1">{{$archive->status}}</span>
                            @else
                                <span class="badge bg-label-danger me-1">{{$archive->status}}</span>
                            @endif
                        </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item"
                                       href="{{route("panel.archive.edit", ['id' => $archive->id])}}"
                                    ><i class="bx bx-edit-alt me-1"></i>İncele</a
                                    >
                                    <a class="dropdown-item" href="javascript:void(0);"
                                    ><i class="bx bx-trash me-1"></i>Sil</a
                                    >
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{ $archives->links('pagination') }}

@endsection
