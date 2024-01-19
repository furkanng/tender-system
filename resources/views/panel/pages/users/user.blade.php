@extends('panel.layout.app')

@section('title', 'Home Page')
@section('content')


<div class="card">
    <div class="row">
        <div class="col-4">
            <h5 class="card-header">Kullanıcılar</h5>
        </div>
        <div class="col-8 d-flex justify-content-end">
            <form action="{{ route('panel.user.index') }}" method="GET" class="d-flex align-items-center mx-3">
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
                <th>ID</th>
                <th>Ad Soyad</th>
                <th>Email</th>
                <th>Seviye</th>
                <th>İşlemler</th>
                <th>Kayıt Tarihi</th>
            </tr>
            </thead>
            <tbody class="table-border-bottom-0">
            @foreach($users as $user)
                <tr>
                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td><span class="badge bg-label-primary me-1">{{$user->email}}</span></td>
                    <td>
                        @php
                            $role;
                            if($user->role == 1){
                                $role ="Onaylı";
                            }
                            else if($user->role == 2){
                                $role ="Onaysız";
                            }
                            else if($user->role == 3){
                                $role ="VIP";
                            }

                            echo $role;
                        @endphp

                    </td>
                    <td>
                        <div class="mb-3 col-md-12">
                            <select class="form-select" id="roleType" name="roleType"
                                    aria-label="Default select example">
                                <option selected value="KAPALI">Onaylı</option>
                                <option value="AÇIK">VIP</option>
                                <option value="AÇIK">Onaysız</option>
                            </select>
                            <input class="btn btn-primary" type="button" value="Kaydet">
                        </div>
                    </td>

                    <td><span class="badge bg-label-secondary me-1">
                       {{$user->created_at}}
                    
                    
                    </span></td>
                
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                    data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item"
                                   href="{{route("panel.user.edit", ['id' => $user->id])}}"
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

{{ $users->links('pagination') }}
@endsection