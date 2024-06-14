@extends('user.layout.app')

@section('title', 'Home Page')
@section('content')
<div class="container mt-5 mb-5">
    <form action="{{route("user.profile.store")}}" method="POST">
        
        @csrf
    <div class="d-flex justify-content-center row">
        <h6 class="mb-4">Profil</h6>
        <div class="col-6">
            <div class="bg-light rounded h-100 p-4">
               
                
                    <div class="mb-3">
                        <label for="title" class="form-label">İsim-Soyisim</label>
                        <input type="text"  class="form-control" name="name" id="name" value="{{$user->name}}">
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Email</label>
                        <input type="text"  class="form-control" name="email" id="email" value="{{$user->email}}"></input>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Telefon</label>
                        <input type="text"  class="form-control" name="phone" id="phone" value="{{$user->phone}}"></input>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Rol</label>
                        
                        <input type="text"  class="form-control"  readonly value="{{$user->role == 1?'Onaylı':'VIP'}}"></input>
                    </div>
                    
                
            </div>
        </div>
        <div class="col-6">
            <div class="bg-light rounded h-100 p-4">

                    <div class="mb-3">
                        <label for="title" class="form-label">Şifre</label>
                        <input type="text"  class="form-control" name="password" id="password" >
                    </div>
                   
                    <div class="mb-3">
                        <label for="content" class="form-label">Şehir</label>
                        <input type="text"  class="form-control" name="city" id="city" value="{{$user->city}}"></input>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">İlçe</label>
                        <input type="text"  class="form-control" name="district" id="district" value="{{$user->district}}"></input>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Adres</label>
                        <textarea type="text" class="form-control" name="address" id="address" >{{$user->address}}</textarea>
                    </div>
                    
                    
                
            </div>
        </div>
        

    </div>
    <div style="display: flex;
    justify-content: center;
    margin-top: 10px;">
        <button type="submit" class="btn btn-primary" style="padding-inline: 50px;
        font-size: 15px;
        font-weight: bold;">Kaydet</button>
    </div>
   
</form>
</div>

@endsection
