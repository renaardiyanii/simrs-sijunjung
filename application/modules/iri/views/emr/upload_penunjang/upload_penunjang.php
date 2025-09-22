<?php 
$this->load->view('layout/header_form');
// var_dump($persetujuan_transfusi_darah);die();
?>
<style>

</style>

<div class="card m-5">
	<div class="card-header ">
        <div class="d-flex justify-content-between">
			<h5>Uploud Penunjang</h5>
			<div class="d-flex">
               <a href="<?= base_url('emedrec/C_emedrec/upload_penunjang_rj/' . $noreg_old . '/' . $data_pasien[0]['no_cm'] . '/' . $data_pasien[0]['no_medrec']) ?>" target="_blank" class="btn btn-primary pull-right">View Uploud Penunjang IRJ</a>&nbsp;&nbsp;
                <a href="<?= base_url('emedrec/C_emedrec_iri/upload_penunjang_ri/' . $no_ipd . '/' . $data_pasien[0]['no_medrec'] . '/' . $data_pasien[0]['no_cm']) ?>" target="_blank" class="btn btn-primary pull-right">View Uploud Penunjang IRI</a>
			</div>
		</div>
    </div>

<div class="card m-5">
    <div class="body">
    <div id="surveyupload_penunjang"></div>

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

surveyJSONserah_upload_penunjang = <?php echo file_get_contents("upload_penunjang.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerUploadPenunjang(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_upload_penunjang/') ?>',
            data: {
                no_register : '<?php echo $no_ipd;?>',
                upload_penunjang_json:JSON.stringify(survey.data),
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


    var survey_upload_penunjang = new Survey.Model(surveyJSONserah_upload_penunjang);

    <?php if($upload_penunjang){ ?>
		survey_upload_penunjang.data = <?php echo isset($upload_penunjang->formjson)?$upload_penunjang->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveyupload_penunjang").Survey({
    model: survey_upload_penunjang,
    onComplete: sendDataToServerUploadPenunjang
});
</script>