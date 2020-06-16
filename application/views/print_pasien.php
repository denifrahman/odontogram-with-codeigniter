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

                                	<div class="row">
                                		<div class="col-md-12" id="div_detail_print">
                                			
                                		</div>
                                	</div>

                                	<div class="row">
                                		<div class="col-md-12">
                                			<button class="btn btn-success" style="width: 100%" onclick="btnPrintPasien();">
                                				Print
                                			</button>
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

<script>
	var base_url = '<?php echo base_url() ?>';
	var id_to_print = '<?php echo $id; ?>'
</script>

<script src="<?php echo base_url();?>assets/js/apps/print_pasien.js"></script>

<script type="text/javascript">

    $(document).ready(function() {

        app_print_pasien.init();

    });

</script>



</html>