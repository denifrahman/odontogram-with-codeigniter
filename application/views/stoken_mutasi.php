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
                        <a class="navbar-brand" href="#"> Mutasi </a>
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
                                    <h4 class="card-title">Laporan Mutasi Saldo</h4>
                                    <blockquote>
                                        <p>
                                            Saldo anda saat ini <strong>Rp. <?php echo number_format($saldo);?></strong>
                                        </p>
                                    </blockquote>
                                    <div class="toolbar">
	                                    <form method="POST" action="<?php echo $idUser;?>">
	                                        <div class="row">
			                                    <div class="col-sm-3">
				                                    <div class="form-group label-floating label-static">
				                                        <label class="control-label">Tgl Dari</label>
				                                        <input type="text" class="form-control datepicker" name="fromDate" id="fromDate" value="<?php echo $fromDate;?>" />
                                                        <input type="hidden" class="form-control" name="id_user" id="id_user" value="<?php echo $idUser;?>" />
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
                                    <div class="table-responsive" style="-webkit-overflow-scrolling: touch;">
                                        <table class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                	<th>No</th>
                                                    <th>Time Ins</th>
                                                    <th>User Ins</th>
                                                    <th>ID Transaksi</th>
                                                    <?php echo $idUser == "29" ? "<th>Kepada</th>": ""; ?>
                                                    <th>Keterangan</th>
                                                    <th>Masuk</th>
                                                    <th>Keluar</th>
                                                    <th>Sisa Saldo</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Time Ins</th>
                                                    <th>User Ins</th>
                                                    <th>ID Transaksi</th>
                                                    <?php echo $idUser == "29" ? "<th>Kepada</th>": ""; ?>
                                                    <th>Keterangan</th>
                                                    <th>Masuk</th>
                                                    <th>Keluar</th>
                                                    <th>Sisa Saldo</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                            	<?php 
                                            	$no = 0;
                                            	if($m_token != ""){
				            						foreach ($m_token as $key) {
                                                        $nominal = $key->saldo;
                                                        $masuk = 0;
                                                        $keluar = 0;
				            							if ($key->tipe == "IN") {
                                                            if ($nominal < 0) {
                                                                $keluar = $nominal * -1;
                                                            } else {
                                                                $masuk = $nominal;
                                                            }
                                                        } else if ($key->tipe == "OUT"){

                                                            if ($nominal < 0) {
                                                                $masuk = $nominal * -1;
                                                            } else {
                                                                $keluar = $nominal;
                                                            }
                                                        }
				            							echo '<tr>
				                                                    <td>'.($no + 1).'</td>
				                                                    <td>'.$key->time_ins.'</td>
				                                                    <td>'.$key->user_ins.'</td>
				                                                    <td>'.$key->id_trx.'</td>
                                                                    '.($idUser == "29" ? '<td>'.$key->nama_user.'</td>' : '').'
				                                                    <td>'.$key->keterangan.'</td>
				                                                    <td>'.$masuk.'</td>
				                                                    <td>'.$keluar.'</td>
                                                                    <td>'.$key->saldo_akhir.'</td>
                                                                </tr>';

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