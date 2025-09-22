<?php
  $this->load->view('layout/header_left.php');
//   var_dump($data);die;
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
                $('#detailObat').css("display", "");
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
    <?php
include('Frmvdetaildistribusi2.php');
?>
    <section class="content" style="width:97%;margin:0 auto">
        <div class="row">
             <div class="col-lg-12 col-md-12">
                <div class="card">
                <?php echo form_open('logistik_farmasi/FrmCDistribusiLangsung/insert_detail_distribusi',array('id'=>'frmAdd','method'=>'post')); ?>
                        <div class="card-header">
                         
                                <div class="form-group row">
                                    <p class="col-sm-2 form-control-label" id="lidsupplier">Nama Obat</p>
                                    <div class="col-sm-6">
                                        <select id="id_obat_new" class="form-control select2" name="id_obat_new">
                                            <option value="">-Pilih Obat-</option>
                                            <?php
                                            foreach($data_obat as $row){
                                                echo '<option value="'.$row->id_obat.'@'.$row->batch_no.'">'.$row->nm_obat.' '.'-'.'(batch: '.$row->batch_no.')-(stock:'.$row->qty.')</option>';
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

                                <input type="hidden" name="id_distribusi" value=<?= $id_dis ?>>

                                <div class="form-group row">
                                    <div class="col-sm-5"></div>
                                    <p class="col-sm-3 form-control-label"></p>
                                    <div class="col-sm-3">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                        </div>   
                        <?php echo form_close();?>  
                             
                                <br/>

                                <div class="card-header">
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

                                            <tbody>
								<?php									
									$ppn=10;
										foreach($item_distribusi as $row){
																		
									?>
										<tr>
										
											<td><?php echo $row->id_obat ; ?></td>
											<td><?php echo $row->nm_obat ; ?></td>
											<td><?php echo $row->satuank ; ?></td>
											<td><?php echo $row->qty ; ?></td>											
											<td><?php echo $row->expire_date ?></td>
											<td><?php echo $row->batch_no; ?></td>
											
											<td>
												
												<a href="<?php echo site_url("logistik_farmasi/FrmcDistribusiLangsung/hapus_data_distribusi/".$row->id_distribusi.'/'.$row->id);?>" class="btn btn-danger btn-xs">Hapus</a>
											</td>

										</tr>
									<?php
										}
									?>
							</tbody>
                                        </table>
                                     
                                    <?php if ($header->verif == 0){?>
                                        <div class="modal-footer">
                                            
                                            <?php echo form_open('logistik_farmasi/FrmcDistribusiLangsung/insert_verifikasi');?>
                                                <br><hr>
                                                <div class="col-md-12" align="right">
                                                        <input type="hidden" name="id_distribusi" value="<?php echo $id_dis ; ?>"></input>
                                                        <button class="btn btn-primary" type="submit">Verifikasi</button>
                                                </div>
                                            <?php echo form_close(); ?>
                                        </div>
                                    <?php }?>
                                </div>
                    
                            


                            
                        
                    </div>


                </div>
            </div>
        </div>
    </section>

    
    <?php
  $this->load->view('layout/footer_left.php');
?>