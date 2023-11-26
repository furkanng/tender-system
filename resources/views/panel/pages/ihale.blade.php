@extends('panel.layout.app')

@section('title', 'Home Page')
@section('content')

    <div class="card">
        <h5 class="card-header">Tüm İhaleler</h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Araç</th>
                    <th>Firma</th>
                    <th>İhale Tipi</th>
                    <th>İhale No</th>
                    <th>Durum</th>
                    <th>İşlemler</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach($tenders as $tender)
                    <tr>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> {{$tender->name}}</td>
                        <td>{{\App\Models\Company::find($tender->company_id)->name}}</td>
                        <td><span class="badge bg-label-primary me-1">{{$tender->tender_type}}</span></td>
                        <td><span class="badge bg-label-secondary me-1">{{$tender->tender_no}}</span></td>
                        <td>@if($tender->status == 1)
                                <span class="badge bg-label-success me-1">Aktif</span>
                            @else
                                <span class="badge bg-label-danger me-1">Pasif</span>
                            @endif</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item"
                                       href="{{route("panel.tender.edit", ['id' => $tender->id])}}"
                                    ><i class="bx bx-edit-alt me-1"></i>Düzenle</a
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

    {{ $tenders->links('pagination') }}

@endsection
