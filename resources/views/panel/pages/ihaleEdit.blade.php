@extends('panel.layout.app')

@section('title', 'Home Page')
@section('content')
    <div class="nav-align-top mb-4">
        <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
            <li class="nav-item">
                <button
                    type="button"
                    class="nav-link active"
                    role="tab"
                    data-bs-toggle="tab"
                    data-bs-target="#navs-pills-justified-home"
                    aria-controls="navs-pills-justified-home"
                    aria-selected="true"
                >
                    <i class="tf-icons bx bxs-car"></i> Araç Bilgileri
                </button>
            </li>
            <li class="nav-item">
                <button
                    type="button"
                    class="nav-link"
                    role="tab"
                    data-bs-toggle="tab"
                    data-bs-target="#navs-pills-justified-profile"
                    aria-controls="navs-pills-justified-profile"
                    aria-selected="false"
                >
                    <i class="tf-icons bx bx-user"></i> Servis Bilgileri
                </button>
            </li>
            <li class="nav-item">
                <button
                    type="button"
                    class="nav-link"
                    role="tab"
                    data-bs-toggle="tab"
                    data-bs-target="#navs-pills-justified-messages"
                    aria-controls="navs-pills-justified-messages"
                    aria-selected="false"
                >
                    <i class="tf-icons bx bx-message-square"></i> İhale Geçmişi
                </button>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                <div class="row mb-5">
                    <div class="col-3"><h5 class="card-header">Araç Görselleri</h5></div>
                    <div class="col-6">
                        @if($tenders->company_id == 99)
                            <form method="POST" action="{{route("panel.tender.images.update",["id" => $tenders->id])}}"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <label for="formFileMultiple" class="d-flex justify-content-center form-label mx-2">Çoklu
                                    Resim Yükle</label>
                                <div class="d-flex flex-row">
                                    <input class="form-control" type="file" id="formFileMultiple" name="images[]"
                                           multiple/>
                                    <button type="submit" class="btn btn-outline-success me-2 mx-2">Ekle</button>
                                </div>
                            </form>
                        @endif</div>
                    <div class="col-3" style="display: flex; justify-content: end">
                        <h5 class="card-header">
                            @if($tenders->company_id !== 99)
                                {{isset($tenders->images) ? count(json_decode($tenders->images)): 0}} Tane
                            @else
                                @php $images =\App\Models\TenderImages::where("tender_id",$tenders->id)->get() @endphp
                                {{isset($images) ? count($images): 0}} Tane
                            @endif
                        </h5>
                    </div>
                </div>

                @if(isset($tenders->images) && $tenders->company_id !== 99)
                    <div class="card-body">
                        @php $imageCounter = 0 @endphp
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            @foreach(json_decode($tenders->images) as $image)
                                @if($imageCounter < 9)
                                    <a target="_blank" href={{ $image }}>
                                        <img
                                            src="{{ $image }}"
                                            alt="images"
                                            class="d-block rounded"
                                            height="100"
                                            width="100"
                                            id="images"
                                        />
                                    </a>
                                    @php $imageCounter++ @endphp
                                @endif
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="card-body">
                        @php $images = \App\Models\TenderImages::where("tender_id", $tenders->id)->get() @endphp
                        @php $imageCounter = 0 @endphp
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            @foreach($images as $image)
                                @if($imageCounter < 9)
                                    <div class="position-relative">
                                        <a target="_blank" href="{{ $image->url }}">
                                            <img
                                                src="{{ $image->url }}"
                                                alt="images"
                                                class="d-block rounded"
                                                height="100"
                                                width="100"
                                                id="images"
                                            />
                                        </a>
                                        <!-- Resim Silme Butonu -->
                                        <form action="{{route("panel.tender.images.destroy",["id" => $image->id])}}"
                                              method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit"
                                                    class="btn btn-danger btn-sm position-absolute top-0 end-0">
                                                Sil
                                            </button>
                                        </form>
                                    </div>
                                    @php $imageCounter++ @endphp
                                @endif
                            @endforeach
                        </div>
                    </div>

                @endif
                <hr class="my-0"/>
                <div class="card-body">
                    <form method="POST"
                          action="{{ route("panel.tender.update", ['id' => $tenders->id]) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="tender_no" class="form-label">İhale No</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="tender_no"
                                    name="tender_no"
                                    value="{{($tenders->tender_no)}}"
                                    disabled
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">İhale Adı</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{$tenders->name}}"
                                    autofocus
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="lastName" class="form-label">Marka</label>
                                <input class="form-control" type="text" name="marka" id="marka"
                                       value="{{$tenders->brand}}"/>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="model" class="form-label">Model</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="model"
                                    name="model"
                                    value="{{$tenders->brand}}"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="year" class="form-label">Yıl</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="year"
                                    name="year"
                                    value="{{$tenders->year}}"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="km" class="form-label">Km</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="km"
                                    name="km"
                                    value="{{$tenders->km}}"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="plate" class="form-label">Plaka</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="plate"
                                    name="plate"
                                    value="{{$tenders->plate}}"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="fuel_type" class="form-label">Yakıt Tipi</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="fuel_type"
                                    name="fuel_type"
                                    value="{{$tenders->fuel_type}}"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="roll" class="form-label">Silindir</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="roll"
                                    name="roll"
                                    value="{{$tenders->roll}}"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="tsrsb" class="form-label">TSRSB</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="tsrsb"
                                    name="tsrsb"
                                    value="{{$tenders->tsrsb}}"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="gear" class="form-label">Vites</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="gear"
                                    name="gear"
                                    value="{{$tenders->gear}}"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="sase_no" class="form-label">Şase No</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="sase_no"
                                    name="sase_no"
                                    value="{{$tenders->sase_no}}"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="car_type" class="form-label">Araç Tipi</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="car_type"
                                    name="car_type"
                                    value="{{$tenders->car_type}}"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="tender_type" class="form-label">İhale Tipi</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="tender_type"
                                    name="tender_type"
                                    value="{{strtoupper($tenders->tender_type)}}"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="closed_date" class="form-label">Kapanış Tarihi</label>
                                <input
                                    type="datetime-local"
                                    class="form-control"
                                    id="closed_date"
                                    name="closed_date"
                                    value="{{$tenders->closed_date}}"
                                    @if($tenders->company_id !== 99) disabled @endif
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <div class="form-check form-switch mt-4">
                                    <input style="width: 50px; height: 30px" name="status" class="form-check-input"
                                           type="checkbox"
                                           id="flexSwitchCheckChecked"
                                           value="{{$tenders->status}}"
                                           @if($tenders->status == 1) checked @endif
                                    />
                                    <label class="form-check-label mx-2" for="flexSwitchCheckChecked"
                                    >Durum</label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Kaydet</button>
                            <button type="reset" class="btn btn-outline-secondary">Geri</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="tab-pane fade" id="navs-pills-justified-profile" role="tabpanel">
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                @if($tenders->company_id !== 99)
                                    <p class="card-text">
                                        {{$tenders->serviceName . " ".$tenders->servicePhone." ". $tenders->address . " ". $tenders->city . " ". $tenders->district}}
                                    </p>
                                @else
                                    <form method="POST"
                                          action="{{ route("panel.tender.update", ['id' => $tenders->id]) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="serviceName" class="form-label">Servis Adı</label>
                                                <input
                                                    class="form-control"
                                                    type="text"
                                                    id="serviceName"
                                                    name="serviceName"
                                                    value="{{$tenders->serviceName}}"
                                                />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="address" class="form-label">Adres</label>
                                                <input
                                                    class="form-control"
                                                    type="text"
                                                    id="address"
                                                    name="address"
                                                    value="{{$tenders->address}}"
                                                />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="servicePhone" class="form-label">Servis Telefon</label>
                                                <input
                                                    class="form-control"
                                                    type="text"
                                                    id="servicePhone"
                                                    name="servicePhone"
                                                    value="{{$tenders->servicePhone}}"
                                                />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="city" class="form-label">Şehir</label>
                                                <input
                                                    class="form-control"
                                                    type="text"
                                                    id="city"
                                                    name="city"
                                                    value="{{$tenders->city}}"
                                                />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="district" class="form-label">İlçe</label>
                                                <input
                                                    class="form-control"
                                                    type="text"
                                                    id="district"
                                                    name="district"
                                                    value="{{$tenders->district}}"
                                                />
                                            </div>
                                            <div class="mt-2">
                                                <button type="submit" class="btn btn-primary me-2">Kaydet</button>
                                            </div>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4>Hasar Bilgileri</h4>
                                <p class="card-text">
                                    {{$tenders->damages !== "" ? $tenders->damages : "Hasar Kayıtı Bulunamamıştır"}}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <p class="card-text">
                                    Oluşturulma tarihi :
                                    {{$tenders->created_at}}
                                </p>
                                <p class="card-text">
                                    Güncellenme tarihi :
                                    {{$tenders->updated_at}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="tab-pane fade" id="navs-pills-justified-messages" role="tabpanel">
                <p>
                    Oat cake chupa chups dragée donut toffee. Sweet cotton candy jelly beans macaroon gummies
                    cupcake gummi bears cake chocolate.
                </p>
                <p class="mb-0">
                    Cake chocolate bar cotton candy apple pie tootsie roll ice cream apple pie brownie cake. Sweet
                    roll icing sesame snaps caramels danish toffee. Brownie biscuit dessert dessert. Pudding jelly
                    jelly-o tart brownie jelly.
                </p>
            </div>
        </div>
    </div>
@endsection
