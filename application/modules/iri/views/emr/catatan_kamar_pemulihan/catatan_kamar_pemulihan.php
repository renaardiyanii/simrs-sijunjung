<?php 
$this->load->view('layout/header_form');
// var_dump($pengkajian_jatuh_neonatus)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveykamar_pemulihan"></div>

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

surveyJSONkamar_pemulihan = <?php echo file_get_contents("catatan_kamar_pemulihan.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerkamar_pemulihan(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_catatan_kamar_pemulihan/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                catatan_kamar_pemulihan_json:JSON.stringify(survey.data),
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


    var survey_kamar_pemulihan = new Survey.Model(surveyJSONkamar_pemulihan);

    <?php if($cat_kamar_pemulihan){ ?>
		survey_kamar_pemulihan.data = <?php echo isset($cat_kamar_pemulihan->formjson)?$cat_kamar_pemulihan->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveykamar_pemulihan").Survey({
    model: survey_kamar_pemulihan,
    onComplete: sendDataToServerkamar_pemulihan
});
</script>