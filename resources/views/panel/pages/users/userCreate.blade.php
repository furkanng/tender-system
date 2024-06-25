@extends('panel.layout.app')

@section('title', 'Home Page')
@section('content')
    <div class="nav-align-top mb-4">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                <div class="card-body">
                    <form method="POST"
                          action="{{route("panel.user.store")}}">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">İsim *</label>
                                <div class="input-group input-group-merge">
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="name"
                                        name="name"
                                        autofocus
                                    />
                                </div>
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">Email *</label>
                                <input
                                    class="form-control"
                                    type="email"
                                    id="email"
                                    name="email"
                                />
                                @error('email')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="password" class="form-label">Şifre *</label>
                                <input class="form-control" type="password" name="password" id="password"/>
                                @error('password')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="password" class="form-label">Şifre Tekrar *</label>
                                <input class="form-control" type="password" name="password_confirmation" id="password"/>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="phone" class="form-label">Telefon *</label>
                                <input class="form-control" type="text" name="phone" id="phone"
                                       oninput="function formatPhoneNumber(input) {
                                   var cleaned = ('' + input.value).replace(/\D/g, '');

                                    // Parçalara ayırma
                                    var match = cleaned.match(/^(\d{3})(\d{3})(\d{2})(\d{2})$/);

                                    if (match) {
                                        input.value = '(' + match[1] + ') ' + match[2] + ' ' + match[3] + ' ' + match[4];
                                    }
                                   }
                                   formatPhoneNumber(this)" maxlength="10"/>
                                @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">Rol</label>
                                <select class="form-select" id="role" name="role"
                                        aria-label="Default select example">
                                    <option value="1">Onaylı</option>
                                    <option value="2">VIP</option>
                                    <option value="0">Onaysız</option>
                                </select>
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
                                <label for="office" class="form-label">Şirket</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="office"
                                    name="office"
                                />
                            </div>
                            <div class="mb-3 col-md-6">
                                <div class="form-check form-switch">
                                    <label class="form-check-label mx-2" for="flexSwitchCheckChecked"
                                    >Durum</label>

                                    <input style="width: 50px; height: 30px" name="status" class="form-check-input"
                                           type="checkbox"
                                           id="flexSwitchCheckChecked"
                                           checked
                                    />
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var switchInput = document.getElementById('flexSwitchCheckChecked');
        var statusHiddenInput = document.getElementById('status_hidden');

        switchInput.addEventListener('change', function () {
            // Switch'ın değeri değiştiğinde bu fonksiyon çalışır
            var value = this.checked ? '1' : '0';
            this.value = value;
            statusHiddenInput.value = value;

        });
    });
</script>
