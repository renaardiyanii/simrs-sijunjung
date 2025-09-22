<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Antrian Poliklinik <?= $poliklinik->nm_poli ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;900&display=swap" rel="stylesheet">
    <style>
        *{
            font-family: 'Lato', sans-serif;
        }
        body{
            /* background: linear-gradient(0deg, rgba(255, 255, 255, 0.7), rgba(255, 255, 255, 0.7)),url("<?= base_url('assets/antrian/img/bg_rs.jpg') ?>"); */
            /* background-repeat: no-repeat; */
            background-color:#f5f5f5;
            /* background-position: center ; */
            /* background-size:  100% 100%; */
            /* height:100vh; */
            /* background-color: rgba(255, 255, 255, 0.486); */
        }
        .header
        {
            
        }
        .main{
            margin-top:1em;
            height:80vh;
        }
        .content-top{
            height:49vh;
            border-radius:10px;
            background-color:#fff;
        }
        .content-bottom{
            height:29vh;
            display:grid;
            grid-column-gap: 1em;
            /* grid-template-columns: repeat(6, 1fr); */

        }
        .batas{
            height:2vh;
        }
        .section{
            width:100%;
            padding-top:1em;
            /* background-color:blue; */
        }
        .main-section{
            /* background-color:purple; */
            height:70%;
            display:flex;
            justify-content:center;
            align-items:center;
            font-size:50pt;
        }
        .sisa{
            text-align:center;
            height:auto;
            font-size:22pt;
            /* background-color:red; */
        }
        .garis{
            margin-top:3em;
            height:80%;
            background-color:#BDBDBD;
            width:5px;
        }
        .section-bawah{
            /* background:red; */
            /* border:1px solid black; */
            height:100%;
            
            border-radius:10px;
            background-color:#fff;
        }

    </style>
  </head>
  <body>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.0/knockout-min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script>
         var myViewModel = {
            dataPeserta: ko.observableArray([]),
            pasienSaatIni: ko.observableArray([]),
            listPetugas: ko.observableArray([]),
        };
        ko.applyBindings(myViewModel);
    </script>
    <div class="body">
        <div class="p-4">
            <div class="header d-flex justify-content-between ">
                <img src="<?= base_url('assets/antrian/img/logo_kemenkes.png') ?>" height="60" width="120" alt="">
                <div style="padding-right:2em;">
                    <span style="font-size:34pt;">ANTRIAN POLIKLINIK <?= $poliklinik->nm_poli ?> </span>
                </div>
                <img src="<?= base_url('assets/antrian/img/logo_rs.png') ?>" width="60" height="60" alt="">
            </div>
            <div class="main">
                <div class="content-top d-flex">
                    <div class="section">
                        <div class="sisa">Dokter</div>
                        <div id="pemanggilan-pasien"  class="main-section">--</div>
                        <div id="dokter-pasien" class="sisa">Dokter</div>
                    </div>
                    <div class="garis"></div>
                    <div class="section">
                        <div class="sisa">Perawat</div>
                        <div id="pemanggilan-pasien-perawat" class="main-section">--</div>
                        <div id="perawat-pasien" class="sisa">Perawat</div>
                    </div>
                </div>
                <div class="batas"></div>
                <div class="content-bottom">
                    
                </div>
            </div>
            <div class="footer">
    
            </div>
        </div>
    </div>

    <script>
        // count_peserta = 0;

        pesertaPerawat = [];

        const grab_all_peserta_perawat = () =>{

            $.ajax({
                    type: "POST",
                    url: "<?= base_url('antrian/antrian/detail_count_peserta_perawat/'.$poliklinik->id_poli); ?>",
                    success: (res)=>{
                        if(res.length >0){
                            res.forEach(function (val){
                                if(pesertaPerawat!=null){
                                    if(pesertaPerawat.includes(val.id_perawat)){
                                        $(`#${val.id_perawat}`).html(`${val.nama}`);
                                    }else{
                                        $('.content-bottom').append(`<div class="section-bawah">
                                            <div class="sisa" style="font-size:14pt;">Perawat <br>( ${val.perawat} )</div>
                                            <div id="${val.id_perawat}" style="font-size:18pt;display:flex;align-items:center;justify-content:center;height:60%;text-align:center;">${val.nama}</div>
                                            <div class="sisa" style="font-size:14pt;">Sedang Diperiksa</div>
                                        </div>`);
                                        pesertaPerawat.push(val.id_perawat);
                                    }
                                  
                                }else{
                                    $('.content-bottom').append(`<div class="section-bawah">
                                        <div class="sisa" style="font-size:14pt;">Perawat <br>( ${val.perawat} )</div>
                                        <div id="${val.id_perawat}" style="font-size:18pt;display:flex;align-items:center;justify-content:center;height:60%;text-align:center;">${val.nama}</div>
                                        <div class="sisa" style="font-size:14pt;">Sedang Diperiksa</div>
                                    </div>`);
                                    pesertaPerawat.push(val.id_perawat);
                                }
                                
                                
                              
                            })
                            grab_all_peserta_dokter();
                        }

                    },
                    dataType: 'json'
                });
        }
        pesertaDokter = [];

        const grab_all_peserta_dokter = () =>{
            $.ajax({
                    type: "POST",
                    url: "<?= base_url('antrian/antrian/detail_count_peserta_dokter/'.$poliklinik->id_poli); ?>",
                    success: (res)=>{
                        if(res.length >0){
                            res.forEach(function (val){
                                // console.log(pesertaDokter);
                                if(pesertaDokter!=null){
                                    if(pesertaDokter.includes(val.id_dokter)){
                                        $(`#${val.id_dokter}`).html(`${val.nama}`);
                                    }else{
                                        
                                        $('.content-bottom').append(`<div class="section-bawah">
                                            <div class="sisa" style="font-size:14pt;">Dokter <br>( ${val.dokter} )</div>
                                            <div id="${val.id_dokter}" style="font-size:18pt;display:flex;align-items:center;justify-content:center;height:60%;text-align:center;">${val.nama}</div>
                                            <div class="sisa" style="font-size:14pt;">Sedang Diperiksa</div>
                                        </div>`);
                                        pesertaDokter.push(val.id_dokter);
                                    }
                                  
                                }else{
                                    $('.content-bottom').append(`<div class="section-bawah">
                                        <div class="sisa" style="font-size:14pt;">Perawat <br>( ${val.perawat} )</div>
                                        <div id="${val.id_dokter}" style="font-size:18pt;display:flex;align-items:center;justify-content:center;height:60%;text-align:center;">${val.nama}</div>
                                        <div class="sisa" style="font-size:14pt;">Sedang Diperiksa</div>
                                    </div>`);
                                    pesertaDokter.push(val.id_dokter);
                                }
                              
                            })

                            // // old 
                            // res.forEach(function (val){
                            //     // console.log(val.id_perawat);
                            //     var matchDokter = ko.utils.arrayFirst(myViewModel.dataPeserta(), function(item) {
                            //         return item.id_dokter == val.id_dokter;
                            //     });
                            //     if(!matchDokter){
                            //         // console.log('masuk sono');
                            //         $('.content-bottom').append(`<div class="section-bawah">
                            //             <div class="sisa" style="font-size:14pt;">Dokter <br>( ${val.dokter} )</div>
                            //             <div id="${val.id_dokter}-${val.no_register}" style="font-size:18pt;display:flex;align-items:center;justify-content:center;height:60%;text-align:center;">${val.nama}</div>
                            //             <div class="sisa" style="font-size:14pt;">Sedang Diperiksa</div>
                            //         </div>`);
                            //         myViewModel.dataPeserta().push(val);
                            //     }

                            //     var matchDokterPasien = ko.utils.arrayFirst(myViewModel.dataPeserta(), function(item) {
                            //         if(item.id_dokter == val.id_dokter){
                            //             if(item.no_register!=val.no_register){
                            //                 $(`#${item.id_dokter}-${item.no_register}`).html(`${val.nama}`);
                            //                 $(`#${item.id_dokter}-${item.no_register}`).attr('id', `${item.id_dokter}-${val.no_register}`);
                            //             }
                            //         }
                            //     });
                              
                            // })
                            
                        }

                    },
                    dataType: 'json'
                });
        }

        

        const counter_peserta = () =>{
            $.ajax({
                    type: "POST",
                    url: "<?= base_url('antrian/antrian/count_peserta/'.$poliklinik->id_poli); ?>",
                    success: (res)=>{
                        // console.log(res);
                        // console.log('----disini----');
                        if(res.length >0){
                            // console.log(res);
                            // console.log(res[0].count_peserta);
                            $('.content-bottom').css( "grid-template-columns", `repeat(${res[0].count_peserta}, 1fr)` );
                            grab_all_peserta_perawat();
                            // grab_all_peserta_dokter();
                        }

                    },
                    dataType: 'json'
                });
        }

        const pemanggilan_pasien = () =>{
            $.ajax({
                    type: "POST",
                    url: "<?= base_url('antrian/antrian/pemanggilan_pasien/'.$poliklinik->id_poli); ?>",
                    success: (res)=>{
                        
                        // console.log(res.length);
                        if(res.length >0){
                            // console.log(res);
                            $('#pemanggilan-pasien-perawat').html(`${res[0].nama}`);
                            $('#perawat-pasien').html(`${res[0].name}`);

                            // myViewModel.pasienSaatIni(res[0].nama);
                            // console.log(myViewModel.pasienSaatIni());
                        }

                    },
                    dataType: 'json'
                });
        }

        const pemanggilan_pasien_dokter = () =>{
            $.ajax({
                    type: "POST",
                    url: "<?= base_url('antrian/antrian/pemanggilan_pasien_dokter/'.$poliklinik->id_poli); ?>",
                    success: (res)=>{
                        // console.log(res.length);
                        if(res.length >0){
                            // console.log(res);
                            $('#pemanggilan-pasien').html(`${res[0].nama}`);
                            $('#dokter-pasien').html(`${res[0].name}`);

                        }

                    },
                    dataType: 'json'
                });
        }


        $(document).ready(function(){
            counter_peserta();
            pemanggilan_pasien();
            pemanggilan_pasien_dokter();

            setInterval(function(){ 
                counter_peserta();
                pemanggilan_pasien();
                pemanggilan_pasien_dokter();
                // $('#pemanggilan-pasien').html(`pasien dokter ${count}`);
                
             }, 2000);
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>