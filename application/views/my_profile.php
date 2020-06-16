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
                        <a class="navbar-brand" href="#"> Profile </a>
                    </div>
                </div>
            </nav>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    <i class="material-icons">perm_identity</i>
                                </div>
                                <div class="card-content">
                                    <h4 class="card-title">Edit Profile - <small class="category"><?php echo $this->session->userdata('username');?></small></h4>
                                    <div class="toolbar">
	                                    <form name="fomrMasterUser" id="fomrMasterUser" method="POST" action="">
	                                        <div class="row">
			                                    <div class="col-sm-12">
								            		<div class="form-group label-floating label-static">
								                        <label class="control-label">
								                            Nama
								                            <small>*</small>
								                        </label>
								                        <input class="form-control" name="nama" id="nama" type="text" required="true" />
						                                <input class="form-control" name="id" id="id" type="hidden" required="true" value="undefined" />
								                    </div>
								                    <div class="row">
						                                <div class="col-sm-6">
										                    <div class="form-group label-floating label-static">
										                        <label class="control-label">
										                            Username
										                            <small>*</small>
										                        </label>
										                        <input class="form-control" name="username" id="username" type="text" required="true"/>
										                    </div>
										                </div>
										                <div class="col-sm-6">
								                            <div class="form-group label-floating label-static">
								                                <label class="control-label">
								                                    Password
								                                    <small>*</small>
								                                </label>
								                                <input class="form-control" name="password" id="password" type="password" required="true" />
								                            </div>
								                        </div>
								                    </div>

						                            <div class="form-group label-floating label-static">
						                                <label class="control-label">
						                                    No. Telp
						                                    <small>*</small>
						                                </label>
						                                <input class="form-control" name="no_telp" id="no_telp" type="text" required="true"/>
						                            </div>
						                            <div class="row">
						                                <div class="col-sm-4">
						                                    <div class="form-group label-floating label-static">
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
						                                    <div class="form-group label-floating label-static">
						                                        <label class="control-label">
						                                            Role
						                                            <small>*</small>
						                                        </label>
						                                        <div class="col-sm-12" style="padding-left: 0px; padding-right: 0px;" id="div_role">
						                                            <select class="form-control" id="role" name="role" disabled required >
						                                                <option disabled>Pilih Role</option>
						                                                <option value="ADMIN">ADMIN</option>
						                                                <option value="DOKTER_MUDA">DOKTER MUDA</option>
						                                                <option value="MAHASISWA">MAHASISWA</option>
						                                            </select>
						                                        </div>
						                                    </div>
						                                </div>
						                            </div>
						                            <br/>
						                            <div class="form-group">
						                                <div class="form-group label-floating label-static">
						                                    <label class="control-label">
						                                        Alamat
						                                     </label>
						                                    <textarea class="form-control" id="alamat" name="alamat"></textarea>
						                                </div>
						                            </div>
						                            <div class="text-right">
					                                	<button type="button" class="btn btn-primary btn-fill" name="submit" onclick="saveUser()">Simpan</button>
					                                	<button type="button" class="btn btn-primary btn-fill" name="cancel" onclick="editUser('<?php echo $this->session->userdata('id');?>')">Batal</button>
					                                </div>
								                </div>
			                                </div>

			                            </form>
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
<script>var id_user = '<?php echo $this->session->userdata('id'); ?>';</script>
<script src="<?php echo base_url();?>assets/js/apps/my_profile.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
    	app_profile.init();
    });
</script>

</html>