
<?php
$this->load->view('layout/header_form');


function formRowBuild2($name,$label,$value="")
{
    return '
    <div class="form-group row">
        <label for="visus_od" class="col-2 col-form-label">'.$label.'</label>
        <div class="col-sm-4">
            <div class="input-group">
                <input type="text" class="form-control" name="'.$name.'" id="'.$name.'" placeholder="" value="'.$value.'" required>
            </div>
        </div>	
    </div>
    ';
}
?>

<form method="POST" id="push_perawat_atau_dokter" class="form-horizontal"> 


<?php if($statfisik == 'show'){
		?>
	<?php //include('formfisik/fisik_mata.php'); ?>
	<?php //include('formfisik/fisik_perawat.php') ?>

	<?php //} elseif($statfisik == 'show' && $id_poli != 'BH00' ){
		?>

	<?php include('formfisik/fisik_perawat.php') ?>
    
    <div id="SurveyMasalahKeperawatan"></div>
<?php }else{ ?>						
	
	<?php include('assesmentmedikdokter/formassesmentmedikdokter.php'); ?>
	<?php } ?>
<div class="card m-5">
<div class="card-body">
<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register" />
<button type="submit" class="btn btn-primary" id="btn-form-fisik-insert">Simpan</button>	
</div>
</div>
</form>
<script type='text/javascript'>
var statfisik = "<?php $statfisik;?>";
surveyJSONMasalahEdukasi = <?php echo file_get_contents(__DIR__ ."/formfisik/surveyMasalahEdukasi.json");?>;
 Survey.StylesManager.applyTheme("modern");
    var surveyMasalahKeperawatan = new Survey.Model(surveyJSONMasalahEdukasi);
	surveyMasalahKeperawatan.showNavigationButtons = false;
    
        function sendDataToServerMasalahKeperawatan(survey) {
            //  console.log(JSON.stringify(survey.data));
          
            $.ajax({
                type: "POST",
                url: '<?php echo base_url('irj/rjcpelayanan/insert_masalah_keperawatan/'); ?>',
                data: {
                    masalahkeperawatansoap: JSON.stringify(survey.data),
					no_register:'<?= $no_register ?>'
                },
                success: function(data){
                  
                },
                dataType: 'json'
                });
        }

		
        // surveyMasalahKeperawatan.render("SurveyMasalahKeperawatan");

		<?php
		// var_dump($data_fisik->masalah_keperawatan_json);
		if(isset($data_fisik->masalah_keperawatan_json)){
		?>
		surveyMasalahKeperawatan.data = <?= $data_fisik->masalah_keperawatan_json ?>;
		<?php } ?>

        surveyMasalahKeperawatan
            .onComplete
            .add(function (result) {
                sendDataToServerMasalahKeperawatan(result);
            });

if(statfisik == 'hide'){
	$(document).ready(function() {
      $('#push_perawat_atau_dokter').on('submit', function(e){  
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
                            type: "success",
                            showCancelButton: false,
                            closeOnConfirm: false,
                            showLoaderOnConfirm: false,
								willClose: () => {
									// window.location.reload();
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

  	} );
}else{
	$(document).ready(function() {
		
      $('#push_perawat_atau_dokter').on('submit', function(e){  
		  e.preventDefault();       
		surveyMasalahKeperawatan.completeLastPage();

		//   surveyMasalahKeperawatan.completeLastPage();
		  document.getElementById("btn-form-fisik-insert").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
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
									timer: 1000, // menampilkan dialog selama 2 detik
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
			// Swal.fire({
			// 	title: 'Simpan Data?',
			// 	text: "Apakah Anda Yakin Dengan data Tersebut!",
			// 	icon: 'warning',
			// 	showCancelButton: true,
			// 	confirmButtonColor: '#3085d6',
			// 	cancelButtonColor: '#d33',
			// 	confirmButtonText: 'Ya, Simpan Data'
			// 	}).then((result) => {
			// 	if (result.isConfirmed) {
			// 		$.ajax({  
			// 			url:"<?php //echo base_url(); ?>irj/rjcpelayanan/insert_fisik/<?php echo $staff?>",                         
			// 			method:"POST",  
			// 			data:new FormData(this),  
			// 			contentType: false,  
			// 			cache: false,  
			// 			processData:false,  
			// 			success: function(data)  
			// 			{ 
			// 				document.getElementById("btn-form-fisik-insert").innerHTML = 'Simpan';
						
			// 				// document.getElementById("insert_pemeriksaan_fisik_atau_dokter").reset();
			// 				if (data = true) {        
			// 				new swal({
			// 								title: "Selesai",
			// 								text: "Data berhasil disimpan",
			// 								type: "success",
			// 								showCancelButton: false,
			// 								closeOnConfirm: false,
			// 								showLoaderOnConfirm: true,
			// 									willClose: () => {
			// 										window.location.reload();
			// 									}
			// 							},
			// 							function () {
			// 								// window.location.reload();
			// 							});
			// 				// console.log(data)
			// 				} else {
			// 				new swal("Error","Data gagal disimpan.", "error");
			// 				}
			// 			},
			// 			error:function(event, textStatus, errorThrown) {
            // 				document.getElementById("btn-form-fisik-insert").innerHTML = 'Simpan';
					
			// 				new swal("Error","Data gagal disimpan.", "error"); 
			// 				console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
			// 			}  
			// 			}); 
			// 	}else{
					
			// 		document.getElementById("btn-form-fisik-insert").innerHTML = 'Simpan';
			// 	}
		
			// 	});
          
      });

  	} );
}






// function validateAlergi() {


//   if (document.getElementById("tidak_alergi").checked == true) {
// 	document.getElementById("riwayat_alergi").value='' ; 
// 	document.getElementById("riwayat_alergi").disabled = true;
// 	$('#reak').hide();
//   }else{
// 	document.getElementById("riwayat_alergi").disabled = false;
// 	$('#reak').show();
//   }
// }

// if (document.getElementById("tidak_alergi").checked == true) {
// 	document.getElementById("riwayat_alergi").value='' ; 
// 	document.getElementById("riwayat_alergi").disabled = true;
// 	$('#reak').hide();
//   }else{
// 	document.getElementById("riwayat_alergi").disabled = true;
// 	$('#reak').show();
//   }

//   $('#reak').hide();
// function validateInputAlergi() {
// 	document.getElementById("ada").checked = true;
// 	$('#reak').show();
// }

//unchecked alergi
		// $(document).on("click", "input[name='alergi']", function(){
		// 			thisRadio = $(this);
		// 			if (thisRadio.hasClass("imCek")) {
		// 				thisRadio.removeClass("imCek");
		// 				thisRadio.prop('checked', false);
		// 				document.getElementById("riwayat_alergi").disabled = true;
		// 				$('#reak').hide();
		// 			} else { 
		// 				thisRadio.prop('checked', true);
		// 				thisRadio.addClass("imCek");
		// 			};
		// })
//unchecked keadaan umum
		$(document).on("click", "input[name='keadaan_umum']", function(){
					thisRadio = $(this);
					if (thisRadio.hasClass("imCek")) {
						thisRadio.removeClass("imCek");
						thisRadio.prop('checked', false);						
						$('#reak').hide();
					} else { 
						thisRadio.prop('checked', true);
						thisRadio.addClass("imCek");
					};
		})
//unchecked kesadaran pasien 
		$(document).on("click", "input[name='kesadaran_pasien']", function(){
					thisRadio = $(this);
					if (thisRadio.hasClass("imCek")) {
						thisRadio.removeClass("imCek");
						thisRadio.prop('checked', false);						
						$('#reak').hide();
					} else { 
						thisRadio.prop('checked', true);
						thisRadio.addClass("imCek");
					};
		})




</script>									
									


									
									

