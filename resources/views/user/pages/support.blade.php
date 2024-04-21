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
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="row mb-4">
                        <div class="col"><h6 class="mb-4">Destek Taleplerim</h6></div>
                        <div class="col d-flex justify-content-end">
                            <a href="{{route("user.support.create")}}">
                                <button class="btn btn-primary">Talep Oluştur</button>
                            </a>
                        </div>
                    </div>
                    @if(isset($supports))
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Başlık</th>
                                    <th scope="col">Durum</th>
                                    <th scope="col">Cevap</th>
                                    <th scope="col">Son Güncelleme</th>
                                    <th scope="col">İşlem</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($supports as $support)
                                    <tr>
                                        <td>{{$support->title}}</td>
                                        <td>
                                            @if($support->status == 1)
                                                <button class="btn btn-sm btn-success">Aktif</button>
                                            @else
                                                <button class="btn btn-sm btn-danger">Kapatılmış</button>
                                            @endif
                                        </td>
                                        <td>
                                            @if($support->read == "customer")
                                                Yanıt Bekliyor
                                            @else
                                                Cevaplanmış
                                            @endif
                                        </td>
                                        <td>{{$support->updated_at}}</td>
                                        <td>
                                            <a href="{{route("user.support.show",["id" => $support->id])}}">
                                                <button class="btn btn-sm btn-info">incele</button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-danger text-center" role="alert">
                            Destek talebi bulunamadı.
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
