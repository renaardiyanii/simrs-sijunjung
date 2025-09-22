<?php $this->load->view('layout/header_form');?>
<!-- <link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->
<div id="surveyContainerMata"></div>

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

//Survey.CustomWidgetCollection.Instance.addCustomWidget(widget, "type");



surveyJSON = <?php echo file_get_contents(__DIR__ ."/emr/asesment awal keperawatan poliklinik mata.json");?>;
    Survey.StylesManager.applyTheme("modern");
    var surveyAssesmentKeperawatanMata = new Survey.Model(surveyJSON);

        function sendDataToServerKeperawatanMata(survey) {
            // console.log(JSON.stringify(survey.data));
          
            $.ajax({
                type: "POST",
                url: '<?php echo base_url('irj/rjcpelayanan/insert_assesment_keperawatan_rj/'.$no_register); ?>',
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
        if($assesment_keperawatan){
        ?>
        surveyAssesmentKeperawatanMata.data = <?= $assesment_keperawatan->formjson; ?>;
        <?php }else{
        ?>
        <?php }
        ?>
        
        surveyAssesmentKeperawatanMata.render("surveyContainerMata");
        surveyAssesmentKeperawatanMata
            .onComplete
            .add(function (result) {
                sendDataToServerKeperawatanMata(result);
            });

        

          
</script>