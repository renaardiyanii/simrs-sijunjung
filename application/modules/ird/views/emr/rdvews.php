<?php 
$this->load->view('layout/header_form');
?>
<style>

</style>
<link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script>



<div class="card m-5">
    <div class="body">
    <div id="SurveyEWS"></div>

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

Survey.CustomWidgetCollection.Instance.addCustomWidget(widget, "type");

Survey.StylesManager.applyTheme("modern");

surveyJSONEws = <?php echo file_get_contents(__DIR__ ."/form/form_ews.json");?>;

function sendDataToServerEws(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('ird/rdcpelayanan/insert_ews/') ?>',
            data: {
                no_register : '<?= $data_pasien_daftar_ulang->no_register ?>',
                ews_json:JSON.stringify(survey.data),
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


    var survey_ews = new Survey.Model(surveyJSONEws);
    <?php 
if(isset($data_fisik->ews_json)){
    if($data_fisik->ews_json != null){
?>
survey_ews.data = <?php echo $data_fisik->ews_json ?>
<?php
    } 
}else{

?>
let pernafasan  = '';
if('<?= $data_fisik->pernafasan ?>'<8){
    pernafasan = '3';
}else if('<?= $data_fisik->pernafasan ?>'>=9 && '<?= $data_fisik->pernafasan ?> '<=11){
    pernafasan = '1';
}else if ('<?= $data_fisik->pernafasan ?>'>=12 && '<?= $data_fisik->pernafasan ?>'<=20){
    pernafasan = '0';
}else if ('<?= $data_fisik->pernafasan ?>'>= 21 && '<?= $data_fisik->pernafasan ?>'<=24){
    pernafasan = '2';
}else if ('<?= $data_fisik->pernafasan ?>'>25){
    pernafasan = '3.';
}

let suhu  = '';
if('<?= $data_fisik->suhu ?>'<35){
    suhu = '3';
}else if('<?= $data_fisik->suhu ?>'>=35.1 && '<?= $data_fisik->suhu ?>'<=36){
    suhu = '1';
}else if ('<?= $data_fisik->suhu ?>'>=36.2 && '<?= $data_fisik->suhu ?>'<=38){
    suhu = '0';
}else if ('<?= $data_fisik->suhu ?>'>=39.1){
    suhu = '1.';
}


let sitolic  = '';
if('<?= $data_fisik->sitolic ?>'<90){
    sitolic = '3';
}else if('<?= $data_fisik->sitolic ?>'>=90 && '<?= $data_fisik->sitolic ?>'<=100){
    sitolic = '2';
}else if ('<?= $data_fisik->sitolic ?>'>=101 && '<?= $data_fisik->sitolic ?>'<=110){
    sitolic = '1';
}
else if ('<?= $data_fisik->sitolic ?>'>=111 && '<?= $data_fisik->sitolic ?>'<=219){
    sitolic = '0';
}else if ('<?= $data_fisik->sitolic ?>'>=220){
    sitolic = '3.';
}

let nadi  = '';
if('<?= $data_fisik->nadi ?>'<=40){
    nadi = '3.';
}else if('<?= $data_fisik->nadi ?>'>=41 && '<?= $data_fisik->nadi ?>'<=50){
    nadi = '1';
}else if ('<?= $data_fisik->nadi ?>'>=51 && '<?= $data_fisik->nadi ?>'<=90){
    nadi = '0';
}
else if ('<?= $data_fisik->nadi ?>'>=91 && '<?= $data_fisik->nadi ?>'<=110){
    nadi = '1.';
}
else if ('<?= $data_fisik->nadi ?>'>=111 && '<?= $data_fisik->nadi ?>'<=130){
    nadi = '2';
}else if ('<?= $data_fisik->nadi ?>'>=131){
    nadi = '3';
}

survey_ews.data = {
    "physiological": {
        "result": {
            "1": pernafasan, 
            "2": suhu,
            "3": sitolic,
            "4": nadi,
        }
    }
}

    


<?php } ?>

	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#SurveyEWS").Survey({
    model: survey_ews,
    onComplete: sendDataToServerEws
});
</script>