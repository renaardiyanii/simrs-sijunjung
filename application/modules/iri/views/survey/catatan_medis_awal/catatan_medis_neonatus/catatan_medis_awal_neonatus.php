<?php
 $test = isset($assesment_keperawatan_iri[0]->formjson_bayi)?json_decode($assesment_keperawatan_iri[0]->formjson_bayi):'';
 $interval = date_diff(date_create(), date_create($data_pasien[0]['tgl_lahir']));
$umur = $interval->format("%Y Tahun");
 //var_dump($test);die();
?>
<style>

</style>
<!-- <link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->
<div class="pl-4 pt-2">
	<a target="_blank" href="<?= base_url('emedrec/C_emedrec_iri/catatan_medis_awal_neonatus/'.$no_ipd) ?>" class="btn btn-primary">Lihat Catatan Medis Awal Neonatus</a>
</div>

<div id="SurveyNeonetus"></div>
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


Survey.CustomWidgetCollection.Instance.addCustomWidget(bgSignatureWidget, "type");

Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("catatan_medis_awal_neonatus.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServer(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/catatan_medis_awal_neonatus/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd ;?>',
                neonetus_json:JSON.stringify(survey.data),
            },
            success: function(data)
            {
            
                location.reload();
                

            },
            error: function(data)
            {
                
            }
        }); 
            //  console.log(JSON.stringify(survey.data));
        
        }


    var survey_neonetus = new Survey.Model(surveyJSON);
   
	<?php if($neonatus->num_rows()){ ?>
		survey_neonetus.data = <?= $neonatus->row()->formjson; ?>
	<?php }else{ ?>
		
        <?php } ?>
        


	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#SurveyNeonetus").Survey({
    model: survey_neonetus,
    onComplete: sendDataToServer
});
</script>