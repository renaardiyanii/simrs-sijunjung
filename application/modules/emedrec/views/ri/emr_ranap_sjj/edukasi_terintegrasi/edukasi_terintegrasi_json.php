<?php 
$this->load->view('ri/layout/header_form');
// var_dump($lembar_ppi);die();
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="survey_edukasi_terintegrasi"></div>

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

surveyJSONedukasi_terintegrasi = <?php echo file_get_contents("edukasi_terintegrasi.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServeredukasi_terintegrasi(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_edukasi_terintegrasi/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                edukasi_terintegrasi_json:JSON.stringify(survey.data),
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


    var survey_edukasi_terintegrasi = new Survey.Model(surveyJSONedukasi_terintegrasi);

    <?php if($edukasi_terintegrasi){ ?>
		survey_edukasi_terintegrasi.data = <?php echo isset($edukasi_terintegrasi->formjson)?$edukasi_terintegrasi->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#survey_edukasi_terintegrasi").Survey({
    model: survey_edukasi_terintegrasi,
    onComplete: sendDataToServeredukasi_terintegrasi
});
</script>