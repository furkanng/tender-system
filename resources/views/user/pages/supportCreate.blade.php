@extends('user.layout.app')

@section('title', 'Home Page')
@section('content')

    <div class="container mt-5 mb-5">
        <div class="d-flex justify-content-center row">
            <div class="col-6">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Talep Oluştur</h6>
                    <form action="{{route("user.support.store")}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Başlık</label>
                            <input type="text" required class="form-control" name="title" id="title">
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Mesajınız</label>
                            <textarea type="text" required class="form-control" name="content" id="content"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Gönder</button>
                    </form>
                </div>
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
@endsection
