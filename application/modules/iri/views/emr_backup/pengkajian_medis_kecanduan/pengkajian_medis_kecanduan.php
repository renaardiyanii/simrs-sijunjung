<?php 
$this->load->view('layout/header_form');
// var_dump($pengkajian_jatuh_neonatus)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveyresipengkajiankecanduan"></div>

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

surveyJSONpengkajiankecanduan = <?php echo file_get_contents("pengkajian_medis_kecanduan.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerpengkajiankecanduan(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_medis_kecanduan/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                pengkajian_medis_kecanduan_json:JSON.stringify(survey.data),
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


    var survey_pengkajian_kecanduan = new Survey.Model(surveyJSONpengkajiankecanduan);

    <?php if($pengkajian_kecanduan){ ?>
		survey_pengkajian_kecanduan.data = <?php echo isset($pengkajian_kecanduan->formjson)?$pengkajian_kecanduan->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveyresipengkajiankecanduan").Survey({
    model: survey_pengkajian_kecanduan,
    onComplete: sendDataToServerpengkajiankecanduan
});
</script>