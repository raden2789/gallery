@extends('layouts.app')

@section('content')

<h2 class="text-center">Buat Album</h2>
<div class="card-body">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
</div>
<form action="{{route('album-store')}}" method="post" id="image_upload_form" enctype="multipart/form-data">
    @csrf
      <div class="form-group">
        <label for="nama">Nama Album:</label>
        <input type="text" name="nama" class="form-control" placeholder="Masukkan Keterangan" id="caption">
      </div>

      <button type="submit" class="btn btn-primary">Kirim</button>
    </form>

@endsection