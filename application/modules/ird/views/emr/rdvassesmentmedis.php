<?php 
$this->load->view('layout/header_form');
?>
<?php
if(!isset($assesment_medik_igd)){
    $assesment_medik_igd=0;
}
if(isset($triase[0]->formjson)){
    $data_triase = json_decode($triase[0]->formjson);
}

$data_keperawatan = isset($assesment_keperawatan[0]->formjson)?json_decode($assesment_keperawatan[0]->formjson):null;

// var_dump();
?>

<link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<!--script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script-->
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<script>
    function inputResep() {
        window.open("<?=base_url('farmasi/Frmcdaftar/permintaan_obat/'.$no_register.'/DOKTER')?>", "_self");
    }

	function inputLabor() {
		window.open("<?=base_url('lab/labcdaftar/pemeriksaan_lab/'.$no_register.'/DOKTER')?>", "_self");
    }

	function inputRadiologi() {
        window.open("<?= base_url('rad/radcdaftar/pelayanan_rad/'.$no_register.'/DOKTER')?>", "_self");
    }

	function inputElektromedik() {
		window.open("<?=base_url('elektromedik/emcdaftar/pemeriksaan_em/'.$no_register.'/DOKTER')?>", "_self");
    }
</script>
<!-- <button onclick="clearButton()">Clear</button> -->
<div class="row">
    <div class="col-md-8">
        <div class="body">
            <div class="card m-5">
                <div id="surveyContainer"></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card m-5">
            <div class="card-body">
                <div class="row">
                    <center>
                        <a class="btn btn-primary" href="<?php echo base_url('ird/rdcpelayanan/form/diagnosa/'.$no_register);?>" style="width:85%; margin-bottom: 15px;">Diagnosa</a>&nbsp;&nbsp;<br>
                        <a class="btn btn-primary" href="<?php echo base_url('ird/rdcpelayanan/form/prosedur/'.$no_register);?>" style="width:85%; margin-bottom: 15px;">Procedure</a>&nbsp;&nbsp;<br>
                        <button class="btn btn-primary" onclick="inputResep()" style="width:85%; margin-bottom: 15px;"><i class="fa fa-plus"></i> Resep</button>&nbsp;&nbsp;<br>
                        <button class="btn btn-primary" onclick="inputLabor()" style="width:85%; margin-bottom: 15px;"><i class="fa fa-plus" ></i> Laboratorium</button>&nbsp;&nbsp;<br>
                        <button class="btn btn-primary" onclick="inputRadiologi()" style="width:85%; margin-bottom: 15px;"><i class="fa fa-plus" ></i>Radiologi</button>&nbsp;&nbsp;<br>
                        <button class="btn btn-primary" onclick="inputElektromedik()" style="width:85%;"><i class="fa fa-plus" ></i>Elektromedik</button>&nbsp;&nbsp;
                    </center>
                </div>
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

Survey.StylesManager.applyTheme("modern");
var surveyJSON = <?php echo file_get_contents(__DIR__ ."/form/assesment_awal_medis.json");?>;


 
function sendDataToServer(survey) {
    $.ajax({
    type: "POST",
    url: '<?php echo base_url('ird/rdcpelayananfdokter/insert_medik_igd/'.$no_register); ?>',
    data: {
        formjson:JSON.stringify(survey.data),
        id_dokter : "<?= $data_pasien_daftar_ulang->id_dokter ?>"

    },
    success: function(data){
        // console.log(data);
      
            location.reload();
       
    },
    // dataType: 'json'
    });
}

var survey = new Survey.Model(surveyJSON);

// function clearButton(){
//     survey.clearValue('imageigd');

// }


<?php
if(isset($assesment_medik_igd[0]->formjson)){
?>
survey.data = <?= $assesment_medik_igd[0]->formjson; ?>;
survey.setValue('pemeriksaan_penunjang_dokter',"<?= isset($soap_pasien_rj)?str_replace(["\r","\n",PHP_EOL],'\n',$soap_pasien_rj->pemeriksaan_penunjang_dokter):'' ?>");
// survey.setValue("diagnosa_kerja_dokter","<?php // isset($soap_pasien_rj->diagnosis_kerja_dokter)?str_replace("<br>",'\n',$soap_pasien_rj->diagnosis_kerja_dokter):'' ?>");

// survey.setValue("terapi_tindakan_dokter","<?php
//     $tind_from_keperawatan = "";
//     $a = "";
//     if(isset($data_keperawatan->table1)){
//         foreach($data_keperawatan->table1 as $val){
//             $a.=$val->time.' '.$val->tindakan.' '.$val->nama_obat_infus.' '.$val->dosis_frekuensi.' '.$val->cara_pemberian.'\n';
//         }
//     }
//     echo isset($a)?$a.(isset($soap_pasien_rj->terapi_tindakan_dokter)?str_replace([PHP_EOL,"\r","\n"],'\n',$soap_pasien_rj->terapi_tindakan_dokter):''):(isset($soap_pasien_rj->terapi_tindakan_dokter)?str_replace([PHP_EOL,"\r","\n"],'\n',$soap_pasien_rj->terapi_tindakan_dokter):'');
//     // echo str_replace([PHP_EOL,"\r","\n"],"\n",$tind_from_keperawatan.(isset($soap_pasien_rj->terapi_tindakan_dokter)?$soap_pasien_rj->terapi_tindakan_dokter:''));
//     ?>");
<?php 
}else{
?>
    survey.data = {"question5":[
      {
         "nama_obat":"IVFD NaCl 0,9%",
         "jumlah_frekwensi":"12 jam/kolf",
         "dosis":"500 ml",
         "cara_pemberian":"IV"
      },
      {
         "nama_obat":"O2",
         "jumlah_frekwensi":"",
         "dosis":"",
         "cara_pemberian":""
      },
      {
         "nama_obat":"Ranitidin",
         "jumlah_frekwensi":"2x1",
         "dosis":"",
         "cara_pemberian":"IV"
      },
      {
         "nama_obat":"Citicolin",
         "jumlah_frekwensi":"2x1",
         "dosis":"",
         "cara_pemberian":"PO"
      },
      {
         "nama_obat":"Simvastin",
         "jumlah_frekwensi":"1x1",
         "dosis":"",
         "cara_pemberian":"PO"
      },
      {
         "nama_obat":"Aspilet",
         "jumlah_frekwensi":"1x1",
         "dosis":"",
         "cara_pemberian":"PO"
      },
      {
         "nama_obat":"Neurodex",
         "jumlah_frekwensi":"1x1",
         "dosis":"",
         "cara_pemberian":"PO"
      },
      {
         "nama_obat":"IV Cath No. 20",
         "jumlah_frekwensi":"",
         "dosis":"",
         "cara_pemberian":""
      },
      {
         "nama_obat":"Infus Set Makro",
         "jumlah_frekwensi":"",
         "dosis":"",
         "cara_pemberian":""
      },
      {
         "nama_obat":"Spuit 3 cc",
         "jumlah_frekwensi":"",
         "dosis":"",
         "cara_pemberian":""
      }
      ]
      };
    survey.setValue('anamnesis',"<?= isset($data_triase->keluhan_utama)?str_replace([PHP_EOL,"\r","\n"],'\n',$data_triase->keluhan_utama):''; ?>");
    survey.setValue("ku","<?= isset($data_fisik->ku)?str_replace([PHP_EOL,"\r","\r"],'\n',$data_fisik->ku):(isset($data_triase->keluhan_utama)?str_replace([PHP_EOL,"\r","\n"],'\n',$data_triase->keluhan_utama):null) ?>");
    survey.setValue("vitalsign","<?= isset($data_fisik->vitalsign)?$data_fisik->vitalsign:'' ?>");
    survey.setValue("td","<?= isset($data_fisik->sitolic) && isset($data_fisik->diatolic)?$data_fisik->sitolic.'/'.$data_fisik->diatolic:(isset($data_triase->tekanan_darah)?$data_triase->tekanan_darah:null) ?>");
    survey.setValue("nadi","<?= isset($data_fisik->nadi)?$data_fisik->nadi:(isset($data_triase->nadi)?$data_triase->nadi:null) ?>");
    survey.setValue("pernafasan","<?= isset($data_fisik->pernafasan)?$data_fisik->pernafasan:(isset($data_triase->nafas)?$data_triase->nafas:null) ?>");
    survey.setValue("suhu","<?= isset($data_fisik->suhu)?$data_fisik->suhu:(isset($data_triase->suhu1)?$data_triase->suhu1:null) ?>");
    survey.setValue("bb","<?= isset($data_fisik->bb)?$data_fisik->bb:'' ?>");
    survey.setValue("kesadaran","<?= isset($data_fisik->kesadaran)?$data_fisik->kesadaran:'' ?>");
    survey.setValue("gcs","<?= isset($data_fisik->e_gcs)?'E :'.' '.$data_fisik->e_gcs.' '.' '.'M :'.' '.$data_fisik->m_gcs.' '.' '.'V :'.' '.$data_fisik->v_gcs:'' ?>");
    survey.setValue('sensorik_tangan_kiri',"<?= isset($data_fisik->sensorik_tangan_kiri)?$data_fisik->sensorik_tangan_kiri:'' ?>");
    survey.setValue('sensorik_tangan_kanan',"<?= isset($data_fisik->sensorik_tangan_kanan)?$data_fisik->sensorik_tangan_kanan:'' ?>");
    survey.setValue('motorik_kaki_kiri',"<?= isset($data_fisik->sensorik_kaki_kiri)?$data_fisik->sensorik_kaki_kiri:'' ?>");
    survey.setValue('motorik_kaki_kanan',"<?= isset($data_fisik->sensorik_kaki_kanan)?$data_fisik->sensorik_kaki_kanan:'' ?>");
    survey.setValue('lengan_kanan',<?= isset($data_fisik->motorik_tangan_kanan)?$data_fisik->motorik_tangan_kanan:'' ?>);
    survey.setValue('lengan_kiri',<?= isset($data_fisik->motorik_tangan_kiri)?$data_fisik->motorik_tangan_kiri:'' ?>);
    survey.setValue('kaki_kiri',<?= isset($data_fisik->motorik_kaki_kiri)?$data_fisik->motorik_kaki_kiri:'' ?>);
    survey.setValue('kaki_kanan',<?= isset($data_fisik->motorik_kaki_kanan)?$data_fisik->motorik_kaki_kanan:'' ?>);
    survey.setValue('lateralisasi_lengan_kanan',<?= isset($data_fisik->literalisasi_kanan)?$data_fisik->literalisasi_kanan:'' ?>);
    survey.setValue('lateralisasi_lengan_kiri',<?= isset($data_fisik->literalisasi_kiri)?$data_fisik->literalisasi_kiri:'' ?>);
    
    
    survey.setValue('subject',"<?= isset($data_keperawatan->riwayat_kesehatan)?str_replace([PHP_EOL,"\r","\n"],'\n',$data_keperawatan->riwayat_kesehatan):'' ?>");
    survey.setValue('object',"<?= isset($soap_pasien_rj)?str_replace([PHP_EOL,"\r","\n"],'\n',$soap_pasien_rj->objective_perawat):'' ?>");
    survey.setValue('plan',"<?= isset($soap_pasien_rj)?trim(str_replace('<br>','\n',$soap_pasien_rj->plan_dokter)):'' ?>");
    // survey.setValue('pemeriksaan_penunjang_dokter',"<?php // isset($soap_pasien_rj)?trim(str_replace('<br>','\n',$soap_pasien_rj->pemeriksaan_penunjang_dokter)):'' ?>");
    survey.setValue("status_generalis_dokter","<?= isset($data_fisik->e_gcs)?'E :'.' '.$data_fisik->e_gcs.' '.' '.'M :'.' '.$data_fisik->m_gcs.' '.' '.'V :'.' '.$data_fisik->v_gcs:'' ?>");
    survey.setValue("assesment","<?= isset($soap_pasien_rj->assesment_dokter)?str_replace(["<br>",PHP_EOL,"\r","\n"],'\n',$soap_pasien_rj->assesment_dokter):'' ?>");
    // survey.setValue("diagnosa_kerja_dokter","<?php // isset($soap_pasien_rj->diagnosis_kerja_dokter)?str_replace("<br>",'\n',$soap_pasien_rj->diagnosis_kerja_dokter):'' ?>");
    // survey.setValue("terapi_tindakan_dokter","<?php
    // $tind_from_keperawatan = "";
    // $a = "";
    // if(isset($data_keperawatan->table1)){
    //     foreach($data_keperawatan->table1 as $val){
    //         $a .= $val->tindakan.' '.$val->nama_obat_infus.' '.$val->dosis_frekuensi.' '.$val->cara_pemberian.'\n';
    //     }
    // }
    // echo isset($a)?$a.(isset($soap_pasien_rj->terapi_tindakan_dokter)?str_replace([PHP_EOL,"\r","\n"],'\n',$soap_pasien_rj->terapi_tindakan_dokter):''):(isset($soap_pasien_rj->terapi_tindakan_dokter)?str_replace([PHP_EOL,"\r","\n"],'\n',$soap_pasien_rj->terapi_tindakan_dokter):'');
    // // echo str_replace([PHP_EOL,"\r","\n"],'\n',$tind_from_keperawatan.(isset($soap_pasien_rj->terapi_tindakan_dokter)?$soap_pasien_rj->terapi_tindakan_dokter:''));
    // ?>");


<?php
}
?>

$("#surveyContainer").Survey({
    model: survey,
    onComplete: sendDataToServer
});
</script>