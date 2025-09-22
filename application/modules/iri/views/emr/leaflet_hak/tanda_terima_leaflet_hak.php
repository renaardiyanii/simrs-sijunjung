<?php 
// $this->load->view('layout/header_form');
// var_dump($tindakan_hemodialisa);die();
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveyleaflet_hak"></div>

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

surveyJSONleaflet_hak = <?php echo file_get_contents("tanda_terima_leaflet_hak.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerleaflet_hak(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_leaflet_hak/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                tanda_terima_leaflet_hak_json:JSON.stringify(survey.data),
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


    var survey_leaflet_hak = new Survey.Model(surveyJSONleaflet_hak);

    <?php if($leaflet_hak){ ?>
		survey_leaflet_hak.data = <?php echo isset($leaflet_hak->formjson)?$leaflet_hak->formjson:''; ?>
	<?php }else{ ?>
        survey_leaflet_hak.data = {"question2":{"text1":"<?= isset($data_pasien[0]['nama'])?$data_pasien[0]['nama']:''?>",
            "text2":"<?= isset($data_pasien[0]['no_cm'])?$data_pasien[0]['no_cm']:''?>"},
            "identitas":{"text1":"<?= isset($data_pasien[0]['nama'])?$data_pasien[0]['nama']:''?>",
            "text2":"<?= isset($data_pasien[0]['no_cm'])?$data_pasien[0]['no_cm']:''?>",
            "text3":"<?= isset($data_pasien[0]['tgl_lahir'])?date('d/m/Y',strtotime($data_pasien[0]['tgl_lahir'])):''?>",
            "text4":"<?= isset($data_pasien[0]['alamat'])?$data_pasien[0]['alamat']:''?>",
            "text5":"<?= isset($data_pasien[0]['no_hp'])?$data_pasien[0]['no_hp']:''?>"}}

    <?php } ?>
    

// survey.css = myCss;
$("#surveyleaflet_hak").Survey({
    model: survey_leaflet_hak,
    onComplete: sendDataToServerleaflet_hak
});
</script>