@extends('panel.layout.app')

@section('title', 'Contact Page')
@section('content')
    <div class="nav-align-top mb-4">
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <div class="tab-content">
            <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                <div class="card-body">
                    <form method="POST"
                          action="{{route("panel.api.store")}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="whatsapp_api" class="form-label">Whatsapp</label>
                                    <div class="input-group input-group-merge">
                                    <textarea
                                        class="form-control bg-black text-white"
                                        id="whatsapp_api"
                                        name="whatsapp_api"
                                        autofocus
                                    >{{ $api["whatsapp_api"] }}</textarea>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="phone_api" class="form-label">Telefon</label>
                                    <textarea
                                        class="form-control bg-black text-white"
                                        id="phone_api"
                                        name="phone_api"
                                    >{{ $api["phone_api"] }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="analytics_api" class="form-label">Analytics</label>
                                    <textarea
                                        class="form-control bg-black text-white"
                                        id="analytics_api"
                                        name="analytics_api"
                                    >{{ $api["analytics_api"] }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="rcaptha_api" class="form-label">R-Captha</label>
                                    <textarea
                                        class="form-control bg-black text-white"
                                        id="rcaptha_api"
                                        name="rcaptha_api"
                                    >{{ $api["rcaptha_api"] }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="webmaster_api" class="form-label">Web Master</label>
                                    <div class="input-group input-group-merge">
                                    <textarea
                                        class="form-control bg-black text-white"
                                        id="webmaster_api"
                                        name="webmaster_api"
                                    >{{ $api["webmaster_api"] }}</textarea>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="map_api" class="form-label">Harita</label>
                                    <textarea
                                        class="form-control bg-black text-white"
                                        id="map_api"
                                        name="map_api"
                                    >{{ $api["map_api"] }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="livesupport_api" class="form-label">Canlı Destek</label>
                                    <textarea
                                        class="form-control bg-black text-white"
                                        id="livesupport_api"
                                        name="livesupport_api"
                                    >{{ $api["livesupport_api"] }}</textarea>
                                </div>
                            </div>
                        </div>


                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Kaydet</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
