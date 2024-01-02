@extends('front.layout.app')

@section('title', 'Home Page')
@section('content')

    <!-- Header Start -->
    <div class="container-fluid header bg-white p-0">
        <div class="row g-0 align-items-center flex-column-reverse flex-md-row">
            <div class="col-md-6 p-5 mt-lg-5">
                <h1 class="display-5 animated fadeIn mb-4">
                    En Güvenilir <span class="text-primary"> Hasarlı Araç</span> İhale Platformu
                </h1>
                <p class="animated fadeIn mb-4 pb-2">


                </p>
                <a href="" class="btn btn-primary py-3 px-5 me-3 animated fadeIn"
                >Teklif Ver</a
                >
            </div>
            <div class="col-md-6 animated fadeIn">
                <div class="owl-carousel header-carousel">
                    <div class="owl-carousel-item">
                        <img class="img-fluid" src="{{asset("front/resimler/slider-1.jpg")}}" alt=""/>
                    </div>
                    <div class="owl-carousel-item">
                        <img class="img-fluid" src="{{asset("front/resimler/slider-2.jpg")}}" alt=""/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Search Start -->
    <div
        class="container-fluid bg-primary mb-5 wow fadeIn"
        data-wow-delay="0.1s"
        style="padding: 35px"
    >
        <div class="container">
            <div class="row g-2">
                <div class="col-md-10">
                    <div class="row g-2">
                        <div class="col-md-8">
                            <input
                                type="text"
                                class="form-control border-0 py-3"
                                placeholder="Marka, Model giriniz"
                            />
                        </div>
                        <div class="col-md-4">
                            <select class="form-select border-0 py-3">
                                <option selected>Lokasyon Seçiniz</option>
                                <option value="1">İstanbul</option>
                                <option value="2">Ankara</option>
                                <option value="3">İzmir</option>
                                <option value="4">Manisa</option>
                                <option value="5">Adana</option>
                                <option value="6">Konya</option>
                                <option value="7">Bursa</option>
                                <option value="8">Kocaeli</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-dark border-0 w-100 py-3">Arama Yap</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Search End -->

    <!-- Category Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div
                class="text-center mx-auto mb-5 wow fadeInUp"
                data-wow-delay="0.1s"
                style="max-width: 600px"
            >
                <h1 class="mb-3">Nasıl Çalışır</h1>
                <p>
                    Yılda 56.000'den Fazla Aracın İşlem Gördüğü
                    Kapsamlı Oto İhale Platformu
                </p>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <a
                        class="cat-item d-block bg-light text-center rounded p-3"
                        href=""
                    >
                        <div class="rounded p-4">
                            <div class="icon mb-3">
                                <img
                                    class="img-fluid"
                                    src="{{asset("front/img/icon-condominium.png")}}"
                                    alt="Icon"
                                />
                            </div>
                            <h6>Kayıt Olun</h6>
                            <span>Hemen üyelik oluşturun. Ve teklif vermeye başlayın</span>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                    <a
                        class="cat-item d-block bg-light text-center rounded p-3"
                        href=""
                    >
                        <div class="rounded p-4">
                            <div class="icon mb-3">
                                <img
                                    class="img-fluid"
                                    src="{{asset("front/img/icon-villa.png")}}"
                                    alt="Icon"
                                />
                            </div>
                            <h6>İlanları Kontrol Edin!</h6>
                            <span>Her gün gerçekleşen binlerce araç ihalesine gözatın</span>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                    <a
                        class="cat-item d-block bg-light text-center rounded p-3"
                        href=""
                    >
                        <div class="rounded p-4">
                            <div class="icon mb-3">
                                <img
                                    class="img-fluid"
                                    src="{{asset("front/img/icon-house.png")}}"
                                    alt="Icon"
                                />
                            </div>
                            <h6>Teklif Verin</h6>
                            <span>İstediğiniz herhangi bir araca teklif verebilirsiniz.</span>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <a
                        class="cat-item d-block bg-light text-center rounded p-3"
                        href=""
                    >
                        <div class="rounded p-4">
                            <div class="icon mb-3">
                                <img
                                    class="img-fluid"
                                    src="{{asset("front/img/icon-villa.png")}}"
                                    alt="Icon"
                                />
                            </div>
                            <h6>Kazanç Sağlayın</h6>
                            <span>Türkiyenin en güvenilir hasarlı araç platformunda öne çıkın.</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Category End -->

    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="about-img position-relative overflow-hidden p-5 pe-0">
                        <img class="img-fluid w-100" src="{{asset("front/resimler/about.jpg")}}"/>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <h1 class="mb-4">Oto İhale Sistemi Hakkında</h1>
                    <p class="mb-4">
                        Tüm sigorta şirketlerinin hasarlı araçlarını inceleyip teklif verebilirsiniz.
                    </p>
                    <p>
                        <i class="fa fa-check text-primary me-3"></i>Teklif verilen araç, ihale sonunda size kalırsa
                        işlemleri yapılır.
                    </p>
                    <p>
                        <i class="fa fa-check text-primary me-3"></i>Sigortadan ödeme emri geldiğinde 3 iş günü
                        içerisinde aracın ödemesi yapılır.
                    </p>
                    <p>
                        <i class="fa fa-check text-primary me-3"></i>Teklif verdiğim araç, ihalede bana kalırsa araç
                        teslim edilir.
                    </p>
                    <a class="btn btn-primary py-3 px-5 mt-3" href="">Daha Fazla</a>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Property List Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-0 gx-5 align-items-end">
                <div class="col-lg-6">
                    <div
                        class="text-start mx-auto mb-5 wow slideInLeft"
                        data-wow-delay="0.1s"
                    >
                        <h1 class="mb-3">İhaledeki Bazı Araçlar</h1>
                        <p>
                            İhaledeki güncel araçları inceleyebilirsiniz.
                        </p>
                    </div>
                </div>
                <div
                    class="col-lg-6 text-start text-lg-end wow slideInRight"
                    data-wow-delay="0.1s"
                >
                    <ul class="nav nav-pills d-inline-flex justify-content-end mb-5">
                        <li class="nav-item me-2">
                            <a
                                class="btn btn-outline-primary active"
                                data-bs-toggle="pill"
                                href="#tab-1"
                            >Featured</a
                            >
                        </li>
                        <li class="nav-item me-2">
                            <a
                                class="btn btn-outline-primary"
                                data-bs-toggle="pill"
                                href="#tab-2"
                            >For Sell</a
                            >
                        </li>
                        <li class="nav-item me-0">
                            <a
                                class="btn btn-outline-primary"
                                data-bs-toggle="pill"
                                href="#tab-3"
                            >For Rent</a
                            >
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane fade show p-0 active">
                    <div class="row g-4">
                       
                        @foreach ( $lastSixTenders as $item)
                        @php
                        $imagesArray = json_decode($item->images, true);
                        $firstImage = isset($imagesArray[0]) ? $imagesArray[0] : null;
                        @endphp
                        <div
                            class="col-lg-4 col-md-6 wow fadeInUp"
                            data-wow-delay="0.5s"
                        >
                            <div class="property-item rounded overflow-hidden">
                                <div class="position-relative overflow-hidden">
                                    <a href=""
                                    ><img class="img-fluid" src="{{$firstImage}}" alt="" style="height:30vh !important"
                                        /></a>
                                    <div
                                        class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3"
                                    >
                                        For Rent
                                    </div>
                                    <div
                                        class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3"
                                    >
                                        {{$item->brand}}
                                    </div>
                                </div>
                                <div class="p-4 pb-0">
                                    <h5 class="text-primary mb-3">{{$item->year}}</h5>
                                    <a class="d-block h5 mb-2" href=""
                                    >{{$item->name}}</a
                                    >
                                    <p>
                                        <i class="fa fa-map-marker-alt text-primary me-2"></i
                                        >{{$item->city}}
                                    </p>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="flex-fill text-center border-end py-2"
                                    ><i class="fa fa-ruler-combined text-primary me-2"></i
                                        >{{$item->gear}}</small
                                    >
                                    <small class="flex-fill text-center border-end py-2"
                                    ><i class="fa fa-bed text-primary me-2"></i>{{$item->car_type}}</small
                                    >
                                    <small class="flex-fill text-center py-2"
                                    ><i class="fa fa-bath text-primary me-2"></i>
                                    {{$item->damages}}
                                        </small
                                    >
                                </div>
                            </div>
                        </div>
    
                        @endforeach
                        <div
                            class="col-12 text-center wow fadeInUp"
                            data-wow-delay="0.1s"
                        >
                            <a class="btn btn-primary py-3 px-5" href="giris-yap"
                            >Tüm İlanları Görüntüle</a
                            >
                        </div>
                    </div>
                </div>
                <div id="tab-2" class="tab-pane fade show p-0">
                    <div class="row g-4">
                        <div class="col-lg-4 col-md-6">
                            <div class="property-item rounded overflow-hidden">
                                <div class="position-relative overflow-hidden">
                                    <a href=""
                                    ><img class="img-fluid" src="img/property-1.jpg" alt=""
                                        /></a>
                                    <div
                                        class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3"
                                    >
                                        For Sell
                                    </div>
                                    <div
                                        class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3"
                                    >
                                        Appartment
                                    </div>
                                </div>
                                <div class="p-4 pb-0">
                                    <h5 class="text-primary mb-3">$12,345</h5>
                                    <a class="d-block h5 mb-2" href=""
                                    >Golden Urban House For Sell</a
                                    >
                                    <p>
                                        <i class="fa fa-map-marker-alt text-primary me-2"></i
                                        >123 Street, New York, USA
                                    </p>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="flex-fill text-center border-end py-2"
                                    ><i class="fa fa-ruler-combined text-primary me-2"></i
                                        >1000 Sqft</small
                                    >
                                    <small class="flex-fill text-center border-end py-2"
                                    ><i class="fa fa-bed text-primary me-2"></i>3 Bed</small
                                    >
                                    <small class="flex-fill text-center py-2"
                                    ><i class="fa fa-bath text-primary me-2"></i>2
                                        Bath</small
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="property-item rounded overflow-hidden">
                                <div class="position-relative overflow-hidden">
                                    <a href=""
                                    ><img class="img-fluid" src="img/property-2.jpg" alt=""
                                        /></a>
                                    <div
                                        class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3"
                                    >
                                        For Rent
                                    </div>
                                    <div
                                        class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3"
                                    >
                                        Villa
                                    </div>
                                </div>
                                <div class="p-4 pb-0">
                                    <h5 class="text-primary mb-3">$12,345</h5>
                                    <a class="d-block h5 mb-2" href=""
                                    >Golden Urban House For Sell</a
                                    >
                                    <p>
                                        <i class="fa fa-map-marker-alt text-primary me-2"></i
                                        >123 Street, New York, USA
                                    </p>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="flex-fill text-center border-end py-2"
                                    ><i class="fa fa-ruler-combined text-primary me-2"></i
                                        >1000 Sqft</small
                                    >
                                    <small class="flex-fill text-center border-end py-2"
                                    ><i class="fa fa-bed text-primary me-2"></i>3 Bed</small
                                    >
                                    <small class="flex-fill text-center py-2"
                                    ><i class="fa fa-bath text-primary me-2"></i>2
                                        Bath</small
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="property-item rounded overflow-hidden">
                                <div class="position-relative overflow-hidden">
                                    <a href=""
                                    ><img class="img-fluid" src="img/property-3.jpg" alt=""
                                        /></a>
                                    <div
                                        class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3"
                                    >
                                        For Sell
                                    </div>
                                    <div
                                        class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3"
                                    >
                                        Office
                                    </div>
                                </div>
                                <div class="p-4 pb-0">
                                    <h5 class="text-primary mb-3">$12,345</h5>
                                    <a class="d-block h5 mb-2" href=""
                                    >Golden Urban House For Sell</a
                                    >
                                    <p>
                                        <i class="fa fa-map-marker-alt text-primary me-2"></i
                                        >123 Street, New York, USA
                                    </p>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="flex-fill text-center border-end py-2"
                                    ><i class="fa fa-ruler-combined text-primary me-2"></i
                                        >1000 Sqft</small
                                    >
                                    <small class="flex-fill text-center border-end py-2"
                                    ><i class="fa fa-bed text-primary me-2"></i>3 Bed</small
                                    >
                                    <small class="flex-fill text-center py-2"
                                    ><i class="fa fa-bath text-primary me-2"></i>2
                                        Bath</small
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="property-item rounded overflow-hidden">
                                <div class="position-relative overflow-hidden">
                                    <a href=""
                                    ><img class="img-fluid" src="img/property-4.jpg" alt=""
                                        /></a>
                                    <div
                                        class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3"
                                    >
                                        For Rent
                                    </div>
                                    <div
                                        class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3"
                                    >
                                        Building
                                    </div>
                                </div>
                                <div class="p-4 pb-0">
                                    <h5 class="text-primary mb-3">$12,345</h5>
                                    <a class="d-block h5 mb-2" href=""
                                    >Golden Urban House For Sell</a
                                    >
                                    <p>
                                        <i class="fa fa-map-marker-alt text-primary me-2"></i
                                        >123 Street, New York, USA
                                    </p>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="flex-fill text-center border-end py-2"
                                    ><i class="fa fa-ruler-combined text-primary me-2"></i
                                        >1000 Sqft</small
                                    >
                                    <small class="flex-fill text-center border-end py-2"
                                    ><i class="fa fa-bed text-primary me-2"></i>3 Bed</small
                                    >
                                    <small class="flex-fill text-center py-2"
                                    ><i class="fa fa-bath text-primary me-2"></i>2
                                        Bath</small
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="property-item rounded overflow-hidden">
                                <div class="position-relative overflow-hidden">
                                    <a href=""
                                    ><img class="img-fluid" src="img/property-5.jpg" alt=""
                                        /></a>
                                    <div
                                        class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3"
                                    >
                                        For Sell
                                    </div>
                                    <div
                                        class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3"
                                    >
                                        Home
                                    </div>
                                </div>
                                <div class="p-4 pb-0">
                                    <h5 class="text-primary mb-3">$12,345</h5>
                                    <a class="d-block h5 mb-2" href=""
                                    >Golden Urban House For Sell</a
                                    >
                                    <p>
                                        <i class="fa fa-map-marker-alt text-primary me-2"></i
                                        >123 Street, New York, USA
                                    </p>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="flex-fill text-center border-end py-2"
                                    ><i class="fa fa-ruler-combined text-primary me-2"></i
                                        >1000 Sqft</small
                                    >
                                    <small class="flex-fill text-center border-end py-2"
                                    ><i class="fa fa-bed text-primary me-2"></i>3 Bed</small
                                    >
                                    <small class="flex-fill text-center py-2"
                                    ><i class="fa fa-bath text-primary me-2"></i>2
                                        Bath</small
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="property-item rounded overflow-hidden">
                                <div class="position-relative overflow-hidden">
                                    <a href=""
                                    ><img class="img-fluid" src="img/property-6.jpg" alt=""
                                        /></a>
                                    <div
                                        class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3"
                                    >
                                        For Rent
                                    </div>
                                    <div
                                        class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3"
                                    >
                                        Shop
                                    </div>
                                </div>
                                <div class="p-4 pb-0">
                                    <h5 class="text-primary mb-3">$12,345</h5>
                                    <a class="d-block h5 mb-2" href=""
                                    >Golden Urban House For Sell</a
                                    >
                                    <p>
                                        <i class="fa fa-map-marker-alt text-primary me-2"></i
                                        >123 Street, New York, USA
                                    </p>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="flex-fill text-center border-end py-2"
                                    ><i class="fa fa-ruler-combined text-primary me-2"></i
                                        >1000 Sqft</small
                                    >
                                    <small class="flex-fill text-center border-end py-2"
                                    ><i class="fa fa-bed text-primary me-2"></i>3 Bed</small
                                    >
                                    <small class="flex-fill text-center py-2"
                                    ><i class="fa fa-bath text-primary me-2"></i>2
                                        Bath</small
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <a class="btn btn-primary py-3 px-5" href=""
                            >Browse More Property</a
                            >
                        </div>
                    </div>
                </div>
                <div id="tab-3" class="tab-pane fade show p-0">
                    <div class="row g-4">
                        <div class="col-lg-4 col-md-6">
                            <div class="property-item rounded overflow-hidden">
                                <div class="position-relative overflow-hidden">
                                    <a href=""
                                    ><img class="img-fluid" src="img/property-1.jpg" alt=""
                                        /></a>
                                    <div
                                        class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3"
                                    >
                                        For Sell
                                    </div>
                                    <div
                                        class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3"
                                    >
                                        Appartment
                                    </div>
                                </div>
                                <div class="p-4 pb-0">
                                    <h5 class="text-primary mb-3">$12,345</h5>
                                    <a class="d-block h5 mb-2" href=""
                                    >Golden Urban House For Sell</a
                                    >
                                    <p>
                                        <i class="fa fa-map-marker-alt text-primary me-2"></i
                                        >123 Street, New York, USA
                                    </p>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="flex-fill text-center border-end py-2"
                                    ><i class="fa fa-ruler-combined text-primary me-2"></i
                                        >1000 Sqft</small
                                    >
                                    <small class="flex-fill text-center border-end py-2"
                                    ><i class="fa fa-bed text-primary me-2"></i>3 Bed</small
                                    >
                                    <small class="flex-fill text-center py-2"
                                    ><i class="fa fa-bath text-primary me-2"></i>2
                                        Bath</small
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="property-item rounded overflow-hidden">
                                <div class="position-relative overflow-hidden">
                                    <a href=""
                                    ><img class="img-fluid" src="img/property-2.jpg" alt=""
                                        /></a>
                                    <div
                                        class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3"
                                    >
                                        For Rent
                                    </div>
                                    <div
                                        class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3"
                                    >
                                        Villa
                                    </div>
                                </div>
                                <div class="p-4 pb-0">
                                    <h5 class="text-primary mb-3">$12,345</h5>
                                    <a class="d-block h5 mb-2" href=""
                                    >Golden Urban House For Sell</a
                                    >
                                    <p>
                                        <i class="fa fa-map-marker-alt text-primary me-2"></i
                                        >123 Street, New York, USA
                                    </p>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="flex-fill text-center border-end py-2"
                                    ><i class="fa fa-ruler-combined text-primary me-2"></i
                                        >1000 Sqft</small
                                    >
                                    <small class="flex-fill text-center border-end py-2"
                                    ><i class="fa fa-bed text-primary me-2"></i>3 Bed</small
                                    >
                                    <small class="flex-fill text-center py-2"
                                    ><i class="fa fa-bath text-primary me-2"></i>2
                                        Bath</small
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="property-item rounded overflow-hidden">
                                <div class="position-relative overflow-hidden">
                                    <a href=""
                                    ><img class="img-fluid" src="img/property-3.jpg" alt=""
                                        /></a>
                                    <div
                                        class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3"
                                    >
                                        For Sell
                                    </div>
                                    <div
                                        class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3"
                                    >
                                        Office
                                    </div>
                                </div>
                                <div class="p-4 pb-0">
                                    <h5 class="text-primary mb-3">$12,345</h5>
                                    <a class="d-block h5 mb-2" href=""
                                    >Golden Urban House For Sell</a
                                    >
                                    <p>
                                        <i class="fa fa-map-marker-alt text-primary me-2"></i
                                        >123 Street, New York, USA
                                    </p>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="flex-fill text-center border-end py-2"
                                    ><i class="fa fa-ruler-combined text-primary me-2"></i
                                        >1000 Sqft</small
                                    >
                                    <small class="flex-fill text-center border-end py-2"
                                    ><i class="fa fa-bed text-primary me-2"></i>3 Bed</small
                                    >
                                    <small class="flex-fill text-center py-2"
                                    ><i class="fa fa-bath text-primary me-2"></i>2
                                        Bath</small
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="property-item rounded overflow-hidden">
                                <div class="position-relative overflow-hidden">
                                    <a href=""
                                    ><img class="img-fluid" src="img/property-4.jpg" alt=""
                                        /></a>
                                    <div
                                        class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3"
                                    >
                                        For Rent
                                    </div>
                                    <div
                                        class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3"
                                    >
                                        Building
                                    </div>
                                </div>
                                <div class="p-4 pb-0">
                                    <h5 class="text-primary mb-3">$12,345</h5>
                                    <a class="d-block h5 mb-2" href=""
                                    >Golden Urban House For Sell</a
                                    >
                                    <p>
                                        <i class="fa fa-map-marker-alt text-primary me-2"></i
                                        >123 Street, New York, USA
                                    </p>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="flex-fill text-center border-end py-2"
                                    ><i class="fa fa-ruler-combined text-primary me-2"></i
                                        >1000 Sqft</small
                                    >
                                    <small class="flex-fill text-center border-end py-2"
                                    ><i class="fa fa-bed text-primary me-2"></i>3 Bed</small
                                    >
                                    <small class="flex-fill text-center py-2"
                                    ><i class="fa fa-bath text-primary me-2"></i>2
                                        Bath</small
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="property-item rounded overflow-hidden">
                                <div class="position-relative overflow-hidden">
                                    <a href=""
                                    ><img class="img-fluid" src="img/property-5.jpg" alt=""
                                        /></a>
                                    <div
                                        class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3"
                                    >
                                        For Sell
                                    </div>
                                    <div
                                        class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3"
                                    >
                                        Home
                                    </div>
                                </div>
                                <div class="p-4 pb-0">
                                    <h5 class="text-primary mb-3">$12,345</h5>
                                    <a class="d-block h5 mb-2" href=""
                                    >Golden Urban House For Sell</a
                                    >
                                    <p>
                                        <i class="fa fa-map-marker-alt text-primary me-2"></i
                                        >123 Street, New York, USA
                                    </p>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="flex-fill text-center border-end py-2"
                                    ><i class="fa fa-ruler-combined text-primary me-2"></i
                                        >1000 Sqft</small
                                    >
                                    <small class="flex-fill text-center border-end py-2"
                                    ><i class="fa fa-bed text-primary me-2"></i>3 Bed</small
                                    >
                                    <small class="flex-fill text-center py-2"
                                    ><i class="fa fa-bath text-primary me-2"></i>2
                                        Bath</small
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="property-item rounded overflow-hidden">
                                <div class="position-relative overflow-hidden">
                                    <a href=""
                                    ><img class="img-fluid" src="img/property-6.jpg" alt=""
                                        /></a>
                                    <div
                                        class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3"
                                    >
                                        For Rent
                                    </div>
                                    <div
                                        class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3"
                                    >
                                        Shop
                                    </div>
                                </div>
                                <div class="p-4 pb-0">
                                    <h5 class="text-primary mb-3">$12,345</h5>
                                    <a class="d-block h5 mb-2" href=""
                                    >Golden Urban House For Sell</a
                                    >
                                    <p>
                                        <i class="fa fa-map-marker-alt text-primary me-2"></i
                                        >123 Street, New York, USA
                                    </p>
                                </div>
                                <div class="d-flex border-top">
                                    <small class="flex-fill text-center border-end py-2"
                                    ><i class="fa fa-ruler-combined text-primary me-2"></i
                                        >1000 Sqft</small
                                    >
                                    <small class="flex-fill text-center border-end py-2"
                                    ><i class="fa fa-bed text-primary me-2"></i>3 Bed</small
                                    >
                                    <small class="flex-fill text-center py-2"
                                    ><i class="fa fa-bath text-primary me-2"></i>2
                                        Bath</small
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <a class="btn btn-primary py-3 px-5" href=""
                            >Browse More Property</a
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Property List End -->

    <!-- Call to Action Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="bg-light rounded p-3">
                <div
                    class="bg-white rounded p-4"
                    style="border: 1px dashed rgba(0, 185, 142, 0.3)"
                >
                    <div class="row g-5 align-items-center">
                        <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                            <img
                                class="img-fluid rounded w-100"
                                src="{{asset("front/img/call-to-action.jpg")}}"
                                alt=""
                            />
                        </div>
                        <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                            <div class="mb-4">
                                <h1 class="mb-3">Bizimle iletişime geçebilirsiniz.</h1>
                                <p>
                                    Merak ettiğiniz ve öğrenmek istediğiniz her şey için bize ulaşabilirsiniz.
                                </p>
                            </div>
                            <a href="" class="btn btn-primary py-3 px-4 me-2"
                            ><i class="fa fa-phone-alt me-2"></i>Bizi Arayın</a
                            >
                            <a href="" class="btn btn-dark py-3 px-4"
                            ><i class="fa fa-calendar-alt me-2"></i>İletişim</a
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Call to Action End -->

@endsection
