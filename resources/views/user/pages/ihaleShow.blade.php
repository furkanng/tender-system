@extends('user.layout.app')

@section('title', 'Home Page')
@section('content')

    <div class="container mt-5 mb-5">
        <div class="d-flex justify-content-center row">
            <div class="col-md-12">


                <div class="d-flex mb-2 justify-content-center">
                    <h4 class="text-secondary">{{$tender->name}}</h4>
                </div>
                <div class="border border-label-gray rounded">

                    @if(!empty($tender->images) && $tender->company_id != 99)
                        <div class="card-body">
                            @php $imageCounter = 0 @endphp
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <swiper-container class="mySwiper" pagination="true" pagination-clickable="true"
                                                  space-between="15" slides-per-view="5" navigation="true">
                                    @foreach(json_decode($tender->images) as $image)
                                        @if($imageCounter < 20)
                                            <swiper-slide>
                                                <a target="_blank" href={{ $image }}>
                                                    <img src="{{ $image }}" alt="images" class="d-block rounded"
                                                         height="100" width="100" id="images"/>
                                                </a>

                                            </swiper-slide>

                                            @php $imageCounter++ @endphp
                                        @endif
                                    @endforeach

                                </swiper-container>
                            </div>
                        </div>
                    @else
                        <div class="card-body">
                            @php $images = \App\Models\TenderImages::where("tender_id", $tender->id)->get() @endphp
                            @php $imageCounter = 0 @endphp
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <swiper-container class="mySwiper" pagination="true" pagination-clickable="true"
                                                  space-between="15" slides-per-view="5" navigation="true">
                                    @foreach($images as $image)
                                        @if($imageCounter < 20)
                                            <swiper-slide>
                                                <a target="_blank" href={{ $image->url }}>
                                                    <img src="{{ $image->url }}" alt="images" class="d-block rounded"
                                                         height="100" width="100" id="images"/>
                                                </a>

                                            </swiper-slide>

                                            @php $imageCounter++ @endphp
                                        @endif
                                    @endforeach

                                </swiper-container>
                            </div>
                        </div>
                    @endif
                    <hr style="width: 70%; margin-left: auto;margin-right: auto; height: 2px;" class="bg-label-secondary">
                    <div class="card-body p-3">

                        <div class="row p-3">
                            <div class="col">
                                <ul class="list-group list-group-horizontal">
                                    <li class="list-group-item">Marka</li>
                                    <li class="list-group-item">{{$tender->brand}}</li>
                                </ul>
                            </div>
                            <div class="col">test</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
