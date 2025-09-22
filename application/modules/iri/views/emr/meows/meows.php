<?php 
$this->load->view('layout/header_form');
// var_dump($lembar_ppi);die();
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveymeows"></div>

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

surveyJSONmeows = <?php echo file_get_contents("meows.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServermeows(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_meows/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                meows_json:JSON.stringify(survey.data),
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


    var survey_meows = new Survey.Model(surveyJSONmeows);

    <?php if($meows){ ?>
		survey_meows.data = <?php echo isset($meows->formjson)?$meows->formjson:''; ?>
	<?php }else{ ?>
        survey_meows.data = {"question2":{"text1":"<?= isset($data_pasien[0]['nama'])?$data_pasien[0]['nama']:''?>",
            "text2":"<?= isset($data_pasien[0]['tgl_lahir'])?date('d/m/Y',strtotime($data_pasien[0]['tgl_lahir'])):''?>"}}

    <?php } ?>
    

// survey.css = myCss;
$("#surveymeows").Survey({
    model: survey_meows,
    onComplete: sendDataToServermeows
});
</script>