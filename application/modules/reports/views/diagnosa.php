

<?php
$this->load->view("layout/header_left");
$i = 1;
foreach($data as $row)
{
?>
    <table class="table table-bordered">
        <tbody>
        <tr class="table-success">
            <th width="5%" class="thead-dark" scope="col">
                No.
            </td>
            <th width="15%" class="thead-dark" scope="col">
                Tgl Pelayanan
            </td>
            <th width="15%" class="thead-dark" scope="col">
                ID . Diagnosa
            </td>
            <th width="40%" class="thead-dark" scope="col">
                Nama Diagnosa
            </td>
            <th width="20%" class="thead-dark" scope="col">
                Klasifikasi Diagnosa
            </td>
        </tr>
        <tr>
            <td scope="col">
                <?php echo $i;?>
            </td>
            <td scope="col">
                <?php echo date('Y-m-d',strtotime($row->tgl_kunjungan));?>
            </td>
            <td scope="col">
                <?php echo $row->id_diagnosa;?>
            </td>
            <td scope="col">
                <?php echo $row->diagnosa;?>
            </td>
            <td scope="col">
                <?php echo $row->klasifikasi_diagnos;?>
            </td>
        </tr>
        
</tbody>
    </table>

    <br/>
    <hr/>
<?php
$i++;
}
?>
