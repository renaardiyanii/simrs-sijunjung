<?php 
$this->load->view('layout/header_form');
// var_dump($pengkajian_medis_kb)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveypaps"></div>

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

surveyJSONpaps = <?php echo file_get_contents("paps.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerpaps(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_paps/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                paps_json:JSON.stringify(survey.data),
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


    var survey_paps = new Survey.Model(surveyJSONpaps);

    <?php if($paps){ ?>
		survey_paps.data = <?php echo isset($paps->formjson)?$paps->formjson:''; ?>
	<?php }else{ ?>

        survey_paps.data = {"question3":{"text1":"<?= isset($data_pasien[0]['no_cm'])?$data_pasien[0]['no_cm']:''?>",
            "text2":"<?= isset($data_pasien[0]['nama'])?$data_pasien[0]['nama']:''?>",
            "text3":"<?= isset($data_pasien[0]['tgl_lahir'])?date('d-m-Y',strtotime($data_pasien[0]['tgl_lahir'])):''?>",
            "text4":"<?= isset($data_pasien[0]['alamat'])?$data_pasien[0]['alamat']:''?>",
            "text5":"<?= isset($ruang[0]['nmruang'])?$ruang[0]['nmruang']:''?>"}}

    <?php } ?>
    

// survey.css = myCss;
$("#surveypaps").Survey({
    model: survey_paps,
    onComplete: sendDataToServerpaps
});
</script>