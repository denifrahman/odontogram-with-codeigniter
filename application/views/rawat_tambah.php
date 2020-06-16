<!doctype html>

<html lang="en">



<?php $this->load->view($header);?>
<style type="text/css">
    ::-webkit-scrollbar {
    -webkit-appearance: none;
    }
    ::-webkit-scrollbar:vertical {
        width: 12px;
    }
    ::-webkit-scrollbar:horizontal {
        height: 12px;
    }
    ::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, .5);
        border-radius: 10px;
        border: 2px solid #ffffff;
    }
    ::-webkit-scrollbar-track {
        border-radius: 10px;
        background-color: #ffffff;
    }

    .modal-loading {
        display:    none;
        position:   fixed;
        z-index:    1000;
        top:        0;
        left:       0;
        height:     100%;
        width:      100%;
        
    }

    body.loading {
        overflow: hidden;   
    }

    body.loading .modal-loading {
        display: block;
    }
</style>


<body>

    <div class="modal-loading" style="background: rgba( 255, 255, 255, .8 ) 
            url('<?php echo base_url();?>assets/img/loading-icon-red.gif') 
            50% 50% 
            no-repeat;"></div>

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

                        <a class="navbar-brand" href="#"> Input Pasien </a>

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

                                	<form id="formRawatTambah" method="">

	                                    <h4 class="card-title">Input Pasien Baru</h4>

	                                    <!-- <div class="row">

	                                        <div class="col-md-offset-1 col-sm-8">

	                                        	<div class="form-group label-floating" id="div_pasien">

	                                        		<label class="control-label">Pilih Pasien *</label>

							                        <input class="form-control" name="pasien_nama" id="pasien_nama" type="text" required="true" disabled="true"/>

							                        <input class="form-control" name="pasien_id" id="pasien_id" value="undefined" type="hidden" required="true"/>

							                        <input class="form-control" name="pasien_telp" id="pasien_telp" value="undefined" type="hidden" required="true"/>

							                    </div>

	                                        </div>

	                                        <div class="col-sm-2">

						                        <button type="button" class="btn btn-primary btn-fill" onclick="lookupPasien();" rel="tooltip" title="Pilih Pasien" >Cari</button>

						                    </div>

	                                    </div>

	                                    <div class="row">

	                                        <div class="col-md-offset-1 col-sm-8">

	                                        	<div class="form-group label-floating" id="div_penyakit">

	                                        		<label class="control-label">Pilih Kategori Penyakit *</label>

							                        <input class="form-control" name="penyakit_nama" id="penyakit_nama" type="text" required="true" disabled="true"/>

							                        <input class="form-control" name="penyakit_id" id="penyakit_id" value="undefined" type="hidden" required="true"/>

							                    </div>

	                                        </div>

	                                        <div class="col-sm-2">

						                        <button type="button" class="btn btn-primary btn-fill" onclick="lookupPenyakit();" rel="tooltip" title="Pilih Kategori Penyakit" >Cari</button>

						                    </div>

	                                    </div>

	                                    <div class="row">

		                                    <div class="col-md-offset-1 col-sm-8">

			                                    <div class="form-group label-floating label-static" id="div_tgl_rawat">

			                                        <label class="control-label">Tgl rawat</label>

			                                        <input type="text" class="form-control datepicker" name="tgl_rawat" id="tgl_rawat"/>

			                                    </div>

			                                </div>

		                                </div>

		                                <div class="row">

		                                    <div class="col-md-offset-1 col-sm-8">

		                                    	<div class="text-right">

			                                    	<button type="button" class="btn btn-info btn-fill" id="simpanUser" onclick="saveRawat();">Simpan</button>

			                						<button type="button" class="btn btn-danger btn-fill" onclick="cancelRawat();">Cancel</button>

		                						</div>

		                                    </div>

		                                </div> -->

                                        <div class="row">

                                            <div class="col-sm-offset-1 col-sm-5">

                                                <div class="form-group label-floating" id="div_pasien">

                                                    <label class="control-label">

                                                        Nama Pasien

                                                        <small>*</small>

                                                    </label>

                                                    <input class="form-control" name="nama_pasien" id="nama_pasien" type="text" required="true" />

                                                    <input class="form-control" name="id" id="id" type="hidden" required="true" value="undefined" />

                                                    <input class="form-control" name="id_rawat" id="id_rawat" type="hidden" required="true" value="undefined" />

                                                </div>

                                            </div>

                                            <div class="col-sm-5">

                                                <div class="form-group label-floating label-static" id="div_tgl_rawat">

                                                    <label class="control-label">Tgl Input</label>

                                                    <input type="text" class="form-control datepicker" name="tgl_rawat_header" id="tgl_rawat_header" disabled="true" />

                                                </div>

                                            </div>
                                            
                                            
                                        </div>
                                             
                                         <div class="row">
                                            
                                            <div class="col-sm-offset-1 col-sm-5">

                                                <div class="form-group label-floating" id="div_pasien">

                                                    <label class="control-label">

                                                        Tgl. Lahir

                                                        <small>*</small>

                                                    </label>
                                                    <div  style="display: inline;">
                                                        <div class="input-group">
                                                            <div class="input-group-addon" style="width: 100px; padding: 0px; padding-right: 10px;border: none;">
                                                                <select id="tgl_lahir_d" name="tgl_lahir_d" class="form-control" size="1" required>
                                                                    <option disabled>Pilih Kerjaan</option>
                                                                    <option class="X">BBB</option>
                                                                </select>
                                                            </div>
                                                            <div class="input-group-addon" style="width: 75px; padding: 0px; padding-right: 10px; border: none;">
                                                                <select id="tgl_lahir_m" name="tgl_lahir_m" class="form-control" size="1" required>
                                                                    <option disabled>Pilih Kerjaan</option>
                                                                    <option class="X">BBB</option>
                                                                </select>
                                                            </div>

                                                            <div class="input-group-addon" style="width: 100px; padding: 0px; border: none;">
                                                                <select id="tgl_lahir_y" name="tgl_lahir_y" class="form-control" size="1" required>
                                                                    <option disabled>Pilih Kerjaan</option>
                                                                    <option class="X">BBB</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <input class="form-control" name="umur_pasien" id="umur_pasien" type="number" required="true" /> -->

                                                </div>

                                            </div>
                                            
                                        <!-- </div> -->
                                             
                                         <!-- <div class="row"> -->

                                            <div class="col-sm-5">

                                                <div class="form-group label-floating">

                                                    <label class="control-label">

                                                        Penyakit Sistemik

                                                        <small>*</small>

                                                    </label>

                                                    <div class="col-sm-12" style="padding-left: 0px; padding-right: 0px;" id="div_role">

                                                        <select class="form-control" id="sistemik_pasien" name="sistemik_pasien" required>

                                                            <option disabled>Pilih Penyakit Sistemik</option>
                                                            
                                                            <option value="tidakAda">Tidak Ada</option>

                                                            <option value="diabetesMellitus">Diabetes Mellitus</option>

                                                            <option value="penyakitKardivaskular">Penyakit Kardivaskular</option>

                                                            <option value="Hipertiroidisme">Hipertiroidisme</option>
                                                            
                                                            <option value="gagalGinjalkronis">Gagal Ginjal Kronis</option>
                                                            
                                                            <option value="PenyakitHatikronis">Penyakit Hati Kronis</option>
                                                            
                                                            <option value="Asma">Asma</option>

                                                        </select>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                            
                                   

                                        <div class="row">

                                            <div class="col-sm-offset-1 col-sm-3">
                                                <div class="form-group label-floating">

                                                    <label class="control-label">

                                                        Jenis Kelamin

                                                        <small>*</small>

                                                    </label>

                                                    <div class="col-sm-12" style="padding-left: 0px; padding-right: 0px;" id="div_jenis_kelamin">

                                                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>

                                                            <option disabled>Pilih Jenis Kelamin</option>

                                                            <option value="L">LAKI - LAKI</option>

                                                            <option value="P">PEREMPUAN</option>

                                                        </select>

                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-sm-offset-2 col-sm-5">

                                                <div class="form-group label-floating" id="div_pasien">

                                                    <label class="control-label">

                                                        No. Telp Pasien

                                                        <small>*</small>

                                                    </label>

                                                    <input class="form-control" name="notelp_pasien" id="notelp_pasien" type="text" onchange="validatePhone(event);" onkeypress="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();" required="true" />

                                                </div>

                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-sm-offset-1 col-sm-10">

                                                <div class="form-group">

                                                    <div class="form-group label-floating">

                                                        <label class="control-label">

                                                            Alamat Pasien

                                                         </label>

                                                        <textarea class="form-control" id="alamat_pasien" name="alamat_pasien"></textarea>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                       <div class="row">

                                            <div class="col-md-3 col-sm-2">

                                                <label for="single" class="label-control">Foto Pasien</label>

                                                <div class="form-group is-empty"><input class="form-control" name="pasien_foto_base64" accept="image/*;capture=camera" id="pasien_foto_base64" type="hidden" required="true" value="undefined"><span class="material-input"></span></div>

                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput" data-name="pasien_fotos" id="pasien_div_foto_base64">

                                                    <!-- <input type="hidden" name="fotos" value="1" /> -->

                                                    <div class="fileinput-new thumbnail">

                                                        <img src="https://bankpasienfkgunair.com/assets/img/image_placeholder.jpg" alt="..." id="pasien_image_foto">

                                                    </div>

                                                    <div class="fileinput-preview fileinput-exists thumbnail" id="pasien_div_ada_foto"></div>

                                                    <div>

                                                        <span class="btn btn-rose btn-round btn-file">

                                                            <span class="fileinput-new">Select image</span>

                                                            <span class="fileinput-exists">Change</span>

                                                            <input type="file" name="pasien_fotos" id="pasien_fotos" accept="image/x-png,image/gif,image/jpeg" multiple="">

                                                        </span>

                                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="col-md-3 col-sm-2">

                                                <label for="single" class="label-control">Rahang Atas</label>

                                                <div class="form-group is-empty"><input class="form-control" name="rahang_atas_base64" accept="image/*;capture=camera" id="rahang_atas_base64" type="hidden" required="true" value="undefined"><span class="material-input"></span><span class="material-input"></span></div>

                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput" data-name="rahang_atas_fotos" id="rahang_atas_div_foto_base64">

                                                    <!-- <input type="hidden" name="fotos" value="1" /> -->

                                                    <div class="fileinput-new thumbnail">

                                                        <img src="https://bankpasienfkgunair.com/assets/img/image_placeholder.jpg" alt="..." id="rahang_atas_image_foto">

                                                    </div>

                                                    <div class="fileinput-preview fileinput-exists thumbnail" id="rahang_atas_div_ada_foto"></div>

                                                    <div>

                                                        <span class="btn btn-rose btn-round btn-file">

                                                            <span class="fileinput-new">Select image</span>

                                                            <span class="fileinput-exists">Change</span>

                                                            <input type="file" name="rahang_atas_fotos" id="rahang_atas_fotos" accept="image/x-png,image/gif,image/jpeg" multiple="">

                                                        </span>

                                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>

                                                    </div>

                                                </div>

                                            </div>
                                            
                                            <div class="col-md-3 col-sm-2">

                                                <label for="single" class="label-control">Rahang Bawah</label>

                                                <div class="form-group is-empty"><input class="form-control" name="rahang_bawah_base64" accept="image/*;capture=camera" id="rahang_bawah_base64" type="hidden" required="true" value="undefined"><span class="material-input"></span><span class="material-input"></span></div>

                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput" data-name="rahang_bawah_fotos" id="pasien_div_foto_base64">

                                                    <!-- <input type="hidden" name="fotos" value="1" /> -->

                                                    <div class="fileinput-new thumbnail">

                                                        <img src="https://bankpasienfkgunair.com/assets/img/image_placeholder.jpg" alt="..." id="rahang_bawah_image_foto">

                                                    </div>

                                                    <div class="fileinput-preview fileinput-exists thumbnail" id="rahang_bawah_div_ada_foto"></div>

                                                    <div>

                                                        <span class="btn btn-rose btn-round btn-file">

                                                            <span class="fileinput-new">Select image</span>

                                                            <span class="fileinput-exists">Change</span>

                                                            <input type="file" name="rahang_bawah_fotos" id="rahang_bawah_fotos" accept="image/x-png,image/gif,image/jpeg" multiple="">

                                                        </span>

                                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>

                                                    </div>

                                                </div>

                                            </div>
                                            
                                            <div class="col-md-3 col-sm-2">

                                                <label for="single" class="label-control">Tambahan</label>

                                                <div class="form-group is-empty"><input class="form-control" name="tambahan_base64" accept="image/*;capture=camera" id="tambahan_base64" type="hidden" required="true" value="undefined"><span class="material-input"></span><span class="material-input"></span></div>

                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput" data-name="tambahan_fotos" id="tambahan_div_foto_base64">

                                                    <!-- <input type="hidden" name="fotos" value="1" /> -->

                                                    <div class="fileinput-new thumbnail">

                                                        <img src="https://bankpasienfkgunair.com/assets/img/image_placeholder.jpg" alt="..." id="tambahan_image_foto">

                                                    </div>

                                                    <div class="fileinput-preview fileinput-exists thumbnail" id="tambahan_div_ada_foto"></div>

                                                    <div>

                                                        <span class="btn btn-rose btn-round btn-file">

                                                            <span class="fileinput-new">Select image</span>

                                                            <span class="fileinput-exists">Change</span>

                                                            <input type="file" name="tambahan" id="tambahan_fotos" accept="image/x-png,image/gif,image/jpeg" multiple="">

                                                        </span>

                                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>

                                                    </div>

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
                                        
                                        
                                            <div class="row">

                                            <div class="col-sm-offset-1 col-sm-10">

                                                <div class="form-group">

                                                    <div class="form-group label-floating">

                                                        <label class="control-label">

                                                            Notes

                                                         </label>

                                                        <textarea class="form-control" id="note" name="note" rows="9" cols="90"></textarea>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-sm-offset-1 col-sm-5">

                                                <div class="form-group label-floating">

                                                    <label class="control-label">

                                                        Tingkat Kooperatif

                                                        <small>*</small>

                                                    </label>

                                                    <div class="col-sm-12" style="padding-left: 0px; padding-right: 0px;" id="div_role">

                                                        <select class="form-control" id="tingkat_kooperatif" name="tingkat_kooperatif" required>

                                                            <option disabled>Pilih Tingkat Kooperatif</option>

                                                            <option value="BAIK">BAIK</option>

                                                            <option value="SEDANG">SEDANG</option>

                                                            <option value="BURUK">BURUK</option>

                                                        </select>

                                                    </div>

                                                </div>
                                                
                                                

                                            </div>
                                            <!-- <div class="col-sm-offset-1 col-sm-5">

                                                <div class="form-group label-floating">

                                                    <label class="control-label">

                                                      <h2> Total Harga = Rp </h2>

                                                        <small>*</small>

                                                    </label>

                                                    

                                                </div>
                                            </div> -->

                                        </div>

                                        <div class="row" id="div_save_header_rawat">

                                            <div class="col-sm-offset-1 col-sm-10">

                                                <div class="text-right">

                                                    <button type="button" class="btn btn-info btn-fill" id="simpanUser" onclick="saveHeaderRawat('add');">Save To Add Detail</button>

                                                    <button type="button" class="btn btn-danger btn-fill" onclick="cancelSaveRawat();">Cancel</button>

                                                </div>

                                            </div>

                                        </div>

                                    </form>

                                </div>

                                <div id="div_detail_penyakit">

                                <div class="card-header card-header-icon" data-background-color="purple">

                                    <i class="material-icons">assignment</i>

                                </div>

                                <div class="card-content">

                                    <form id="formRawatTambah" method="">

                                        <h4 class="card-title">Detail Diagnosa Pasien</h4>

                                        <div class="row">

                                            <div class="col-md-offset-1 col-sm-10">

                                                <div class="material-datatables">

                                                    <table id="datatables-detail-rawat" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">

                                                        <thead>

                                                            <tr>

                                                                <th>No</th>

                                                                <th>Departemen</th>

                                                                <th>Diagnosa</th>

                                                                <th>Harga</th>

                                                                <th class="disabled-sorting text-right">Actions</th>

                                                            </tr>

                                                        </thead>

                                                        <tbody id="tabel_master_user">

                                                        

                                                        </tbody>

                                                    </table>

                                                </div>

                                            </div>

                                            <div class="col-md-offset-6 col-sm-5">
                                                <form class="form-horizontal">
                                                    <div class="row">
                                                        <label class="col-md-4 label-on-left text-right" style="padding: 10px 5px 0 0; font-size: 24px;">Total Harga</label>
                                                        <div class="col-md-8">
                                                            <div class="form-group label-floating is-empty">
                                                                <label class="control-label"></label>
                                                                <input type="text" class="form-control text-right" name="total_harga_hide" id="total_harga_hide" disabled value="<?php echo number_format($harga_total);?>" style="font-size: 28px;">
                                                                <input type="hidden" class="form-control" name="harga_total" id="harga_total" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-offset-1 col-sm-5">



                                                <div class="text-left">

                                                    <button type="button" class="btn btn-info btn-fill" id="tambahDetail" onclick="tambahDetailPenyakit();">Tambah Detail</button>

                                                    

                                                </div>

                                            </div>

                                            <div class="col-sm-5">

                                                <div class="text-right">

                                                    <button type="button" class="btn btn-info btn-fill" id="simpanUser" onclick="saveHeaderRawat('edit');">Simpan</button>

                                                    <button type="button" class="btn btn-danger btn-fill" onclick="cancelRawat();">Cancel</button>

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

<script src="<?php echo base_url();?>assets/js/apps/rawat-tambah.js"></script>

<script type="text/javascript">

    $(document).ready(function() {

        app_rawat_tambah.init();

    });

</script>



</html>



<!-- Classic Modal Pasien -->

<div class="modal fade" id="myModalDetailPenyakit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

        	<form id="formDetailPenyakit" method="" enctype='multipart/form-data'>

	            <div class="modal-header">

	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">

	                    <i class="material-icons">clear</i>

	                </button>

	                <h4 class="modal-title" id="modal-title">Lookup Pasien</h4>

	            </div>

	            <div class="modal-body">

	            	<div class="row">

                        <div class="col-sm-12">

                            <div class="form-group label-floating label-static" id="div_tgl_rawat">

                                <label class="control-label">Tgl rawat</label>

                                <input type="text" class="form-control datepicker" name="tgl_rawat" id="tgl_rawat" disabled="true" />

                            </div>

                        </div>

                        <div class="col-sm-12">

                            <div class="form-group label-floating">

                                <label for="single" class="label-control">Departemen</label>

                                <div class="col-sm-12"  style="padding-left: 0px; padding-right: 0px;" >

                                    <input class="form-control" name="id_detail_rawat" id="id_detail_rawat" type="hidden" required="true" value="undefined" />
                                     <input class="form-control" name="harga" id="harga" type="hidden" required="true" value="5000" />

                                    <select id="id_bidang_ilmu" name="id_bidang_ilmu" class="form-control select2-single" required>

                                        

                                    </select>

                                </div>

                            </div>

                        </div>

                    </div>

                    </br>

                    <div class="row">

                        <div class="col-sm-6">

                            <div class="form-group label-floating">

                                <label class="control-label">

                                    Gigi

                                    <small>*</small>

                                </label>

                                <div class="col-sm-12" style="padding-left: 0px; padding-right: 0px;" id="div_role">

                                    <select class="form-control" id="gigi" name="gigi" required>

                                        <option disabled>Pilih Gigi</option>

                                       <option value="11">11</option>

                                        <option value="12">12</option>

                                        <option value="13">13</option>

                                        <option value="14">14</option>

                                        <option value="15">15</option>

                                        <option value="16">16</option>

                                        <option value="17">17</option>
                                        
                                        <option value="18">18</option>
                                        
                                        
                                        <option value="21">21</option>

                                        <option value="22">22</option>

                                        <option value="23">23</option>

                                        <option value="24">24</option>

                                        <option value="25">25</option>

                                        <option value="26">26</option>
                                        
                                        <option value="27">27</option>
                                        
                                        <option value="28">28</option>
                                        
                                        
                                        <option value="31">31</option>

                                        <option value="32">32</option>

                                        <option value="33">33</option>

                                        <option value="34">34</option>

                                        <option value="35">35</option>

                                        <option value="36">36</option>
                                        
                                        <option value="37">37</option>
                                        
                                        <option value="38">38</option>


                                        <option value="41">41</option>

                                        <option value="42">42</option>

                                        <option value="43">43</option>

                                        <option value="44">44</option>

                                        <option value="45">45</option>

                                        <option value="46">46</option>
                                        
                                        <option value="47">47</option>
                                        
                                        <option value="48">48</option>



                                        <option value="51">51</option>
                                        
                                        <option value="52">52</option>

                                        <option value="53">53</option>

                                        <option value="54">54</option>

                                        <option value="55">55</option>
                                        
                                        
                                        <option value="61">61</option>
                                        
                                        <option value="62">62</option>

                                        <option value="63">63</option>

                                        <option value="64">64</option>
                                        
                                        <option value="65">65</option>
                                        

                                        <option value="71">71</option>

                                        <option value="72">72</option>

                                        <option value="73">73</option>

                                        <option value="74">74</option>

                                        <option value="75">75</option>
                                        


                                        <option value="81">81</option>

                                        <option value="82">82</option>

                                        <option value="83">83</option>

                                        <option value="84">84</option>

                                        <option value="85">85</option>
                                    </select>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-sm-12">

                            <div class="form-group label-floating">

                                <label for="single" class="label-control">Diagnosa</label>

                                <div class="col-sm-12"  style="padding-left: 0px; padding-right: 0px;" >

                                    <select id="id_penyakit" name="id_penyakit" class="form-control select2-single" required>

                                        

                                    </select>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-sm-12">

                            <div class="form-group label-floating">

                                <label for="single" class="label-control">Rencana Perawatan</label>

                                <div class="col-sm-12"  style="padding-left: 0px; padding-right: 0px;" >

                                    <select id="id_rencana_perawatan" name="id_rencana_perawatan" class="form-control select2-single" required>

                                        

                                    </select>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-sm-12">

                            <div class="form-group label-floating">

                                <label for="single" class="label-control">Harga</label>
                                <input type="text" name="harga_detail" id="harga_detail" disabled class="form-control">
                                <input type="hidden" name="harga" id="harga" required class="form-control">

                            </div>

                        </div>

                    </div>

                    <!-- <div class="row">

                        <div class="col-md-4 col-sm-4">

                            <label for="single" class="label-control">Foto</label>

                            <input class="form-control" name="foto_base64" id="foto_base64" type="hidden" required="true" value="undefined" />

                            <div class="fileinput fileinput-new text-center" data-provides="fileinput" data-name="fotos" id="div_foto_base64">

                                 <input type="hidden" name="fotos" value="1" /> 

                                <div class="fileinput-new thumbnail">

                                    <img src="<?php echo base_url();?>assets/img/image_placeholder.jpg" alt="..." id="image_foto">

                                </div>

                                <div class="fileinput-preview fileinput-exists thumbnail" id="div_ada_foto"></div>

                                <div>

                                    <span class="btn btn-rose btn-round btn-file">

                                        <span class="fileinput-new">Select image</span>

                                        <span class="fileinput-exists">Change</span>

                                        <input type="file" name="fotos" id="fotos" accept="image/x-png,image/gif,image/jpeg" multiple/>

                                    </span>

                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput" id="remove_detail_foto"><i class="fa fa-times"></i> Remove</a>

                                </div>

                            </div>

                        </div>

                    </div> -->

	            </div>

	            <div class="modal-footer">

                    <button type="button" class="btn btn-info btn-fill" onclick="saveDetailRawat();">Simpan</button>

	                <button type="button" class="btn btn-danger btn-fill" data-dismiss="modal">Close</button>

	            </div>

	        </form>

        </div>

    </div>

</div>

<!--  End Modal -->





<!-- Classic Modal Penyakit -->

<div class="modal fade" id="myModalPenyakit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

        	<form id="fomrMasterUser" method="">

	            <div class="modal-header">

	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">

	                    <i class="material-icons">clear</i>

	                </button>

	                <h4 class="modal-title" id="modal-title">Lookup Penyakit</h4>

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