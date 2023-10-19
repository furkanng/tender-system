@extends('front.layout.app')

@section('title', 'Home Page')
@section('content')

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

@endsection
