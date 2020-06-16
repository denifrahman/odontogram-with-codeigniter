var table_user;

app_rawat_verifikasi     = {

	init: function () {

		loaded();

	}

}



var loaded = function(){

	$('.datepicker').datetimepicker({

	        format: 'YYYY-MM-DD',

			keyBinds: false,

	        icons: {

	            time: "fa fa-clock-o",

	            date: "fa fa-calendar",

	            up: "fa fa-chevron-up",

	            down: "fa fa-chevron-down",

	            previous: 'fa fa-chevron-left',

	            next: 'fa fa-chevron-right',

	            today: 'fa fa-screenshot',

	            clear: 'fa fa-trash',

	            close: 'fa fa-remove'

	        }

	    });



	    $("#fromDate").on("dp.change", function (e) {

			console.log(e.date);

			$('#toDate').data("DateTimePicker").minDate(e.date).format('YYYY-MM-DD').defaultDate(e.date).keyBinds(false);

		});



		$("#toDate").data("DateTimePicker").minDate($("#fromDate").val());



        $('#datatables').DataTable({

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


function getRawat(){

	var dari = $("#fromDate").val();

	var sampai = $("#toDate").val();

    $.ajax({

        type: "POST",

        url: base_url + "rawat_verifikasi/getRawat",                                    

        cache: false,              

        data: JSON.stringify({"dari" : dari, "sampai" : sampai}),

        success: function(json) {

            // console.log('json: ', json);

           $("#datatables").html(json);

           $('#datatables').DataTable().destroy();

           $('#datatables').DataTable({

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



function verifikasiPasien(id, tipe){

    if (id != null || id != undefined) {
        $("#myModal").modal({
            show: 'false',
            backdrop: 'static', 
            keyboard: false
        });
        $("#row-loading").show();
        $("#row-odonto").hide();

        $.ajax({
            type: "POST",
            url: base_url + "rawat_verifikasi/getDetailPasien",                                 
            cache: false,                               
            data: JSON.stringify({
                "id" : id
                }),
            success: function(json) {
                var isi_foto = "";
                var obj = JSON.parse(json);

                viewOdonto(JSON.parse(obj.odontogram));
                $("#row-loading").hide();
                $("#row-odonto").show();
                $("#nama_pasien").val(obj.nama_pasien);
                $("#diagnosa").val(obj.nama_penyakit);
                $("#tgl_rawat_header").val(obj.tgl_rawat);
                $("#tgl_lahir").val(obj.umur_pasien);
                //image_placeholder.jpg
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
                
                
                console.log(obj.verifikasi);

                if (obj.verifikasi == 0) {
                    $("#footer_detail_pasien").html('<button type="button" class="btn btn-info btn-fill" id="verifikasi" onclick="updateVerifikasi('+"'yes', " + obj.id + ');">Verifikasi Data</button>'+
                                                '<button type="button" class="btn btn-danger btn-fill" data-dismiss="modal">Close</button>');
                } else if (obj.verifikasi == 1) {
                    $("#footer_detail_pasien").html('<button type="button" class="btn btn-warning btn-fill" id="unVerifikasi" onclick="updateVerifikasi('+"'no', " + obj.id + ');">Batalkan Verifikasi Data</button>'+
                                                '<button type="button" class="btn btn-danger btn-fill" data-dismiss="modal">Close</button>');
                }

                if (tipe == "detail") {
                    $("#footer_detail_pasien").html('<button type="button" class="btn btn-danger btn-fill" data-dismiss="modal">Close</button>');
                }
            }

        });

    }

}



function updateVerifikasi(action, id){
    if (id != undefined) {
        console.log(action, id);
        $('#myModal').modal('hide');
        $.ajax({
            type: "POST",
            url: base_url + "rawat_verifikasi/update_verifikasi",                                 
            cache: false,                               
            data: JSON.stringify({
                "id" : id,
                "action" : action
                }),
            success: function(json) {

                var obj = JSON.parse(json);
                if (obj.rc === "0000") {
                    notifikasi("success", obj.message);
                    getRawat();
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
                $("#div-foto-pasien").html('<img src="'+obj.foto+'" width="200px">');
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