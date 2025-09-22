<?php
$this->load->view("layout/header_left");
// var_dump($data);die();
if($data!=null){
foreach($data as $row)
{
    $kacamata = json_decode($row->json_kacamata);
    $mokular = json_decode($row->json_mokular_mata);
    $visus = json_decode($row->json_visus);
?>
    <table class="table table-bordered">
        <thead class="thead-dark">
        <tr class="table-danger">
            <th width="50%" class="thead-dark" scope="col">
                Tgl Pelayanan
            </td>
            <th width="50%" class="thead-dark" scope="col">
                Poli Klinik
            </td>
        </tr>
        </thead>
        <tbody>
        <tr >
            <td scope="col">
                <?php echo date('d/m/Y H:i:s',strtotime($row->waktu_pelayanan));?>
            </td>
            <td scope="col">
                <?php echo $row->poli_name;?>
            </td>
        </tr>
       
        <tr class="table-success">
            <th width="50%" class="thead-dark" scope="col">
                No Registrasi
            </td>
            <th width="50%" class="thead-dark" scope="col">
                Nama Dokter/Perawat
            </td>
        </tr>
        <tr>
            <td scope="col">
                <?php echo $row->regristrasi_number;?>
            </td>
            <td scope="col">
                <?php echo $row->dokter;?>
            </td>
        </tr>
      
        <tr class="table-success">
            <th class="thead-dark" scope="col">
                Status Generalis
            </td>
            <th class="thead-dark" scope="col">
                Status Lokalis
            </td>
        </tr>
        <tr>
            <td>
                <?php echo nl2br($row->generalis);?>
            </td>
            <td>
                <?php echo nl2br($row->lokalis);?>
            </td>
        <tr>

        <tr class="table-success">
            <th class="thead-dark" scope="col">
                Diagnosis Kerja
            </td>
            <th class="thead-dark" scope="col">
                Diagnosis Banding
            </td>
        </tr>
        <tr>
            <td>
                <?php echo nl2br($row->diagnosis_kerja);?>
            </td>
            <td>
                <?php echo nl2br($row->diagnosis_banding);?>
            </td>
        <tr>

        <tr class="table-success">
            <th class="thead-dark" scope="col">
                Pemeriksaan
            </td>
            <th class="thead-dark" scope="col">
                Terapi / Tindakan
            </td>
        </tr>
        <tr>
            <td>
                <?php echo nl2br($row->pemeriksaan);?>
            </td>
            <td>
                <?php echo nl2br($row->terapi);?>
            </td>
        <tr>
        <tr class="table-success">
            <th class="thead-dark" scope="col">
                OD
            </td>
            <th class="thead-dark" scope="col">
                OS
            </td>
        </tr>
        <tr>
            <td>
                <?php echo ($kacamata)?$kacamata->od:'-'; ?>
            </td>
            <td>
                <?php echo ($kacamata)?$kacamata->os:'-'; ?>
            </td>
        <tr>

        <tr class="table-success">
            <th class="thead-dark" scope="col">
                Mokular OD
            </td>
            <th class="thead-dark" scope="col">
                Mokular OS
            </td>
        </tr>
        <tr>
            <td>
                <?php 
                if($mokular){
                    for($i = 0;$i<count($mokular->od);$i++)
                    {
                        if($mokular->od[$i] == 'N')
                        {
                            echo '<br>';
                        }
                        echo $mokular->od[$i];
                    }
                }else{
                    echo '-';
                }
                ?>
            </td>
            <td>
            <?php 
                if($mokular){
                    for($i = 0;$i<count($mokular->os);$i++)
                    {
                        if($mokular->os[$i] == 'N')
                        {
                            echo '<br>';
                        }
                        echo $mokular->os[$i];
                    }
                }else{
                    echo '-';
                }
                ?>
            </td>
        <tr>
        <tr class="table-success">
            <th class="thead-dark" scope="col">
                Visus OD
            </td>
            <th class="thead-dark" scope="col">
                Visus OS
            </td>
        </tr>
        <tr>
            <td>
                <?php echo ($visus)?$visus->od:'-'; ?>
            </td>
            <td>
                <?php echo ($visus)?$visus->os:'-'; ?>
            </td>
        <tr>
</tbody>
    </table>

    <br/>
    <hr/>
<?php
}}
?>
