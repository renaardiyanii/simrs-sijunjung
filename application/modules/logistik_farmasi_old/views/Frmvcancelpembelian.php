<?php
$this->load->view('layout/header_left.php');
?>
<script type='text/javascript'>
    //-----------------------------------------------Data Table
    $(document).ready(function () {
        $('#examplee').DataTable();
        $(".select2").select2();
        $(".js-example-basic-single").select2();
        var objTable, tableDetail;

        objTable = $('#example').DataTable( {
           
            ajax: "<?php echo site_url('logistik_farmasi/Frmccancelpembelian/get_data_po'); ?>",
            columns: [
             //   { data: "no" },
                { data: "no_faktur" },
                { data: "tgl_kontra_bon" },
                { data: "jatuh_tempo" },
                { data: "company_name" },
                { data: "jenis_barang" },
                { data: "total" },
                { data: "total_price" },
                { data: "aksi" }
            ],
            columnDefs: [
                { targets: [ 0 ], visible: true }
            ] ,
            searching: true,
            paging: true,
            bDestroy : true,
            bSort : false,
            "lengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]]
        } );

        $("#find_by_date").click(function () {
            var tgl = $("#date_picker3").val();
            $.ajax({
                dataType: "json",
                type: 'POST',
                data: { tgl: tgl },
                url: "<?php echo site_url('logistik_farmasi/Frmccancelpembelian/get_data_po'); ?>",
                success: function( response ) {
                    objTable.clear().draw();
                    objTable.rows.add(response.data);
                    objTable.columns.adjust().draw();
                }
            });
        });
    });

    $(function () {
        $('#date_picker').datepicker({
            format: "yyyy-mm-dd",

            autoclose: true,
            todayHighlight: true,
        });

    });
    $(function () {
        $('#date_picker2').datepicker({
            format: "yyyy-mm-dd",
            endDate: "0",
            autoclose: true,
            todayHighlight: true,
        });

    });

    $(function() {
        $('#date_picker3').datepicker({
            format: "yyyy-mm-dd",
            endDate: '0',
            autoclose: true,
            todayHighlight: true
        });  
            
    });

    

    function lihat_detail(receiving_id) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "<?php echo base_url('logistik_farmasi/Frmccancelpembelian/get_data_detail_pembelian')?>",
            data: {
                receiving_id: receiving_id
            },
            success: function (data) {
                $('#edit_receiving_id').val(data[0].receiving_id);
                $('#edit_supplier_id').val(data[0].supplier_id);
                $('#edit_employee_id').val(data[0].employee_id);
                $('#edit_comment').val(data[0].comment);
                $('#edit_payment_type').val(data[0].payment_type);
               // $('#edit_total').val(data[0].total);
                $('#edit_total_price').val(data[0].total_price);
                $('#edit_amount_tendered').val(data[0].amount_tendered);
                $('#edit_amount_change').val(data[0].amount_change);
                $('#edit_tgl_kontra_bon').val(data[0].tgl_kontra_bon);
                $('#edit_jatuh_tempo').val(data[0].jatuh_tempo);
                $('#edit_ppn').val(data[0].ppn);
                $('#edit_no_faktur').val(data[0].no_faktur);
            },
            error: function () {
                alert("error");
            }
        });
    }

    $(document).ready(function () {
        $('#tabel_kwitansi').DataTable();
    });
    //-----------------------------------------------Data Table
    $(document).ready(function () {
        $('#example').DataTable();
    });
    //---------------------------------------------------------

</script>


<section class="content-header">
    <?php echo $this->session->flashdata('success_msg'); ?>
</section>

<?php echo form_open('logistik_farmasi/Frmccancelpembelian/insert_detail_pembelian'); ?>


<!-- Modal -->

<!-- Modal content-->
<div class="panel-body" style="width:100%">
    <div class="col-md-16">
        <div class="ribbon-wrapper card">
            <!-- <div class="ribbon ribbon-info">
                Detail Transaksi
            </div>
            <div class="ribbon-content">
            </div> -->

    </div>
</div>
</div>
<?php echo form_close(); ?>

         <div class="card" style="width:100%">
                <div class="card-block">
                    <div class="col-md-4">
                    <div class="form-group col-md-8 m-t-10">
                        <select name="filter" id="filter" class="form-control" style="width:100%">
                            <?php
                                foreach ($gudang as $row) {
                                    echo '<option value="' . $row->id_gudang . '">' . $row->nama_gudang. '</option>';
                                }
                            ?>
                        </select>
                    </div>
                                <div class="form-group">
                                    <div class="input-group">
                                    <input type="text" id="date_picker3" class="form-control"  placeholder="Tanggal Kontra Bon" name="date3">
                                          <span class="input-group-btn">
                                        <button class="btn btn-primary" type="submit" id="find_by_date">Cari</button> -->
                                </span>
                                

                                    </div><!-- /input-group -->

                                </div><!-- /.col-lg-6 -->
                         <!--   <div class="form-group">     
                            <select name="jenis_barang" id="fiter" class="form-control">
                            <option value="UMUM" <?= $gudang == "1" ? 'selected' : ''?>>UMUM</option>
                            <option value="BPJS" <?= $gudang == "2" ? 'selected' : ''?>>BPJS</option>
                            </select>
                           
                        
                            </div> --> 
                             
                           
                             
                            </div>
                    

                    <div class="modal-body">
                        <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <!-- <th>No</th> -->
                                <th>No Faktur</th>
                               <!--  <th>RECEIVING ID</th> -->
                                <th>KONTRA BON</th>
                                <th>JATUH TEMPO</th>
                                <th>SUPPLIER</th>
                                <th>GUDANG</th>
                                <th>Jumlah Item</th>
                                <th>TOTAL PEMBELIAN(Rp)</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
  
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    

<?php $this->load->view('layout/footer_left.php'); ?>