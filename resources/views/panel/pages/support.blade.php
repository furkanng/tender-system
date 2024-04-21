@extends('panel.layout.app')

@section('title', 'Home Page')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">
            <h5 class="card-header">Destek Talepleri</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                    <tr class="text-nowrap">
                        <th>Başlık</th>
                        <th>Durum</th>
                        <th>Cevap</th>
                        <th>Son Güncelleme</th>
                        <th>İşlem</th>
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
                                <a href="{{route("panel.support.show",["id" => $support->id])}}">
                                    <button class="btn btn-sm btn-info">incele</button>
                                </a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
