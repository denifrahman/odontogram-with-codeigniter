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
                        <a class="navbar-brand" href="#"> Deposit Administrator</a>
                    </div>
                </div>
            </nav>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Deposit Saldo User</h4>
                                    <blockquote>
                                        <p>
                                            Saldo anda saat ini <strong id="current_my_saldo">Rp. 0</strong>
                                        </p>
                                    </blockquote>
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                	<th>No</th>
                                                    <th>Nama User</th>
                                                    <th>User Name</th>
                                                    <th>Saldo</th>
                                                    <th>Deposit Hari ini</th>
                                                    <th>Transaksi Hari Ini</th>
                                                    <th class="disabled-sorting text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                	<th>No</th>
                                                    <th>Nama User</th>
                                                    <th>User Name</th>
                                                    <th>Saldo</th>
                                                    <th>Deposit Hari ini</th>
                                                    <th>Transaksi Hari Ini</th>
                                                    <th class="text-right">Actions</th>
                                                </tr>
                                            </tfoot>
                                            <tbody id="tabel_master_user">
                                            	<?php 
                                            	$no = 0;
                                            	if($m_token != ""){
				            						foreach ($m_token as $key) {
				            							echo '<tr>
				                                                    <td>'.($no + 1).'</td>
				                                                    <td>'.$key->nama_user.'</td>
				                                                    <td>'.$key->username.'</td>
				                                                    <td class="text-right">'.number_format($key->saldo).'</td>
                                                                    <td class="text-right">'.number_format($key->deposit_today).'</td>
                                                                    <td class="text-right">'.number_format($key->trx_today).'</td>
				                                                    <td class="text-right">
				                                                        <a href="#" class="btn btn-simple btn-warning btn-icon edit" rel="tooltip" title="Penambahan Deposit" onclick="addSaldo('."'".$key->nama_user."'".', '."'".$key->saldo."'".', '."'".$key->id_user."'".');"><i class="material-icons">edit</i></a>

                                                                        <a href="#" class="btn btn-simple btn-warning btn-icon edit" rel="tooltip" title="Lihat Mutasi User" onclick="viewMutasi('."'".$key->id_user."'".');"><i class="material-icons">pageview</i></a>
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
<script>
    var base_url = '<?php echo base_url() ?>';
    var id_user = '<?php echo $this->session->userdata('id');?>';
</script>
<script src="<?php echo base_url();?>assets/js/apps/s_token.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        app_s_token.init();
    });
</script>

</html>

<!-- Classic Modal -->
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        	<form id="fomrSaldo" method="">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
	                    <i class="material-icons">clear</i>
	                </button>
	                <h4 class="modal-title" id="modal-title">Modal title</h4>
	            </div>
	            <div class="modal-body">
	            	<div class="row">
	            		<div class="col-sm-12">
                            <p id="p_current_saldo">Saldo anda saat ini <strong>Rp. 0</strong></p>
                            <p id="p_user_saldo">Nama sisa saldo <strong>Rp. 0</strong></p>
                            <br>
		                    <div class="form-group label-floating">
		                        <label class="control-label">
		                            Nominal
		                            <small>*</small>
		                        </label>
		                        <input class="form-control" name="nominal" id="nominal" type="number" required="true"/>
                                <input class="form-control" name="id" id="id" type="hidden" required="true" value="undefined" />
                                <input class="form-control" name="id_admin" id="id_admin" type="hidden" required="true" value="undefined" />
                            </div>
                            <p>Gunakan minus untuk penarikan saldo (ex: -50000)</p>
		                </div>
		            </div>
	            </div>
	            <div class="modal-footer">
	                <!-- <button type="button" class="btn btn-warning btn-fill">Clear</button> -->
                    <button type="button" class="btn btn-info btn-fill" id="simpanUser" onclick="saveSaldo();">Simpan</button>
	                <button type="button" class="btn btn-danger btn-fill" data-dismiss="modal">Close</button>
	            </div>
	        </form>
        </div>
    </div>
</div>
<!--  End Modal -->