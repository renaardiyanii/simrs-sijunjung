<?php $this->load->view('layout/header_form');
?>
<script>
$(document).ready(function(){
	$('#keluhan').val('<?= isset($keluhan)?$keluhan:null ?>');
	$('#riwayat_kesehatan').val('<?= isset($riwayat_kesehatan)?$riwayat_kesehatan:null ?>');
});
</script>	

<?php
// var_dump($get_soap[0]);
function textAreaBuilder($name,$label,$value='')
{
    return '<div class="col-sm-6">
            <label class="col-form-label" for="'.$name.'">'.$label.'</label><br>
            <textarea class="form-control" rows="5" cols="40" name="'.$name.'" id="'.$name.'" required="">'.$value.'</textarea>
        </div>';
}


?>
<div class="card m-5">
<div class="card-body">					
<form method="POST" id="insert_form_medik_perawat" class="form-horizontal"> 
    <div class="form-group row">
        <?= textAreaBuilder('subjective_perawat','Subjective',str_replace('-',PHP_EOL,$get_soap[0]->subjective_perawat??"")) ?>
        <?= textAreaBuilder('objective_perawat','Objective',str_replace('-',PHP_EOL,$get_soap[0]->objective_perawat??"")) ?>
    </div>
    <div class="form-group row">
        <?= textAreaBuilder('assesment_perawat','Assesment',str_replace('-',PHP_EOL,$get_soap[0]->assesment_perawat??"")) ?>
        <?= textAreaBuilder('plan_perawat','Plan',str_replace('-',PHP_EOL,$get_soap[0]->plan_perawat??"")) ?>
    </div><br>
    <input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
    <button type="submit" class="btn btn-primary" id="btn_form_medik_perawat_insert">Simpan</button>										
</form>
</div>
</div>
<script type='text/javascript'>
$(document).ready(function() {
    $('#insert_form_medik_perawat').on('submit', function(e){  
    e.preventDefault();             
    document.getElementById("btn_form_medik_perawat_insert").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
    $.ajax({  
        url:"<?php echo base_url(); ?>irj/rjcpelayananfdokter/insert_fisik",                         
        method:"POST",  
        data:new FormData(this),  
        contentType: false,  
        cache: false,  
        processData:false,  
        success: function(data)  
        { 
        document.getElementById("btn_form_medik_perawat_insert").innerHTML = 'Simpan';
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
        error:function(event, textStatus, errorThrown) {
        document.getElementById("btn-form-fisik-insert").innerHTML = 'Simpan';
        new swal("Error","Data gagal disimpan.", "error"); 
        console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }  
    });   
    });

});
</script>									
									


									
									

