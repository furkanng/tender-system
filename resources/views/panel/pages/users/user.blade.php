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

    @if(session('message'))
    <script>
        $(document).ready(function () {
            $('#successModal').modal('show');
        });
    </script>
@endif
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
                            else if($user->role == 0){
                                $role ="Onaysız";
                            }
                            else if($user->role == 2){
                                $role ="VIP";
                            }

                            echo $role;
                        @endphp

                    </td>
                    <td>
                        <form method="POST" action="{{ route("panel.user.update", ['id' => $user->id]) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3 col-md-12">
                            <select class="form-select" id="role" name="role"
                                    aria-label="Default select example">
                                <option {{ $user->role == '1' ? 'selected' : '' }} value="1">Onaylı</option>
                                <option {{ $user->role == '2' ? 'selected' : '' }} value="2">VIP</option>
                                <option {{ $user->role == '0' ? 'selected' : '' }} value="0">Onaysız</option>
                            </select>
                            <input class="btn btn-primary" type="submit" value="Kaydet">
                        </div>
                    </form>
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