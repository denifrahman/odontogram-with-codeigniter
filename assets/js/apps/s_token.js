var table_user;
var kode = "", nama = "";
var current_saldo = 0;
app_s_token = {
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
        //     "url": base_url + "sToken/getSaldo",
        //     "type": "POST"
        // }

    });

    $('.card .material-datatables label').addClass('form-group');

    setFormValidation('#fomrSaldo');
    getSaldoUser();

}


var addSaldo = function (nama_user, saldo, to_user) {
    clearModal();
    unsetFormValidation();
    $("#id").val(to_user);
    $("#id_admin").val(id_user);
    $("#p_current_saldo").html("Saldo anda saat ini <strong>Rp. "+numberWithCommas(current_saldo)+"</strong>");
    $("#p_user_saldo").html(nama_user+" sisa saldo <strong>Rp. "+numberWithCommas(saldo)+"</strong>")
	$("#modal-title").text("Penambahan Saldo");
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
    $("#nominal").val("");
    $("#id").val("undefined");
    $("#id_admin").val("undefined");
    unsetLabelStatic("#fomrSaldo")
}

function saveSaldo(){
    var $validator = $('#fomrSaldo').validate({
        errorPlacement: function(error, element) {
            $(element).parent('div').addClass('has-error');
         }
    });
    // if ($('#kode').valid() && $('#nama').valid()) {
        // var data_send = "?nama=" + $('#nama').val() + "&username=" +$("username")+ "&password=" +$("password")+ "&no_telp=" +
                        // $("no_telp")+ "&alamat=" +$("alamat")+ "&role=" +$("role")+ "&jenis_kelamin=" +$("jenis_kelamin")
        var $valid = $('#fomrSaldo').valid();
        if(!$valid) {
            $validator.focusInvalid();
            return false;
        } else {
            var url = base_url + "sToken/allocate_deposit";

            $('#myModal').modal('hide');
            $.ajax({
                    type: "POST",
                    url: url,                                    
                    cache: false,                               
                    data: $("#fomrSaldo").serialize(),
                    success: function(json) {
                        var obj = JSON.parse(json);
                        if (obj.rc === "0000") {
                            unsetLabelStatic("#fomrSaldo");
                            notifikasi("success", obj.message);
                            getSaldoUser();
                            getSaldo();
                        } else {
                            notifikasi("danger", obj.message);
                        }
                    }
                });
        // }
    }
}

function getSaldo(){
    $.ajax({
        type: "GET",
        url: base_url + "sToken/getSaldo",                                    
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

function getSaldoUser(){
    console.log('id_user: ', id_user);
    $.ajax({
        type: "POST",
        url: base_url + "sToken/get_saldo_user",
        data: JSON.stringify({"id_user" : id_user}),                                 
        cache: false,
        success: function(json) {
            // console.log('json: ', json);
            var obj = JSON.parse(json);
            if (obj.rc === "0000") {
                $("#current_my_saldo").text("Rp. "+numberWithCommas(obj.saldo));
                current_saldo = obj.saldo;
            }
        }
    });
}

function viewMutasi(id){

    if (id != null || id != undefined) {

        window.location.href = base_url + 'sToken/index_mutasi/'+id;

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

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}