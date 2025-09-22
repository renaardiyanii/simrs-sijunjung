<hr>
<div class="pl-4 pt-2">
	<a target="_blank" href="<?= base_url('emedrec/C_emedrec_iri/assesment_awal_keperawatan_anak/'.$no_ipd.'/'.$data_pasien[0]['no_medrec'].'/'.$data_pasien[0]['no_cm']) ?>" class="btn btn-primary">Lihat Catatan Medis Awal Anak</a>
</div>
<div class="ml-4 mt-4">
	Pilih Halaman :
	<select id="pageSelector" onchange="surveyKeperawatan.currentPageNo = this.value"></select>
</div>
<hr/>
<div id="surveyKeperawatanAnak"></div>

<script>
	Survey.StylesManager.applyTheme("modern");
	function doOnCurrentPageChanged(survey) {
		document
			.getElementById('pageSelector')
			.value = survey.currentPageNo;
		document
			.getElementById('surveyPrev')
			.style
			.display = !survey.isFirstPage
				? "inline"
				: "none";
		document
			.getElementById('surveyNext')
			.style
			.display = !survey.isLastPage
				? "inline"
				: "none";
		document
			.getElementById('surveyComplete')
			.style
			.display = survey.isLastPage
				? "inline"
				: "none";
		document
			.getElementById('surveyProgress')
			.innerText = "Page " + (
		survey.currentPageNo + 1) + " of " + survey.visiblePageCount + ".";
		if (document.getElementById('surveyPageNo')) 
			document
				.getElementById('surveyPageNo')
				.value = survey.currentPageNo;
		}
	function setupPageSelector(survey) {
		var selector = document.getElementById('pageSelector');
		for (var i = 0; i < survey.visiblePages.length; i++) {
			var option = document.createElement("option");
			option.value = i;
			option.text = "Page " + (
			i + 1);
			selector.add(option);
		}
	}
	
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
	
	
    surveyKeperawatanAnak = <?php echo file_get_contents("assesment_awal_keperawatan_anak.json",FILE_USE_INCLUDE_PATH);?>;
    var surveyKeperawatan = new Survey.Model(surveyKeperawatanAnak);
	
   



    function sendDataToServerAnak(survey) {
		console.log(JSON.stringify(survey.data));
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
				$.ajax({
						url: "<?php echo base_url('iri/rictindakan/insert_assesment_awal_keperawatan/')?>",
						type : 'POST',
						data : {
							no_ipd:'<?php echo $no_ipd ;?>',
							data: JSON.stringify(survey.data)
						},
						datatype:'json',
					
						beforeSend:function()
						{
						},      
						complete:function()
						{
						//stopPreloader();
						},
						success:function(data)
						{
							// new swal('Berhasil!','Data Berhasil Disimpan','success');
							// window.reload();
							window.location.reload();
						},
							error: function(e){
								new swal('Gagal!','Gagal Disimpan Karena ' + e,'error');

							}
					});
			// 	};
	
			// });
            
    }

	<?php
	if(isset($assesment_keperawatan_iri[0]->formjson)){
	?>
	surveyKeperawatan.data = <?php echo $assesment_keperawatan_iri[0]->formjson ?>;
	<?php } ?>
	surveyKeperawatan.setValue('e','<?= isset($data_fisik->gcs)?explode('-',$data_fisik->gcs)[0]:'' ?>');
	surveyKeperawatan.setValue('m','<?= isset($data_fisik->gcs)?explode('-',$data_fisik->gcs)[1]:'' ?>');
	surveyKeperawatan.setValue('v','<?= isset($data_fisik->gcs)?explode('-',$data_fisik->gcs)[2]:'' ?>');
	surveyKeperawatan.setValue('suhu','<?= isset($data_fisik->suhu)?$data_fisik->suhu:'' ?>');
	surveyKeperawatan.setValue('nadi','<?= isset($data_fisik->nadi)?$data_fisik->nadi:'' ?>');
	surveyKeperawatan.setValue('frekuensi_nafas','<?= isset($data_fisik->frekuensi_nafas)?$data_fisik->frekuensi_nafas:'' ?>');
	surveyKeperawatan.setValue('tekanan_darah','<?= isset($data_fisik->td)?$data_fisik->td:'' ?>');
	surveyKeperawatan.setValue('bb','<?= isset($data_fisik->bb)?$data_fisik->bb:'' ?>');
    surveyKeperawatan
        .onComplete
        .add(function (result) {
            sendDataToServerAnak(result);
        });

    surveyKeperawatan.render("surveyKeperawatanAnak");
	surveyKeperawatan
    .onCurrentPageChanged
    .add(doOnCurrentPageChanged);

	setupPageSelector(surveyKeperawatan);
	doOnCurrentPageChanged(surveyKeperawatan);
</script>