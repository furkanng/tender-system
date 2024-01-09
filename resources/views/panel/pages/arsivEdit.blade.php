@extends('panel.layout.app')

@section('title', 'Archive')
@section('content')
<hr class="my-0"/>
<div class="card-body">
    <form method="POST"
          action="{{ route("panel.archive.update", ['id' => $archive->id]) }}">
        @csrf
        @method('PUT')
        <div class="row">

            <div class="mb-3 col-md-6">
                <label for="tender_no" class="form-label">İhale No</label>
                <input
                    type="text"
                    class="form-control"
                    id="tender_no"
                    name="tender_no"
                    value="{{($archive->tender_no)}}"
                    disabled
                />
            </div>
            <div class="mb-3 col-md-6">
                <label for="name" class="form-label">Plaka</label>
                <input
                    class="form-control"
                    type="text"
                    id="plate"
                    name="plate"
                    value="{{$archive->plate}}"
                    autofocus
                />
            </div>
            <div class="mb-3 col-md-6">
                <label for="name" class="form-label">Marka - Model</label>
                <input
                    class="form-control"
                    type="text"
                    id="model-marka"
                    name="model-marka"
                    value="{{$archive->car}}"
                    
                />
            </div>
            <div class="mb-3 col-md-6">
                <label for="name" class="form-label">Sıra</label>
                <input
                    class="form-control"
                    type="text"
                    id="order"
                    name="order"
                    value="{{$archive->order}}"
                    
                />
            </div>
            <div class="mb-3 col-md-6">
                <label for="name" class="form-label">Teklif</label>
                <input
                    class="form-control"
                    type="text"
                    id="my_bid"
                    name="my_bid"
                    value="{{$archive->my_bid}}"
                    
                />
            </div>
            <div class="mb-3 col-md-6">
                <label for="name" class="form-label">En Yüksek Teklif</label>
                <input
                    class="form-control"
                    type="text"
                    id="bid_win"
                    name="bid_win"
                    value="{{$archive->bid_win}}"
                    
                />
            </div>
            <div class="mb-3 col-md-6">
                <label for="name" class="form-label">Durum</label>
                <input
                    class="form-control"
                    type="text"
                    id="status"
                    name="status"
                    value="{{$archive->status}}"
                    
                />
            </div>
           
       
        </div>
        <div class="mt-2">
            <button type="submit" class="btn btn-primary me-2">Kaydet</button>
            <button type="reset" class="btn btn-outline-secondary" onclick="window.location.href='{{ route('panel.archive.index') }}'">Geri</button>
        </div>
    </form>
</div>
@endsection
