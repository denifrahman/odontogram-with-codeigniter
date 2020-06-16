<!doctype html>
<html lang="en">

<?php $this->load->view($header);?>

<body class="off-canvas-sidebar">
    <div class="wrapper wrapper-full-page">
        <div class="full-page login-page" filter-color="black" data-image="<?php echo base_url();?>assets/img/background.jpeg">
            <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                            <form method="POST" action="">
                                <div class="card card-login card-hidden">
                                    <div class="card-header text-center" data-background-color="purple">
                                        <h4 class="card-title">Login</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">face</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Username</label>
                                                <input type="text" class="form-control" name="username" id="username">
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                            <div class="form-group label-floating">
                                                <label class="control-label">Password</label>
                                                <input type="password" class="form-control" name="password" id="password">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer text-center">
                                        <input type="submit" name="login" class="btn btn-primary btn-wd btn-lg" value="Login" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php $this->load->view($script);?>
<!-- <script>var base_url = '<?php echo base_url() ?>';</script>
<script src="<?php echo base_url();?>assets/js/apps/pasien.js"></script> -->
<script type="text/javascript">
    $(document).ready(function() {
    	demo.checkFullPageBackgroundImage();

        setTimeout(function() {
            // after 1000 ms we add the class animated to the login/register card
            $('.card').removeClass('card-hidden');
        }, 700)
    });
</script>

</html>