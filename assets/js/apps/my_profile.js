var table_user;
app_profile = {
	init: function () {
		loaded();
	}
}

var loaded = function(){
	editUser(id_user);

    $('.card .material-datatables label').addClass('form-group');

    setFormValidation('#fomrMasterUser');
    setLabelStatic('#fomrMasterUser');
}

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
    $("#username").attr("disabled", "true");
    $("#nama").val("");
    $("#username").val("");
    $("#id").val("undefined");
    $("#password").val("");
    $("#no_telp").val("");
    $("#alamat").val("");
    setLabelStatic("#fomrMasterUser")
}

function editUser(id) {
    if (id != null || id != undefined) {
        $.ajax({
            type: "POST",
            url: base_url + "master_user/get_user_by_id",                                    
            cache: false,                               
            data: JSON.stringify({"id" : id}),
            success: function(json) {
                console.log('get_user: ', json);
                var obj = JSON.parse(json);
                if (obj.rc === "0000") {
                    setLabelStatic("#fomrMasterUser");
                    $("#id").val(obj.id);
                    $("#nama").val(obj.nama);
                    $("#username").val(obj.username);
                    $("#password").val(obj.password);
                    $("#no_telp").val(obj.no_telp);
                    $("#alamat").val(obj.alamat);
                    $('#jenis_kelamin option[value='+obj.jenis_kelamin+']').attr('selected', 'selected');
                    $('#role option[value='+obj.role+']').attr('selected', 'selected');

                    $("#username").attr("disabled", "true");
                } else {
                    notifikasi("danger", obj.message);
                }
            }
        });
    }
}

function saveUser(){
    var $validator = $('#fomrMasterUser').validate({
        errorPlacement: function(error, element) {
            $(element).parent('div').addClass('has-error');
         }
    });
    // if ($('#nama').valid() && $('#username').valid() && $('#password').valid()  && $('#no_telp').valid() && $('#alamat').valid()) {
        // var data_send = "?nama=" + $('#nama').val() + "&username=" +$("username")+ "&password=" +$("password")+ "&no_telp=" +
                        // $("no_telp")+ "&alamat=" +$("alamat")+ "&role=" +$("role")+ "&jenis_kelamin=" +$("jenis_kelamin")
        var $valid = $('#fomrMasterUser').valid();
        if(!$valid) {
            $validator.focusInvalid();
            return false;
        } else {
            var url = "";
            if ($("#id").val() == "undefined") {
                url = base_url + "master_user/add_user";
            } else {
                url = base_url + "master_user/edit_user";
            }
            $.ajax({
                    type: "POST",
                    url: url,                                    
                    cache: false,                               
                    data: $("#fomrMasterUser").serialize(),
                    success: function(json) {

                        // clearModal();
                        var obj = JSON.parse(json);
                        if (obj.rc === "0000") {
                            unsetLabelStatic("#fomrMasterUser");
                            notifikasi("success", obj.message);
                            editUser(id_user);
                        } else {
                            notifikasi("danger", obj.message);
                        }
                    }
                });
        }
    // }
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