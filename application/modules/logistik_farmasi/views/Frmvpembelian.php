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
            ajax: "<?php echo site_url('logistik_farmasi/Frmcpembelian/get_data_po'); ?>",
            columns: [
                { data: "no" },
                { data: "id_penerimaan" },
                { data: "no_faktur" },
                { data: "no_do" },
                { data: "tgl_kontra_bon" },
                { data: "jatuh_tempo" },
                { data: "company_name" },
                { data: "jenis_penerimaan" },
                { data: "verif_penerima" },
                { data: "verif_gudang" },
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

            // addded @aldi
            let tglAkhir = $("#date_picker34").val();

            /**
             * Added @aldi 
             * pencarian by tgl picker range
             */
            // $.ajax({
            //     dataType: "json",
            //     type: 'POST',
            //     data: { tgl: tgl },
            //     url: "<?php //echo site_url('logistik_farmasi/Frmcpembelian/get_data_po'); ?>",
            //     success: function( response ) {
            //         objTable.clear().draw();
            //         objTable.rows.add(response.data);
            //         objTable.columns.adjust().draw();
            //     }
            // });
            $.ajax({
                dataType: "json",
                type: 'POST',
                data: { tglawal: tgl,tglakhir:tglAkhir },
                url: "<?php echo site_url('logistik_farmasi/Frmcpembelian/get_data_po_range'); ?>",
                success: function( response ) {
                    objTable.clear().draw();
                    objTable.rows.add(response.data);
                    objTable.columns.adjust().draw();
                }
            });

        });
    });

    $(function () {
        // $('#date_picker').datepicker({
        //     format: "yyyy-mm-dd",

        //     autoclose: true,
        //     todayHighlight: true,
        // });

    });
    $(function () {
        // $('#date_picker2').datepicker({
        //     format: "yyyy-mm-dd",
        //     endDate: "0",
        //     autoclose: true,
        //     todayHighlight: true,
        // });

    });

    $(function() {
        // $('#date_picker3').datepicker({
        //     format: "yyyy-mm-dd",
        //     endDate: '0',
        //     autoclose: true,
        //     todayHighlight: true
        // });  
            
    });

    

    function lihat_detail(receiving_id) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "<?php echo base_url('logistik_farmasi/Frmcpembelian/get_data_detail_pembelian')?>",
            data: {
                receiving_id: receiving_id
            },
            success: function (data) {
                $('#edit_receiving_id').val(data[0].receiving_id);
                $('#edit_supplier_id').val(data[0].supplier_id);
                $('#edit_employee_id').val(data[0].employee_id);
                $('#edit_comment').val(data[0].comment);
                $('#edit_payment_type').val(data[0].payment_type);
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

<?php echo form_open('logistik_farmasi/Frmcpembelian/insert_detail_pembelian'); ?>


<!-- Modal -->

<!-- Modal content-->
<?php //if($role_id == '1' || $role_id == '1026'){?>
<div class="panel-body" style="width:100%">
    <div class="col-md-16">
        <div class="ribbon-wrapper card">
            <div class="ribbon ribbon-info">
                Detail Transaksi
            </div>
            <div class="ribbon-content">

                <!-- <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lpaymethod">Transaksi</p>
                    <div class="col-sm-6">
                        <select class="form-control" name="payment_type" id="pay_method">
                            <option value="" disabled selected>----- Pilih Transaksi -----</option>
                            <option value="Terima Cash">Pembelian Cash</option>
                            <option value="Terima Credit">Pembelian Credit</option>
                        </select>
                    </div>
                </div> -->

                <!-- <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lcomment">DO/FAKTUR</p>
                    <div class="col-sm-6">
                       
                            <input type="radio" id="do" class="with-gap radio-col-blue" value="do"  name="do_faktur">
                            <label for="do">DO</label>
                            &nbsp;
                            <input type="radio" id="fktr" class="with-gap radio-col-blue" value="faktur" name="do_faktur"/>
                            <label for="fktr" >Faktur</label>
                    </div>
                </div> -->

                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lnofaktur">No Faktur</p>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="no_faktur" id="no_faktur">
                    </div>
                </div>

                <!-- <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lnofaktur">No DO</p>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="no_do" id="no_do" >
                    </div>
                </div> -->

                <div class="form-group row" hidden>
                    <p class="col-sm-2 form-control-label">Receiving ID</p>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="receiving_id" id="receiving_id" required
                               disabled>
                    </div>
                </div>

                <!-- <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lidsupplier">Produsen/Prinsipal</p>
                    <div class="col-sm-6">
                        <select name="id_produsen" class="form-control select2" style="width:100%">
                        <option value="" disabled selected>---- Pilih ----</option>
                        <?php
                        //foreach ($produsen as $row) {
                         //   echo '<option value="' . $row->id . '">' . $row->nm_produsen . '</option>';
                       // }
                        ?>
                        </select>
                    </div>
                </div> -->

                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lidsupplier">PBF</p>
                    <div class="col-sm-6">
                        <select name="id_supplier" class="form-control select2" style="width:100%">
                        <option value="" disabled selected>---- Pilih ----</option>
                        <?php
                        foreach ($pbf as $row) {
                            echo '<option value="' . $row->id . '">' . $row->pbf . '</option>';
                        }
                        ?>
                        </select>
                    </div>
                    <!-- <div class="col-xs-1" align="right">
                        <div class="input-group">
                          <span class="input-group-btn">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Tambah Supplier Baru</button>
                          </span>
                        </div>
                    </div> -->
                </div>
                <!-- <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lbjp">Jenis Pengadaan</p>
                    <div class="col-sm-6">
                        <select class="form-control" name="jenis_pengadaan" id="jenis_pengadaan">
                            <option value="" disabled selected>----- Pilih Pengadaan -----</option>
                            <option value="BPJS">BPJS</option>
                            <option value="UMUM">UMUM</option>
                        </select>
                    </div>
                </div> -->

                <!-- <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lidsupplier">Jenis Obat</p>
                    <div class="col-sm-6">
                        <select name="id_jenis" class="form-control select2" style="width:100%" required>
                        <option value="" disabled selected>---- Pilih Jenis Obat ----</option>
                        <?php
                        foreach ($select_jenis as $row) {
                            echo '<option value="' . $row->id_jenis . '">' . $row->nm_jenis . '</option>';
                        }
                        ?>
                        </select>
                    </div>
                </div> -->

                

                <!-- <div class="form-group row">
                  <p class="col-sm-2 form-control-label" id="gudang">Gudang</p>
                  <div class="col-sm-6">
                    <select class="form-control" name="gudang" id="gudang">
                      <option value="" disabled selected>---- Pilih Gudang ----</option>
                      <?php
                        foreach ($select_gudang as $row) {
                            echo '<option value="' . $row->id_gudang . '">' . $row->nama_gudang . '</option>';
                        }
                        ?>
                    </select>
                  </div>
                </div>
 -->

                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="ljatuhtempo">Tanggal Faktur </p>
                    <div class="col-sm-6">
                        <input type="date" id="date_picker2" class="form-control" placeholder="Kontra Bon"
                               name="tgl_kontra_bon">
                    </div>
                </div>

                <!-- <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="ljatuhtempo">Tanggal DO </p>
                    <div class="col-sm-6">
                        <input type="date" id="date_picker2" class="form-control" placeholder="Kontra Bon"
                               name="tgl_kontra_bon_do">
                    </div>
                </div> -->

                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="ljatuhtempo">Tanggal Jatuh Tempo </p>
                    <div class="col-sm-6">
                        <input type="date" id="date_picker" class="form-control" placeholder="Jatuh Tempo"
                               name="jatuh_tempo">
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lditerimabarang">Tanggal Penerimaan Barang </p>
                    <div class="col-sm-6">
                        <input type="date" id="date_picker" class="form-control" placeholder="Penerimaan Barang"
                               name="diterima_barang">
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lcomment">Keterangan</p>
                    <div class="col-sm-6">
                        <textarea type="text" class="form-control" name="comment" id="comment"></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lcomment">Status</p>
                    <div class="col-sm-6">
                       
                            <input type="radio" id="stat1" class="with-gap radio-col-blue" value="Beli sendiri"  name="status" checked>
                            <label for="stat1">Beli sendiri</label>
                            &nbsp;
                            <input type="radio" id="stat2" class="with-gap radio-col-blue" value="Konsinyasi" name="status"/>
                            <label for="stat2" >Konsinyasi</label>
                            &nbsp;
                            <input type="radio" id="stat3" class="with-gap radio-col-blue" value="Pinjam Barang" name="status"/>
                            <label for="stat3" >Pinjam Barang</label>
                            &nbsp;
                            <input type="radio" id="stat5" class="with-gap radio-col-blue" value="mengembalikan_barang" name="status"/>
                            <label for="stat5" >Mengembalikan Barang</label>
                            &nbsp;
                            <input type="radio" id="stat4" class="with-gap radio-col-blue" value="Hibah" name="status"/>
                            <label for="stat4" >Hibah</label>
                       
                    </div>
                </div>


                <input type="hidden" class="form-control" name="jenis_barang" id="jenis_barang" value="">

                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Detail Pembelian</button>
                </div>
            </div>
        <!-- Modal Edit Obat -->
        <div class="modal fade" id="lihatdetail" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Detail Pembelian</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Receiving Id</p>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="edit_receiving_id"
                                       id="edit_receiving_id" disabled="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Supplier Id</p>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="edit_supplier_id"
                                       id="edit_supplier_id" disabled="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Employee Id</p>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="edit_employee_id"
                                       id="edit_employee_id" disabled="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Comment</p>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="edit_comment" id="edit_comment"
                                       disabled="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Payment Type</p>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="edit_payment_type"
                                       id="edit_payment_type" disabled="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Total Price</p>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="edit_total_price"
                                       id="edit_total_price" disabled="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Amount Tendered</p>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="edit_amount_Tendered"
                                       id="edit_amount_tendered" disabled="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Amount Change</p>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="edit_amount_change"
                                       id="edit_amount_change" disabled="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Tanggal Kontra Bon</p>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="edit_tgl_kontra_bon"
                                       id="edit_tgl_kontra_bon" disabled="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Jatuh Tempo</p>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="edit_jatuh_tempo"
                                       id="edit_jatuh_tempo" disabled="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">PPN</p>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="edit_ppn" id="edit_ppn" disabled="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">No Faktur</p>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="edit_no_faktur" id="edit_no_faktur"
                                       disabled="">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php echo form_close(); ?>
<?php //}?>



         <div class="card" style="width:100%">
                <div class="card-block">
                    
                <div class="row p-t-10 m-b-15">
                    <div class="col-md-1">
                        <div class="form-group pt-2">
                            <label class="control-label">Tgl. Awal</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group has-danger">
                            <input type="date" id="date_picker3" class="form-control" placeholder="Tanggal Kontra Bon" name="date3">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group pt-2">
                            <label class="control-label">Tgl. Akhir</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group has-danger">
                            <input type="date" id="date_picker34" class="form-control" placeholder="Tanggal Kontra Bon" name="date34">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-actions">
                            <button class="btn waves-effect waves-light btn-info" type="button" id="find_by_date">
                                <i class="fa fa-search"></i> Cari Data
                            </button>
                        </div>
                    </div>
                </div>

                    <div class="modal-body">
                        <div class="table-responsive">
                        <table id="example" class=" nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Penerimaan</th>
                                <th>No Faktur</th>
                                <th>No DO</th>
                                <th>Tgl DO/Faktur</th>
                                <th>JATUH TEMPO</th>
                                <th>SUPPLIER/PBF</th>
                                <!-- <th>Produsen/Prinsipal</th> -->
                                <th>Jenis Penerimaan</th>
                                <th>Verifikasi Penerima</th>
                                <th>Verifikasi Gudang</th>
                                <th>LIHAT DETAIL</th>
                            </tr>
                            </thead>
                            <tbody>
  
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
        </div>

<?php echo form_open('logistik_farmasi/Frmcpembelian/insert_supplier'); ?>

<!-- Modal Insert Supplier -->
<div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-success">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Tambah Supplier Baru</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmsupplier">Nama Supplier</p>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="nmsupplier" id="nmsupplier" required="">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_accountnumber">Account Number</p>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="accountnumber" id="accountnumber" required="">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_adress">Alamat</p>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="adress" id="adress" required="">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_zip_code">Zip Code</p>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="zip_code" id="zip_code">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_phone">Phone</p>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="phone" id="phone" required="">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="submit">Insert Supplier</button>
            </div>
        </div>
    </div>
</div>

<?php echo form_close(); ?>


<?php $this->load->view('layout/footer_left.php'); ?>