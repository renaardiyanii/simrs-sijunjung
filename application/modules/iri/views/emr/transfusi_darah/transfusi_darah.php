<?php 
$this->load->view('layout/header_form');
// var_dump($transfusi_darah);die();
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveypersetujuan_transfusi"></div>

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

Survey.CustomWidgetCollection.Instance.setActivatedBy("select2", "type");

surveyJSONserah_transfusi_darah = <?php echo file_get_contents("transfusi_darah.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServertransfusi_darah(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_persetujuan_transfusi_darah/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                transfusi_darah_json:JSON.stringify(survey.data),
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


    var survey_transfusi_darah = new Survey.Model(surveyJSONserah_transfusi_darah);

    <?php if($persetujuan_transfusi_darah){ ?>
		survey_transfusi_darah.data = <?php echo isset($persetujuan_transfusi_darah->formjson)?$persetujuan_transfusi_darah->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveypersetujuan_transfusi").Survey({
    model: survey_transfusi_darah,
    onComplete: sendDataToServertransfusi_darah
});
</script>