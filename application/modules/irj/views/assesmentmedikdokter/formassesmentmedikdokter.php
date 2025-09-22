<?php 
$this->load->view('layout/header_form');
// var_dump($data_fisik);

?>

<div class="row">
    <div class="col-md-8">
        <div class="card m-5">
            <div class="card-body">
                <form method="POST" id="insert_pemeriksaan_fisik_atau_dokter" class="form-horizontal"> 

                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="col-form-label" for="subjective_dokter">Subjective</label><br>
                        <textarea class="form-control" rows="5" cols="40" name="subjective_dokter" id="subjective_dokter"><?php if(isset($soap_pasien_rj[0]->subjective_dokter) && $soap_pasien_rj[0]->subjective_dokter!=null){
                            echo $soap_pasien_rj[0]->subjective_dokter;
                        }else{
                            if(isset($soap_pasien_rj[0]->subjective_perawat)){
                                echo $get_soap[0]->subjective_perawat;
                            }
                        } ?></textarea>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label" for="objective">Objective</label><br>
                        <textarea class="form-control" rows="5" cols="40" name="objective_dokter" id="objective_dokter"><?php if(isset($soap_pasien_rj[0]->objective_dokter)){echo $soap_pasien_rj[0]->objective_dokter;}else{echo str_replace('-',PHP_EOL,$get_soap[0]->objective_perawat??"");}?>
                        </textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="col-form-label" for="assesment_dokter">Assesment</label><br>
                        <textarea class="form-control" rows="5" cols="40" name="assesment_dokter" id="assesment_dokter"><?= isset($soap_pasien_rj[0]->assesment_dokter)?str_replace('<br>',PHP_EOL,$soap_pasien_rj[0]->assesment_dokter):null ?></textarea>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label" for="plan_dokter">Plan</label><br>
                        <textarea class="form-control" rows="5" cols="40" name="plan_dokter" id="plan_dokter"><?= isset($soap_pasien_rj[0]->plan_dokter)?str_replace('<br>',PHP_EOL,$soap_pasien_rj[0]->plan_dokter):null ?></textarea>
                    </div>
                </div>


                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="col-form-label" for="intruksi">Intruksi</label><br>
                        <textarea class="form-control" rows="5" cols="40" name="intruksi" id="intruksi"><?php if (isset($soap_pasien_rj[0]->intruksi)) {echo str_replace('<br>', "
                ", $soap_pasien_rj[0]->intruksi);} ?></textarea>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label" for="pemeriksaan_penunjang_dokter">Pemeriksaan Penunjang</label><br>
                        <textarea class="form-control" rows="5" cols="40" name="pemeriksaan_penunjang_dokter" id="pemeriksaan_penunjang_dokter"><?php if (isset($soap_pasien_rj[0]->pemeriksaan_penunjang_dokter)) {echo str_replace('<br>', "
                ", $soap_pasien_rj[0]->pemeriksaan_penunjang_dokter);} ?></textarea>
                    </div>
                </div>


                <!-- <div class="form-group row">
                    <div class="col-sm-6">
                        <label  class="col-form-label" for="diagnosis_kerja">Diagnosis Kerja</label><br>
                        <textarea class="form-control" rows="5" cols="40" name="diagnosis_kerja_dokter" id="diagnosis_kerja"><?php if (isset($soap_pasien_rj[0]->diagnosis_kerja_dokter)) {echo str_replace('<br>', "
                ", $soap_pasien_rj[0]->diagnosis_kerja_dokter);} ?>	</textarea>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-form-label" for="diagnosis_banding">Diagnosis Banding</label><br>
                        <textarea class="form-control" rows="5" cols="40" name="diagnosis_banding_dokter" id="diagnosis_banding"><?php if (isset($soap_pasien_rj[0]->diagnosis_banding_dokter)) {echo str_replace('\n', "
                ", $soap_pasien_rj[0]->diagnosis_banding_dokter);} ?></textarea>
                    </div>
                </div> -->
                <br>
                <input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register" />
                <input type="hidden" class="form-control" value="<?php echo $id_poli;?>" name="poli" />
                <input type="hidden" name="id_dokter" id="" value="<?= $dokter_tindakan2[0]->id_dokter; ?>">
                <button type="submit" class="btn btn-primary" id="btn-form-fisik-insert">Simpan</button>	
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card m-5">
            <div class="card-body">
                <!-- <div class="row"> -->
                    <center>
                        <input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="user_id" />
                        <input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec" />
                        <input type="hidden" class="form-control" value="<?php echo $no_cm;?>" name="no_cm" />
                        <a class="btn btn-primary" href="<?php echo base_url('emedrec/C_emedrec/cetak_cppt_pasien_poli_all/'.$no_cm.'/'.$no_medrec);?>" style="width:85%; margin-bottom: 15px;" target="_blank">CPPT Sebelumnya</a>&nbsp;&nbsp;<br>
                        <a class="btn btn-primary" href="<?php echo base_url('irj/rjcpelayananfdokter/form/diagnosa/'.$id_poli.'/'.$no_register);?>" style="width:85%; margin-bottom: 15px;">Diagnosa</a>&nbsp;&nbsp;<br>
                        <a class="btn btn-primary" href="<?php echo base_url('irj/rjcpelayananfdokter/form/procedure/'.$id_poli.'/'.$no_register);?>" style="width:85%; margin-bottom: 15px;">Procedure</a>&nbsp;&nbsp;<br>
                        <button class="btn btn-primary" onclick="inputResep()" style="width:85%; margin-bottom: 15px;"><i class="fa fa-plus"></i> Resep</button>&nbsp;&nbsp;<br>
                        <a class="btn btn-primary" href="<?php echo base_url('irj/rjcpelayananfdokter/form/tindakan/'.$id_poli.'/'.$no_register);?>" style="width:85%; margin-bottom: 15px;">Tindakan</a>&nbsp;&nbsp;<br>
                        <div class = "row">
                            <button class="btn btn-primary" onclick="inputLabor()" style="width:40%; margin-bottom: 15px; margin-left: 35px;"><i class="fa fa-plus" ></i> Laboratorium</button>&nbsp;&nbsp;<br>
                            <a class="btn btn-primary" href="<?php echo base_url('emedrec/C_emedrec/cetak_history_laboratorium_all/'.$no_medrec);?>" style="width:38%; margin-bottom: 15px;"  >View</a>&nbsp;&nbsp;<br>
                        </div>
                        <div class = "row">
                            <button class="btn btn-primary" onclick="inputRadiologi()" style="width:40%; margin-bottom: 15px; margin-left: 35px;"><i class="fa fa-plus" ></i>Radiologi</button>&nbsp;&nbsp;<br>
                            <a class="btn btn-primary" href="<?php echo base_url('emedrec/C_emedrec/cetak_surat_radiologi_all/'.$no_medrec.'/'.$no_cm);?>" style="width:38%; margin-bottom: 15px;">View</a>&nbsp;&nbsp;<br>
                        </div>
                        <a class="btn btn-primary" href="<?php echo base_url('irj/rjcpelayananfdokter/kunj_pasien_poli/'.$id_poli);?>" style="width:85%; margin-bottom: 15px;">Kembali Ke List Pasien</a>&nbsp;&nbsp;<br>
                        <div class = "row">
                            <!-- <button class="btn btn-primary" onclick="inputElektromedik()" style="width:40%; margin-left: 35px;"><i class="fa fa-plus" ></i>Elektromedik</button>&nbsp;&nbsp;<br> -->
                            <!-- <a class="btn btn-primary" href="<?php //echo base_url('emedrec/C_emedrec/cetak_surat_elektromedik_all/'.$no_register.'/'.$no_cm.'/'.$no_medrec);?>" style="width:38%;" target="_blank">View</a>&nbsp;&nbsp;<br> -->
                            <!-- <a class="btn btn-primary" href="<?php echo base_url('emedrec/C_emedrec/cetak_surat_elektromedik_all/'.$no_register.'/'.$no_cm.'/'.$no_medrec);?>" style="width:38%;" target="_blank">View</a>&nbsp;&nbsp;<br> -->
                        </div>
                    </center>
                <!-- </div> -->
            </div>
        </div>
    </div>
</div>

<script type='text/javascript'>
    var statfisik = "<?php $statfisik;?>";
	function inputResep() {
        window.open("<?=base_url('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/'.$pelayan)?>", "_self");
        // new swal({
        //     title: "Resep",
        //     text: "Input Data Resep Pasien?",
        //     type: "warning",
        //     showCancelButton: true,
        //     showLoaderOnConfirm: true,
        //     confirmButtonColor: "#DD6B55",
        //     confirmButtonText: "Ya!",
        //     cancelButtonText: "Tidak!",
        //     closeOnConfirm: false,
        //     closeOnCancel: false
        // },
        // function(isConfirm){
        //     if (isConfirm) {
        //         window.open("<?=base_url('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/'.$pelayan.'/'.$id_poli)?>", "_self");
        //     } else {
        //         swal("Close", "Batal Input Resep", "error");
        //     }
        // }).then((result) => {
        //     /* Read more about isConfirmed, isDenied below */
        //     if (result.isConfirmed) {
        //         window.open("<?=base_url('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/'.$pelayan)?>", "_self");
        //     } else if (result.isDenied) {
        //         swal("Close", "Batal Input Resep", "error");
        //     }
        //     });
    }

	function inputLabor() {
        window.open("<?=base_url('lab/labcdaftar/pemeriksaan_lab/'.$no_register.'/'.$pelayan)?>", "_self");
        // new swal({
        //     title: "Laboratorium",
        //     text: "Input Data Laboratorium Pasien?",
        //     type: "warning",
        //     showCancelButton: true,
        //     showLoaderOnConfirm: true,
        //     confirmButtonColor: "#DD6B55",
        //     confirmButtonText: "Ya!",
        //     cancelButtonText: "Tidak!",
        //     closeOnConfirm: false,
        //     closeOnCancel: false        
        // }).then((result) => {
        //     /* Read more about isConfirmed, isDenied below */
        //     if (result.isConfirmed) {
        //         window.open("<?=base_url('lab/labcdaftar/pemeriksaan_lab/'.$no_register.'/'.$pelayan)?>", "_self");
        //         // $.ajax({
        //         //     type: "POST",
        //         //     url: "<?=base_url('irj/rjcpelayanan/update_rujukan_penunjang_lab')?>",
        //         //     data: {
        //         //         id_poli: "<?=$id_poli?>",
        //         //         no_register: "<?=$no_register?>"
        //         //     },
        //         //     dataType: 'text',
        //         //     success: function (data) {
        //         //         //if(data === 'success'){
        //         //             window.open("<?=base_url('lab/labcdaftar/pemeriksaan_lab/'.$no_register.'/'.$pelayan)?>", "_self");
        //         //         /*}else{
        //         //             swal("Close", "Oops! Terjadi Kesalahan, silahkan hubungi IT", "error");
        //         //         }*/
        //         //     }
        //         // });
        //     } else if (result.isDenied) {
        //         swal("Close", "Batal Input Resep", "error");
        //     }
        //     });
    }

	function inputRadiologi() {
        window.open("<?=base_url('rad/radcdaftar/pelayanan_rad/'.$no_register.'/'.$pelayan)?>", "_self");
        // new swal({
        //     title: "Radiologi",
        //     text: "Input Data Radiologi Pasien?",
        //     type: "warning",
        //     showCancelButton: true,
        //     showLoaderOnConfirm: true,
        //     confirmButtonColor: "#DD6B55",
        //     confirmButtonText: "Ya!",
        //     cancelButtonText: "Tidak!",
        //     closeOnConfirm: false,
        //     closeOnCancel: false        
        // }).then((result) => {
        //     /* Read more about isConfirmed, isDenied below */
        //     if (result.isConfirmed) {
        //         window.open("<?=base_url('rad/radcdaftar/pelayanan_rad/'.$no_register.'/'.$pelayan)?>", "_self");
        //         // $.ajax({
        //         //     type: "POST",
        //         //     url: "<?=base_url('irj/rjcpelayanan/update_rujukan_penunjang_rad')?>",
        //         //     data: {
        //         //         id_poli: "<?=$id_poli?>",
        //         //         no_register: "<?=$no_register?>"
        //         //     },
        //         //     dataType: 'text',
        //         //     success: function (data) {
        //         //         //if(data === 'success'){
                            
        //         //             window.open("<?=base_url('rad/radcdaftar/pemeriksaan_rad/'.$no_register.'/'.$pelayan)?>", "_self");
        //         //         /*}else{
        //         //             swal("Close", "Oops! Terjadi Kesalahan, silahkan hubungi IT", "error");
        //         //         }*/
        //         //     }
        //         // });
        //     } else if (result.isDenied) {
        //         swal("Close", "Batal Input Resep", "error");
        //     }
        //     });
    }

	function inputElektromedik() {
        new swal({
            title: "Elektromedik",
            text: "Input Data Elektromedik Pasien?",
            type: "warning",
            showCancelButton: true,
            showLoaderOnConfirm: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya!",
            cancelButtonText: "Tidak!",
            closeOnConfirm: false,
            closeOnCancel: false        
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                window.open("<?=base_url('elektromedik/emcdaftar/pemeriksaan_em/'.$no_register.'/'.$pelayan)?>", "_self");
                // $.ajax({
                //     type: "POST",
                //     url: "<?=base_url('irj/rjcpelayanan/update_rujukan_penunjang_em')?>",
                //     data: {
                //         id_poli: "<?=$id_poli?>",
                //         no_register: "<?=$no_register?>"
                //     },
                //     dataType: 'text',
                //     success: function (data) {
                //         //if(data === 'success'){
                //             window.open("<?=base_url('elektromedik/emcdaftar/pemeriksaan_em/'.$no_register.'/'.$pelayan)?>", "_self");
                //         /*}else{
                //             swal("Close", "Oops! Terjadi Kesalahan, silahkan hubungi IT", "error");
                //         }*/
                //     }
                // });
            } else if (result.isDenied) {
                swal("Close", "Batal Input Resep", "error");
            }
        });
    }

if(statfisik != 'hide'){
    // console.log(statfisik);
	$(document).ready(function() {
      $('#insert_pemeriksaan_fisik_atau_dokter').on('submit', function(e){  
        //   $('').disabled('true')
          $('#btn-form-fisik-insert').prop('disabled', true);
        e.preventDefault();             
        document.getElementById("btn-form-fisik-insert").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
		  url:"<?php echo base_url(); ?>irj/rjcpelayananfdokter/insert_fisik",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-form-fisik-insert").innerHTML = 'Simpan';
			let response = JSON.parse(data);
			new swal({
			title: "Selesai",
			text: "Data berhasil disimpan",
			icon: "success",
			buttons: false, // menonaktifkan tombol
			timer: 800, // menampilkan dialog selama 2 detik
		}).then(() => {
			window.location.reload(); // memuat ulang halaman setelah dialog ditutup
		});
          },
          error:function(event, textStatus, errorThrown) {
            document.getElementById("btn-form-fisik-insert").innerHTML = 'Simpan';
            new swal("Error","Data gagal disimpan.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
      });

  	} );
}else{
    // console.log(statfisik);
	$(document).ready(function() {
		
      $('#insert_pemeriksaan_fisik_atau_dokter').on('submit', function(e){  
        $('#btn-form-fisik-insert').prop('disabled', true);

		  e.preventDefault();             
		  document.getElementById("btn-form-fisik-insert").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
			Swal.fire({
				title: 'Simpan Data?',
				text: "Apakah Anda Yakin Dengan data Tersebut!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya, Simpan Data'
				}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({  
						url:"<?php echo base_url(); ?>irj/rjcpelayanan/insert_fisik/<?php echo $staff?>",                         
						method:"POST",  
						data:new FormData(this),  
						contentType: false,  
						cache: false,  
						processData:false,  
						success: function(data)  
						{ 
							document.getElementById("btn-form-fisik-insert").innerHTML = 'Simpan';
						
							// document.getElementById("insert_pemeriksaan_fisik_atau_dokter").reset();
							if (data = true) {        
                                new swal({
			title: "Selesai",
			text: "Data berhasil disimpan",
			icon: "success",
			buttons: false, // menonaktifkan tombol
			timer: 800, // menampilkan dialog selama 2 detik
		}).then(() => {
			window.location.reload(); // memuat ulang halaman setelah dialog ditutup
		});
							// console.log(data)
							} else {
							new swal("Error","Data gagal disimpan.", "error");
							}
						},
						error:function(event, textStatus, errorThrown) {
            				document.getElementById("btn-form-fisik-insert").innerHTML = 'Simpan';
					
							new swal("Error","Data gagal disimpan.", "error"); 
							console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
						}  
						}); 
				}else{
					
					document.getElementById("btn-form-fisik-insert").innerHTML = 'Simpan';
				}
		
				});
          
      });

  	} );
}

</script>