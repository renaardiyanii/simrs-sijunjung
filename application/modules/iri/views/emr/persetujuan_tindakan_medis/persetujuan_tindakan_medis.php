<?php 
$this->load->view('layout/header_form');
// var_dump($pengkajian_medis_kb)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveypersetujuan_medis"></div>

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

surveyJSONpersetujuan_medis = <?php echo file_get_contents("persetujuan_tindakan_medis.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerpersetujuan_medis(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_persetujuan_tindakan_medis/') ?>',
            data: {
                no_register : '<?php echo $no_ipd;?>',
                persetujuan_tindakan_medis_json:JSON.stringify(survey.data),
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


    var survey_persetujuan_medis = new Survey.Model(surveyJSONpersetujuan_medis);

    <?php if($persetujuan_tindakan_medis){ ?>
		survey_persetujuan_medis.data = <?php echo isset($persetujuan_tindakan_medis->formjson)?$persetujuan_tindakan_medis->formjson:''; ?>
	<?php }else{ ?>
        survey_persetujuan_medis.data = {"question11":{"Row 1":{"Column 1":"<?= isset($data_pasien[0]['nama'])?$data_pasien[0]['nama']:''?>",
            "Column 2":"<?= isset($data_pasien[0]['tgl_lahir'])?$data_pasien[0]['tgl_lahir']:''?>",
            "Column 3":"<?= isset($data_pasien[0]['sex'])?$data_pasien[0]['sex']:''?>",
            "Column 4":"<?= isset($data_pasien[0]['alamat'])?$data_pasien[0]['alamat']:''?>"}}}

    <?php } ?>
    

// survey.css = myCss;
$("#surveypersetujuan_medis").Survey({
    model: survey_persetujuan_medis,
    onComplete: sendDataToServerpersetujuan_medis
});
</script>