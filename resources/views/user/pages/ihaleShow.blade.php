@extends('user.layout.app')

@section('title', 'Home Page')
@section('content')

    @if(session('message'))

        <div class="alert alert-success alert-dismissible" role="alert" style="margin-top: 30px">
            Teklif verme işlemi başarılı.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('tenderFactorError'))
        <div class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 30px">
            Teklif tutarı hatalı! Lütfen {{session('tenderFactorError')}}'ün katları şeklinde tutar giriniz.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

    @endif
    @if(session('tenderClosedTimeError'))
        <div class="alert alert-danger alert-dismissible" role="alert" style="margin-top: 30px">
            Teklif vermek istediğiniz ihalenin teklif süresi dolmuştur.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

    @endif
<style>
    .tender-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #e5eff8;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .tender-label {
        font-weight: bold;
        color: #343a40;
    }

    .countdown {
        font-size: 1.2em;
        color: #343a40;
        display: flex;
        align-items: center;
    }

    .countdown i {
        margin-right: 5px;
    }
    input[type="text"] {
        width: 200px;
        height: 30px;
        margin-right: 20px;
        border-radius: 10px;
        border: 1px solid gray;
        padding: 0 10px;
        transition: border-color 0.3s, box-shadow 0.3s;
        outline: none; /* Tarayıcı outline'ını kaldırır */
    }

    input[type="text"]:focus {
        border-color: #007bff; /* Odaklandığında border rengini değiştirir */
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Box shadow ekler */
    }
</style>
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
                                <swiper-container class="mySwiper" init="false"

                                                  >
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
                                <swiper-container class="mySwiper"  pagination="true" pagination-clickable="true"
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
                        @php
                            $closedDateTimestamp = \Carbon\Carbon::createFromTimestamp($tender->closed_date)->format('M-d-Y H:i:s');
                            $closedDateFormatted = \Carbon\Carbon::createFromTimestamp($tender->closed_date)->translatedFormat('d-m-Y');
                        @endphp

                        <div class="tender-info">
                            <span class="tender-label">İhale Bitiş Tarihi: {{ $closedDateFormatted }}</span>
                            <span class="countdown" id="gerisayim{{ $tender->id }}"></span>
                        </div>


                        <script>
                            document.addEventListener('DOMContentLoaded', (event) => {
                                var countDownDate{{ $tender->id }} = new Date("{{ $closedDateTimestamp }}").getTime();

                                var x = setInterval(function() {

                                    var now = new Date().getTime();
                                    var distance = countDownDate{{ $tender->id }} - now;

                                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                    if (hours < 10) { hours = '0' + hours; }
                                    if (minutes < 10) { minutes = '0' + minutes; }
                                    if (seconds < 10) { seconds = '0' + seconds; }

                                    var countdownString = days + " gün " + hours + ":" + minutes + ":" + seconds;

                                    document.getElementById("gerisayim{{ $tender->id }}").innerHTML = '<i class="fa fa-clock"></i> ' + countdownString;

                                    if (distance < 0) {
                                        clearInterval(x);
                                        document.getElementById("gerisayim{{ $tender->id }}").innerHTML = "<i class='fa fa-clock'></i> İhale Sona Erdi";
                                    }

                                }, 1000);
                            });
                        </script>

                        <div style="display: flex;justify-content: center">
                            <form action="{{route("user.bid.store",["tender_id" => $tender["id"]])}}" method="post">
                                @csrf
                                <input class="form" type="text" name="bid" id="bid" placeholder="TEKLİF VER" >

                                <button class="btn btn-primary btn-sm" type="submit">Teklif Ver</button>
                            </form>
                        </div>
                        <div class="row p-3">
                            <div class="col-md-6">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <strong>İhale ID:</strong> {{$tender["tender_no"]}}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Marka:</strong> {{$tender["brand"]}}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Model:</strong> {{$tender["model"]}}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Model Yılı:</strong> {{$tender["year"]}}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>KM:</strong> {{$tender["km"]}}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Plaka:</strong> {{$tender["plate"]}}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Yakıt Tipi:</strong> {{$tender["fuel_type"]}}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>TSRB Bedeli:</strong> {{$tender["tsrb"]}}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Vites Tipi:</strong> {{$tender["gear"]}}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Araç Tipi:</strong> {{$tender["car_type"]}}
                                    </li>

                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <strong>İhale Tipi:</strong> {{$tender["tender_doc"]}}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Servis Bilgisi:</strong> {{$tender["service_name"]}}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Servis Adresi:</strong> {{$tender["address"]}}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Servis Telefon:</strong> {{$tender["service_phone"]}}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Servis Tipi:</strong> {{$tender["service_type"]}}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Şehir:</strong> {{$tender["city"]}}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>İlçe:</strong> {{$tender["district"]}}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Araç Hasar Tipi:</strong> {{$tender["damages"]}}
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!--
                        <div class="row p-3">
                            <div class="col-md-6">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td>İhale <ID></ID> :</td>
                                        <td>{{$tender["tender_no"]}}</td>
                                    </tr>
                                    <tr>
                                        <td>Marka :</td>
                                        <td>{{$tender["brand"]}}</td>
                                    </tr>

                                    <tr>
                                        <td>Model :</td>
                                        <td>{{$tender["model"]}}</td>
                                    </tr>
                                    <tr>
                                        <td>Model Yılı :</td>
                                        <td>{{$tender["year"]}}</td>
                                    </tr>

                                    <tr>
                                        <td>KM :</td>
                                        <td>{{$tender["km"]}}</td>
                                    </tr>
                                    <tr>
                                        <td>Plaka :</td>
                                        <td>{{$tender["plate"]}}</td>
                                    </tr>

                                    <tr>
                                        <td>Yakıt Tipi :</td>
                                        <td>{{$tender["fuel_type"]}}</td>
                                    </tr>

                                    <tr>
                                        <td>TSRB Bedeli :</td>
                                        <td>{{$tender["tsrb"]}}</td>
                                    </tr>
                                    <tr>
                                        <td>Vites Tipi :</td>
                                        <td>{{$tender["gear"]}}</td>
                                    </tr>

                                    <tr>
                                        <td>Araç Tipi :</td>
                                        <td>{{$tender["car_type"]}}</td>
                                    </tr>

                                    <tr>
                                        <td>İhale Tipi :</td>
                                        <td>{{$tender["tender_doc"]}}</td>
                                    </tr>

                                    <tr>
                                        <td>İhale Firması :</td>
                                        <td>{{\App\Models\Company::find($tender->company_id)->name ?? "Bilinmiyor"}}</td>
                                    </tr>

                                </tbody>
                            </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-striped">
                                    <tbody>

                                    <tr>
                                        <td>Araç Hasar Tipi :</td>
                                        <td>{{$tender["damages"]}}</td>
                                    </tr>

                                    <tr>
                                        <td>Servis Bilgisi :</td>
                                        <td>{{$tender["service_name"]}}</td>
                                    </tr>
                                    <tr>
                                        <td>Servis Adresi :</td>
                                        <td>{{$tender["address"]}}</td>
                                    </tr>
                                    <tr>
                                        <td>Servis Telefon :</td>
                                        <td>{{$tender["service_phone"]}}</td>
                                    </tr>
                                    <tr>
                                        <td>Servis Tipi :</td>
                                        <td>{{$tender["service_type"]}}</td>
                                    </tr>
                                    <tr>
                                        <td>Şehir :</td>
                                        <td>{{$tender["city"]}}</td>
                                    </tr>
                                    <tr>
                                        <td>İlçe:</td>
                                        <td>{{$tender["district"]}}</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const swiperEl = document.querySelector('.mySwiper')

        Object.assign(swiperEl, {
            slidesPerView:1,
            spaceBetween:2,
            pagination:{
                clickable: true,
            },

            navigation:true,
          breakpoints: {
            640: {
              slidesPerView: 3,
              spaceBetween: 10,
            },
            1200:{
                slidesPerView: 5,
              spaceBetween: 15,
            }

          },
        });
        swiperEl.initialize();
      </script>
@endsection
