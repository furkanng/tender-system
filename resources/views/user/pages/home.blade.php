@extends('user.layout.app')

@section('title', 'Home Page')
@section('content')
    @php $user = auth()->guard("user")->user()  @endphp
    @if(empty($user->city) || empty($user->district) || empty($user->address) || empty($user->phone))
        <div class="container-fluid pt-4 px-4">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-danger">Hoşgeldiniz {{auth()->guard("user")->user()->name}}
                                🎉</h5>
                            <p class="mb-4 text-danger">
                                Oto İhale Sistemine Hoşgeldiniz. İhalelere teklif verebilmek için öncelikle profilim
                                sayfasında eksik bulunan iletişim bilgilerinizi doldurunuz.
                            </p>
                            <a href="{{route("user.profile.index")}}" class="btn btn-sm btn-outline-danger">Profilim</a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img
                                src="{{asset("panel/assets/img/illustrations/man-with-laptop-light.png")}}"
                                height="140"
                                alt="View Badge User"
                                data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Sale & Revenue Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-6 col-xl-4">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-line fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Toplam Araç</p>
                        <h6 class="mb-0">{{$tendersCount}}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-4">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-bar fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Arşivdeki Araç</p>
                        <h6 class="mb-0">{{$archivesCount}}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-4">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-area fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Teklifdeki Araç</p>
                        <h6 class="mb-0">{{$bidsCount}}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Sale & Revenue End -->

    <!-- Recent Sales Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Öne Çıkan İhaleler</h6>
                <a href="{{route("user.tender.index")}}">Tümünü İncele</a>
            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                    <tr class="text-dark">
                        <th scope="col">#</th>
                        <th scope="col">Araç</th>
                        <th scope="col">Tip</th>
                        <th scope="col">Servis</th>
                        <th scope="col">Yıl</th>
                        <th scope="col">Detay</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($lastFiveTenders as $item )
                        @php
                            $imagesArray = json_decode($item->images, true);
                            $firstImage = $imagesArray[0] ?? null;
                        @endphp
                        <tr>
                            <td>
                                <a href="{{ route('user.tender.show', ['id' => $item->id]) }}"><img src="{{ $firstImage }}" alt="Tender" style="width: 150px; height: 100px;"/></a>
                            </td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->car_type }}</td>
                            <td>{{ $item->service_type }}</td>
                            <td>{{ $item->year }}</td>
                            <td>
                                <a class="btn btn-sm btn-primary"
                                   href="{{ route('user.tender.show', ['id' => $item->id]) }}">Detay</a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Recent Sales End -->

@endsection
