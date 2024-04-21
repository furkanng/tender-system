@extends('panel.layout.app')

@section('title', 'Home Page')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-center row">
            <div class="col-12" style="max-height: 500px; overflow-y: scroll;">

                <div class="card border-info mb-3">
                    <div class="card-header bg-info text-white">{{$support->user->name}} -
                        Tarih: {{$support->updated_at}}</div>
                    <div class="card-body">
                        <p class="card-text">{{$support->content}}</p>
                    </div>
                </div>

                @if(!empty($support->message))
                    @foreach($support->message as $message)
                        <div class="card  {{$message->user ? "border-info" : "border-danger"}} mb-3">
                            <div
                                class="card-header {{$message->user ? "bg-info" : "bg-danger"}}
                                text-white">{{$message->user->name ?? $message->admin->name}}
                                -Tarih: {{$message->updated_at}}</div>
                            <div class="card-body">
                                <p class="card-text">{{$message->answer}}</p>
                                @if($message->admin)
                                    <hr>
                                    <p class="card-text">Saygılarımızla,<br><strong>Oto İhale Sistemi Destek
                                            Merkezi</strong></p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="mt-3">
                <div class="col">
                    <form action="{{route("panel.support.update",["id" =>$support->id])}}" method="POST">
                        @csrf
                        @method("PUT")
                        <div class="input-group">
                            <textarea class="form-control" name="answer" placeholder="Cevap Yaz"></textarea>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-success">Gönder</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection
