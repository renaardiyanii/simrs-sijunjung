<?php
$this->load->view('templates/templates_header');
?>
    <div class="mt-4 ml-4 mr-4">
        <h5>Daftar Penyakit Terbanyak</h5>
        <div class="card mb-2" style="margin-left:-1em;">
            <div class="card-body">
                <input id="datepicker" placeholder="Pilih Bulan" />
                <button class="btn btn-primary submitDiagnosa" type="submit">Cari</button>
                <select class="form-select mt-2" aria-label="Default select example" id="opsi">
                    <option selected> Pilih Pelayanan </option>
                    <option value="RJ">Rawat Jalan</option>
                    <option value="RI">Rawat Inap</option>
                </select>
            </div>
        </div>

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
                    <h6>Daftar Penyakit Terbanyak</h6>
                    <table class="table table-bordered dataTables" >
                        <thead>
                            <tr>
                            <th scope="col">No</th>
                            <th scope="col">Diagnosa</th>
                            <th scope="col">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no=1;
                            foreach($diagnosa as $val){
                            ?>
                            <tr>
                                <th scope="row"><?= $no ?></th>
                                <td><?= $val['diagnosa']."( ".$val['id_diagnosa']." )" ?></td>
                                <td><?= $val['jumlah_diagnosa'] ?></td>
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
   let opsi = '<?= $opsi ?>';
   $('#opsi').change(function(){ 
        var value = $(this).val();
        opsi = value;
        window.location = '<?= base_url('/dashboard/top_ten_diagnosa/') ?>'+opsi;
    });
    var dp = $('#datepicker').datepicker( {
        format: "yyyy/mm",
        startView: "months", 
        minViewMode: "months"
    });

   $(document).ready(function(){

    const changeNamaBulan = (bulan) =>{
      
        switch(bulan){
            case '01':
                return 'Januari';
                break;
            case '02':
                return 'Februari';
                break;
            case '03':
                return 'Maret';
                break;
            case '04':
                return 'April';
                break;
            case '05':
                return 'Mei';
                break;
            case '06':
                return 'Juni';
                break;
            case '07':
                return 'Juli';
                break;
            case '08':
                return 'Agustus';
                break;
            case '09':
                return 'September';
                break;
            case '10':
                return 'Oktober';
                break;
            case '11':
                return 'November';
                break;
            case '12':
                return 'Desember';
                break;
            
        }
          
    }

        $('.submitDiagnosa').click(function(){
            let picker = $('#datepicker').val();
            console.log(picker);
            window.location = '<?= base_url('/dashboard/top_ten_diagnosa/') ?>'+opsi+'/'+picker;
        });

       let nmDiagnosa = [];
       let jumlahDiagnosa = [];
       let backgroundColor = [];
       let borderColor = [];

       $('.dataTables').DataTable({
           "pageLength": 5
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
                           text: ''
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
       let where = '';
       let year = '<?= $year ?>';
       let month = '<?= $month ?>';
       let convertBulan = '';
       if(year!=""){
           where += `${year}`;
           if(month!=""){
               where+=`/${month}`;
               convertBulan = changeNamaBulan(month);
           }
       }
       $.get( "<?= base_url('dashboard/get_diagnosa_ten/') ?>"+opsi+'/'+where, function( dataMentah ) {
           let dataMasak = JSON.parse(dataMentah);
           $.each(dataMasak, function( key, value ) {
                nmDiagnosa.push(value.diagnosa);
                jumlahDiagnosa.push(value.jumlah_diagnosa); 
           });
           generateChart('myChart',`Penyakit Terbanyak ${where!=""?year +' '+convertBulan:new Date().getFullYear()}`,nmDiagnosa,jumlahDiagnosa,backgroundColor,borderColor);
   
           
           });
       
   });
   </script>