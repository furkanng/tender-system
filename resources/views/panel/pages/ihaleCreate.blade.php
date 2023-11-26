@extends('panel.layout.app')

@section('title', 'Home Page')
@section('content')
    <div class="nav-align-top mb-4">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                <h5 class="card-header">Araç Görselleri</h5>
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img
                            src="#"
                            alt="user-avatar"
                            class="d-block rounded"
                            height="100"
                            width="100"
                            id="uploadedAvatar"
                        />
                    </div>
                </div>

                <hr class="my-0"/>
                <div class="card-body">
                    <form method="POST"
                          action="{{route("panel.tender.store")}}">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">İhale Adı *</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="name"
                                    name="name"
                                    autofocus
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="brand" class="form-label">Marka *</label>
                                <input class="form-control" type="text" name="brand" id="brand"/>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="model" class="form-label">Model</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="model"
                                    name="model"

                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="year" class="form-label">Yıl</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="year"
                                    name="year"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="km" class="form-label">Km</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="km"
                                    name="km"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="plate" class="form-label">Plaka</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="plate"
                                    name="plate"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="fuel_type" class="form-label">Yakıt Tipi</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="fuel_type"
                                    name="fuel_type"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="roll" class="form-label">Silindir</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="roll"
                                    name="roll"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="tsrsb" class="form-label">TSRSB</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="tsrsb"
                                    name="tsrsb"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="gear" class="form-label">Vites</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="gear"
                                    name="gear"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="sase_no" class="form-label">Şase No</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="sase_no"
                                    name="sase_no"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="car_type" class="form-label">Araç Tipi</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="car_type"
                                    name="car_type"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="tender_no" class="form-label">İhale No *</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text" id="tender_no">WS-</span>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="tender_no"
                                        name="tender_no"
                                    />
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="serviceName" class="form-label">Servis Adı</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="serviceName"
                                    name="serviceName"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="address" class="form-label">Adres</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="address"
                                    name="address"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="servicePhone" class="form-label">Servis Telefonu</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="servicePhone"
                                    name="servicePhone"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="city" class="form-label">Şehir</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="city"
                                    name="city"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="district" class="form-label">İlçe</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="district"
                                    name="district"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="closed_date" class="form-label">Kapanış Tarihi</label>
                                <input
                                    type="datetime-local"
                                    class="form-control"
                                    id="closed_date"
                                    name="closed_date"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="tender_type" class="form-label">İhale Tipi *</label>
                                <select class="form-select" id="tender_type" name="tender_type"
                                        aria-label="Default select example">
                                    <option selected value="KAPALI">KAPALI</option>
                                    <option value="AÇIK">AÇIK</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="damages" class="form-label">Hasar Bilgileri</label>
                                <textarea class="form-control" id="damages" rows="3" name="damages"></textarea>
                            </div>
                            <div class="mb-3 col-md-6">
                                <div class="form-check form-switch mt-4">
                                    <input style="width: 50px; height: 30px" name="status" class="form-check-input"
                                           type="checkbox"
                                           id="flexSwitchCheckChecked"
                                           checked/>
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
        </div>
    </div>
@endsection
