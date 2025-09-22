<?php
$this->load->view('templates/templates_header');
?>
    <!-- Just an image -->
    <!-- <nav class="navbar navbar-light bg-white">
    <a class="navbar-brand" href="#">
        <img src="<?= base_url('/assets/images/logos/logo.png'); ?>" width="50" height="40" alt="">
        RSOMH Bukittinggi
    </a>
    </nav> -->
    <div class="mt-4 ml-4 mr-4">
        <h5>Daftar Kapasitas Bed</h5>
        <div class="row">
            <div class="col">
                <div class="card" style="width:1000px;">
                    <div class="card-body">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                    <h6>Kapasitas Bed</h6>
                    <table class="table table-bordered dataTables" >
                        <thead>
                            <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Ruang</th>
                            <th scope="col">Kapasitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no=1;
                            foreach($kapasitasBed as $val){
                            ?>
                            <tr>
                                <th scope="row"><?= $no ?></th>
                                <td><?= $val['nmruang'] ?></td>
                                <td><?= $val['kapasitas'] ?></td>
                            </tr>
                            <?php 
                            $no++;
                            }
                            ?>
                        </tbody>
                    </table>
                    </div>
                </div>
        
            </div>
        </div>
    </div>
   
    <div class="mt-4 ml-4 mr-4">
        <h4>Ketersediaan Bed</h4>
        <div class="row">
            <div class="col">
                <div class="card" style="width:1000px;">
                    <div class="card-body">
                        <canvas id="chartBedKosong"></canvas>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                    <h6>Daftar Ketersediaan Bed</h6>
                    <table class="table table-bordered dataTables">
                        <thead>
                            <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Ruang</th>
                            <th scope="col">Jumlah </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no=1;
                            foreach($bed_kosong as $val){
                            ?>
                            <tr>
                                <th scope="row"><?= $no ?></th>
                                <td><?= $val['nmruang'] ?></td>
                                <td><?= $val['bed_kosong'] ?></td>
                            </tr>
                            <?php 
                            $no++;
                            }
                            ?>
                        </tbody>
                    </table>
                    </div>
                </div>
        
            </div>
        </div>
    </div>
    <br><br>
  
<?php
$this->load->view('templates/templates_footer');
?>
  <script>
   

   $(document).ready(function(){
       let ruangan = [];
       let kapasitas = [];
       let backgroundColor = [];
       let borderColor = [];
   
       // chart 2
       let ruanganKosong = [];
       let bedKosong = [];
       let backgroundColor2 = [];
       let borderColor2 = [];
       $('.dataTables').DataTable({
           "pageLength": 7
       });
   
       const generateWarna = (max) => {
           let angka = Math.floor(Math.random() * max) + 1;
           let color = generateBackgroundColor(angka);
           return color;   
       }
   
       const generateBackgroundColor = (generate) =>{
           
           switch(generate){
               case 1:
                   return ['rgba(255, 99, 132, 0.2)','rgba(255, 99, 132, 1)'];
                   break;
               case 2:
                   return ['rgba(54, 162, 235, 0.2)','rgba(54, 162, 235, 1)'];
                   break;
               case 3:
                   return ['rgba(255, 206, 86, 0.2)','rgba(255, 206, 86, 1)'];
                   break;
               case 4:
                   return ['rgba(75, 192, 192, 0.2)','rgba(75, 192, 192, 1)'];
                   break;
               case 5:
                   return ['rgba(153, 102, 255, 0.2)','rgba(153, 102, 255, 1)'];
                   break;
               case 6:
                   return ['rgba(245, 125, 145, 0.2)','rgba(245, 125, 145, 1)'];
                   break;
               case 7:
                   return ['rgba(41, 31, 132, 0.2)','rgba(41, 31, 132, 1)'];
                   break;
               case 8:
                   return ['rgba(12, 119, 187, 0.2)','rgba(12, 119, 187, 1)'];
                   break;
               case 9:
                   return ['rgba(73, 170, 61, 0.2)','rgba(73, 170, 61, 1)'];
                   break;
               case 10:
                   return ['rgba(73, 170, 148, 0.2)','rgba(73, 170, 148, 1)'];
                   break;
           }
       };
   
       const generateChart = (id,title,label,data,background,border) => {
           label.forEach(result=>{
               let angka = generateWarna(10);
               background.push(angka[0])
               border.push(angka[1]);
           });
   
           const ctx = document.getElementById(id).getContext('2d');
           const myChart = new Chart(ctx, {
               type: 'bar',
               data: {
                   labels: label,
                   datasets: [{
                       label:title,
                       data: data,
                       backgroundColor: background,
                       borderColor: border,
                       borderWidth: 1
                   }]
               },
               options: {
               
                   plugins: {
                       title: {
                           display: true,
                           text: title
                       },
                       legend: {
                           labels: {
                               font: {
                                   size: 14
                               }
                           }
                       }
                   }
                   
               }
           });
           
       };
   
       $.get( "<?= base_url('dashboard/get_kapasitas_bed') ?>", function( dataMentah ) {
           let dataMasak = JSON.parse(dataMentah);
           $.each(dataMasak, function( key, value ) {
               ruangan.push(value.nmruang);
               kapasitas.push(value.kapasitas); 
           });
           generateChart('myChart','kapasitas Bed',ruangan,kapasitas,backgroundColor,borderColor);
   
           
           });
   
       $.get( "<?= base_url('dashboard/get_kosong_bed') ?>", function( dataMentah ) {
           let dataMasak = JSON.parse(dataMentah);
           $.each(dataMasak, function( key, value ) {
               ruanganKosong.push(value.nmruang);
               bedKosong.push(value.bed_kosong); 
           });
           generateChart('chartBedKosong','Daftar Ketersediaan Bed',ruanganKosong,bedKosong,backgroundColor2,borderColor2);
   
           
           });
           
   
       
   
     
   
       
   });
   </script>