@extends('layouts.dashboard')

@section('title', 'Form Pelanggaran')

@section('content')

<style>

/* CONTAINER */

.form-container{
    width:900px;
    margin:30px auto;
    background:#e5e5e5;
    padding:25px;
    min-height:500px;
}


h3{
    margin-top:0;
    font-size:18px;
    font-weight:normal;
}


/* Baris form */

.form-row{
    display:flex;
    gap:40px;
    margin-bottom:20px;
}


/* Grup input */

.form-group{
    width:50%;
    display:flex;
    align-items:center;
}



.form-group label{
    width:120px;
    font-size:14px;
}




.form-group input,
.form-group select{
    flex:1;
    height:35px;
    border:none;
    background:#d6d6d6;
    padding:5px;
}




/* Textarea */

.full-group{
    display:flex;
    align-items:flex-start;
    margin-top:15px;
    margin-bottom:20px;
}



.full-group label{
    width:120px;
    font-size:14px;
}



.full-group textarea{
    flex:1;
    height:70px;
    border:none;
    background:#d6d6d6;
    padding:8px;
    resize:none;
}





/* Poin */

.poin-box{
    position:relative;
    flex:1;
}


.poin-box input{
    width:100%;
    height:35px;
    border:none;
    background:#d6d6d6;
    padding:5px;
}



.icon{
    position:absolute;
    right:5px;
    top:5px;
    width:25px;
    height:25px;
    background:#aaa;
    display:flex;
    justify-content:center;
    align-items:center;
}



/* Tombol */

.submit-area{
    text-align:right;
    margin-top:50px;
}



button{
    background:#25d6e6;
    border:none;
    padding:10px 30px;
    border-radius:5px;
    cursor:pointer;
}



button:hover{
    background:#1abac8;
}


</style>

<div class="form-container">

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif


<form action="{{ route('pelanggaran.store') }}" 
      method="POST"
      enctype="multipart/form-data">


@csrf

<!-- Baris 1 -->

<div class="form-row">


<div class="form-group">

<label>Nama Siswa</label>

<input 
type="text"
name="nama_siswa"
required>

</div>


<div class="form-group">

<label>Kelas</label>

<input 
type="text"
name="kelas"
required>

</div>


</div>


<!-- Baris 2 -->

<div class="form-row">


<div class="form-group">

<label>Tanggal</label>

<input 
type="date"
name="tanggal"
required>

</div>


<div class="form-group">

<label>Kategori</label>


<select name="kategori" required>

<option value="">
-- Pilih --
</option>

<option value="Ringan">
Ringan
</option>

<option value="Sedang">
Sedang
</option>

<option value="Berat">
Berat
</option>

</select>


</div>


</div>


<!-- Nama Pelanggaran -->

<div class="full-group">

<label>Nama Pelanggaran</label>


<textarea 
name="pelanggaran"
required></textarea>


</div>

<!-- Tambahan Poin -->

<div class="form-row">


<div class="form-group">

<label>Poin</label>

<div class="poin-box">

<input 
type="number"
name="poin"
required>

<div class="icon">
▦
</div>

</div>

</div>

</div>





<!-- Tambahan Sanksi -->


<div class="full-group">


<label>Nama Sanksi
</label>


<textarea 
name="sanksi"
required></textarea>


</div>

<div class="mb-3">

<label>
    Upload Bukti (PDF / Gambar)
</label>


<div class="drop-area" id="drop-area">

    <p>
        📂 Tarik & Lepaskan file disini
        <br>
        atau klik untuk memilih file
    </p>


    <input 
        type="file"
        name="file"
        id="file"
        accept=".pdf,.jpg,.jpeg,.png"
        hidden>


    <div id="file-name"></div>

</div>


</div>



<style>

.drop-area{

    width:100%;
    height:150px;
    border:2px dashed #287b8c;
    background:#f5f5f5;
    display:flex;
    justify-content:center;
    align-items:center;
    text-align:center;
    cursor:pointer;
    border-radius:10px;
    transition:0.3s;

}


.drop-area:hover{

    background:#e8f8fa;

}


.drop-area.active{

    background:#d9f5f7;
    border-color:#168bd4;

}


#file-name{

    margin-top:10px;
    font-weight:bold;

}

</style>



<script>

const dropArea = document.getElementById('drop-area');
const fileInput = document.getElementById('file');
const fileName = document.getElementById('file-name');



// klik area upload

dropArea.addEventListener('click',()=>{

    fileInput.click();

});




// pilih file

fileInput.addEventListener('change',()=>{

    showFile(fileInput.files[0]);

});




// drag masuk

dropArea.addEventListener('dragover',(e)=>{

    e.preventDefault();

    dropArea.classList.add('active');

});




// drag keluar

dropArea.addEventListener('dragleave',()=>{

    dropArea.classList.remove('active');

});




// drop file

dropArea.addEventListener('drop',(e)=>{

    e.preventDefault();


    dropArea.classList.remove('active');


    fileInput.files = e.dataTransfer.files;


    showFile(e.dataTransfer.files[0]);

});


// tampil nama file

function showFile(file){


    if(file){

        fileName.innerHTML =
        "📎 File : " + file.name;

    }

}

</script>

<div class="submit-area">

<button type="submit">
Submit
</button>

</div>




</form>


</div>


@endsection