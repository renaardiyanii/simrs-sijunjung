<?php $this->load->view('layout/header_form');?>
<link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script>
<div class="row">
    <div class="col-md-8">
        <div class="card m-5">
            <div class="card-body">
				<div id="surveyContainerMedikMata"></div>
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
                        <a class="btn btn-primary" href="<?php echo base_url('emedrec/C_emedrec/cetak_cppt_pasien_poli/'.$no_medrec.'/'.$id_poli);?>" style="width:85%; margin-bottom: 15px;">CPPT Sebelumnya</a>&nbsp;&nbsp;<br>
                        <a class="btn btn-primary" href="<?php echo base_url('irj/rjcpelayananfdokter/form/diagnosa/'.$id_poli.'/'.$no_register);?>" style="width:85%; margin-bottom: 15px;">Diagnosa</a>&nbsp;&nbsp;<br>
                        <a class="btn btn-primary" href="<?php echo base_url('irj/rjcpelayananfdokter/form/procedure/'.$id_poli.'/'.$no_register);?>" style="width:85%; margin-bottom: 15px;">Procedure</a>&nbsp;&nbsp;<br>
                        <button class="btn btn-primary" onclick="inputResep()" style="width:85%; margin-bottom: 15px;"><i class="fa fa-plus"></i> Resep</button>&nbsp;&nbsp;<br>
                        <div class = "row">
                            <button class="btn btn-primary" onclick="inputLabor()" style="width:40%; margin-bottom: 15px; margin-left: 35px;"><i class="fa fa-plus" ></i> Laboratorium</button>&nbsp;&nbsp;<br>
                            <a class="btn btn-primary" href="<?php echo base_url('emedrec/C_emedrec/cetak_history_laboratorium_all/'.$no_medrec);?>" style="width:38%; margin-bottom: 15px;"  >View</a>&nbsp;&nbsp;<br>
                        </div>
                        <div class = "row">
                            <button class="btn btn-primary" onclick="inputRadiologi()" style="width:40%; margin-bottom: 15px; margin-left: 35px;"><i class="fa fa-plus" ></i>Radiologi</button>&nbsp;&nbsp;<br>
                            <a class="btn btn-primary" href="<?php echo base_url('emedrec/C_emedrec/cetak_surat_radiologi_all');?>" style="width:38%; margin-bottom: 15px;" target="_blank">View</a>&nbsp;&nbsp;<br>
                        </div>
                        <div class = "row">
                            <button class="btn btn-primary" onclick="inputElektromedik()" style="width:40%; margin-left: 35px;"><i class="fa fa-plus" ></i>Elektromedik</button>&nbsp;&nbsp;<br>
                            <a class="btn btn-primary" href="<?php echo base_url('emedrec/C_emedrec/cetak_surat_elektromedik_all');?>" style="width:38%;" target="_blank">View</a>&nbsp;&nbsp;<br>
                        </div>
                    </center>
                <!-- </div> -->
            </div>
        </div>
    </div>
</div>


<script>

var bgSignatureWidget = {
    //the widget name. It should be unique and written in lowercase.
	name: "drawingboard",
	title: "Drawing Board",
    //SurveyJS library calls this function for every question to check 
    //if this widget should apply to the particular question.
    isFit: function (question) {
        //We are going to apply this widget for comment questions (textarea)
        return question.getType() == "signaturepad";
    },
    //We will change the default rendering, but do not override it completely
	isDefaultRender: true,
	init() {
		Survey.Serializer.addProperty("signaturepad", {
			name: "image",
			default: "",
			category: "general",
		});
/*		Survey.Serializer.addClass("drawingboard", [{
				name: "image",
				default: "",
				category: "general",
            }], null, "signaturepad");*/
    },
    
    //"question" parameter is the question we are working with and "el" parameter is HTML textarea in our case
    afterRender: function (question, el) {
		if (question.image) {
			var div = el.children[0];
			var canvas = el.children[0].children[0];
			var divBtn = el.children[1];
			var button = el.children[1].children[0];
			//button.style = "z-index: 2;";
			var mainDiv = document.createElement("canvas"); // we create second canvas for background image
			var buttonDiv = document.createElement("button"); // create button for custom action
			canvas.style = "z-index: 1; position: absolute;"
			mainDiv.style = "z-index: 0; position: absolute;";            
			mainDiv.width = question.width;
			canvas.height = question.height; // the main canvas alway overide click from clear button, so I try to reduce the height of the canvas, but failed. First load is ok, but after we do drawing, it gets back to original size
			canvas.width = question.width;
			mainDiv.height = question.height; // background canvas is ok
			divBtn.className += " mt-3";
			div.insertBefore(mainDiv, canvas);
            div.style= "height:".concat(question.height).concat("px;");
			buttonDiv.innerHTML ="Clear";
			buttonDiv.style = "position: absolute;z-index:2;";
            divBtn.insertBefore(buttonDiv, button);
			buttonDiv.addEventListener('click', function (event) {
				question.value = 
					'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVQYV2NgYAAAAAMAAWgmWQ0AAAAASUVORK5CYII=';
			});
			const context = mainDiv.getContext('2d');
			var img = new Image();
			img.src = question.image;
			img.onload = () => {
				context.drawImage(img, 0, 0, question.width, question.height);
			};
		}
	},
};

//Register our widget in singleton custom widget collection
Survey.CustomWidgetCollection.Instance.add(bgSignatureWidget, 'customtype');

// Survey.CustomWidgetCollection.Instance.addCustomWidget(widget, "type");



surveyJSON = <?php echo file_get_contents(__DIR__ ."/emr/assesmen_medis_mata.json");?>;
    Survey.StylesManager.applyTheme("modern");
    var surveyAssesmentMedisMata = new Survey.Model(surveyJSON);

        function sendDataToServerMedisMata(survey) {
            // console.log(JSON.stringify(survey.data));
          
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>irj/rjcpelayananfdokter/insert_medis_mata/<?php echo $no_register?>", 
                data: {
                    formjson: JSON.stringify(survey.data),
                },
                success: function(data){
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
                dataType: 'json'
                });
        }

		<?php
	if(isset($soap_pasien_rj[0]->formjson)){
	?>
	surveyAssesmentMedisMata.data = <?= isset($soap_pasien_rj[0]->formjson)?$soap_pasien_rj[0]->formjson:'' ?>
	<?php }else{?>
        surveyAssesmentMedisMata.data = 

	{"anamnesis":"<?= isset($soap_pasien_rj[0]->subjective_perawat)?str_replace([PHP_EOL,"\r","\n","<br>"],'\n',$soap_pasien_rj[0]->subjective_perawat):'' ?>",
	"pemeriksaan_fisik":"<?= isset($soap_pasien_rj[0]->objective_perawat)?str_replace([PHP_EOL,"\r","\n","<br>"],'\n',$soap_pasien_rj[0]->objective_perawat):'' ?>",
	"diagnosa_kerja":"<?= isset($soap_pasien_rj[0]->diagnosis_kerja_dokter)?str_replace([PHP_EOL,"\r","\n","<br>"],'\n',$soap_pasien_rj[0]->diagnosis_kerja_dokter):'' ?>",
	"therapi_tindakan":"<?= isset($soap_pasien_rj[0]->terapi_tindakan_dokter)?str_replace([PHP_EOL,"\r","\n","<br>"],'\n',$soap_pasien_rj[0]->terapi_tindakan_dokter):'' ?>"};
    <?php } ?>
     

       
        
        surveyAssesmentMedisMata.render("surveyContainerMedikMata");
        surveyAssesmentMedisMata
            .onComplete
            .add(function (result) {
                sendDataToServerMedisMata(result);
            });

        

          
</script>

<script type='text/javascript'>
function inputResep() {
        new swal({
            title: "Resep",
            text: "Input Data Resep Pasien?",
            type: "warning",
            showCancelButton: true,
            showLoaderOnConfirm: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya!",
            cancelButtonText: "Tidak!",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm){
            if (isConfirm) {
                window.open("<?=base_url('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/'.$pelayan.'/'.$id_poli)?>", "_self");
                // $.ajax({
                //     type: "POST",
                //     url: "<?=base_url('irj/rjcpelayanan/update_rujukan_resep_ruangan')?>",
                //     data: {
                //         id_poli: "<?=$id_poli?>",
                //         no_register: "<?=$no_register?>",
                //         obat: "1"
                //     },
                //     dataType: 'text',
                //     success: function (data) {
                //         //if(data === 'success'){
                //             window.open("<?=base_url('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/'.$pelayan.'/'.$id_poli)?>", "_self");
                //         /*}else{
                //             swal("Close", "Oops! Terjadi Kesalahan, silahkan hubungi IT", "error");
                //         }*/
                //     }
                // });
            } else {
                swal("Close", "Batal Input Resep", "error");
            }
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                window.open("<?=base_url('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/'.$pelayan)?>", "_self");
                // $.ajax({
                //     type: "POST",
                //     url: "<?=base_url('irj/rjcpelayanan/update_rujukan_resep_ruangan')?>",
                //     data: {
                //         id_poli: "<?=$id_poli?>",
                //         no_register: "<?=$no_register?>",
                //         obat: "1"
                //     },
                //     dataType: 'text',
                //     success: function (data) {
                //         //if(data === 'success'){
                //             window.open("<?=base_url('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/'.$pelayan)?>", "_self");
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

	function inputLabor() {
        new swal({
            title: "Laboratorium",
            text: "Input Data Laboratorium Pasien?",
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
                window.open("<?=base_url('lab/labcdaftar/pemeriksaan_lab/'.$no_register.'/'.$pelayan)?>", "_self");
                // $.ajax({
                //     type: "POST",
                //     url: "<?=base_url('irj/rjcpelayanan/update_rujukan_penunjang_lab')?>",
                //     data: {
                //         id_poli: "<?=$id_poli?>",
                //         no_register: "<?=$no_register?>"
                //     },
                //     dataType: 'text',
                //     success: function (data) {
                //         //if(data === 'success'){
                //             window.open("<?=base_url('lab/labcdaftar/pemeriksaan_lab/'.$no_register.'/'.$pelayan)?>", "_self");
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

	function inputRadiologi() {
        new swal({
            title: "Radiologi",
            text: "Input Data Radiologi Pasien?",
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
                window.open("<?=base_url('rad/radcdaftar/pelayanan_rad/'.$no_register.'/'.$pelayan)?>", "_self");
                // $.ajax({
                //     type: "POST",
                //     url: "<?=base_url('irj/rjcpelayanan/update_rujukan_penunjang_rad')?>",
                //     data: {
                //         id_poli: "<?=$id_poli?>",
                //         no_register: "<?=$no_register?>"
                //     },
                //     dataType: 'text',
                //     success: function (data) {
                //         //if(data === 'success'){
                            
                //             window.open("<?=base_url('rad/radcdaftar/pemeriksaan_rad/'.$no_register.'/'.$pelayan)?>", "_self");
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
</script>