<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_left");
        }
        // var_dump($members_ktp);
    ?> 

<?php 

function labeltopinputbot($label,$name,$hidden='text'){
    return '
    <div>
        <span>'.$label.' : </span><br>
        <input type="'.$hidden.'" id="'.$name.'" name="'.$name.'" class="form-control mt-2" >
    </div>';
}

?>
<html>
<script type='text/javascript'>
//-----------------------------------------------Data Table
$(document).ready(function() {
    $('#table').DataTable({
    	"pageLength":100,
    	"columnDefs": [
      { 
        "orderable": false, //set not orderable
        "targets": [7] // column index 
      }
      ]
    });
} );
//---------------------------------------------------------

$(function() {
$('#date_picker').datepicker({
		dateFormat: "dd-mm-yy",
  		changeMonth: true,
  		changeYear: true,
		autoclose: true,
		todayHighlight: true,
		yearRange: "c-100:c+100",
	});  

});

function tindak(waktu_masuk,id_poli,no_register){
	if(waktu_masuk==''){
		swal({
         title: "Tindak Pasien",
         text: "Apakah Pasien sudah masuk Ke Ruangan Poli ?",
         type: "info",
         showCancelButton: true,
         closeOnConfirm: false,
         showLoaderOnConfirm: true,
      },
      function(){
		 	// $.ajax({
		    //     type: "POST",
		    //     url: "<?php echo base_url().'irj/rjcpelayanan/update_waktu_masuk'; ?>",
		    //     dataType: "JSON",
		    //     data: {'no_register' : no_register},
		    //     success: function(data){  
		    //       location.href = '<?php echo site_url('irj/rjcpelayanan/pelayanan_tindakan');?>/'+id_poli+'/'+no_register; 
		    //     },
		    //     error:function(event, textStatus, errorThrown) {    
		    //         swal("Error","Gagal update waktu masuk.", "error");     
		    //         console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
		    //     }
		    // });      	         	        
      });
	}else{
      	// location.href = '<?php echo site_url('irj/rjcpelayanan/pelayanan_tindakan');?>/'+id_poli+'/'+no_register;
   	}
}

// var intervalSetting = function () {
// 		location.reload();
// 	};
// setInterval(intervalSetting, 60000);
</script>
<script>
     
function hapus_pelayanan(id_poli,no_register,cara_bayar,status_sep,hapus) {
	if(hapus=='0'){
		titlebtl = "Batalkan Pelayanan";
		textbtl="Yakin akan membatalkan pelayanan";
	}else{
		titlebtl = "Hapus Pelayanan";
		textbtl="Yakin akan menghapus pelayanan";
	}

	if (status_sep == 0 && cara_bayar == 'BPJS') {
               var getLink = '<?php echo base_url(); ?>irj/rjcpelayanan/pelayanan_batal/'+id_poli+'/'+no_register+'/'+hapus;
               swal({
  			   title: titlebtl,
  			   text: textbtl + " dan menghapus SEP?",
  			   type: "warning",
  			   showCancelButton: true,
  			   confirmButtonColor: "#DD6B55",
  			   confirmButtonText: "Ya",
  			   closeOnConfirm: false
			   },function(){
                        window.location.href = getLink
                    });
                return false;
	}
	else {
               var getLink = '<?php echo base_url(); ?>irj/rjcpelayanan/pelayanan_batal/'+id_poli+'/'+no_register+'/'+hapus;
               swal({ 
  			   title: titlebtl,
  			   text: textbtl + " ini?",
  			   type: "warning",
  			   showCancelButton: true,
  			   confirmButtonColor: "#DD6B55",
  			   confirmButtonText: "Ya",
  			   closeOnConfirm: false
			   },function(){
                        window.location.href = getLink
                    });
                return false;
	}

}      
    </script>
	<section class="content-header">
			<?php
				echo $this->session->flashdata('success_msg');
				echo $this->session->flashdata('notification');				
				echo $this->session->flashdata('notification_sep');				
			?>
				
			</section>
			<section class="content">
				<div class="row">
					<div class="col-sm-12">
						<div class="card card-block">
								<h3 class="card-title p-b-10">Pendaftaran Pasien Ktp Reader</h3>
							
							<div>
								
								<!-- <?php //echo form_open('irj/rjcpelayanan/kunj_pasien_poli_by_date');?>													 -->
								<div class="form-group row">
									<div class="col-md-4">											
										<input type="date"  class="form-control" placeholder="Tanggal Kunjungan" name="date" required>
										<input type="hidden" class="form-control" name="id_poli" value="<?php //echo $id_poli;?>">																				
									</div>
									<div class="input-group-btn">
										<button class="btn btn-primary" type="submit">Cari</button>
								  	</div>
								</div>
								
								<!-- <?php //echo form_close();?> -->
								<br/>
								<div class="table-responsive m-t-0">
								<table id="table" class="display nowrap table table-hover table-bordered table-striped">
									<thead>
										<tr>
											<th>No</th>
                                            <th>Foto</th>
											  <th>NIK</th>
											  <th>Nama</th>
											  <th>Alamat</th>
											  <th class="text-center">Aksi</th>	
										</tr>
									</thead>
                                    <tbody>
                                    <?php 
                                        $i = 1;
                                        if($members_ktp != null){
                                        foreach($members_ktp as $data){
                                    ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><img width="50" height="60" src="<?= 'data:image/png;base64,'.$data['foto']; ?>" alt=""></td>
                                        <td><?= $data['nik'] ?></td>
                                        <td><?= $data['nama'] ?></td>
                                        <td><?= $data['alamat'] ?></td>
                                        <td><button type="button" class="btn btn-primary" data-val="<?=htmlentities(json_encode($data))?>" data-toggle="modal" data-target="#exampleModalCenter">Tambah Pasien</button></td>
                                        <!-- <td><button type="button"  class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Tambah Pasien</button></td> -->
                                    </tr>
                                    <?php }}
                                     ?>
                                    </tbody>
									
								</table>
								</div>
							</div>
						</div>
					</div>
			</section>

            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <form action="<?= base_url("irj/rjcregistrasi/insert_data_pasien"); ?>" method="post">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Pendaftaran Pasien</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <span>Biodata Pasien</span><hr>
                        <div class="row">
                            <div class="col">
                                <?= labeltopinputbot('Nik','nik',) ?>
                                <?= labeltopinputbot('Nama','nama',) ?>
                                <?= labeltopinputbot('Tempat Lahir','tempat_lahir',) ?>
                                <?= labeltopinputbot('Alamat','alamat',) ?>
                                <?= labeltopinputbot('Rt','rt',) ?>
                                <?= labeltopinputbot('Rw','rw',) ?>
                                <?= labeltopinputbot('Kelurahan','kelurahan',) ?>
                                <?= labeltopinputbot('Jenis Kelamin','jenis_kelamin',) ?>
                                <?= labeltopinputbot('Agama','agama',) ?>
                               
                            </div>
                            <div class="col">
                                <?= labeltopinputbot('Status Kawin','status_kawin',) ?>
                                <?= labeltopinputbot('Jenis Pekerjaan','jenis_pekerjaan',) ?>
                                <?= labeltopinputbot('Provinsi','provinsi',) ?>
                                <?= labeltopinputbot('Kabupaten','kabupaten',) ?>
                                <?= labeltopinputbot('Kecamatan','kecamatan',) ?>
                                <?= labeltopinputbot('Golongan Darah','golongan_darah',) ?>
                                <?= labeltopinputbot('Kewarganegaraan','kewarganegaraan',) ?>
                                <?= labeltopinputbot('Tanggal Lahir','tgl_lahir',) ?>
                                <?= labeltopinputbot('Kode Pos','kode_pos',) ?>
                            </div>
                        
                        </div>
                        <input type="hidden" id="ktp_reader" name="ktp_reader" class="form-control" >
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
                </div>
            </div>
            </form>
            </div>

        <script>
        //   function showmodal(data){
                // console.log(data);
                // $('#exampleModalCenter').modal('show');
            // }
            $('#exampleModalCenter').on('show.bs.modal', function (event) {
                var myVal = $(event.relatedTarget).data('val');
                // 
                $('#ktp_reader').val('1');
                $('#nik').val(myVal.nik);
                $('#nama').val(myVal.nama);
                $('#tempat_lahir').val(myVal.tempat_lahir);
                $('#alamat').val(myVal.alamat);
                $('#rt').val(myVal.rt);
                $('#rw').val(myVal.rw);
                $('#kelurahan').val(myVal.kelurahan);
                $('#jenis_kelamin').val(myVal.jenis_kelamin);
                $('#agama').val(myVal.agama);
                $('#status_kawin').val(myVal.status_kawin);
                $('#jenis_pekerjaan').val(myVal.jenis_pekerjaan);
                $('#provinsi').val(myVal.provinsi);
                $('#kabupaten').val(myVal.kabupaten);
                $('#kecamatan').val(myVal.kecamatan);
                $('#golongan_darah').val(myVal.golongan_darah);
                $('#kewarganegaraan').val(myVal.kewarganegaraan);
                $('#tgl_lahir').val(myVal.tgl_lahir);
                $('#kode_pos').val(myVal.kodepos);
                

                // $(this).find(".modal-body").text(myVal);
                // console.log(myVal);

            });
        $( document ).ready(function() {

          
        //    $('#exampleModalCenter').
        });
        </script>


		
    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 