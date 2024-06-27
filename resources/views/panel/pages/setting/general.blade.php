@extends('panel.layout.app')

@section('title', 'Contact Page')
@section('content')
    <div class="nav-align-top mb-4">
        @if(session('message'))
            <script>
                $(document).ready(function () {
                    $('#successModal').modal('show');
                });
            </script>
        @endif
        <div class="tab-content">
            <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                <div class="card-body">
                    <form method="POST"
                          action="{{route("panel.general.store")}}">
                        @csrf

                        <div class="mb-3">
                            <label for="media_facebook" class="form-label">Site Başlık</label>
                            <div class="input-group input-group-merge">
                                <input
                                    type="text"
                                    class="form-control"
                                    id="site_title"
                                    name="site_title"
                                    autofocus
                                    value="{{ $general["site_title"] }}"
                                />
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="media_instagram" class="form-label">Site Anahtar Kelime</label>
                            <input
                                class="form-control"
                                type="text"
                                id="site_keywords"
                                name="site_keywords"
                                value="{{ $general["site_keywords"] }}"
                            />
                        </div>
                        <div class="mb-3">
                            <label for="media_twitter" class="form-label">Site Açıklama</label>
                            <input
                                class="form-control"
                                type="text"
                                name="site_description"
                                id="site_description"
                                value="{{ $general["site_description"] }}"
                            />
                        </div>
                        <div class="mb-3">
                            <label for="media_twitter" class="form-label">İhale Teklif Katsayısı</label>
                            <input
                                class="form-control"
                                type="text"
                                name="site_tender_factor"
                                id="site_tender_factor"
                                value="{{ $general["site_tender_factor"] }}"
                            />
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
