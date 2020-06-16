var table_user;
app_rawat_pilih = {
	init: function () {
		loaded();
	}
}

var loaded = function(){
	

	$('#tablePilihanPasien').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [
            [1 -1],
            [1]
        ],
        responsive: true,

        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
        },

    });

    
    $('#pasienTerpilih').DataTable({
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

    $('.card .material-datatables label').addClass('form-group');


    $(document).on('click', '.pilih-penyakit', function (e) {
    	$("#div_penyakit").addClass("label-static");
        $("#penyakit_nama").val($(this).attr('data-nama'));
        $("#penyakit_id").val($(this).attr('data-id'));
        $('#myModalPenyakit').modal('hide');
    });

}


var lookupPenyakit = function () {
	$.ajax({
        type: "GET",
        url: base_url + "rawat_tambah/lookupPenyakit",                                    
        cache: false,
        success: function(json) {
            // console.log('json: ', json);
           $("#myModalPenyakit").modal({
		        show: 'false',
		        backdrop: 'static', 
		        keyboard: false
		    });

           $("#datatablesPenyakit").html(json);
           $('#datatablesPenyakit').DataTable().destroy();
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
        }
    });
	
};

function cancelCari() {
	$("#div_penyakit").removeClass("label-static");
	$("#penyakit_id").val("undefined");
	$("#penyakit_nama").val("");
}

function cariPasien() {
	if ($("#penyakit_id").val() === "undefined") {
		bootbox.alert("Pilihlah Diagnosa terlebih dahulu!");
	} else {
		$.ajax({
	        type: "POST",
	        url: base_url + "rawat_pilih/getPasien",                                    
	        cache: false,                               
	        data: JSON.stringify({"id_penyakit" : $("#penyakit_id").val()}),
	        success: function(json) {
	            $("#tablePilihanPasien").html(json);
	            $('#tablePilihanPasien').DataTable().destroy();
	            $('#tablePilihanPasien').DataTable({
	                "pagingType": "full_numbers",
	                "lengthMenu": [
	                    
	                ],
	                responsive: true,

	                language: {
	                    search: "_INPUT_",
	                    searchPlaceholder: "Search records",
	                },

	            });
	        }
	    });
	}
}

function getPasienTerpilih() {
	$.ajax({
        type: "GET",
        url: base_url + "rawat_pilih/getPasienTerpilih",                                    
        cache: false,
        success: function(json) {
            $("#pasienTerpilih").html(json);
            $('#pasienTerpilih').DataTable().destroy();
            $('#pasienTerpilih').DataTable({
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
        }
    });
}

function clearCari() {



    $("#penyakit_id").val("");

   

}
function pilihPasien(id) {
	$.ajax({
        type: "POST",
        url: base_url + "rawat_pilih/pilihPasien",                                    
        cache: false,                               
        data: JSON.stringify({"id" : id}),
        success: function(json) {
            var obj = JSON.parse(json);
            if (obj.rc === "0000") {
                notifikasi("success", obj.message);
                getPasienTerpilih();
                clearCari();
                cariPasien();
            } else {
                notifikasi("danger", obj.message);
            }
        }
    });
}

function editPasienTerpilih(x) {
	if (x != null || x != undefined) {
		$.ajax({
            type: "POST",
            url: base_url + "rawat_pilih/get_rawat_by_id",                                    
            cache: false,                               
            data: JSON.stringify({"id" : x}),
            success: function(json) {
                // console.log('get_rawat: ', json);
                var obj = JSON.parse(json);
                if (obj.rc === "0000") {
	                $("#myModalEdit").modal({
	                    show: 'false',
	                    backdrop: 'static', 
	                    keyboard: false
	                });
                    $("#id").val(obj.id);
                    $("#nama_pasien").val(obj.nama_pasien);
                    $("#nama_penyakit").val(obj.nama_penyakit);
                    $("#tgl_rawat").val(obj.tgl_rawat);
                } else {
                    notifikasi("danger", obj.message);
                }
            }
        });
	}
}

function saveUpdateRawat(){
	if ($("#id").val() != "undefined") {
		$('#myModalEdit').modal('hide');
        $.ajax({
            type: "POST",
            url: base_url + "rawat_pilih/update_pasien_terpilih",                                 
            cache: false,                               
            data: JSON.stringify({
            	"id" : $("#id").val(),
            	"action" : $("#action").val()
        		}),
            success: function(json) {

                var obj = JSON.parse(json);
                if (obj.rc === "0000") {
                    notifikasi("success", obj.message);
                    getPasienTerpilih();
                } else {
                    notifikasi("danger", obj.message);
                }
            }
        });
	}
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

function detailOdontoPasien(id){
    if (id != undefined || id != null) {
        $("#myModalDetailOdonto").modal({
            show: 'false',
            backdrop: 'static', 
            keyboard: false
        });
        $("#row-loading").show();
        $("#row-odonto").hide();
        $.ajax({
            type: "POST",
            url: base_url + "rawat_pilih/get_detail_odonto_by_id",                                 
            cache: false,                               
            data: JSON.stringify({
                "id" : id
                }),
            success: function(json) {

                var obj = JSON.parse(json);

                
                if (obj.foto_pasien != "") {
                    $("#div-foto-pasien").html('Foto Pasien<br><img src="'+base_url+"assets/img/pasien/"+obj.foto_pasien+'" width="200px">');    
                } else {
                    $("#div-foto-pasien").html('Foto Pasien<br><img src="'+base_url+'assets/img/image_placeholder.jpg" width="200px">');
                }
                
                if (obj.rahang_atas != "") {
                    $("#div-foto-rahang-atas").html('Rahang Atas<br><img src="'+base_url+"assets/img/pasien/"+obj.rahang_atas+'" width="200px">');
                } else {
                    $("#div-foto-rahang-atas").html('Rahang Atas<br><img src="'+base_url+'assets/img/image_placeholder.jpg" width="200px">');
                }

                if (obj.rahang_bawah != "") {
                    $("#div-foto-rahang-bawah").html('Rahang Bawah<br><img src="'+base_url+"assets/img/pasien/"+obj.rahang_bawah+'" width="200px">');
                } else {
                    $("#div-foto-rahang-bawah").html('Rahang Bawah<br><img src="'+base_url+'assets/img/image_placeholder.jpg" width="200px">');
                }
                if (obj.tambahan != "") {
                    $("#div-foto-tambahan").html('Tambahan<br><img src="'+base_url+"assets/img/pasien/"+obj.tambahan+'" width="200px">');
                } else {
                    $("#div-foto-tambahan").html('Tambahan<br><img src="'+base_url+'assets/img/image_placeholder.jpg" width="200px">');
                }               

                viewOdonto(JSON.parse(obj.odontogram));
                $("#row-loading").hide();
                $("#row-odonto").show();
            }

        });
    }
}

function viewOdonto(data){

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
                        '<polygon points="5,5   15,5    15,15   5,15" fill="'+data[i].data.C+'" stroke="navy" stroke-width="0.5" id="C" opacity="1"></polygon>' +
                        '<polygon points="0,0   20,0    15,5    5,5" fill="'+data[i].data.T+'" stroke="navy" stroke-width="0.5" id="T" opacity="1"></polygon>' +
                        '<polygon points="5,15  15,15   20,20   0,20" fill="'+data[i].data.B+'" stroke="navy" stroke-width="0.5" id="B" opacity="1"></polygon>' +
                        '<polygon points="15,5  20,0    20,20   15,15" fill="'+data[i].data.R+'" stroke="navy" stroke-width="0.5" id="R" opacity="1"></polygon>' +
                        '<polygon points="0,0   5,5     5,15    0,20" fill="'+data[i].data.L+'" stroke="navy" stroke-width="0.5" id="L" opacity="1"></polygon>' +
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

function detailOdontoPasienTerpilih(id)
{
    $("#myModalDetailOdontoTerpilih").modal({
        show: 'false',
        backdrop: 'static', 
        keyboard: false
    });
    $("#row-loading-terpilih").show();
    $("#row-detail").hide();

    $.ajax({
        type: "GET",
        url: base_url + "rawat_history/printPasien/"+id+"/detail",                                    
        cache: false,                               
        success: function(json) {
            if (json) {
               $("#row-detail").html(json);
            } else {
                notifikasi("danger", "Gagal Print Pasien");
            }
            $("#row-loading-terpilih").hide();
            $("#row-detail").show();
        }
    });
}


function printPasien(elem)
{
    // $.ajax({
    //     type: "GET",
    //     url: base_url + "rawat_history/printPasien/"+elem+"/print",                                    
    //     cache: false,                               
    //     success: function(json) {
    //         if (json) {
    //            Popup(json);
    //         } else {
    //             notifikasi("danger", "Gagal Print Pasien");
    //         }
    //     }
    // });
    
    var win = window.open(base_url + "rawat_history/pagePrintPasien/"+elem+"/print", '_blank');
    win.focus();
}

function Popup(data) 
{
    var mywindow = window.open('', 'print pasien', 'height=600,width=700');
    mywindow.document.write('<html><head><title>print pasien</title>');
    /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
    mywindow.document.write('</head><body >');
    mywindow.document.write(data);
    mywindow.document.write('</body></html>');

    mywindow.print();
    mywindow.close();

    return true;
}