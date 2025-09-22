<?php 
$this->load->view('layout/header_form');
// var_dump($tindakan_hemodialisa);die();
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveypermintaan_privasi"></div>

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

surveyJSONpermintaan_privasi = <?php echo file_get_contents("permintaan_privasi.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerpermintaan_privasi(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_permintaan_privasi/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                permintaan_privasi_json:JSON.stringify(survey.data),
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


    var survey_permintaan_privasi = new Survey.Model(surveyJSONpermintaan_privasi);

    <?php if($permintaan_privasi){ ?>
		survey_permintaan_privasi.data = <?php echo isset($permintaan_privasi->formjson)?$permintaan_privasi->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveypermintaan_privasi").Survey({
    model: survey_permintaan_privasi,
    onComplete: sendDataToServerpermintaan_privasi
});
</script>