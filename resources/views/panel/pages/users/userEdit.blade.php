@extends('panel.layout.app')

@section('title', 'User')
@section('content')
    <hr class="my-0"/>
    <div class="card-body">
        <form method="POST"
              action="{{ route("panel.user.update", ['id' => $user->id]) }}">
            @csrf
            @method('PUT')
            <div class="row">

                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">isim</label>
                    <input
                        type="text"
                        class="form-control"
                        id="name"
                        name="name"
                        value="{{($user->name)}}"

                    />
                </div>
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Email</label>
                    <input
                        class="form-control"
                        type="email"
                        id="email"
                        name="email"
                        value="{{$user->email}}"
                        autofocus
                    />
                </div>
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Telefon</label>
                    <input
                        class="form-control"
                        type="text"
                        id="phone"
                        name="phone"
                        value="{{$user->phone}}"

                    />
                </div>
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Rol</label>
                    <select class="form-select" id="role" name="role"
                            aria-label="Default select example">
                        <option {{ $user->role == '1' ? 'selected' : '' }} value="1">Onaylı</option>
                        <option {{ $user->role == '2' ? 'selected' : '' }} value="2">VIP</option>
                        <option {{ $user->role == '0' ? 'selected' : '' }} value="0">Onaysız</option>
                    </select>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Adres</label>
                    <input
                        class="form-control"
                        type="text"
                        id="address"
                        name="address"
                        value="{{$user->address}}"

                    />
                </div>
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Şehir</label>
                    <input
                        class="form-control"
                        type="text"
                        id="city"
                        name="city"
                        value="{{$user->city}}"

                    />
                </div>
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">İlçe</label>
                    <input
                        class="form-control"
                        type="text"
                        id="district"
                        name="district"
                        value="{{$user->district}}"

                    />
                </div>
                <div class="mb-3 col-md-6">
                    <label for="name" class="form-label">Şirket</label>
                    <input
                        class="form-control"
                        type="text"
                        id="office"
                        name="office"
                        value="{{$user->office}}"

                    />
                </div>
                <div class="mb-3 col-md-6">
                    <div class="form-check form-switch mt-4">

                        <label class="form-check-label mx-2" for="flexSwitchCheckChecked"
                        >Durum</label>
                        <input style="width: 50px; height: 30px" name="status" class="form-check-input"
                               type="checkbox"
                               id="flexSwitchCheckChecked"
                               value="{{$user->status}}"
                        @if($user->status == 1)
                            {{"checked"}}
                            @endif
                        />

                    </div>

                </div>


            </div>
            <div class="mt-2">
                <button type="submit" class="btn btn-primary me-2">Kaydet</button>
                <button type="reset" class="btn btn-outline-secondary"
                        onclick="window.location.href='{{ route('panel.user.index') }}'">Geri
                </button>
            </div>
        </form>
    </div>
@endsection
