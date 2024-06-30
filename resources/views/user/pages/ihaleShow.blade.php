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
                        <div>
                            <form action="{{route("user.bid.store",["tender_id" => $tender["id"]])}}" method="post">
                                @csrf
                                <input class="form" type="text" name="bid" id="bid" placeholder="TEKLİF VER" >

                                <button class="btn btn-primary btn-sm" type="submit">Teklif Ver</button>
                            </form>
                        </div>
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
                                        <td>İhale Bitiş Tarihi :</td>
                                        <td>{{\Carbon\Carbon::createFromTimestamp($tender->closed_date)->format('d.m.Y')}}</td>
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
