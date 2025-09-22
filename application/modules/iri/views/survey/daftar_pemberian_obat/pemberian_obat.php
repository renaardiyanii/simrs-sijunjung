<?php 
$this->load->view('layout/header_form');
?>
<?php 
//  
 $data_obat = isset($data_pemberian_obat->formjson)?json_decode($data_pemberian_obat->formjson):'';
//$tests = isset($intruksi_obat->formjson)?json_decode($intruksi_obat->formjson):null;

// var_dump($data_resep_pasien);
// die();
// foreach ($data_obat->pemberian_obat as $a) {
//      $nm_obat[] = $a->nm_obat; 
// }

// foreach ($data_resep_pasien as $b) {
//     $nama_obat[] = $b->nama_obat; 
// }

// var_dump(json_decode(json_encode($nm_obat,true)));
// var_dump(json_decode(json_encode($nama_obat)));
// var_dump(array_diff(json_decode(json_encode($nm_obat,true)), json_decode(json_encode($nama_obat,true))));

?>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->
<script src="<?= base_url('assets/sweetalert2.js') ?>"></script>

<div class="card m-5">
    <div class="body">
    <div id="surveyformPemberianobat"></div>

    </div>
</div>


<script>
    Survey.StylesManager.applyTheme("modern");
    // surveyJsonFormPemberianobat = <?php //echo file_get_contents("pemberian_obat.json",FILE_USE_INCLUDE_PATH);?>;
    surveyJsonFormPemberianobat = {
    "pages": [
     {
      "name": "page1",
      "elements": [
       {
        "type": "panel",
        "name": "panel1",
        "elements": [
         {
          "type": "matrixdynamic",
          "name": "list_obat",
          "title": "List Obat",
          "hideNumber": true,
          "columns": [
           {
            "name": "nm_obat",
            "title": "Nama Obat"
           },
           {
            "name": "signa",
            "title": "Signa"
           }
          ],
          "choices": [
            1,2,3,4
          ],
          "cellType": "text",
          "allowAddRows": false,
          "allowRemoveRows": false,
          "rowCount": 1
         },
         {
          "type": "matrixdynamic",
          "name": "pemberian_obat",
          "title": "Pemberian Obat",
          "hideNumber": true,
          "columns": [
            {
            "name": "nm_dokter",
            "title": "DPJP",
            "cellType": "dropdown",
            "choicesByUrl":{
             "url": "/admin/admin/rest_all_user"
                }
            },
            {
            "name": "nm_apoteker",
            "title": "Apoteker",
            "cellType": "dropdown",
            "choicesByUrl":{
             "url": "/admin/admin/rest_all_user"
                }
            },
            {
            "name": "nm_perawat",
            "title": "Perawat",
            "cellType": "dropdown",
            "choicesByUrl":{
             "url": "/admin/admin/rest_all_user"
                }
            },
           {
            "name": "nm_obat",
            "title": "Nama Obat",
            "cellType": "dropdown"
           },
           {
            "name": "frekuensi",
            "title": "Frekuensi"
           },
           {
            "name": "tgl",
            "title": "Tanggal",
            "cellType": "text",
            "inputType": "date"
           },
           {
            "name": "waktu",
            "title": "Waktu",
            "cellType": "dropdown",
            "choices": [
             {
              "value": "8",
              "text": "8"
             },
             {
              "value": "12",
              "text": "12"
             },
             {
              "value": "18",
              "text": "18"
             },
             {
              "value": "24",
              "text": "24"
             }
            ]
           },
           {
            "name": "pssm",
            "title": "P/S/S/M",
            "cellType": "checkbox",
            "choices": [
             {
              "value": "pagi",
              "text": "P"
             },
             {
              "value": "siang",
              "text": "S"
             },
             {
              "value": "sore",
              "text": "S"
             },
             {
              "value": "malam",
              "text": "m"
             }
            ]
           }
          ],
          "choices": [
              <?php 
            if(isset($data_resep_pasien) != null){
                foreach($data_resep_pasien as $resep) {
                    echo '"'.$resep->nama_obat.'"'.',';
                                            }
                                        }else{

                                        }
        
           ?>
           
          ],
          "cellType": "text",
          "allowRemoveRows": false,
          "rowCount": 1
         }
        ]
       }
      ]
     }
    ]
   };
    var surveyFormPemberianobat = new Survey.Model(surveyJsonFormPemberianobat);


    function sendDataToServerPemberianobat(survey) {
             console.log(surveyFormPemberianobat.data);
        $.ajax({
            url: "<?php echo base_url('iri/rictindakan/daftar_pemberian_obat/')?>",
            type : 'POST',
            data : {
                no_ipd:'<?php echo $no_ipd ;?>',
                formjson: JSON.stringify(survey.data),
            },
            datatype:'json',
        
            beforeSend:function()
            {
            },      
            complete:function()
            {
            //stopPreloader();
            },
            success:function(data)
            {
                new swal('Berhasil!','Data Berhasil Disimpan','success');
               
                 location.reload();
            },
                error: function(e){
                    new swal('Gagal!','Gagal Disimpan Karena ' + e,'error');
                    
                }
        });
            
    }


    surveyFormPemberianobat.data = 
    {
        "list_obat":[
            <?php 
               if(isset($data_resep_pasien) != null){
                foreach($data_resep_pasien as $a){ ?>
            {
               
                "nm_obat":"<?= isset($a->nama_obat)?$a->nama_obat:''?>",
                
                "signa":"<?= isset($a->signa)?$a->signa:''?>"
            },
            <?php }} ?>
        ],

        "pemberian_obat":
        [
            <?php if(isset($data_pemberian_obat)){
                if($data_pemberian_obat != null) {
                 foreach($data_obat->pemberian_obat as $b){
            ?>
            {"nm_obat":"<?php echo isset($b->nm_obat)?$b->nm_obat:'' ?>",
            "frekuensi":"<?php echo isset($b->frekuensi)?$b->frekuensi:'' ?>",
            "tgl":"<?php echo isset($b->tgl)?$b->tgl:'' ?>",
            "waktu":"<?php echo isset($b->waktu)?$b->waktu:'' ?>",
            "pssm":
                [
                    "<?php echo isset($b->pssm)?(in_array("pagi", $b->pssm) ? "pagi":""):"" ?>",
                    "<?php echo isset($b->pssm)?(in_array("siang", $b->pssm) ? "siang":""):"" ?>",
                    "<?php echo isset($b->pssm)?(in_array("sore", $b->pssm) ? "sore":""):"" ?>",
                    "<?php echo isset($b->pssm)?(in_array("malam", $b->pssm) ? "malam":""):"" ?>"
                ]
            },
            <?php }
        }} else { ?>
            {"nm_obat":"",
            "frekuensi":"",
            "tgl":"",
            "waktu":"",
            "pssm":
                [
                    "",
                    "",
                    "",
                    ""
                ]
            }
        <?php }?>
        ]

    };





    
 
    
     
    
    


                
	
   
    
   

    
   
    surveyFormPemberianobat.render("surveyformPemberianobat");
    surveyFormPemberianobat
        .onComplete
        .add(function (result) {
            sendDataToServerPemberianobat(result);
        });
</script>