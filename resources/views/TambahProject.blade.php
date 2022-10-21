@extends('layout.admin')
@section('title', 'Tambah Project')
@section('content-title', 'Tambah Project - '.$siswa->nama)
@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <form>
            <div class="form-group">
                <input type="hidden" name="id_siswa" value="{{ $siswa->id }}" >
                <label for="nama">Nama Project</label>
                <input type="text" class="form-control" id="nama_project" name='nama_project'>
            </div>
            <div class="form-group">
                <label for="nama">Deskripsi Project</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="nama">Tanggal Project</label>
                <input type="date" class="form-control" id="tanggal_project" name='tanggal_project'>
            </div>
            <div class="form-group">
                <a class="btn btn-danger">Batal</a>
                <a class="btn btn-success" type="submit">Simpan</a>
            </div>
        </form>
    </div>
</div>
    
@endsection