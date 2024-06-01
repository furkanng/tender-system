@extends('panel.layout.app')

@section('title', 'Contact Page')
@section('content')
    <div class="nav-align-top mb-4">
            @if(session('message'))
                <script>
                    $(document).ready(function () {
                        $('#successModal').modal('show');
                    });
                </script>
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
                                    <label for="media_facebook" class="form-label">Facebook</label>
                                    <div class="input-group input-group-merge">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="media_facebook"
                                            name="media_facebook"
                                            autofocus
                                            value="{{ $media["media_facebook"] }}"
                                        />
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="media_instagram" class="form-label">İnstagram</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        id="media_instagram"
                                        name="media_instagram"
                                        value="{{ $media["media_instagram"] }}"
                                    />
                                </div>
                                <div class="mb-3">
                                    <label for="media_twitter" class="form-label">Twitter</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        name="media_twitter"
                                        id="media_twitter"
                                        value="{{ $media["media_twitter"] }}"
                                    />
                                </div>

                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="media_linkedin" class="form-label">Linkedin</label>
                                    <div class="input-group input-group-merge">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="media_linkedin"
                                            name="media_linkedin"
                                            value="{{ $media["media_linkedin"] }}"
                                        />
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="media_youtube" class="form-label">Youtube</label>
                                    <input
                                        class="form-control"
                                        type="text"
                                        id="media_youtube"
                                        name="media_youtube"
                                        value="{{ $media["media_youtube"] }}"
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
