<?php 
$this->load->view('layout/header_form');
// var_dump($tindakan_hemodialisa);die();
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveypremedi_lembar_intruksi"></div>

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

surveyJSONlap_pembedahan = <?php echo file_get_contents("laporan_pembedahan.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServer_lap_pembedahan(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_laporan_pembedahan/') ?>',
            data: {
                no_register : '<?php echo $no_ipd;?>',
                laporan_pembedahan_json:JSON.stringify(survey.data),
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


    var survey_premedi_lap_pembedahan = new Survey.Model(surveyJSONlap_pembedahan);

    <?php if($lap_pembedahan){ ?>
		survey_premedi_lap_pembedahan.data = <?php echo isset($lap_pembedahan->formjson)?$lap_pembedahan->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveypremedi_lembar_intruksi").Survey({
    model: survey_premedi_lap_pembedahan,
    onComplete: sendDataToServer_lap_pembedahan
});
</script>