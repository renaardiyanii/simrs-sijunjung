<?php 
$this->load->view('layout/header_form');
// var_dump($pengkajian_medis_kb)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveyringkasan_masuk_keluar"></div>

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

surveyJSONringkasan_masuk_keluar = <?php echo file_get_contents("ringkasan_masuk_keluar_ranap.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerringkasan_masuk_keluar(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_ringkasan_masuk_keluar/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                ringkasan_masuk_keluar_ranap_json:JSON.stringify(survey.data),
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


    var survey_ringkasan_masuk_keluar = new Survey.Model(surveyJSONringkasan_masuk_keluar);

    <?php if($ringkasan_masuk_keluar){ ?>
		survey_ringkasan_masuk_keluar.data = <?php echo isset($ringkasan_masuk_keluar->formjson)?$ringkasan_masuk_keluar->formjson:''; ?>
	<?php }else{ ?>
       
        survey_ringkasan_masuk_keluar.data =  {"question2":{"text1":"<?= isset($data_pasien[0]['no_cm'])?$data_pasien[0]['no_cm']:''?>",
            "text3":"<?= isset($data_pasien[0]['nama'])?$data_pasien[0]['nama']:''?>",
            "text5":"<?= isset($data_pasien[0]['tgl_lahir'])?$data_pasien[0]['tgl_lahir']:''?>",
            "text7":"<?= isset($data_pasien[0]['alamat'])?$data_pasien[0]['alamat']:''?>",
            "text9":"<?= isset($data_pasien[0]['wnegara'])?$data_pasien[0]['wnegara']:''?>",
            "text11":"",
            "text13":"<?= isset($data_pasien[0]['pekerjaan'])?$data_pasien[0]['pekerjaan']:''?>",
            "text2":"<?= isset($data_pasien[0]['no_kartu'])?$data_pasien[0]['no_kartu']:''?>",
            "text4":"<?= isset($data_pasien[0]['no_hp'])?$data_pasien[0]['no_hp']:''?>",
            "text6":"<?= isset($data_pasien[0]['no_identitas'])?$data_pasien[0]['no_identitas']:''?>",
            "text8":"<?= isset($data_pasien[0]['carabayar'])?$data_pasien[0]['carabayar']:''?>",
            "text10":"<?= isset($ruang[0]['nmruang'])?$ruang[0]['nmruang']:''?>",
            "text12":""}}
    <?php } ?>
    

// survey.css = myCss;
$("#surveyringkasan_masuk_keluar").Survey({
    model: survey_ringkasan_masuk_keluar,
    onComplete: sendDataToServerringkasan_masuk_keluar
});
</script>