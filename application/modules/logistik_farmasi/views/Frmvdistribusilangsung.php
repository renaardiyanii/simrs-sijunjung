<?php
  $this->load->view('layout/header_left.php');
?>
    <script type='text/javascript'>
       
        Date.prototype.yyyymmdd = function() {
            var mm = this.getMonth() + 1; // getMonth() is zero-based
            var dd = this.getDate();

            return [this.getFullYear()+'-',
                (mm>9 ? '' : '0') + mm +'-',
                (dd>9 ? '' : '0') + dd +	'-'
            ].join('');
        };

        var table;
        var ndata = 0;
        $(function() {
            <?php echo $this->session->flashdata('cetak'); ?>
            var $id_obat = $("#id_obat_new").select2();

            $("#find_by_date").click(function () {
            var tgl = $("#date_picker3").val();

            $.ajax({
                dataType: "json",
                type: 'POST',
                data: { tgl: tgl },
                url: "<?php echo site_url('logistik_farmasi/FrmcDistribusiLangsung/search_dis_by_date'); ?>",
                success: function( response ) {
                    objTable.clear().draw();
                    objTable.rows.add(response.data);
                    objTable.columns.adjust().draw();
                }
            });
        });

            $('#tgl_amprah').datepicker({
                format: "yyyy-mm-dd",
                endDate: '0',
                autoclose: true,
                todayHighlight: true
            });
            var myDate = new Date();
            $('#tgl_amprah').datepicker('setDate', myDate.yyyymmdd());
            table = $('#example').DataTable();
            $('#btnUbah').css("display", "none");
            
            $('#detailObat').css("display", "none");
            $( "#vgd_dituju" ).change(function() {
                $('#vgd_dituju').prop('disabled', 'disabled');
                $('#btnUbah').css("display", "");
                // $('#detailObat').css("display", "");
                $('#gd_dituju').val( $( "#vgd_dituju" ).val() );
            });
            $( "#btnUbah" ).click(function() {
                $('#vgd_dituju').prop('disabled', '');
                $('#vgd_dituju option[value=""]').prop('selected', 'selected');
                $('#gd_dituju').val("");
                $('#vgd_dituju').focus();
                $('#btnUbah').css("display", "none");
                table.clear().draw();
                $('#detailObat').css("display", "none");
            });

            $("#id_obat_new").change(function(){
                // console.log($('#id_obat').val());
                if ($('#id_obat_new').val() != ''){
                    $.ajax({
                        dataType: "json",
                        data: {id: $('#id_obat_new').val() },
                        type: "POST",
                        url: "<?php echo site_url(); ?>logistik_farmasi/Frmcamprah/get_satuan_obat_for_distribusi",
                        success: function( data ) {
                            console.log(data[0])
                            // $('#satuank').val( response);
                            $('#satuank').val(data[0].satuan);
                            $('#batch_no').val(data[0].batch_no);
                            $('#exp_date').val(data[0].expire_date);
                        }
                    });
                    $('#jml').val('1');
                }
            });

         

            $( "#btnTambah" ).click(function() {
                table.row.add( [
                    $('#id_obat_new').val(),
                    $( "#id_obat_new option:selected" ).text(),
                    $('#satuank').val(),
                    $('#jml').val(),
                    $('#exp_date').val(),
                    $('#batch_no').val(),
                    '<center><button type="button" class="btnDel btn btn-primary btn-xs" title="Hapus">Hapus</button></center>'
                ] ).draw(false);
                $id_obat.val("").trigger("change");
                $('#satuank').val('');
                $('#jml').val('');
                $('#exp_date').val('');
                $('#batch_no').val('');
                populateDataObat();
            });
            $('#example tbody').on( 'click', 'button.btnDel', function () {
                table.row( $(this).parents('tr') ).remove().draw();
                populateDataObat();
            } );
            $( "#btnSimpan" ).click(function() {
                if (ndata == 0){
                    alert("Silahkan input data obat");
                    $('#id_obat_new').focus();
                }else
                    $( "#frmAdd" ).submit();
            });
        });


        function populateDataObat(){
            vjson = table.rows().data();
            ndata = vjson.length;
            var vjson2= [[]];
            jQuery.each( vjson, function( i, val ) {
                vjson2[i] = {
                    "id_obat_new": vjson[i][0],
                    "satuank":vjson[i][2],
                    "qty_req":vjson[i][3],
                    "qty_acc":vjson[i][3],
                    "expire_date":vjson[i][4],
                    "batch_no":vjson[i][5]
                };
            });
            $('#dataobat').val( JSON.stringify(vjson2) );
        }
        function cetak(id){
            var win = window.open(baseurl+'download/logistik_farmasi/FA_'+id+'.pdf', '_blank');
            if (win) {
                //Browser has allowed it to be opened
                win.focus();
            } else {
                //Browser has blocked it
                alert('Please allow popups for this website');
            }
        }

    </script>
    <section class="content" style="width:97%;margin:0 auto">
        <div class="row">
             <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                         <h3 class="card-title">DAFTAR DISTRIBUSI</h3>
                    </div>
                    

                    <div class="card-block">
                        <?php echo form_open('logistik_farmasi/FrmCDistribusiLangsung/insert_header_distribusi',array('id'=>'frmAdd','method'=>'post')); ?>
                            <div class="modal-body">
                                <div class="form-group row">
                                    <div class="col-sm-1"></div>
                                    <p class="col-sm-3 form-control-label">No Distribusi</p>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="no_distribusi" id="no_distribusi" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-1"></div>
                                    <p class="col-sm-3 form-control-label">Tanggal Distribusi</p>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="tgl_distribusi" id="tgl_amprah" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-1"></div>
                                    <p class="col-sm-3 form-control-label" id="lidgudang">Gudang Asal</p>
                                    <div class="col-sm-6">

                                        <select name="gd_asal" id="gd_asal" class="form-control js-example-basic-single" required>
                                            <?php
                                            foreach($select_gudang0 as $row){
                                                echo '<option value="'.$row->id_gudang.'">'.$row->nama_gudang.'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-1"></div>
                                    <p class="col-sm-3 form-control-label">Gudang Tujuan</p>
                                    <div class="col-sm-6">
                                        <select name="vgd_dituju" id="vgd_dituju" class="form-control js-example-basic-single"  required>
                                            <option value="">-Pilih Gudang Tujuan-</option>
                                            <?php
                                            foreach($select_gudang1 as $row){
                                                echo '<option value="'.$row->id_gudang.'">'.$row->nama_gudang.'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <a class="btn btn-default" id="btnUbah">Ubah Gudang</a>
                                    </div>
                                    <input type="hidden" id="user" name="user" value="<?php echo $user_info->username; ?>"/>
                                    <input type="hidden" id="gd_dituju" name="gd_dituju"/>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-primary" type="submit" >Detail Distribusi</button>
                                </div>
                            </div>
                             <!-- Modal Edit Obat -->
                            <div class="modal fade" id="lihatdetail" role="dialog" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog modal-success">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Detail Distribusi</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group row">
                                                <div class="col-sm-1"></div>
                                                <p class="col-sm-3 form-control-label">No Distribusi</p>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" name="edit_receiving_id"
                                                        id="edit_receiving_id" disabled="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-1"></div>
                                                <p class="col-sm-3 form-control-label">Tanggal Distribusi</p>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" name="edit_supplier_id"
                                                        id="edit_supplier_id" disabled="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-1"></div>
                                                <p class="col-sm-3 form-control-label">Gudang Asal</p>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" name="edit_employee_id"
                                                        id="edit_employee_id" disabled="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-1"></div>
                                                <p class="col-sm-3 form-control-label">Gudang Tujuan</p>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" name="edit_comment" id="edit_comment"
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
                            <div id="detailObat">
                                <br/>
                                <div class="form-group row">
                                    <p class="col-sm-2 form-control-label" id="lidsupplier">Nama Obat</p>
                                    <div class="col-sm-6">
                                        <select id="id_obat_new" class="form-control select2" name="id_obat_new">
                                            <option value="">-Pilih Obat-</option>
                                            <?php
                                            foreach($data_obat as $row){
                                                echo '<option value="'.$row->id_obat.'-'.$row->batch_no.'">'.$row->nm_obat.' '.'-'.'(batch: '.$row->batch_no.')-(stock:'.$row->qty.')</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <p class="col-sm-2 form-control-label" id="lidsupplier">Satuan</p>
                                    <div class="col-sm-6">
                                      <input type="text" class="form-control" name="satuank" id="satuank" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <p class="col-sm-2 form-control-label" id="lidsupplier">Jumlah</p>
                                    <div class="col-sm-6">
                                    <input type="number" class="form-control" name="jml" id="jml" min=1 >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <p class="col-sm-2 form-control-label" id="lidsupplier">Batch No</p>
                                    <div class="col-sm-6">
                                    <input type="text" class="form-control" name="batch_no" id="batch_no">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <p class="col-sm-2 form-control-label" id="lidsupplier">Exp Date</p>
                                    <div class="col-sm-6">
                                    <input type="text" class="form-control" name="exp_date" id="exp_date" placeholder="YYYY-mm-dd">
                                    </div>
                                </div>

                                    <div class="form-group row">
                                        <div class="col-sm-5"></div>
                                        <p class="col-sm-3 form-control-label"></p>
                                        <div class="col-sm-3">
                                            <a class="btn btn-primary" id="btnTambah">Tambahkan</a>
                                        </div>
                                    </div>
                                   
                             
                                <br/>
                                <table id="example" class="display" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>ID Obat</th>
                                        <th>Nama Obat</th>
                                        <th>Satuan</th>
                                        <th>Jumlah Distribusi</th>
                                        <th>Exp Date</th>
                                        <th>No Batch</th>
                                        <th>Aksi</th>
                                    </tr>
                                    </thead>
                                </table>
                                <br/><br/>
                                <div class="modal-footer">
                                
                                <input type="hidden" name="dataobat" id="dataobat">
                                <a type="button" class="btn btn-success" id="btnSimpan">Simpan</a>
                                </div>
                            </div>


                            
                        <?php echo form_close();?>
                    </div>


                </div>
            </div>
        </div>
    </section>

    <div class="card" style="width:100%">
                <div class="card-block">
                    <!-- <div class="col-md-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="date" id="date_picker3" class="form-control" placeholder="Tanggal Kontra Bon" name="date3">
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" type="submit" id="find_by_date">Cari</button>
                                        </span>
                                    </div>
                                </div>
                            </div> -->
                    <div class="modal-body">
                        <div class="table-responsive">
                        <table id="example" class=" nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th style="font-weight:bold">No</th>
                                <th style="font-weight:bold">No Distribusi</th>
                                <th style="font-weight:bold">Gudang Asal</th>
                                <th style="font-weight:bold">Gudang Tujuan</th>
                                <th style="font-weight:bold">Status</th>
                                <th style="font-weight:bold">DETAIL</th>
                            </tr>
                            </thead>
                            <tbody>
								<?php									
									$ppn=10;
                                    $i = 1;
										foreach($data_distribusi as $row){
                                           
																		
									?>
										<tr>
										
											<td><?php echo $i++ ; ?></td>
											<td><?php echo $row->no_distribusi ; ?></td>
											<td><?php echo $row->nm_gd_asal ; ?></td>
											<td><?php echo $row->nm_gd_tujuan ; ?></td>	
                                            <?php 
                                                if($row->verif == 0){ ?>
                                                    <td>Belum Verifikasi</td>
                                            <?php  }else{?>
                                                <td>Sudah Verifikasi</td>									
                                                <?php  }?>											
											<td>
												
												<a href="<?php echo site_url("logistik_farmasi/FrmcDistribusiLangsung/form_detail_distribusi/".$row->id_distribusi);?>" class="btn btn-warning btn-xs">Detail</a>
											</td>

										</tr>
									<?php
										}
									?>
							</tbody>
                        </table>
                        </div>
                    </div>
                </div>
        </div>

        
    <?php
  $this->load->view('layout/footer_left.php');
?>