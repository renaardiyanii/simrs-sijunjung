

<hr>
<div class="mt-4 ml-4">

	<a target="_blank" href="<?= base_url('emedrec/C_emedrec_iri/assesment_awal_kebidanan/'.$no_ipd) ?>" class="btn btn-primary">Lihat Assesment Bidan</a>
</div>
<hr>
<div>
		<div id="surveyKeperawatanBidan"></div>
</div>
<script>
    Survey.StylesManager.applyTheme("modern");
    surveyJSONKeperawatanBidan = <?php echo file_get_contents("assesment_keperawatan_bidan.json",FILE_USE_INCLUDE_PATH);?>;
    var surveyKeperawatanBidan = new Survey.Model(surveyJSONKeperawatanBidan);
	
    function sendDataToServerKeperawatanBidan(survey) {

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
							// location.reload();
							window.location.reload();
						},
							error: function(e){
								new swal('Gagal!','Gagal Disimpan Karena ' + e,'error');
								
							}
					});
            
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
    <?php
	if(count($assesment_keperawatan_iri)>0){
	?>
	surveyKeperawatanBidan.data = <?= $assesment_keperawatan_iri[0]->formjson ?>
	<?php }else{?>
        surveyKeperawatanBidan.data = {"asesmen":[{
            "asal_masuk":"<?= isset($data_pasien_rj[0])?$data_pasien_rj[0]['id_poli']!='BA00'?'rawat_jalan':'igd':'' ?>"}],
            "riwayat_perkawinan":"<?= $data_pasien[0]['status']??''; ?>",
                    };
    <?php } ?>

    surveyKeperawatanBidan.render("surveyKeperawatanBidan");
    surveyKeperawatanBidan
        .onComplete
        .add(function (result) {
            sendDataToServerKeperawatanBidan(result);
        });

        surveyKeperawatanBidan
    .onCurrentPageChanged
    .add(doOnCurrentPageChanged);

	setupPageSelector(surveyKeperawatanBidan);
	doOnCurrentPageChanged(surveyKeperawatanBidan);
</script>