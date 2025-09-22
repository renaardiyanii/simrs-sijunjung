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

if(isset($assesment_medik_igd[0]->formjson) && $assesment_medik_igd[0]->formjson!= null){
    $assesment_medik =json_decode($assesment_medik_igd[0]->formjson);
}
// var_dump();
?>
<style>
.container-cover{
    background-color:transparent;
}
</style>
<link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script>

<div class="card m-5">
    <div class="body">
    <div id="surveyKeperawatanIrd"></div>

    </div>
</div>

<script>
    var widget = {
    name: "emptyRadio",
    isFit : function(question) {  
        return question.getType() === 'radiogroup'; 
    },
    isDefaultRender: true,
    afterRender: function(question, el) {
      var $el = $(el);
      $el.find("input:radio").click(function(event){
           var UnCheck = "UnCheck",
                  $clickedbox = $(this),
                  radioname = $clickedbox.prop("name"),
                  $group = $('input[name|="'+ radioname + '"]'),
                  doUncheck = $clickedbox.hasClass(UnCheck),
                  isChecked = $clickedbox.is(':checked');
              if(doUncheck){
                  $group.removeClass(UnCheck);
                  $clickedbox.prop('checked', false);
                  question.value = null;
              }
              else if(isChecked){
                  $group.removeClass(UnCheck);
                  $clickedbox.addClass(UnCheck);
              }
      });    
    },
    willUnmount: function(question, el) {
    }
};


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

Survey.CustomWidgetCollection.Instance.addCustomWidget(widget, "type");

Survey.StylesManager.applyTheme("modern");

var surveyJSON = <?php echo file_get_contents(__DIR__ ."/form/assesment_keperawatan.json");?>;

function sendDataToServer(survey) {
    //send Ajax request to your web server.
    // alert("The results are:" + JSON.stringify(survey.data));

    $.ajax({
                    type: "POST",
                    url: '<?= base_url('ird/rdcpelayanan/insert_assesment_keperawatan_ird/') ?>',
                    data: {
                        nm_pemeriksa : '<?= $data_pemeriksa->name ?>',
                        data:JSON.stringify(survey.data),
                    },
                    success: function(data)
                    {
                        location.reload();

                    },
                    error: function(data)
                    {
                        
                    }
                }); 
    
}

var surveyKeperawatanIrd = new Survey.Model(surveyJSON);


<?php 

if($assesment_keperawatan!= ''){
    $riwayat_kesehatan = '';
if(isset($assesment_keperawatan[0]->formjson)){
    $jsonAssesmentKeperawatan = json_decode($assesment_keperawatan[0]->formjson);
    if(isset($jsonAssesmentKeperawatan->riwayat_kesehatan)){
        $riwayat_kesehatan = json_decode($assesment_keperawatan[0]->formjson)->riwayat_kesehatan;
        
    }
}

?>

surveyKeperawatanIrd.data = <?= $assesment_keperawatan[0]->formjson; ?>;
<?php }else{ ?>


surveyKeperawatanIrd.setValue('no_register',"<?= $data_pasien_daftar_ulang->no_register ?>");
surveyKeperawatanIrd.setValue('umum',"<?= $data_pasien_daftar_ulang->cara_bayar ?>");
surveyKeperawatanIrd.setValue('riwayat_kesehatan',"<?= isset($assesment_medik->anamnesis)?str_replace([PHP_EOL,"\r","\n"],'\n',$assesment_medik->anamnesis):'' ?>");
<?php } ?>


// survey.css = myCss;
$("#surveyKeperawatanIrd").Survey({
    model: surveyKeperawatanIrd,
    onComplete: sendDataToServer
});
</script>