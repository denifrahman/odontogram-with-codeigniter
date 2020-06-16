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
                        <a class="navbar-brand" href="#"> Master Rencana Perawatan </a>
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
                                    <h4 class="card-title">Daftar Rencana Perawatan</h4>
                                    <div class="toolbar">
                                        <button class="btn btn-success" onclick="addRencanaPerawatan();">
	                                        <span class="btn-label">
	                                            <i class="material-icons">add_box</i>
	                                        </span>
	                                        Tambah Rencana Perawatan
	                                    </button>
                                    </div>
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                	<th>No</th>
                                                    <th>Nama</th>
                                                    <th>Kategori Penyakit</th>
                                                    <th class="disabled-sorting text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                	<th>No</th>
                                                    <th>Nama</th>
                                                    <th>Kategori Penyakit</th>
                                                    <th class="text-right">Actions</th>
                                                </tr>
                                            </tfoot>
                                            <tbody id="tabel_master_user">
                                            	<?php 
                                            	$no = 0;
                                            	if($m_master_rencana_perawatan != ""){
				            						foreach ($m_master_rencana_perawatan as $key) {
				            							echo '<tr>
				                                                    <td>'.($no + 1).'</td>
				                                                    <td>'.$key->nama.'</td>
				                                                    <td>'.$key->nama_penyakit.'</td>
				                                                    <td class="text-right">
				                                                        <a href="#" class="btn btn-simple btn-warning btn-icon edit" rel="tooltip" title="Edit" onclick="editRencanaPerawatan('.$key->id.');"><i class="material-icons">edit</i></a>
				                                                        <a href="#" class="btn btn-simple btn-danger btn-icon remove" rel="tooltip" title="Remove" onclick="deleteRencanaPerawatan('.$key->id.', '."'".$key->nama."'".');"><i class="material-icons">close</i></a>
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
<script>var base_url = '<?php echo base_url() ?>';</script>
<script src="<?php echo base_url();?>assets/js/apps/rencana-perawatan.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        app_rencana_perawatan.init();
    });
</script>

</html>

<!-- Classic Modal -->
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        	<form id="fomrMasterPenyakit" method="">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
	                    <i class="material-icons">clear</i>
	                </button>
	                <h4 class="modal-title" id="modal-title">Modal title</h4>
	            </div>
	            <div class="modal-body">
	            	<div class="row">
	            		<div class="col-sm-12">
		            		<div class="form-group label-floating">
		                        <label class="control-label">
		                            Nama
		                            <small>*</small>
		                        </label>
		                        <input class="form-control" name="nama" id="nama" type="text" required="true" />
                                <input class="form-control" name="id" id="id" type="hidden" required="true" value="undefined" />
		                    </div>
		                    <div class="form-group label-floating">
								<label for="single" class="label-control">Kategori Penyakit</label>
								<div class="col-sm-12"  style="padding-left: 0px; padding-right: 0px;" >
									<select id="id_penyakit" name="id_penyakit" class="form-control select2-single" required>
										
									</select>
								</div>
							</div>
		                </div>
		            </div>
	            </div>
	            <div class="modal-footer">
	                <!-- <button type="button" class="btn btn-warning btn-fill">Clear</button> -->
                    <button type="button" class="btn btn-info btn-fill" id="simpanUser" onclick="saveRencanaPerawatan();">Simpan</button>
	                <button type="button" class="btn btn-danger btn-fill" data-dismiss="modal">Close</button>
	            </div>
	        </form>
        </div>
    </div>
</div>
<!--  End Modal -->