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
                          action="{{route("panel.contact.store")}}">
                        @csrf


                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="address" class="form-label">Adres</label>
                                <div class="input-group input-group-merge">
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="address"
                                        name="address"
                                        autofocus
                                        value="{{  $contactInfos->address ?? '' }}"
                                    />
                                </div>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="email" class="form-label">E-Mail</label>
                                <input
                                    class="form-control"
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ $contactInfos->email ?? '' }}"
                                />
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="phone" class="form-label">Telefon</label>
                                <input class="form-control" type="text" name="phone" id="phone"
                                       placeholder="0505 555 55 55" value="{{ $contactInfos->phone ?? '' }}"
                                />
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
