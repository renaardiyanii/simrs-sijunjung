<?php
$this->load->view("layout/header_left");
foreach($data as $row)
{
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
                <?php echo $row->waktu_pelayanan;?>
            </td>
            <td scope="col">
                <?php echo $row->nm_poli;?>
            </td>
        </tr>
        <tr class="table-success">
            <th width="50%" class="thead-dark" scope="col">
                Nama
            </td>
            <th width="50%" class="thead-dark" scope="col">
                Alamat
            </td>
        </tr>
        <tr>
            <td scope="col">
                <?php echo $row->nama;?>
            </td>
            <td scope="col">
                <?php echo $row->alamat;?>
            </td>
        </tr>
        <tr class="table-success">
            <th width="50%" class="thead-dark" scope="col">
                Jenis Kelamin
            </td>
            <th width="50%" class="thead-dark" scope="col">
                Tempat/Tgl Lahir
            </td>
        </tr>
        <tr>
            <td scope="col">
                <?php echo $row->sex;?>
            </td>
            <td scope="col">
                <?php echo $row->tmpt_lahir . "/" . $row->tgl_lahir;?>
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
                <?php echo $row->name_paramedis;?>
            </td>
        </tr>
        <tr class="table-success">
            <th class="thead-dark" scope="col">
                Subyektif
            </td>
            <th class="thead-dark" scope="col">
                Obyektif
            </td>
        </tr>
        <tr>
            <td>
                <?php echo nl2br($row->subjeciv);?>
            </td>
            <td>
                <?php echo nl2br($row->objective);?>
            </td>
        <tr>
        <tr class="table-success">
            <th class="thead-dark" scope="col">
                Assessment
            </td>
            <th class="thead-dark" scope="col">
                Planning
            </td>
        </tr>
        <tr>
            <td>
                <?php echo nl2br($row->assesment);?>
            </td>
            <td>
                <?php echo nl2br($row->planning);?>
            </td>
        <tr>
</tbody>
    </table>

    <br/>
    <hr/>
<?php
}
?>
