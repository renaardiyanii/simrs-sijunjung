<?php 
$this->load->view('layout/header_form');
// var_dump($status_sedasi)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveystatus_sedasi"></div>

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

surveyJSONstatus_sedasi = <?php echo file_get_contents("status_sedasi.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerstatus_sedasi(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_status_sedasi/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                status_sedasi_json:JSON.stringify(survey.data),
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


    var survey_status_sedasi = new Survey.Model(surveyJSONstatus_sedasi);

    <?php if($status_sedasi){ ?>
		survey_status_sedasi.data = <?php echo isset($status_sedasi->formjson)?$status_sedasi->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveystatus_sedasi").Survey({
    model: survey_status_sedasi,
    onComplete: sendDataToServerstatus_sedasi
});
</script>