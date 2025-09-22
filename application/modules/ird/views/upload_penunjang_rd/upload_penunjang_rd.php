<?php 
$this->load->view('layout/header_form');
// var_dump($rencana_kerja);die();
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="Surveyuploadpenunjang"></div>

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

surveyJSONuploadpenunjang = <?php echo file_get_contents("upload_penunjang_rd.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServeruploadpenunjang(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('ird/rdcpelayanan/insert_upload_penunjang_rd/') ?>',
            data: {
                no_ipd : '<?php echo $data_pasien_daftar_ulang->no_register ;?>',
                upload_penunjang_rd_json:JSON.stringify(survey.data),
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


    var survey_upload_penunjang = new Survey.Model(surveyJSONuploadpenunjang);

    <?php if($upload_penunjang_rd){ ?>
		survey_upload_penunjang.data = <?php echo isset($upload_penunjang_rd->formjson)?$upload_penunjang_rd->formjson:''; ?>
	<?php }else{ ?>
       
        
    <?php } ?>

    

// survey.css = myCss;
$("#Surveyuploadpenunjang").Survey({
    model: survey_upload_penunjang,
    onComplete: sendDataToServeruploadpenunjang
});
</script>