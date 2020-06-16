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
                        <a class="navbar-brand" href="#"> Rawat History </a>
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
                                    <h4 class="card-title">Daftar Rawat Pasien</h4>
                                    <div class="toolbar">
	                                    <form method="POST" action="">
	                                        <div class="row">
			                                    <div class="col-sm-3">
				                                    <div class="form-group label-floating label-static">
				                                        <label class="control-label">Tgl Dari</label>
				                                        <input type="text" class="form-control datepicker" name="fromDate" id="fromDate" value="<?php echo $fromDate;?>" />
				                                    </div>
				                                </div>
				                                <div class="col-sm-3">
				                                    <div class="form-group label-floating label-static">
				                                        <label class="control-label">Tgl Sampai</label>
				                                        <input type="text" class="form-control datepicker" name="toDate" id="toDate" value="<?php echo $toDate;?>" />
				                                    </div>
				                                </div>
				                                <div class="col-sm-2">
				                                	<input type="submit" class="btn btn-primary btn-fill" name="cari" value="Cari">
				                                </div>
			                                </div>
			                            </form>
                                    </div>
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                	<th>No</th>
                                                    <th>Tgl. Rawat</th>
                                                    <th>Nama Pasien</th>
                                                    <th>Diagnosa</th>
                                                    <th>Nama Dokter</th>
                                                    <th>Tgl. Pilih</th>
                                                    <th>Tgl. Selesai</th>
                                                    <th>Status</th>
                                                    <th class="text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                	<th>No</th>
                                                    <th>Tgl. Rawat</th>
                                                    <th>Nama Pasien</th>
                                                    <th>Diagnosa</th>
                                                    <th>Nama Dokter</th>
                                                    <th>Tgl. Pilih</th>
                                                    <th>Tgl. Selesai</th>
                                                    <th>Status</th>
                                                    <th class="text-right">Actions</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                            	<?php 
                                            	$no = 0;
                                            	if($m_rawat != ""){
				            						foreach ($m_rawat as $key) {
				            							$status = "";
				            							if ($key->status == "DAFTAR") {
				            								$status = '<button class="btn btn-info btn-xs" style="margin: 0;">DAFTAR</button>';
				            							} else if ($key->status == "RAWAT"){
				            								$status = '<button class="btn btn-warning btn-xs" style="margin: 0;">RAWAT</button>';
                                                        } else if ($key->status == "MENUNGGU_DAFTAR"){
                                                            $status = '<button class="btn btn-xs" style="margin: 0;">MENUNGGU DAFTAR</button>';
                                                        } else if ($key->status == "MENUNGGU_RAWAT"){
                                                            $status = '<button class="btn btn-rose btn-xs" style="margin: 0;">MENUNGGU RAWAT</button>';
                                                        } else if ($key->status == "MENOLAK_RAWAT"){
                                                            $status = '<button class="btn btn-danger btn-xs" style="margin: 0;">MENOLAK RAWAT</button>';
				            							} else {
				            								$status = '<button class="btn btn-success btn-xs" style="margin: 0;">SELESAI</button>';
				            							}
				            							echo '<tr>
				                                                    <td>'.($no + 1).'</td>
				                                                    <td>'.$key->tgl_rawat.'</td>
				                                                    <td>'.$key->nama_pasien.'</td>
				                                                    <td>'.$key->nama_penyakit.'</td>
				                                                    <td>'.$key->nama_dokter.'</td>
				                                                    <td>'.$key->tgl_pilih.'</td>
				                                                    <td>'.$key->tgl_selesai.'</td>
                                                                    <td>'.$status.'</td>
                                                                    <td class="text-right">
                                                                        <a href="#" class="btn btn-simple btn-warning btn-icon edit" rel="tooltip" title="Edit" onclick="editRawat('.$key->id.');"><i class="material-icons">edit</i></a>';
                                                                    if ($key->nama_penyakit) {
                                                                        echo '<a href="#" class="btn btn-simple btn-success btn-icon edit" rel="tooltip" title="Print"  onclick="printPasien('.$key->id_detail.');"><i class="material-icons">print</i></a>';
                                                                    }
                                                                    if (!$key->id_dokter) {
                                                                     echo '
                                                                        <a href="#" class="btn btn-simple btn-danger btn-icon remove" rel="tooltip" title="Remove"  onclick="deleteRawat('.$key->id_rawat.', '."'".$key->nama_pasien."'".', '.$key->id_detail.');"><i class="material-icons">close</i></a>';
                                                                    }
                                                                    echo '</td>';
                                                                echo '</tr>';

                                                        $no++;
				            						}
				            					}

                                            	?>
                                                
                                            </tbody>
                                        </table>
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
<script src="<?php echo base_url();?>assets/js/apps/rawat-history.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
    	
    	app_rawat_history.init();
    });
</script>

</html>