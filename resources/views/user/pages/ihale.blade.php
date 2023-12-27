@extends('user.layout.app')

@section('title', 'Home Page')
@section('content')

    <div class="container mt-5 mb-5">
        <div class="d-flex justify-content-center row">
            <div class="col-md-11">
                @foreach($tenders as $tender)
                    <div class="row p-2 bg-white border rounded mt-3">
                        @if($tender["company_id"] !== 99)
                            @if(isset($tender["images"]))
                                <div class="col-md-3 mt-1">
                                    <img style="height: 200px;object-fit: cover;"
                                         class="img-fluid img-responsive rounded product-image"
                                         src="{{json_decode($tender["images"],true)[0]}}">
                                </div>
                            @else
                                <div class="col-md-3 mt-1">
                                    <img style="height: 200px;object-fit: cover;"
                                         class="img-fluid img-responsive rounded product-image"
                                         src="{{asset("user/img/no_image.png")}}">
                                </div>
                            @endif
                        @else
                            @php $images = \App\Models\TenderImages::where("tender_id", $tender["id"])->first() @endphp

                            @if(isset($images))
                                <div class="col-md-3 mt-1">
                                    <img style="height: 200px;object-fit: cover;"
                                         class="img-fluid img-responsive rounded product-image"
                                         src="{{$images->url}}">
                                </div>
                            @else
                                <div class="col-md-3 mt-1">
                                    <img style="height: 200px;object-fit: cover;"
                                         class="img-fluid img-responsive rounded product-image"
                                         src="{{asset("user/img/no_image.png")}}">
                                </div>
                            @endif
                        @endif

                        <div class="col-md-6 mt-1">
                            <h5>{{ substr($tender["name"], 0, 37)}} </h5>

                            <table class="table table-striped">
                                <tbody>
                                @if(isset($tender["brand"]))
                                    <tr>
                                        <td>Marka :</td>
                                        <td>{{$tender["brand"]}}</td>
                                    </tr>
                                @endif
                                @if(isset($tender["model"]))
                                    <tr>
                                        <td>Model :</td>
                                        <td>{{$tender["model"]}}</td>
                                    </tr>
                                @endif
                                @if(isset($tender["year"]))
                                    <tr>
                                        <td>Model Yılı :</td>
                                        <td>{{$tender["year"]}}</td>
                                    </tr>
                                @endif
                                @if(isset($tender["km"]))
                                    <tr>
                                        <td>KM :</td>
                                        <td>{{$tender["km"]}}</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="align-items-center align-content-center col-md-3 border-left mt-1">
                            <div class="d-flex flex-row align-items-center">
                                <h4 class="mr-1">$14.99</h4><span class="strike-text">$20.99</span>
                            </div>
                            <h6 class="text-success">Free shipping</h6>
                            <div class="d-flex flex-column mt-4">
                                <button class="btn btn-primary btn-sm" type="button">Teklif Ver</button>
                                <button class="btn btn-outline-primary btn-sm mt-2" type="button">İhale
                                    No: {{$tender["tender_no"]}}
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="mt-4 d-flex justify-content-center">
                    {{ $tenders->links('pagination') }}
                </div>
            </div>
        </div>
    </div>


    <style>

        .ratings i {
            font-size: 16px;
            color: red
        }

        .strike-text {
            color: red;
            text-decoration: line-through
        }

        .product-image {
            width: 100%
        }

        .dot {
            height: 7px;
            width: 7px;
            margin-left: 6px;
            margin-right: 6px;
            margin-top: 3px;
            background-color: blue;
            border-radius: 50%;
            display: inline-block
        }

        .spec-1 {
            color: #938787;
            font-size: 15px
        }

        h5 {
            font-weight: 400
        }

        .para {
            font-size: 16px
        }
    </style>

@endsection
