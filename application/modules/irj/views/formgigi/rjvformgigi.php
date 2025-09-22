<?php //var_dump($gigi); die();
$this->load->view('layout/header_form');
function inputrow($label,$name,$optional = ''){
    return '
    <div class="row mb-2">
        <div class="col">
            <label for="'.$name.'">'.$label.'</label>
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

function inputtext2($name="",$value="")
{
    return '
    <input type="text" name="'.$name.'" value="'.$value.'">
    ';
}
?>
<script src="<?= base_url('assets/sweetalert2.js') ?>"></script>
<!-- <link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" /> -->
<!-- <script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->
<div class="card m-5">
<div class="card-body">
<form id="form" action="<?= base_url('irj/rjcpelayanan/insert_assesment_gigi/') ?>">
    <input type="hidden" name="no_register" value="<?= $data_pasien_daftar_ulang->no_register ?>">
    <input type="hidden" name="no_medrec" value="<?= $data_pasien_daftar_ulang->no_cm ?>">
    <input type="hidden" name="tgl_input" value="<?= date('Y-m-d h:i:s') ?>">
    <input type="hidden" name="id_pemeriksa" value="<?= $user->userid ?>">
    <input type="hidden" name="nama" value="<?= $data_pasien_daftar_ulang->nama ?>">
    <!-- <input type="hidden" name="nama_pemeriksa" value="<?= $user_info->name ?>"> -->
    <!-- <input type="hidden" name="ttd_pemeriksa" value="<?= $user_info->ttd ?>"> -->
    <span><h4>Pengkajian Medis Pasien Rawat Jalan Gigi</h4></span>
    <hr>

    <!-- <div id="surveyContainerGigi"></div> -->
    <div class="row">
        <?php include('datamedikyangdiperlukan.php') ?>
    </div>

    <span><h6>B. Pemeriksaan Odontogram</h6></span><hr>
    <?php include('asesmenmedisdoktergigi.php') ?><hr>


    <span><h6>C. Diagnosa</h6></span><hr>

    <div class="col">
        <div class="mb-3">
            <textarea class="form-control" id="diagnosa" rows="3" name="diagnosa">
           <?php 
        //    if($gigi->diagnosa){
        //         echo $gigi->diagnosa;
        //    }else{
        //     foreach($diagnosa as $diag){ 
        //         echo  $diag->id_diagnosa.'-'.$diag->diagnosa.'('.$diag->klasifikasi_diagnos.'), ';
        //      }
        //    }
                
            ?></textarea>
        </div>
    </div>


    <span><h6>D. Terapi / Pengobatan</h6></span><hr>

    <div class="col">
        <div class="mb-3">
            <textarea class="form-control" id="pengobatan" rows="3" name="pengobatan"><?= isset($gigi->pengobatan)?$gigi->pengobatan:'' ?></textarea>
        </div>
    </div>

    <span><h6>E. Perencanaan</h6></span><hr>

    <div class="col">
        <div class="mb-3">
            <textarea class="form-control" id="perencanaan" rows="3" name="perencanaan"><?= isset($gigi->perencanaan)?$gigi->perencanaan:'' ?></textarea>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-wide" id="btn-insert" >SIMPAN</button>
    </div>
</form>
</div>
</div>
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
        // survey.completeLastPage(); 
        // console.log(form.serialize());

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements.
            success: function(data)
            {

                // console.log(data) ;
                new swal({
                    title: "Selesai",
                    text: "Data berhasil disimpan",
                    type: "success",
                    showCancelButton: false,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                        willClose: () => {
                            window.location.reload();
                        }
                },
                function () {
                    // window.location.reload();
                });

            
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

