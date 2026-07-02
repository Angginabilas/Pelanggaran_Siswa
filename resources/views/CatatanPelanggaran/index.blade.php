@extends('layouts.dashboard')

@section('title','Data Pelanggaran')

@section('content')

<style>

/* Container */

.container{
    width:95%;
    margin:20px auto;
}



/* Search */

.search-box{
    display:flex;
    width:250px;
    margin-bottom:30px;
}


.search-box input{
    width:200px;
    height:32px;
    border:1px solid #ccc;
    padding:5px;
}


.search-box button{
    width:45px;
    height:32px;
    margin-left:8px;
    border:none;
    background:#287b8c;
    color:white;
    border-radius:4px;
}





/* TABLE */

table{
    width:100%;
    border-collapse:separate;
    border-spacing:0 12px;
}



thead tr{
    background:#f2f2f2;
}



th{
    padding:12px 18px;
    text-align:left;
    font-weight:bold;
    white-space:nowrap;
}



td{
    padding:14px 18px;
    vertical-align:middle;
}



/* Lebar Kolom */

th:nth-child(1),
td:nth-child(1){
    width:40px;
}


th:nth-child(2),
td:nth-child(2){
    width:160px;
}


th:nth-child(3),
td:nth-child(3){
    width:150px;
}


th:nth-child(4),
td:nth-child(4){
    width:120px;
}


th:nth-child(5),
td:nth-child(5){
    width:220px;
}


th:nth-child(6),
td:nth-child(6){
    width:70px;
}


th:nth-child(7),
td:nth-child(7){
    width:160px;
}


th:nth-child(8),
td:nth-child(8){
    width:70px;
}


th:nth-child(9),
td:nth-child(9){
    width:120px;
    text-align:center;
}





/* Poin */

.poin{
    font-weight:bold;
    color:#287b8c;
}




/* BUTTON */

.btn{
    border:none;
    color:white;
    padding:7px 12px;
    font-size:12px;
    cursor:pointer;
    border-radius:5px;
    text-decoration:none;
    display:inline-block;
    text-align:center;
}



.pdf{
    background:#0aa91b;
    width:45px;
}




/* Aksi */

.aksi{
    width:120px;
    text-align:center;
}



.edit{
    background:#168bd4;
    width:75px;
    margin-bottom:7px;
}



.delete{
    background:#ff8a00;
    width:75px;
}



.delete-form{
    margin:0;
}



</style>

<div class="container">


<div class="header-line"></div>


@if(session('success'))

<div class="alert alert-success">
    {{ session('success') }}
</div>

@endif



<!-- Search -->
 <form method="GET" action="{{ route('CatatanPelanggaran.index') }}">


<div class="search-box">


<input 
type="text"
name="search"
value="{{ request('search') }}"
placeholder="Cari Nama / Kelas">


<button type="submit">
🔍
</button>


</div>


</form>

<table>

<thead>

<tr>

<th>No</th>
<th>Nama</th>
<th>Kelas</th>
<th>Jenis Pelanggaran</th>
<th>Tanggal</th>
<th>Keterangan</th>
<th>Poin</th>
<th>Sanksi</th>
<th>PDF</th>
<th>Aksi</th>

</tr>

</thead>



<tbody>


@forelse($catatanPelanggarans as $data)

<tr>


<td>
{{ $loop->iteration }}
</td>


<td>
{{ $data->nama_siswa }}
</td>

<td>
{{ $data->kelas }}
</td>


<td>
{{ $data->jenis_pelanggaran }}
</td>


<td>
{{ date('d-m-Y', strtotime($data->tanggal)) }}
</td>


<td>
{{ $data->keterangan }}
</td>


<td class="poin">
{{ $data->poin }}
</td>


<td>
{{ $data->sanksi }}
</td>



<td>

@if($data->file)

<a href="{{ asset('storage/'.$data->file) }}" 
target="_blank"
class="btn pdf">

📄

</a>

@else

-

@endif

</td>

<td class="aksi">


<a href="{{ route('CatatanPelanggaran.edit',$data->id) }}"
class="btn edit">

✏ Edit

</a>



<form action="{{ route('CatatanPelanggaran.destroy',$data->id) }}"
method="POST"
class="delete-form">


@csrf
@method('DELETE')


<button 
type="submit"
class="btn delete"
onclick="return confirm('Hapus data?')">

🗑 Delete

</button>


</form>


</td>

</tr>


@empty


<tr>

<td colspan="9" align="center">

Belum ada data pelanggaran

</td>

</tr>


@endforelse


</tbody>


</table>


</div>


@endsection