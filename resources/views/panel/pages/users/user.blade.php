@extends('panel.layout.app')

@section('title', 'Home Page')
@section('content')

    <div class="card">
        <div class="row">
            <div class="col-4">
                <h5 class="card-header">Kullanıcılar</h5>
            </div>
            <div class="col-8 d-flex justify-content-end">
                <form action="{{ route('panel.user.index') }}" method="GET" class="d-flex align-items-center mx-3">
                    <button type="submit" class="btn p-0">
                        <i class="bx bx-search fs-4 lh-0"></i>
                    </button>
                    <input
                        type="text"
                        class="form-control border-0 shadow-none"
                        placeholder="Ad Soyad , Mail , Telefon"
                        aria-label="Ad Soyad , Mail , Telefon"
                        name="filter"
                        value="{{ request('filter') }}"
                    />
                </form>
            </div>
        </div>

        @if(session('message'))
            <script>
                $(document).ready(function () {
                    $('#successModal').modal('show');
                });
            </script>
        @endif
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Ad Soyad</th>
                    <th>E mail</th>
                    <th>Seviye</th>
                    <th>Kayıt Tarihi</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @php
                    $counter = 1;
                @endphp

                @foreach($users as $user)
                    <tr>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i>{{ $counter }}</td>
                        <td>{{ $user->name }}</td>
                        <td><span class="badge bg-label-primary me-1">{{ $user->email }}</span></td>
                        <td>
                            <form id="role-form-{{ $user->id }}" method="POST"
                                  action="{{ route('panel.user.update', ['id' => $user->id]) }}">
                                @csrf
                                @method('PUT')

                                    <select class="form-select role-select me-1" data-user-id="{{ $user->id }}" name="role"
                                            aria-label="Default select example">
                                        @php
                                            $roles = [
                                                0 => 'Onaysız',
                                                1 => 'Onaylı',
                                                2 => 'VIP'
                                            ];
                                        @endphp
                                        @foreach($roles as $key => $value)
                                            <option
                                                value="{{ $key }}" {{ $user->role == $key ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                            </form>
                        </td>

                        <td>
                            <span class="badge bg-label-secondary me-1">{{ $user->created_at }}</span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <form>
                                    <a class="btn btn-primary btn mx-2"
                                       href="{{ route('panel.user.edit', ['id' => $user->id]) }}">
                                        <i class="bx bx-edit"></i> İncele
                                    </a>
                                </form>

                                <form action="{{ route('panel.user.destroy', ['id' => $user->id]) }}" method="POST"
                                      onsubmit="return confirm('Bu kullanıcıyı silmek istediğinizden emin misiniz?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bx bx-trash"></i> Sil
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @php
                        $counter++;
                    @endphp
                @endforeach

                </tbody>
            </table>
        </div>
    </div>

    {{ $users->links('pagination') }}
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roleSelects = document.querySelectorAll('.role-select');

        roleSelects.forEach(select => {
            select.addEventListener('change', function () {
                const userId = this.getAttribute('data-user-id');
                const form = document.getElementById(`role-form-${userId}`);
                form.submit();
            });
        });
    });
</script>
