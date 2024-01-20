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
                            <div class="col">
                                <div class="mb-3">
                                    <label for="mailer_from_name" class="form-label">Gönderen İsim</label>
                                    <div class="input-group input-group-merge">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="mailer_from_name"
                                            name="mailer_from_name"
                                            autofocus
                                            value="{{ $mail["mailer_from_name"] }}"
                                        />
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="mailer_driver" class="form-label">Sunucu Türü</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        id="mailer_driver"
                                        name="mailer_driver"
                                        value="{{ $mail["mailer_driver"] }}"
                                    />
                                </div>
                                <div class="mb-3">
                                    <label for="mailer_from_address" class="form-label">Gönderen Mail</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        name="mailer_from_address"
                                        id="mailer_from_address"
                                        value="{{ $mail["mailer_from_address"] }}"
                                    />
                                </div>
                                <div class="mb-3">
                                    <label for="mailer_encryption" class="form-label">Şifreleme Tipi</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        name="mailer_encryption"
                                        id="mailer_encryption"
                                        value="{{ $mail["mailer_encryption"] }}"
                                    />
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="mailer_port" class="form-label">Port</label>
                                    <div class="input-group input-group-merge">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="mailer_port"
                                            name="mailer_port"
                                            value="{{ $mail["mailer_port"] }}"
                                        />
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="mailer_password" class="form-label">Şifre</label>
                                    <input
                                        class="form-control"
                                        type="password"
                                        id="mailer_password"
                                        name="mailer_password"
                                        value="{{ $mail["mailer_password"] }}"
                                    />
                                </div>
                                <div class="mb-3">
                                    <label for="mailer_username" class="form-label">Kullanıcı Adı</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        name="mailer_username"
                                        id="mailer_username"
                                        value="{{ $mail["mailer_username"] }}"
                                    />
                                </div>
                                <div class="mb-3">
                                    <label for="mailer_host" class="form-label">Hosting</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        name="mailer_host"
                                        id="mailer_host"
                                        value="{{ $mail["mailer_host"] }}"
                                    />
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
