<!doctype html>

<html lang="en">



<?php $this->load->view($header);?>



<body>

    <div class="wrapper">

        

    <?php $this->load->view($menu);?>



        <div class="main-panel">

            <nav class="navbar navbar-transparent navbar-absolute">

                <div class="container-fluid">

                	<div class="navbar-minimize">

                        <button id="minimizeSidebar" class="btn btn-round btn-white btn-fill btn-just-icon">

                            <i class="material-icons visible-on-sidebar-regular">more_vert</i>

                            <i class="material-icons visible-on-sidebar-mini">view_list</i>

                        </button>

                    </div>

                    <div class="navbar-header">

                        <button type="button" class="navbar-toggle" data-toggle="collapse">

                            <span class="sr-only">Toggle navigation</span>

                            <span class="icon-bar"></span>

                            <span class="icon-bar"></span>

                            <span class="icon-bar"></span>

                        </button>

                        <a class="navbar-brand" href="#"> Pencarian Pasien </a>

                    </div>

                </div>

            </nav>

            <div class="content">

                <div class="container-fluid">

                    <div class="row">

                        <div class="col-md-12">

                            <div class="card">

                                <div class="card-header card-header-icon" data-background-color="purple">

                                    <i class="material-icons">assignment</i>

                                </div>

                                <div class="card-content">

                                    <h4 class="card-title">Pilih Pasien Untuk dirawat</h4>

                                    <div class="row">

                                        <div class="col-md-offset-1 col-sm-8">

                                        	<div class="form-group label-floating" id="div_penyakit">

                                        		<label class="control-label">Pilih Diagnosa Penyakit *</label>

						                        <input class="form-control" name="penyakit_nama" id="penyakit_nama" type="text" required="true" disabled="true"/>

						                        <input class="form-control" name="penyakit_id" id="penyakit_id" value="undefined" type="hidden" required="true"/>

						                    </div>

                                        </div>

                                        <div class="col-sm-2">

					                        <button type="button" class="btn btn-primary btn-fill" onclick="lookupPenyakit();" rel="tooltip" title="Pilih Diagnosa Penyakit" >Cari</button>

					                    </div>

                                    </div>

	                                <div class="row">

	                                    <div class="col-md-offset-1 col-sm-8">

	                                    	<div class="text-left">

		                                    	<button type="button" class="btn btn-info btn-fill" id="simpanUser" onclick="cariPasien();">Cari Pasien</button>

		                						<button type="button" class="btn btn-danger btn-fill" onclick="cancelCari();">Cancel</button>

	                						</div>

	                                    </div>

	                                </div>

		                            <div class="row">

			                            <div class="col-sm-12">

			                            	<div class="material-datatables">

		                                        <table id="tablePilihanPasien" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">

		                                            <thead>

		                                                <tr>

		                                                    <th>No</th>

								                            <th>Tgl. Rawat</th>

								                            <th>Nama Pasien</th>

								                            <th>Diagnosa</th>
								                            <th>Harga</th>
                            								<th>Verifikasi</th>

								                            <th class="text-right">Actions</th>

		                                                </tr>

		                                            </thead>

		                                            <tfoot>

		                                                <tr>

		                                                    <th>No</th>

								                            <th>Tgl. Rawat</th>

								                            <th>Nama Pasien</th>

								                            <th>Diagnosa</th>
								                            <th>Harga</th>
                            								<th>Verifikasi</th>

								                            <th class="text-right">Actions</th>

		                                                </tr>

		                                            </tfoot>

		                                            <tbody>



		                                            </tbody>

		                                        </table>

		                                    </div>

		                                </div>

		                            </div>

                                </div>

                                <!-- end content-->

                            </div>

                            <!--  end card  -->

                            <div class="card">

                                <div class="card-header card-header-icon" data-background-color="purple">

                                    <i class="material-icons">assignment</i>

                                </div>

                                <div class="card-content">

	                                <h4 class="card-title">Pasien Terpilih</h4>

	                                    

		                            <div class="row">
		                                
		                               

			                            <div class="col-sm-12">

			                            	<div class="material-datatables">

		                                        <table id="pasienTerpilih" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">

		                                            <thead>

		                                                <tr>

		                                                	<th>No</th>

		                                                    <th>Tgl. Rawat</th>

		                                                    <th>Nama Pasien</th>

		                                                    <th>No. Telp Pasien</th>

		                                                    <th>Diagnosa</th>

		                                                    <th>Tgl. Pilih</th>

		                                                    <th>Status</th>
                            								<th>Verifikasi</th>

		                                                    <th class="disabled-sorting text-right">Actions</th>

		                                                </tr>

		                                            </thead>

		                                            <tfoot>

		                                                <tr>

		                                                	<th>No</th>

		                                                    <th>Tgl. Rawat</th>

		                                                    <th>Nama Pasien</th>

		                                                    <th>No. Telp Pasien</th>

		                                                    <th>Diagnosa</th>

		                                                    <th>Tgl. Pilih</th>

		                                                    <th>Status</th>
                            								<th>Verifikasi</th>

		                                                    <th class="disabled-sorting text-right">Actions</th>

		                                                </tr>

		                                            </tfoot>

		                                            <tbody>

		                                            	<?php 

		                                            	$no = 0;

		                                            	if($m_rawat != ""){

						            						foreach ($m_rawat as $key) {
																$verifikasion = "";
												                if ($key->verifikasi == "1") {
												                    $verifikasion = '<button class="btn btn-success btn-xs btn-fab btn-fab-mini" style="margin: 0;"><i class="material-icons">check</i></button>';
												                } else if ($key->verifikasi == "0"){
												                    $verifikasion = '<button class="btn btn-danger btn-xs btn-fab btn-fab-mini" style="margin: 0;"><i class="material-icons">close</i></button>';
												                }

						            							$status = "";

						            							if ($key->status == "DAFTAR") {

						            								$status = '<button class="btn btn-info btn-xs" style="margin: 0;">DAFTAR</button>';

						            							} else if ($key->status == "RAWAT"){

						            								$status = '<button class="btn btn-warning btn-xs" style="margin: 0;">RAWAT</button>';

		                                                        } else if ($key->status == "MENUNGGU_DAFTAR"){

		                                                            $status = '<button class="btn btn-xs" style="margin: 0;">MENUNGGU DAFTAR</button>';

		                                                        } else if ($key->status == "MENUNGGU_RAWAT"){

		                                                            $status = '<button class="btn btn-rose btn-xs" style="margin: 0;">MENUNGGU RAWAT</button>';

						            							} else {

						            								$status = '<button class="btn btn-success btn-xs" style="margin: 0;">SELESAI</button>';

						            							}

						            							echo '<tr>

						                                                    <td>'.($no + 1).'</td>

						                                                    <td>'.$key->tgl_rawat.'</td>

						                                                    <td>'.$key->nama_pasien.'</td>

						                                                    <td>'.$key->notelp_pasien.'</td>

						                                                    <td>'.$key->nama_penyakit.'</td>

						                                                    <td>'.$key->tgl_pilih.'</td>

						                                                    <td>'.$status.'</td>
                            												<td>'.$verifikasion.'</td>

		                                                                    <td class="text-right">
                            													<a href="#" class="btn btn-simple btn-info btn-icon edit" rel="tooltip" title="Detail Pasien" data-placement="bottom" onclick="detailOdontoPasienTerpilih('.$key->id.');"><i class="material-icons">pageview</i></a>
                            													<a href="#" class="btn btn-simple btn-success btn-icon edit" rel="tooltip" title="Print"  onclick="printPasien('.$key->id.');"><i class="material-icons">print</i></a>

		                                                                        <a href="#" class="btn btn-simple btn-warning btn-icon edit" rel="tooltip" title="Edit"  onclick="editPasienTerpilih('.$key->id.');"><i class="material-icons">edit</i></a>

		                                                                    </td>

		                                                                </tr>';



		                                                        $no++;

						            						}

						            					}



		                                            	?>
		                                            	 

		                                            </tbody>

		                                        </table>
                                                 
		                                    </div>

		                                </div>

		                            </div>

                                </div>

                                <!-- end content-->

                            </div>

                            <!--  end card  -->

                        </div>

                        <!-- end col-md-12 -->

                    </div>

                    <!-- end row -->

                </div>

            </div>

            <?php $this->load->view($footer);?>

        </div>

    </div>

</body>

<?php $this->load->view($script);?>

<script>var base_url = '<?php echo base_url() ?>';</script>

<script src="<?php echo base_url();?>assets/js/apps/rawat-pilih.js"></script>

<script type="text/javascript">

    $(document).ready(function() {

        app_rawat_pilih.init();

    });

</script>



</html>



<!-- Classic Modal Penyakit -->

<div class="modal fade" id="myModalPenyakit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

        	<form id="fomrMasterUser" method="">

	            <div class="modal-header">

	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">

	                    <i class="material-icons">clear</i>

	                </button>

	                <h4 class="modal-title" id="modal-title">Lookup Diagnosa</h4>

	            </div>

	            <div class="modal-body">

	            	<div class="material-datatables">

                        <table id="datatablesPenyakit" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">

                            <thead>

                                <tr>

                                	<th>No</th>

                                    <th>Kode</th>

                                    <th>Nama</th>

                                </tr>

                            </thead>

                            <tfoot>

                                <tr>

                                	<th>No</th>

                                    <th>Kode</th>

                                    <th>Nama</th>

                                </tr>

                            </tfoot>

                            <tbody>



                            </tbody>

                        </table>

                    </div>

	            </div>

	            <div class="modal-footer">

	                <button type="button" class="btn btn-danger btn-fill" data-dismiss="modal">Close</button>

	            </div>

	        </form>

        </div>

    </div>

</div>

<!--  End Modal -->



<!-- Classic Modal Edit -->

<div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

        	<form id="fomrMasterUser" method="">

	            <div class="modal-header">

	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">

	                    <i class="material-icons">clear</i>

	                </button>

	                <h4 class="modal-title" id="modal-title">Edit Perawatan Pasien</h4>

	            </div>

	            <div class="modal-body">

	            	<div class="row">

	            		<div class="col-sm-12">

	            			<div class="form-group label-floating label-static">

		                        <label class="control-label">

		                            Nama Pasien

		                        </label>

		                        <input class="form-control" name="nama_pasien" id="nama_pasien" type="text" required="true" disabled />

                                <input class="form-control" name="id" id="id" type="hidden" required="true" value="undefined" />

		                    </div>

		                    <div class="form-group label-floating label-static">

		                        <label class="control-label">

		                            Diagnosa

		                        </label>

		                        <input class="form-control" name="nama_penyakit" id="nama_penyakit" type="text" required="true" disabled/>

		                    </div>

                            <div class="form-group label-floating label-static">

                                <label class="control-label">

                                    Tgl. Rawat

                                </label>

                                <input class="form-control" name="tgl_rawat" id="tgl_rawat" type="text" required="true" disabled/>

                            </div>

                            <div class="form-group label-floating label-static">

                                <label class="control-label">

                                    Action

                                </label>

                                <div class="col-sm-12" style="padding-left: 0px; padding-right: 0px;" id="div_action">

                                    <select class="form-control" id="action" name="action" required>

                                        <option disabled>Pilih Action</option>

                                        <option value="APPROVE">PASIEN SETUJU DIRAWAT</option>

                                        <option value="SELESAI">SELESAI DIRAWAT</option>

                                        <option value="TOLAK">PASIEN MENOLAK DIRAWAT</option>

                                        <!-- <option value="HAPUS">HAPUS DARI DAFTAR</option> -->

                                    </select>

                                </div>

                            </div>

	            		</div>

	            	</div>

	            </div>

	            <div class="modal-footer">

	            	<button type="button" class="btn btn-info btn-fill" onclick="saveUpdateRawat();">Simpan</button>

	                <button type="button" class="btn btn-danger btn-fill" data-dismiss="modal">Close</button>

	            </div>

	        </form>

        </div>

    </div>

</div>

<!--  End Modal -->


<!-- Classic Modal Edit -->

<div class="modal fade" id="myModalDetailOdonto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

  <div class="modal-dialog" style=" overflow-x: scroll; min-width:75%;  max-height:100%;  margin-top: 60px; margin-bottom:60px;">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">

                    <i class="material-icons">clear</i>

                </button>

                <h4 class="modal-title" id="modal-title">Detail Odontogram Pasien</h4>

            </div>

            <div class="modal-body">
            	<div class="row" id="row-loading">
            		<div class="col-sm-12">
            			<div class="text-center">
            				<img src="<?php echo base_url();?>assets/img/loading.gif">
            			</div>
            		</div>
            	</div>

            	<div class="row" id="row-odonto">

            		<!-- <div class="col-sm-12">
						<div class="col-sm-3 text-right">
							Foto Pasien
						</div>
						<div class="col-sm-5" id="div-foto-pasien">

						</div>
            		</div> -->
            		
                    <div class="row">
                        
                        <div class="col-sm-12">
                            <div class="col-sm-3" id="div-foto-pasien">
                                Foto Pasien
                            </div>
                            <div class="col-sm-3" id="div-foto-rahang-atas">
                                Rahang Atas
                            </div>
                            <div class="col-sm-3" id="div-foto-rahang-bawah">
                                Rahang Bawah
                            </div>
                            <div class="col-sm-3" id="div-foto-tambahan">
                                Tambahan
                            </div>
                        </div>
                    </div>

            	     <div class="row">
                                            <div class="col-sm-offset-1 col-sm-10">
                                                <label class="label-control">Odontogram</label>
                                                <div style="width: 100%; overflow-x: scroll;">
                                                
                                                <table style="width: 100%">
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="2">
                                                                <div id="message" style="height:20px">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div id="svgselect" style="width: 610px; height: 230px; background-color: #ffffff;"> <!-- background-color:red -->
                                                                    <svg version="1.1" height="100%" width="100%" style="overflow-x: scroll;">
                                                                        <g transform="scale(1.5)" id="odontograma">

                                                                        </g>
                                                                    </svg>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div id="controls" class="panel panel-default">
                                                                    <div class="panel-body">
                                                                        <label class="label-control">Pilih Kategori</label>
                                                                        <div class="btn-group list-group" data-toggle="buttons">
                                                                            
                                                                            <div id="kariesSuperfisia" class="btn btn-primary btn-xs list-group-item active" style="width: 100%; background-color: yellow; color: black;">
                                                                                <input type="radio" name="options" id="option2" autocomplete="off" checked> Karies Superfisial
                                                                            </div>
                                                                            <div id="kariesMedia" class="btn btn-warning btn-xs list-group-item" style="width: 100%; background-color: orange; color: black;">
                                                                                <input type="radio" name="options" id="option3" autocomplete="off"> Karies media
                                                                            </div>
                                                                            <div id="kariesProfunda" class="btn btn-warning btn-xs list-group-item" style="width: 100%; background-color: red; color: black;">
                                                                                <input type="radio" name="options" id="option4" autocomplete="off"> Karies profunda
                                                                            </div>
                                                                            <div id="kariesProfundaPerfores" class="btn btn-primary btn-xs list-group-item" style="width: 100%; background-color: gray;color: black; ">
                                                                                <input type="radio" name="options" id="option5" autocomplete="off"> Karies profunda perforasi
                                                                            </div>
                                                                            <div id="sisaAkar" class="btn btn-default btn-xs list-group-item" style="width: 100%; background-color: purple; ">
                                                                                <input type="radio" name="options" id="option6" autocomplete="off"> Sisa akar
                                                                            </div>
                                                                            <div id="pitFissuredalam" class="btn btn-default btn-xs list-group-item" style="width: 100%; background-color: #6495ED; color: black;">
                                                                                <input type="radio" name="options" id="option6" autocomplete="off"> pit fissure dalam
                                                                            </div>
                                                                            <div id="kariesMangkok" class="btn btn-default btn-xs list-group-item" style="width: 100%; background-color: blue; color: black;">
                                                                                <input type="radio" name="options" id="option6" autocomplete="off"> karies mangkok
                                                                            </div>
                                                                            <div id="gigiGoyang" class="btn btn-default btn-xs list-group-item" style="width: 100%; background-color: #7FFF00; color: black; ">
                                                                                <input type="radio" name="options" id="option6" autocomplete="off"> gigi goyang
                                                                            </div>
                                                                            <div id="presistensi" class="btn btn-default btn-xs list-group-item" style="width: 100%; background-color: pink; color: black;">
                                                                                <input type="radio" name="options" id="option6" autocomplete="off"> presistensi
                                                                            </div>
                                                                            <div id="tambalanRestoras" class="btn btn-default btn-xs list-group-item" style="width: 100%; background-color: black;">
                                                                                <input type="radio" name="options" id="option6" autocomplete="off"> tambalan / restoras
                                                                            </div>
                                                                            <div id="gigiHilang" class="btn btn-default btn-xs list-group-item" style="width: 100%; background-color: #228B22; color: black;">
                                                                                <input type="radio" name="options" id="option6" autocomplete="off"> gigi hilang
                                                                            </div>
                                                                            <div id="resesiGingiva" class="btn btn-default btn-xs list-group-item" style="width: 100%; background-color: brown; ">
                                                                                <input type="radio" name="options" id="option6" autocomplete="off"> resesi gingiva
                                                                            </div>
                                                                            <div id="karangGigi" class="btn btn-default btn-xs list-group-item" style="width: 100%; background-color: #191970; ">
                                                                                <input type="radio" name="options" id="option6" autocomplete="off"> Karang Gigi
                                                                            </div>
                                                                        </div>  
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <div id="message" style="height:20px">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                </div>
                                            </div>
                                        </div>

            	</div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-danger btn-fill" data-dismiss="modal">Close</button>

            </div>

        </div>

    </div>

</div>

<!--  End Modal -->

<div class="modal fade" id="myModalDetailOdontoTerpilih" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

  <div class="modal-dialog" style=" overflow-x: scroll; min-width:75%;  max-height:100%;  margin-top: 60px; margin-bottom:60px;">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">

                    <i class="material-icons">clear</i>

                </button>

                <h4 class="modal-title" id="modal-title">Detail Pasien</h4>

            </div>

            <div class="modal-body">
            	<div class="row" id="row-loading-terpilih">
            		<div class="col-sm-12">
            			<div class="text-center">
            				<img src="<?php echo base_url();?>assets/img/loading.gif">
            			</div>
            		</div>
            	</div>

            	<div class="row" id="row-detail" style="margin-left: 0px; margin-right: 0px;">

            	</div>

        	</div>

	        <div class="modal-footer">

	            <button type="button" class="btn btn-danger btn-fill" data-dismiss="modal">Close</button>

	        </div>

	    </div>

	</div>
</div>


