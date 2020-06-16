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
                        <a class="navbar-brand" href="#"> Master Diagnosa Pasien </a>
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
                                    <h4 class="card-title">Daftar Diagnosa Pasien</h4>
                                    <div class="toolbar">
                                        <button class="btn btn-success" onclick="addPasien();">
	                                        <span class="btn-label">
	                                            <i class="material-icons">add_box</i>
	                                        </span>
	                                        Tambah Diagnosa Pasien
	                                    </button>
                                    </div>
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama</th>
                                                    <th>Tgl Lahir</th>
                                                    <th>No. Telp</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>Alamat</th>
                                                    <th class="disabled-sorting text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama</th>
                                                    <th>Tgl Lahir</th>
                                                    <th>No. Telp</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>Alamat</th>
                                                    <th class="text-right">Actions</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                            	<?php 
                                            	$no = 0;
                                            	if($m_user != ""){
				            						foreach ($m_user as $key) {
				            							$jenis_kelamin = "";
				            							if ($key->jenis_kelamin == "L") {
				            								$jenis_kelamin = "LAKI - LAKI";
				            							} else if ($key->jenis_kelamin == "P"){
				            								$jenis_kelamin = "PEREMPUAN";
				            							}
				            							echo '<tr>
                                                                <td>'.($no + 1).'</td>
                                                                <td>'.$key->nama.'</td>
                                                                <td>'.$key->tgl_lahir.'</td>
                                                                <td>'.$key->no_telp.'</td>
                                                                <td>'.$jenis_kelamin.'</td>
                                                                <td>'.$key->alamat.'</td>
                                                                <td class="text-right">
                                                                    <a href="#" class="btn btn-simple btn-warning btn-icon edit" rel="tooltip" title="Edit" onclick="editPasien('.$key->id.');"><i class="material-icons">edit</i></a>
                                                                    <a href="#" class="btn btn-simple btn-danger btn-icon remove" rel="tooltip" title="Remove"  onclick="deletePasien('.$key->id.', '."'".$key->nama."'".');"><i class="material-icons">close</i></a>
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
<script src="<?php echo base_url();?>assets/js/apps/pasien.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        app_pasien.init();
    });
</script>

</html>

<!-- Classic Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        	<form id="fomrMasterPasien" method="">
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
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label">
                                            Jenis Kelamin
                                            <small>*</small>
                                        </label>
                                        <div class="col-sm-12" style="padding-left: 0px; padding-right: 0px;" id="div_jenis_kelamin">
                                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                                <option disabled>Pilih Jenis Kelamin</option>
                                                <option value="L">L</option>
                                                <option value="P">P</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group label-floating label-static" id="div_tgl_lahir">
                                        <label class="control-label">Tgl Lahir</label>
                                        <input type="text" class="form-control datepicker" name="tgl_lahir" id="tgl_lahir"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group label-floating">
                                <label class="control-label">
                                    No. Telp
                                    <small>*</small>
                                </label>
                                <input class="form-control" name="no_telp" id="no_telp" type="text" required="true"/>
                            </div>
                            
                            <br/>
                            <div class="form-group">
                                <div class="form-group label-floating">
                                    <label class="control-label">
                                        Alamat
                                     </label>
                                    <textarea class="form-control" id="alamat" name="alamat"></textarea>
                                </div>
                            </div>
		                </div>
		            </div>
	            </div>
	            <div class="modal-footer">
	                <!-- <button type="button" class="btn btn-warning btn-fill">Clear</button> -->
                    <button type="button" class="btn btn-info btn-fill" id="simpanUser" onclick="savePasien();">Simpan</button>
	                <button type="button" class="btn btn-danger btn-fill" data-dismiss="modal">Close</button>
	            </div>
	        </form>
        </div>
    </div>
</div>
<!--  End Modal -->