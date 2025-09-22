<?php 
$this->load->view('layout/header_form');
// var_dump($pengkajian_medis_kb)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveyedukasi_anastesi"></div>

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

surveyJSONedukasianastesi = <?php echo file_get_contents("edukasi_anestesi_sedasi.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServeredukasianastesi(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_edukasi_anastesi_sedasi/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                edukasi_anestesi_sedasi_json:JSON.stringify(survey.data),
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


    var survey_edukasi_anastesi_sedasi = new Survey.Model(surveyJSONedukasianastesi);

    <?php if($edukasi_anastesi_sedasi){ ?>
		survey_edukasi_anastesi_sedasi.data = <?php echo isset($edukasi_anastesi_sedasi->formjson)?$edukasi_anastesi_sedasi->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveyedukasi_anastesi").Survey({
    model: survey_edukasi_anastesi_sedasi,
    onComplete: sendDataToServeredukasianastesi
});
</script>