@extends('user.layout.app')

@section('title', 'Home Page')
@section('content')
    @if(session('message'))
        <script>
            $(document).ready(function () {
                $('#successModal').modal('show');
            });
        </script>
    @endif
    <div class="container mt-5 mb-5">
        <div class="alert alert-secondary" role="alert">
            Herhangi bir veri kaydetmek için şifrenizi zorunlu olarak giriniz. (Yeni şifre oluşturmak için de
            kullanılır.)
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Profil Detayları</h5>

                    <!-- Account -->
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <div id="profileImageContainer">
                                @if(empty($user->image))
                                    <img
                                        src="{{ asset('user/img/no_profile.png') }}"
                                        alt="user-avatar"
                                        class="d-block rounded"
                                        height="100"
                                        width="100"
                                        id="profileImage"
                                    />
                                @else
                                    <img
                                        src="{{ url('storage/users/'.$user->image) }}"
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
                                          action="{{route('user.profile.image')}}" id="uploadForm">
                                        @csrf
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
                                      action="{{route("user.profile.destroy",["id" => $user->id])}}">
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
                    <hr class="my-0"/>
                    <div class="card-body">
                        <form id="formAccountSettings" method="POST"
                              action="{{route("user.profile.update",["id" => $user->id])}}">
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
                                    @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">E Mail *</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        id="email"
                                        name="email"
                                        value="{{$user->email}}"
                                    />
                                    @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">Telefon *</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        id="phone"
                                        name="phone"
                                        value="{{$user->phone}}"
                                        oninput="function formatPhoneNumber(input) {
                                   var cleaned = ('' + input.value).replace(/\D/g, '');

                                    // Parçalara ayırma
                                    var match = cleaned.match(/^(\d{3})(\d{3})(\d{2})(\d{2})$/);

                                    if (match) {
                                        input.value = '(' + match[1] + ') ' + match[2] + ' ' + match[3] + ' ' + match[4];
                                    }
                                   }
                                   formatPhoneNumber(this)" maxlength="10"
                                    />
                                    @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">Adres *</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        id="address"
                                        name="address"
                                        value="{{$user->address}}"
                                    />
                                    @error('address')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">Şehir *</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        id="city"
                                        name="city"
                                        value="{{$user->city}}"
                                    />
                                    @error('city')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">İlçe *</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        id="district"
                                        name="district"
                                        value="{{$user->district}}"
                                    />
                                    @error('district')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">Şifre * <span class="text-danger">En az 8 karakter giriniz.</span></label>
                                    <input
                                        class="form-control"
                                        type="password"
                                        id="password"
                                        name="password"
                                    />
                                    @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">Şifre Tekrar *</label>
                                    <input
                                        class="form-control"
                                        type="password"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                    />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">Firma</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        id="office"
                                        name="office"
                                        value="{{$user->office}}"
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
    </div>

@endsection
