@extends('panel.layout.app')

@section('title', 'User')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i>Profil</a>
                </li>
                <!--
                <li class="nav-item">
                    <a class="nav-link" href="pages-account-settings-notifications.html"
                    ><i class="bx bx-bell me-1"></i> Notifications</a
                    >
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pages-account-settings-connections.html"
                    ><i class="bx bx-link-alt me-1"></i> Connections</a
                    >
                </li>
                -->
            </ul>
            <div class="card mb-4">
                <h5 class="card-header">Profil Detayları</h5>
                <!-- Account -->
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <div id="profileImageContainer">
                            @if(empty($user->image))
                                <img
                                    src="{{ asset('panel/assets/img/avatars/no_profile.png') }}"
                                    alt="user-avatar"
                                    class="d-block rounded"
                                    height="100"
                                    width="100"
                                    id="profileImage"
                                />
                            @else
                                <img
                                    src="{{ url('storage/admin/'.$user->image) }}"
                                    alt="user-avatar"
                                    class="d-block rounded"
                                    height="100"
                                    width="100"
                                    id="profileImage"
                                />
                            @endif
                        </div>

                        <div class="button-wrapper d-flex">
                            <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                <form method="POST" enctype="multipart/form-data"
                                      action="{{route('panel.profile.update',["id" => $user->id])}}" id="uploadForm">
                                    @csrf
                                    @method("PUT")
                                    <span class="d-none d-sm-block">Yeni Fotoğraf Yükle</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input
                                        type="file"
                                        id="upload"
                                        name="image"
                                        class="account-file-input"
                                        hidden
                                        accept="image/png, image/jpeg"
                                        onchange="document.getElementById('uploadForm').submit()"
                                    />
                                </form>
                            </label>
                            <form method="POST" enctype="multipart/form-data"
                                  action="{{route("panel.profile.destroy",["id" => $user->id])}}">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="btn btn-outline-secondary account-image-reset mb-4">
                                    <i class="bx bx-reset d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Temizle</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @if(session('message'))
                    <script>
                        $(document).ready(function () {
                            $('#successModal').modal('show');
                        });
                    </script>
                @endif
                <hr class="my-0"/>
                <div class="card-body">
                    <form id="formAccountSettings" method="POST"
                          action="{{route("panel.profile.update",["id" => $user->id])}}">
                        @csrf
                        @method("PUT")
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="firstName" class="form-label">İsim Soyisim</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{$user->name}}"
                                    autofocus
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">E Mail</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    id="email"
                                    name="email"
                                    value="{{$user->email}}"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">Şifre</label>
                                <input
                                    class="form-control"
                                    type="password"
                                    id="password"
                                    name="password"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">Şifre Tekrar</label>
                                <input
                                    class="form-control"
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                />
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Kaydet</button>
                        </div>
                    </form>
                </div>
                <!-- /Account -->
            </div>
        </div>
    </div>

@endsection
