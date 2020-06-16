var table_user;

var formData;

var data_penyakit;

var data_edit = {};

app_rawat_edit = {

	init: function () {

		loaded();
        odontogram();

        $(document.body).on("change","#id_penyakit",function(){
            var id_select = this.value;
             for (var i = 0; i < data_penyakit.length; i++) {
                if (data_penyakit[i].id === id_select) {
                    // alert(data_penyakit[i].nama+", harga: "+data_penyakit[i].harga);
                    $("#harga").val(data_penyakit[i].harga);
                    $("#harga_detail").val(numberWithCommas(data_penyakit[i].harga));
                }
             }
        });

	}

}

var by = function (name, minor) {
    return function (o, p) {
        var a, b;
        if (typeof o === 'object' && typeof p === 'object' && o && p) {
            a = o[name];
            b = p[name];
            if (a === b) {
                return typeof minor === 'function' ? minor(o, p) : o;
            }
            if (typeof a === typeof b) {
                return a < b ? -1 : 1;
            }
            return typeof a < typeof b ? -1 : 1;
        } else {
            throw {
                name: 'Error',
                message: 'Expected an object when sorting by ' + name
            };
        }
    }
}; 


var odontogram = function () {
        var data = JSON.parse(odontogramData);

        // data = data.sort(by('id'));

        console.log(data.sort(by('id')));

    allDental = data;
    //hasil 
    function parseSVG(s) {
        var div= document.createElementNS('http://www.w3.org/1999/xhtml', 'div');
        div.innerHTML= '<svg xmlns="http://www.w3.org/2000/svg">'+s+'</svg>';
        var frag= document.createDocumentFragment();
        while (div.firstChild.firstChild)
            frag.appendChild(div.firstChild.firstChild);
        return frag;
    }

    var arrId4Sisi = ['dental13', 'dental12', 'dental11', 'dental21', 'dental22', 'dental23', 
    'dental53', 'dental52', 'dental51', 'dental61', 'dental62', 'dental63',
    'dental83', 'dental82', 'dental81', 'dental71', 'dental72', 'dental73',
    'dental43', 'dental42', 'dental41', 'dental31', 'dental32', 'dental33'];

    for (var i = 0; i < data.length; i++) {
        if (arrId4Sisi.indexOf(data[i].id) > -1){

            var svg = '<g id="'+data[i].id+'" transform="translate('+data[i].transform1+','+data[i].transform2+')">' +
                        '<polygon points="0,0   20,0    15,10    0,10" fill="'+data[i].data.T+'" stroke="navy" stroke-width="0.5" id="T" opacity="1" onclick="clickSvg(this);"></polygon>' +
                        '<polygon points="5,10  15,10   20,20   0,20" fill="'+data[i].data.B+'" stroke="navy" stroke-width="0.5" id="B" opacity="1" onclick="clickSvg(this);"></polygon>' +
                        '<polygon points="20,0  20,0    20,20   15,10" fill="'+data[i].data.R+'" stroke="navy" stroke-width="0.5" id="R" opacity="1" onclick="clickSvg(this);"></polygon>' +
                        '<polygon points="0,0   5,10     5,10    0,20" fill="'+data[i].data.L+'" stroke="navy" stroke-width="0.5" id="L" opacity="1" onclick="clickSvg(this);"></polygon>' +
                        '<text x="6" y="30" stroke="navy" fill="navy" stroke-width="0.1" style="font-size: 6pt;font-weight:normal">'+data[i].title+'</text>' +
                    '</g>';
        } else {

            var svg = '<g id="'+data[i].id+'" transform="translate('+data[i].transform1+','+data[i].transform2+')">' +
                        '<polygon points="5,5   15,5    15,15   5,15" fill="'+data[i].data.C+'" stroke="navy" stroke-width="0.5" id="C" opacity="1" onclick="clickSvg(this);"></polygon>' +
                        '<polygon points="0,0   20,0    15,5    5,5" fill="'+data[i].data.T+'" stroke="navy" stroke-width="0.5" id="T" opacity="1" onclick="clickSvg(this);"></polygon>' +
                        '<polygon points="5,15  15,15   20,20   0,20" fill="'+data[i].data.B+'" stroke="navy" stroke-width="0.5" id="B" opacity="1" onclick="clickSvg(this);"></polygon>' +
                        '<polygon points="15,5  20,0    20,20   15,15" fill="'+data[i].data.R+'" stroke="navy" stroke-width="0.5" id="R" opacity="1" onclick="clickSvg(this);"></polygon>' +
                        '<polygon points="0,0   5,5     5,15    0,20" fill="'+data[i].data.L+'" stroke="navy" stroke-width="0.5" id="L" opacity="1" onclick="clickSvg(this);"></polygon>' +
                        '<text x="6" y="30" stroke="navy" fill="navy" stroke-width="0.1" style="font-size: 6pt;font-weight:normal">'+data[i].title+'</text>' +
                    '</g>';
        }

        var parser = new DOMParser();
        var doc = parser.parseFromString(svg, "image/svg+xml");
        // var baru = document.importNode(svg,true);
        document.getElementById("odontograma").appendChild(parseSVG(svg));
        // console.log("svg: " , doc);
        // $("#odontograma").append(svg);
    }

}


var loaded = function(){

	// $('.datepicker').datetimepicker({

 //        format: 'YYYY-MM-DD',

	// 	keyBinds: false,

	// 	date: new Date(),

 //        icons: {

 //            time: "fa fa-clock-o",

 //            date: "fa fa-calendar",

 //            up: "fa fa-chevron-up",

 //            down: "fa fa-chevron-down",

 //            previous: 'fa fa-chevron-left',

 //            next: 'fa fa-chevron-right',

 //            today: 'fa fa-screenshot',

 //            clear: 'fa fa-trash',

 //            close: 'fa fa-remove'

 //        }

 //    });



	table_user = $('#datatablesPasien').DataTable({

        "pagingType": "full_numbers",

        "lengthMenu": [

            [10, 25, 50, -1],

            [10, 25, 50, "All"]

        ],

        responsive: true,



        language: {

            search: "_INPUT_",

            searchPlaceholder: "Search records",

        },



    });



    $('#datatablesPenyakit').DataTable({

        "pagingType": "full_numbers",

        "lengthMenu": [

            [10, 25, 50, -1],

            [10, 25, 50, "All"]

        ],

        responsive: true,



        language: {

            search: "_INPUT_",

            searchPlaceholder: "Search records",

        },



    });



    $( ".select2-single" ).select2( {

        theme: "bootstrap",

        placeholder: "Pencarian",

        maximumSelectionSize: 6,

        width: null,

        containerCssClass: ':all:'

    });



    $('.card .material-datatables label').addClass('form-group');



    $(document).on('click', '.pilih-pasien', function (e) {

    	$("#div_pasien").addClass("label-static");

        $("#pasien_nama").val($(this).attr('data-nama'));

        $("#pasien_id").val($(this).attr('data-id'));

        $("#pasien_telp").val($(this).attr('data-telp'));

        $('#myModalPasien').modal('hide');

    });



    $(document).on('click', '.pilih-penyakit', function (e) {

    	$("#div_penyakit").addClass("label-static");

        $("#penyakit_nama").val($(this).attr('data-nama'));

        $("#penyakit_id").val($(this).attr('data-id'));

        $('#myModalPenyakit').modal('hide');

    });

    $(".select2-single").select2("val", "");



    getBidangIlmu();



    $('#id_penyakit').on('change', function() {

        getRencanaPerawatan($("#id_penyakit").val());

    });



    $('#fotos').on('change', function() {

        

        if ($("#fotos")[0].files[0] !== undefined) {

            getBase64($("#fotos")[0].files[0]);

        }

    });

    $('#pasien_fotos').on('change', function() {
        console.log('pasien_fotos');
        if ($("#pasien_fotos")[0].files[0] !== undefined) {
            getBase64FotoPasien($("#pasien_fotos")[0].files[0]);

        }

    });
    
     $('#rahang_atas_fotos').on('change', function() {
        console.log('rahang_atas_fotos');
        if ($("#rahang_atas_fotos")[0].files[0] !== undefined) {
            getBase64RahangAtas($("#rahang_atas_fotos")[0].files[0]);

        }

    });
    
     $('#rahang_bawah_fotos').on('change', function() {
        console.log('rahang_bawah_fotos');
        if ($("#rahang_bawah_fotos")[0].files[0] !== undefined) {
            getBase64RahangBawah($("#rahang_bawah_fotos")[0].files[0]);

        }

    });

     $('#tambahan_fotos').on('change', function() {
        console.log('tambahan_fotos');
        if ($("#tambahan_fotos")[0].files[0] !== undefined) {
            getBase64Tambahan($("#tambahan_fotos")[0].files[0]);

        }

    });

    $('#id_bidang_ilmu').on('change', function() {

        getKategoriPenyakit($("#id_bidang_ilmu").val());

        console.log("ccs: ", $('#id_bidang_ilmu option:selected').attr('data-nama'));

    });

}



    function updateJsonOdontograma(idSvg, idPolygon, color){
        for (var i =  1; i < allDental.length; i++) {
            if (allDental[i].id === idSvg) {
                if (idPolygon === "C") {
                    allDental[i].data.C = color;
                } else if (idPolygon === "T") {
                    allDental[i].data.T = color;
                } else if (idPolygon === "B") {
                    allDental[i].data.B = color;
                } else if (idPolygon === "R") {
                    allDental[i].data.R = color;
                } else if (idPolygon === "L") {
                    allDental[i].data.L = color;
                }
                console.log(allDental[i]);
            }
        }
    }

    function clickSvg(x){
        var control = $("#controls").children().find('.active').attr('id');
        var idSvg = $(x).parent().attr('id');
        var idPolygon = $(x).attr("id");
        console.log($(x).parent().attr('id'));

        switch (control) {
                case "kariesSuperfisia":
                    
                    if ($(x).attr("fill").toLowerCase() === "yellow") {
                        $(x).attr("fill", "white");
                        updateJsonOdontograma(idSvg, idPolygon, "white");
                    } else {
                        $(x).attr("fill", "yellow");
                        updateJsonOdontograma(idSvg, idPolygon, "yellow");
                    }
                    break;
                case "kariesMedia":
                    if ($(x).attr("fill").toLowerCase() === "orange") {
                        $(x).attr("fill", "white");
                        updateJsonOdontograma(idSvg, idPolygon, "white");
                    } else {
                        $(x).attr("fill", "orange");
                        updateJsonOdontograma(idSvg, idPolygon, "orange");
                    }
                    break;
                case "kariesProfunda":
                    if ($(x).attr("fill").toLowerCase() === "red") {
                        $(x).attr("fill", "white");
                        updateJsonOdontograma(idSvg, idPolygon, "white");
                    } else {
                        $(x).attr("fill", "red");
                        updateJsonOdontograma(idSvg, idPolygon, "red");
                    }
                    break;
                case "kariesProfundaPerfores":
                    if ($(x).attr("fill").toLowerCase() === "gray") {
                        $(x).attr("fill", "white");
                        updateJsonOdontograma(idSvg, idPolygon, "white");
                    } else {
                        $(x).attr("fill", "gray");
                        updateJsonOdontograma(idSvg, idPolygon, "gray");
                    }
                    break;
                case "sisaAkar":
                    if ($(x).attr("fill").toLowerCase() === "purple") {
                        $(x).attr("fill", "white");
                        updateJsonOdontograma(idSvg, idPolygon, "white");
                    } else {
                        $(x).attr("fill", "purple");
                        updateJsonOdontograma(idSvg, idPolygon, "purple");
                    }
                    break;
                case "pitFissuredalam":
                    if ($(x).attr("fill").toLowerCase() === "#6495ed") {
                        $(x).attr("fill", "white");
                        updateJsonOdontograma(idSvg, idPolygon, "white");
                    } else {
                        $(x).attr("fill", "#6495ED");
                        updateJsonOdontograma(idSvg, idPolygon, "#6495ED");
                    }
                    break;
                case "kariesMangkok":
                    if ($(x).attr("fill").toLowerCase() === "blue") {
                        $(x).attr("fill", "white");
                        updateJsonOdontograma(idSvg, idPolygon, "white");
                    } else {
                        $(x).attr("fill", "blue");
                        updateJsonOdontograma(idSvg, idPolygon, "blue");
                    }
                    break;
                case "gigiGoyang":
                    if ($(x).attr("fill").toLowerCase() === "#7fff00") {
                        $(x).attr("fill", "white");
                        updateJsonOdontograma(idSvg, idPolygon, "white");
                    } else {
                        $(x).attr("fill", "#7FFF00");
                        updateJsonOdontograma(idSvg, idPolygon, "#7FFF00");
                    }
                    break;
                case "presistensi":
                    if ($(x).attr("fill").toLowerCase() === "pink") {
                        $(x).attr("fill", "white");
                        updateJsonOdontograma(idSvg, idPolygon, "white");
                    } else {
                        $(x).attr("fill", "pink");
                        updateJsonOdontograma(idSvg, idPolygon, "pink");
                    }
                    break;
                case "tambalanRestoras":
                    if ($(x).attr("fill").toLowerCase() === "black") {
                        $(x).attr("fill", "white");
                        updateJsonOdontograma(idSvg, idPolygon, "white");
                    } else {
                        $(x).attr("fill", "black");
                        updateJsonOdontograma(idSvg, idPolygon, "black");
                    }
                    break;
                 case "tambalanRestoras":
                    if ($(x).attr("fill").toLowerCase() === "black") {
                        $(x).attr("fill", "white");
                        updateJsonOdontograma(idSvg, idPolygon, "white");
                    } else {
                        $(x).attr("fill", "black");
                        updateJsonOdontograma(idSvg, idPolygon, "black");
                    }
                    break;
                 case "gigiHilang":
                    if ($(x).attr("fill").toLowerCase() === "#228b22") {
                        $(x).attr("fill", "white");
                        updateJsonOdontograma(idSvg, idPolygon, "white");
                    } else {
                        $(x).attr("fill", "#228B22");
                        updateJsonOdontograma(idSvg, idPolygon, "#228B22");
                    }
                    break;
                 case "resesiGingiva":
                    if ($(x).attr("fill").toLowerCase() === "brown") {
                        $(x).attr("fill", "white");
                        updateJsonOdontograma(idSvg, idPolygon, "white");
                    } else {
                        $(x).attr("fill", "brown");
                        updateJsonOdontograma(idSvg, idPolygon, "brown");
                    }
                    break;
                      case "karangGigi":
                    if ($(x).attr("fill").toLowerCase() === "#191970") {
                        $(x).attr("fill", "white");
                        updateJsonOdontograma(idSvg, idPolygon, "white");
                    } else {
                        $(x).attr("fill", "#191970");
                        updateJsonOdontograma(idSvg, idPolygon, "#191970");
                    }
                    break;
                default:
                    console.log("borrar case");
            }
            return false;
    }




    function getBidangIlmu(id){

        var selected = "";

        $("#id_bidang_ilmu").html("");

        $.ajax({

            type: "GET",

            url: base_url + "master_bidang_ilmu/getBidangIlmuSelect2",                                    

            cache: false,

            success: function(json) {

                var obj = JSON.parse(json)

                for (var i = 0; i < obj.length; i++) {

                    if(id === obj[i].id){

                        selected = "selected";

                    } else {

                        selected = "";

                    }

                    $("#id_bidang_ilmu").append("<option value='"+obj[i].id+"' "+selected+" data-nama='"+obj[i].nama+"'>"+obj[i].nama+"</option>")

                    // console.log("<option value='"+obj[i].id+"' "+selected+">"+obj[i].nama+"</option>");

                }

                if ($("#id_bidang_ilmu").val() != null || $("#id_bidang_ilmu").val() != undefined) {

                    getKategoriPenyakit($("#id_bidang_ilmu").val(), data_edit.id_penyakit);

                    console.log("ccc: ", $('#id_bidang_ilmu option:selected').attr('data-nama'));

                }



            }

        });

    }



    function getKategoriPenyakit(id, x){

        var selected = "";

        $("#id_penyakit").html("");

        var data_send = "id="+id;

        $.ajax({

            type: "POST",

            url: base_url + "master_penyakit/getPenyakitByBidangIlmuSelect2",                                    

            cache: false,

            data: data_send,

            success: function(json) {

                var obj = JSON.parse(json);

                data_penyakit = obj;

                for (var i = 0; i < obj.length; i++) {

                    if (i == 0) {
                        $("#harga").val(obj[i].harga);
                        $("#harga_detail").val(numberWithCommas(obj[i].harga));
                    }

                    if(x === obj[i].id){

                        selected = "selected";

                        $("#harga").val(obj[i].harga);
                        $("#harga_detail").val(numberWithCommas(obj[i].harga));

                    } else {

                        selected = "";

                    }

                    $("#id_penyakit").append("<option value='"+obj[i].id+"' "+selected+" data-nama='"+obj[i].nama+"'>"+obj[i].nama+"</option>")

                    console.log("<option value='"+obj[i].id+"' "+selected+">"+obj[i].nama+"</option>");

                }

                if ($("#id_penyakit").val() != null || $("#id_penyakit").val() != undefined) {

                    getRencanaPerawatan($("#id_penyakit").val(), data_edit.id_rencana_perawatan);

                }



            }

        });

    }







    function getRencanaPerawatan(id, x){

        var selected = "";

        $("#id_rencana_perawatan").html("");

        var data_send = "id="+id;

        $.ajax({

            type: "POST",

            url: base_url + "master_rencana_perawatan/getRencanaPerawatanByPenyakitSelect2",                                    

            cache: false,

            data: data_send,

            success: function(json) {

                var obj = JSON.parse(json)

                for (var i = 0; i < obj.length; i++) {

                    if(x === obj[i].id){

                        selected = "selected";

                    } else {

                        selected = "";

                    }

                    $("#id_rencana_perawatan").append("<option value='"+obj[i].id+"' "+selected+" data-nama='"+obj[i].nama+"'>"+obj[i].nama+"</option>")

                    console.log("<option value='"+obj[i].id+"' "+selected+">"+obj[i].nama+"</option>");

                }



            }

        });

    }



var tambahDetailPenyakit = function () {

    $("#tgl_rawat").val(moment().format("YYYY-MM-DD"));

    $("#id_detail_rawat").val("undefined");

    $("#modal-title").text("Tambah Detail Rawat");

    $("#remove_detail_foto").trigger("click");

    $("#myModalDetailPenyakit").modal({

             show: 'false',

             backdrop: 'static', 

             keyboard: false

         });

}



function saveDetail() {

    var nama_bidang_ilmu = $('#id_bidang_ilmu option:selected').attr('data-nama');

    console.log("xx: ", $("#fotos")[0].files[0]);

}



function cancelSaveRawat() {

	window.location.href = base_url + 'rawat_history';

}







function saveHeaderRawat() {

    var $validator = $('#formRawatTambah').validate({

        errorPlacement: function(error, element) {

            $(element).parent('div').addClass('has-error');

         }

    });

    var $valid = $('#formRawatTambah').valid();

    if(!$valid) {

        $validator.focusInvalid();

        return false;

    } else {

        var $validDate = isValidDate($("#tgl_lahir_m").val() +"-"+$("#tgl_lahir_d").val() +"-"+ $("#tgl_lahir_y").val());
        if(!$validDate) {
            bootbox.alert("Tanggal lahir yang anda masukkan tidak valid!");
            return false;
        } else {

            console.log("foto pasien: ", $('#pasien_foto_base64_1').val());

            if ($('#pasien_foto_base64_1').val() === "undefined" || $('#pasien_foto_base64_1').val() === "") {
                notifikasi("danger", "Silahkan Tambah Photo Pasien");
                return;
            }
            if ($('#rahang_atas_base64_1').val() === "undefined" || $('#rahang_atas_base64_1').val() === "") {
                notifikasi("danger", "Silahkan Tambah Photo Rahang Atas Pasien");
                return;
            }
            if ($('#rahang_bawah_base64_1').val() === "undefined" || $('#rahang_bawah_base64_1').val() === "") {
                notifikasi("danger", "Silahkan Tambah Photo Rahang Bawah Pasien");
                return;
            }

            $("body").addClass("loading");  

            // $("#tgl_rawat").val(parseDate($("#tgl_rawat").val()));
            var tgl_lahir = $("#tgl_lahir_y").val() +"-"+$("#tgl_lahir_m").val() +"-"+$("#tgl_lahir_d").val();

            console.log($('#formRawatTambah').serialize());

    		$.ajax({

                type: "POST",

                url: base_url + "rawat_tambah/edit_rawat_header",                                    

                cache: false,                               

                data: $('#formRawatTambah').serialize()+"&tgl_rawat=" + $("#tgl_rawat").val() + "&odontogram=" + JSON.stringify(allDental)+"&umur_pasien="+tgl_lahir,

                success: function(json) {
                    $('body').removeClass("loading");
                    var obj = JSON.parse(json);
                    location.reload();
                    if (obj.rc === "0000") {

                        notifikasi("success", obj.message);
                        $("body").addClass("loading");
                        window.setTimeout(function(){
                        
                            // Move to a new location or you can do something else
                           // window.location.href = base_url + 'rawat_history';
                           //window.location.reload();

                        }, 5000);

                    } else {

                        notifikasi("danger", obj.message);

                    }

                },
                complete: function(obj){
                    $('body').removeClass("loading");
                }

            });
        }

    }

}



function saveDetailRawat () {

    var $validator = $('#formDetailPenyakit').validate({

        errorPlacement: function(error, element) {

            $(element).parent('div').addClass('has-error');

         }

    });

    var $valid = $('#formDetailPenyakit').valid();

    if(!$valid) {

        $validator.focusInvalid();

        return false;

    } else {

        var url = "";

        var src_foto = $("#foto_base64").val();

        // $("#tgl_rawat").val(parseDate($("#tgl_rawat").val()));

        // console.log("xx: ", $("#fotos")[0].files[0]);

        

            $("#myModalDetailPenyakit").modal("hide");



            if ($("#id_detail_rawat").val() == "undefined") {

                url = base_url + "rawat_tambah/add_rawat_detail";

            } else {

                url = base_url + "rawat_tambah/edit_rawat_detail";

            }

            $("body").addClass("loading");

            $.ajax({

                type: "POST",

                url: url,                                    

                cache: false,                               

                data: $('#formDetailPenyakit').serialize()+"&id_rawat=" + $("#id_rawat").val()+"&tgl_rawat=" + $("#tgl_rawat").val(),

                success: function(json) {
                    $('body').removeClass("loading");
                    var obj = JSON.parse(json);

                    $("#remove_detail_foto").trigger("click");

                    if (obj.rc === "0000") {

                        notifikasi("success", obj.message);

                        getDetailRawat(obj.id_rawat);
                        getUpdateTotalHargaRawat(obj.id_rawat);
                        

                        // $("#div_detail_penyakit").show();

                        // $("#div_save_header_rawat").hide();



                        // $("#nama_pasien").attr("disabled", "true");

                        // $("#notelp_pasien").attr("disabled", "true");

                        // $("#alamat_pasien").attr("disabled", "true");

                        // $("#tingkat_kooperatif").attr("disabled", "true");

                        // $("#id_rawat").val(obj.id_rawat);

                    } else {

                        notifikasi("danger", obj.message);

                    }

                },
                complete: function(obj){
                    $('body').removeClass("loading");
                }

            });

            

        

    }

}



function deleteRawatDetail(id, id_rawat, nama) {

    bootbox.confirm("Apakah anda yakin untuk menghapus penyakit [' "+nama+" '] dari daftar detail rawat?", function(result) {

      if(result) {

          $.ajax({

                    type: "POST",

                    url: base_url + "rawat_tambah/deleteRawatDetail",                                    

                    cache: false,                               

                    data: JSON.stringify({"id" : id.toString(), "id_rawat": id_rawat.toString()}),

                    success: function(json) {

                        var obj = JSON.parse(json);

                        if (obj.rc === "0000") {

                            notifikasi("success", obj.message);

                            getDetailRawat(id_rawat);

                            getUpdateTotalHargaRawat(id_rawat);

                        } else {

                            notifikasi("danger", obj.message);

                        }

                    },

                    error: function(e) {

                        // console.log("delete_pasien: ", e.responseText);

                        

                    }

                });



      }

    }); 

}



function editDetailRawat(id) {

    if (id != null || id != undefined) {
        $("body").addClass("loading");  

        $.ajax({

            type: "POST",

            url: base_url + "rawat_tambah/getDetailRawatById",                                    

            cache: false,                               

            data: JSON.stringify({"id" : id}),

            success: function(json) {
                $("body").removeClass("loading");  



                $("#modal-title").text("Edit Detail Rawat");

                $("#myModalDetailPenyakit").modal({

                    show: 'false',

                    backdrop: 'static', 

                    keyboard: false

                });

                // console.log('get_user: ', json);

                var obj = JSON.parse(json);

                if (obj.rc === "0000") {

                    data_edit = obj;

                    getBidangIlmu(obj.id_bidang_ilmu);

                    $("#id_detail_rawat").val(obj.id);

                    $("#div_foto_base64").removeClass("fileinput-new");

                    $("#div_foto_base64").addClass("fileinput-exists");

                    $("#div_ada_foto").html("<img src='" + obj.foto + "'>");

                    $("#tgl_rawat").val(obj.tgl_rawat);

                    $("#foto_base64").val(obj.foto);

                    $("#harga").val(obj.harga);
                    $("#harga_detail").val(obj.harga);

                    // $("#fotos")[0].val(obj.foto);

                    // console.log($("#tgl_rawat"));

                    // $("#fotos")[0].files[0].result = obj.foto;

                    // if ($("#fotos")[0].files[0] !== undefined) {



                    //     getBase64($("#fotos")[0].files[0]);

                    // }

                    // $("#nama").val(obj.nama);

                    // edit_datepicker(toDate(obj.tgl_lahir));

                    // $("#no_telp").val(obj.no_telp);

                    // $("#alamat").val(obj.alamat);

                    // $('#jenis_kelamin option[value='+obj.jenis_kelamin+']').attr('selected', 'selected');

                } else {

                    notifikasi("danger", obj.message);

                }

            }

        });

    }

}



function getDetailRawat(id){

    var data_send = "id="+id;

    $.ajax({

        type: "POST",

        url: base_url + "rawat_tambah/getDetailRawat",                                    

        cache: false,

        data: data_send,

        success: function(json) {

            // console.log('json: ', json);

           $("#datatables-detail-rawat").html(json);

           // $('#datatables').DataTable().destroy();

           // $('#datatables').DataTable({

           //      "pagingType": "full_numbers",

           //      "lengthMenu": [

           //          [10, 25, 50, -1],

           //          [10, 25, 50, "All"]

           //      ],

           //      responsive: true,



           //      language: {

           //          search: "_INPUT_",

           //          searchPlaceholder: "Search records",

           //      },



           //  });

        }

    });

}

function getUpdateTotalHargaRawat(id_rawat){


    $.ajax({

        type: "POST",

        url: base_url + "rawat_tambah/getTotalHarga",                                    

        cache: false,

        data: JSON.stringify({"id_rawat" : id_rawat}),

        success: function(json) {

            var obj = JSON.parse(json);
            if (obj.total_harga) {
                $("#total_harga_hide").val(numberWithCommas(obj.total_harga));
                $("#harga_total").val(obj.total_harga);
            }
        }

    });

}




function notifikasi(jenis, data) {



    $.notify({

        icon: "notifications",

        message: data



    }, {

        type: jenis,

        timer: 3000,

        placement: {

            from: "top",

            align: "right"

        }

    });

}



function parseDate(s) {

console.log(s);

  var months = {jan:"01",feb:"02",mar:"03",apr:"04",may:"05",jun:"06",

                jul:"07",aug:"08",sep:"09",oct:"10",nov:"11",dec:"12"};

  var p = s.split('-');

  return p[2] + "-" + months[p[1].toLowerCase()] + "-" +  (p[0].length === 1 ? "0"+p[0] : p[0]);

}



function toDate(dateStr) {

    var parts = dateStr.split("-");

    return new Date(parts[0], parts[1] - 1, parts[2]);

}



function getBase64(file) {

    var response = "";

   var reader = new FileReader();

   reader.readAsDataURL(file);

   reader.onload = function (e) {

     response = e.target.result;

     $("#foto_base64").val(response);

   };

   reader.onerror = function (error) {

     notifikasi('danger: ', error);

   };

   return response;

}

function getBase64FotoPasien(file) {

    var response = "";

   var reader = new FileReader();

   reader.readAsDataURL(file);

   reader.onload = function (e) {

     response = e.target.result;

     $("#pasien_foto_base64_1").val(response);

   };

   reader.onerror = function (error) {

     notifikasi('danger: ', error);

   };

   return response;

}

function getBase64RahangAtas(file) {

    var response = "";

  var reader = new FileReader();

  reader.readAsDataURL(file);

  reader.onload = function (e) {

     response = e.target.result;

     $("#rahang_atas_base64_1").val(response);

  };

  reader.onerror = function (error) {

     notifikasi('danger: ', error);

  };

  return response;

}

function getBase64RahangBawah(file) {

    var response = "";

  var reader = new FileReader();

  reader.readAsDataURL(file);

  reader.onload = function (e) {

     response = e.target.result;

     $("#rahang_bawah_base64_1").val(response);

  };

  reader.onerror = function (error) {

     notifikasi('danger: ', error);

  };

  return response;

}

function getBase64Tambahan(file) {

    var response = "";

  var reader = new FileReader();

  reader.readAsDataURL(file);

  reader.onload = function (e) {

     response = e.target.result;

     $("#tambahan_base64_1").val(response);

  };

  reader.onerror = function (error) {

     notifikasi('danger: ', error);

  };

  return response;

}

function validatePhone(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode( key );
    var regex = /[0-9]/;
    if( !regex.test(key) ) {
        theEvent.returnValue = false;
        if(theEvent.preventDefault) theEvent.preventDefault();
    }
}


function isValidDate(date)
{
    var matches = /^(\d{1,2})[-\/](\d{1,2})[-\/](\d{4})$/.exec(date);
    if (matches == null) return false;
    var d = matches[2];
    var m = matches[1] - 1;
    var y = matches[3];
    var composedDate = new Date(y, m, d);
    return composedDate.getDate() == d &&
            composedDate.getMonth() == m &&
            composedDate.getFullYear() == y;
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}