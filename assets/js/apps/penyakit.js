var table_user;
var kode = "", nama = "";
app_master_penyakit = {
	init: function () {
		loaded();
	}
}

var loaded = function(){
	table_user = $('#datatables').DataTable({
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
        // "ajax": {
        //     "url": base_url + "master_penyakit/getPenyakit",
        //     "type": "POST"
        // }

    });

    $('.card .material-datatables label').addClass('form-group');

    setFormValidation('#fomrMasterPenyakit');

    $( ".select2-single" ).select2( {
		theme: "bootstrap",
		placeholder: "Pilih Bidang Ilmu",
		maximumSelectionSize: 6,
		width: null,
		containerCssClass: ':all:'
	});

	// getKategoriPenyakit();

    // $('#fomrMasterPenyakit input').on('keyup blur', function () {
    //     if ($('#nama').valid() && $('#username').valid() && $('#password').valid()  && $('#no_telp').valid() && $('#alamat').valid()) {
    //     // if ($('#fomrMasterPenyakit').valid()) {
    //         $('#simpanUser').prop('disabled', false);
    //     } else {
    //         $('#simpanUser').prop('disabled', 'disabled');
    //     }
    // });
}

function getKategoriPenyakit(id){
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
	            $("#id_bidang_ilmu").append("<option value='"+obj[i].id+"' "+selected+">"+obj[i].nama+"</option>")
	            console.log("<option value='"+obj[i].id+"' "+selected+">"+obj[i].nama+"</option>");
            }
        }
    });
}

var addPenyakit = function () {
    clearModal();
    unsetFormValidation();
	$("#modal-title").text("Tambah Diagnosa");
	$("#myModal").modal({
        show: 'false',
        backdrop: 'static', 
        keyboard: false
    });
};

function setFormValidation(id) {
    $(id).validate({
        errorPlacement: function(error, element) {
            $(element).closest('div').addClass('has-error');
        }
    });
}

 
function setLabelStatic(id) {
    $(id+ ' div').addClass('label-static');
}

function unsetLabelStatic(id) {
    $(id+ ' div').removeClass('label-static');
}

function unsetFormValidation() {
    $('input').removeClass('error');
    $('div').removeClass('has-error');
}

function clearModal() {
    $("#nama").val("");
    $("#kode").val("");
    $("#harga").val("");
    $("#id").val("undefined");
    unsetLabelStatic("#fomrMasterPenyakit")
}

function deletePenyakit(id, nama) {
    bootbox.confirm("Apakah anda yakin untuk menghapus master penyakit [' "+nama+" ']?", function(result) {
      if(result) {
          $.ajax({
                    type: "POST",
                    url: base_url + "master_penyakit/delete_penyakit",                                    
                    cache: false,                               
                    data: JSON.stringify({"id" : id}),
                    success: function(json) {
                        var obj = JSON.parse(json);
                        if (obj.rc === "0000") {
                            notifikasi("success", obj.message);
                            getPenyakit();
                        } else {
                            notifikasi("danger", obj.message);
                        }
                    }
                });

      }
    }); 
}

function editPenyakit(id) {
    if (id != null || id != undefined) {
        $.ajax({
            type: "POST",
            url: base_url + "master_penyakit/get_penyakit_by_id",                                    
            cache: false,                               
            data: JSON.stringify({"id" : id}),
            success: function(json) {
                $("#modal-title").text("Edit Penyakit");
                $("#myModal").modal({
                    show: 'false',
                    backdrop: 'static', 
                    keyboard: false
                });
                // console.log('get_user: ', json);
                var obj = JSON.parse(json);
                if (obj.rc === "0000") {
                    setLabelStatic("#fomrMasterPenyakit");
                    $("#id").val(obj.id);
                    $("#nama").val(obj.nama);
                    $("#kode").val(obj.kode);
                    // $("#harga").val(obj.harga);
                    // getKategoriPenyakit(obj.id_bidang_ilmu);
                    kode = obj.kode;
                    nama = obj.nama;
                } else {
                    notifikasi("danger", obj.message);
                }
            }
        });
    }
}

function savePenyakit(){
    var $validator = $('#fomrMasterPenyakit').validate({
        errorPlacement: function(error, element) {
            $(element).parent('div').addClass('has-error');
         }
    });
    // if ($('#kode').valid() && $('#nama').valid()) {
        // var data_send = "?nama=" + $('#nama').val() + "&username=" +$("username")+ "&password=" +$("password")+ "&no_telp=" +
                        // $("no_telp")+ "&alamat=" +$("alamat")+ "&role=" +$("role")+ "&jenis_kelamin=" +$("jenis_kelamin")
        var $valid = $('#fomrMasterPenyakit').valid();
        if(!$valid) {
            $validator.focusInvalid();
            return false;
        } else {
            var url = "";
            if ($("#id").val() == "undefined") {
                url = base_url + "master_penyakit/add_penyakit";
            } else {
                url = base_url + "master_penyakit/edit_penyakit";
            }
            $('#myModal').modal('hide');
            console.log("select2: ", $("#id_kategori_penyakit").val());
            console.log('data: ', $("#fomrMasterPenyakit").serialize() + "&kode_lama=" + encodeURIComponent(kode) + "&nama_lama=" + encodeURIComponent(nama));
            $.ajax({
                    type: "POST",
                    url: url,                                    
                    cache: false,                               
                    data: $("#fomrMasterPenyakit").serialize() + "&kode_lama=" + encodeURIComponent(kode) + "&nama_lama=" + encodeURIComponent(nama),
                    success: function(json) {
                        var obj = JSON.parse(json);
                        if (obj.rc === "0000") {
                            unsetLabelStatic("#fomrMasterPenyakit");
                            notifikasi("success", obj.message);
                            getPenyakit();
                        } else {
                            notifikasi("danger", obj.message);
                        }
                    }
                });
        // }
    }
}

function getPenyakit(){
    $.ajax({
        type: "GET",
        url: base_url + "master_penyakit/getPenyakit",                                    
        cache: false,
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