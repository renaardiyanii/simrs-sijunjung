<?php 
function inputrow($label,$name,$optional = ''){
    return '
    <div class="row mb-2">
        <div class="col">
            <label for="golongan_darah">'.$label.'</label>
        </div>
        <div class="col">
            <input type="text" name="'.$name.'" class="form-control" id="'.$name.'" value="'.$optional.'">
        </div>    
    </div>
    ';
}
function inputrowrightlabel($label,$name,$optional = ''){
    return '
    <div class="row mb-2">
        <div class="col">
            <input type="text" name="'.$name.'" class="form-control" id="'.$name.'" value="'.$optional.'">
        </div>    
        <div class="col">
            <label for="'.$name.'">'.$label.'</label>
        </div>
    </div>
    ';
}

function inputtext($name,$optional = '',$placeholder = ''){
    return '<input type="text" name="'.$name.'" placeholder="'.$placeholder.'" class="form-control" id="'.$name.'" value="'.$optional.'">';
}

function radiobutton($label,$name,$id,$value="",$optional=""){
    return ' 
    <input type="radio" name="'.$name.'" id="'.$id.'" value="'.$value.'" '.$optional.'>
    <label for="'.$id.'">'.$label.'</label>';
}

function inputrowwithradio($judul,$optional=''){
    return '
    <div class="row">
        <div class="col">
            <label>'.$judul.'</label>
        </div>
        <div class="col">
            '.$optional.'
        </div>    
    </div>
    ';
}

function inputcolwithradio($judul,$optional=""){
    return '
    <div >
        <label>'.$judul.'</label>
    </div>
    <div class="row">
        <div class="col">
            '.$optional.'
        </div>    
    </div>
    ';
}
?>

<script src="<?= base_url('assets/sweetalert2.js') ?>"></script>

<!-- <link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" /> -->
<!-- <script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->
<form id="form" action="<?= base_url('ird/rdcpelayanan/insert_assesment_gigi/') ?>">
    <input type="hidden" name="no_register" value="<?= $data_pasien_daftar_ulang->no_register ?>">
    <input type="hidden" name="no_medrec" value="<?= $data_pasien_daftar_ulang->no_cm ?>">
    <span>Data Medik Yang Perlu Diperhatikan</span>
    <hr>

    <!-- <div id="surveyContainerGigi"></div> -->
    <div class="row">
        <?php include('formgigi/datamedikyangdiperlukan.php') ?>
    </div>

    <span>ASSEMEN MEDIS KEDOKTERAN GIGI</span><hr>
    <?php include('formgigi/asesmenmedisdoktergigi.php') ?>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-wide" id="btn-insert" >SIMPAN</button>
    </div>
</form>

<!-- <?php //echo form_close();?> -->
<script>
// this is the id of the form
$("#form").submit(function(e) {

e.preventDefault(); // avoid to execute the actual submit of the form.

var form = $(this);
var url = form.attr('action');

Swal.fire({
  title: 'Apakah Anda Yakin?',
  showCancelButton: true,
  confirmButtonText: `Save`,
}).then((result) => {
  if (result.isConfirmed) {
        survey.completeLastPage(); // tambahanan fungsinya ada di file formgigi/carddiagnosa.php

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            success: function(data)
            {

                // console.log(data) ;
                Swal.fire(
                    'Sukses!',
                    'Data Berhasil Disimpan.',
                    'success'
                )

            
            },
            error: function(data)
            {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Data Gagal Disimpan , Cek kembali Data Anda!'
                })
            }
        });
  } 
})


});
</script>

