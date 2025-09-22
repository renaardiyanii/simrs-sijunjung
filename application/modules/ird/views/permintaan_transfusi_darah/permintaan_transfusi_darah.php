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

surveyJSONpermintaan_darah = <?php echo file_get_contents("permintaan_transfusi_darah.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerpermintaan_darah(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('ird/rdcpelayanan/insert_permintaan_transfusi_darah_igd/') ?>',
            data: {
                no_ipd : '<?php echo $data_pasien_daftar_ulang->no_register ;?>',
                permintaan_transfusi_darah_json:JSON.stringify(survey.data),
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


    var survey_permintaan_darah = new Survey.Model(surveyJSONpermintaan_darah);

    <?php if($permintaan_transfusi_darah){ ?>
		survey_permintaan_darah.data = <?php echo isset($permintaan_transfusi_darah->formjson)?$permintaan_transfusi_darah->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

// survey.css = myCss;
$("#surveymeows").Survey({
    model: survey_permintaan_darah,
    onComplete: sendDataToServerpermintaan_darah
});
</script>