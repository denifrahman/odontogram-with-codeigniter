var table_user;
app_pasien = {
	init: function () {
		loaded();
	}
}

var loaded = function(){
	$('.datepicker').datetimepicker({
        format: 'DD-MMM-YYYY',
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

    });

    $('.card .material-datatables label').addClass('form-group');

    setFormValidation('#fomrMasterPasien');
    setLabelStatic("#fomrMasterPasien");

    // $('#fomrMasterPasien input').on('keyup blur', function () {
    //     if ($('#nama').valid() && $('#username').valid() && $('#password').valid()  && $('#no_telp').valid() && $('#alamat').valid()) {
    //     // if ($('#fomrMasterPasien').valid()) {
    //         $('#simpanUser').prop('disabled', false);
    //     } else {
    //         $('#simpanUser').prop('disabled', 'disabled');
    //     }
    // });
}

var addPasien = function () {
    clearModal();
    unsetFormValidation();
	$("#modal-title").text("Tambah Diagnosa Pasien");
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
	$("#div_tgl_lahir").addClass("label-static");
}

function unsetFormValidation() {
    $('input').removeClass('error');
    $('div').removeClass('has-error');
}

function clearModal() {
	$("#div_tgl_lahir").addClass("label-static");
    $("#nama").val("");
    $("#tgl_lahir").val("");
    $("#id").val("undefined");
    $("#no_telp").val("");
    $("#alamat").val("");
    unsetLabelStatic("#fomrMasterPasien")
}

function edit_datepicker(x){
	if (x != null || x != undefined) {
		$('#tgl_lahir').data("DateTimePicker").date(x);
	}
}

function deletePasien(id, nama) {
    bootbox.confirm("Apakah anda yakin untuk menghapus diagnosa [' "+nama+" ']?", function(result) {
      if(result) {
          $.ajax({
                    type: "POST",
                    url: base_url + "master_pasien/delete_pasien",                                    
                    cache: false,                               
                    data: JSON.stringify({"id" : id}),
                    success: function(json) {
                        var obj = JSON.parse(json);
                        if (obj.rc === "0000") {
                            notifikasi("success", obj.message);
                            getPasien();
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

function editPasien(id) {
    if (id != null || id != undefined) {
        $.ajax({
            type: "POST",
            url: base_url + "master_pasien/get_pasien_by_id",                                    
            cache: false,                               
            data: JSON.stringify({"id" : id}),
            success: function(json) {
                $("#modal-title").text("Edit Diagnosa Pasien");
                $("#myModal").modal({
                    show: 'false',
                    backdrop: 'static', 
                    keyboard: false
                });
                // console.log('get_user: ', json);
                var obj = JSON.parse(json);
                if (obj.rc === "0000") {
                    setLabelStatic("#fomrMasterPasien");
                    $("#id").val(obj.id);
                    $("#nama").val(obj.nama);
                    edit_datepicker(toDate(obj.tgl_lahir));
                    $("#no_telp").val(obj.no_telp);
                    $("#alamat").val(obj.alamat);
                    $('#jenis_kelamin option[value='+obj.jenis_kelamin+']').attr('selected', 'selected');
                } else {
                    notifikasi("danger", obj.message);
                }
            }
        });
    }
}

function savePasien(){
    var $validator = $('#fomrMasterPasien').validate({
        errorPlacement: function(error, element) {
            $(element).parent('div').addClass('has-error');
         }
    });
    // if ($('#nama').valid() && $('#tgl_lahir').valid()  && $('#no_telp').valid() && $('#alamat').valid()) {
        var $valid = $('#fomrMasterPasien').valid();
        if(!$valid) {
            $validator.focusInvalid();
            return false;
        } else {

            var url = "";
            if ($("#id").val() == "undefined") {
                url = base_url + "master_pasien/add_pasien";
            } else {
                url = base_url + "master_pasien/edit_pasien";
            }
            $('#myModal').modal('hide');
            $("#tgl_lahir").val(parseDate($("#tgl_lahir").val()));
            $.ajax({
                    type: "POST",
                    url: url,                                    
                    cache: false,                               
                    data: $("#fomrMasterPasien").serialize(),
                    success: function(json) {
                        var obj = JSON.parse(json);
                        if (obj.rc === "0000") {
                            unsetLabelStatic("#fomrMasterPasien");
                            notifikasi("success", obj.message);
                            getPasien();
                        } else {
                            notifikasi("danger", obj.message);
                        }
                    }
                });
        }
    // }
}

function getPasien(){
    $.ajax({
        type: "GET",
        url: base_url + "master_pasien/getPasien",                                    
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