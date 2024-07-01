@extends('user.layout.app')

@section('title', 'Home Page')
@section('content')

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
                                <img src="{{ $firstImage }}" alt="Tender" style="width: 150px; height: 100px;"/>
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
