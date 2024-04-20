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
        <div class="d-flex justify-content-center row">
            <div class="col-12" style="max-height: 500px; overflow-y: scroll;">
                <div class="card border-info mb-3">
                    <div class="card-header bg-info text-white">{{$support->user->name}} -
                        Tarih: {{$support->updated_at}}</div>
                    <div class="card-body">
                        <p class="card-text">{{$support->content}}</p>
                        <hr>
                        <p class="card-text">Saygılarımızla,<br><strong>Oto İhale Sistemi Destek Merkezi</strong></p>
                    </div>
                </div>
                <div class="card border-info mb-3">
                    <div class="card-header bg-info text-white">{{$support->user->name}} -
                        Tarih: {{$support->updated_at}}</div>
                    <div class="card-body">
                        <p class="card-text">{{$support->content}}</p>
                        <hr>
                        <p class="card-text">Saygılarımızla,<br><strong>Oto İhale Sistemi Destek Merkezi</strong></p>
                    </div>
                </div>
                <div class="card border-info mb-3">
                    <div class="card-header bg-info text-white">{{$support->user->name}} -
                        Tarih: {{$support->updated_at}}</div>
                    <div class="card-body">
                        <p class="card-text">{{$support->content}}</p>
                        <hr>
                        <p class="card-text">Saygılarımızla,<br><strong>Oto İhale Sistemi Destek Merkezi</strong></p>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <form class="row">
                    <div class="col">
                        <div class="input-group">
                            <textarea class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                                      placeholder="Cevap Yaz"></textarea>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-success">Gönder</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>


        </div>
    </div>
@endsection
