var table_user;

app_user = {

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

        //     "url": base_url + "master_user/getUser",

        //     "type": "POST"

        // }



    });



    $('.card .material-datatables label').addClass('form-group');



    setFormValidation('#fomrMasterUser');



    // $('#fomrMasterUser input').on('keyup blur', function () {

    //     if ($('#nama').valid() && $('#username').valid() && $('#password').valid()  && $('#no_telp').valid() && $('#alamat').valid()) {

    //     // if ($('#fomrMasterUser').valid()) {

    //         $('#simpanUser').prop('disabled', false);

    //     } else {

    //         $('#simpanUser').prop('disabled', 'disabled');

    //     }

    // });

}



var addUser = function () {

    clearModal();

    unsetFormValidation();

	$("#modal-title").text("Tambah User");

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

    $("#username").removeAttr("disabled");

    $("#nama").val("");

    $("#username").val("");

    $("#id").val("undefined");

    $("#password").val("");

    $("#no_telp").val("");

    $("#alamat").val("");

    unsetLabelStatic("#fomrMasterUser")

}



function deleteUser(id, nama) {

    bootbox.confirm("Apakah anda yakin untuk menghapus user [' "+nama+" ']?", function(result) {

      if(result) {

          $.ajax({

                    type: "POST",

                    url: base_url + "master_user/delete_user",                                    

                    cache: false,                               

                    data: JSON.stringify({"id" : id}),

                    success: function(json) {

                        var obj = JSON.parse(json);

                        if (obj.rc === "0000") {

                            notifikasi("success", obj.message);

                            getUser();

                        } else {

                            notifikasi("danger", obj.message);

                        }

                    }

                });



      }

    }); 

}



function editUser(id) {

    if (id != null || id != undefined) {

        $.ajax({

            type: "POST",

            url: base_url + "master_user/get_user_by_id",                                    

            cache: false,                               

            data: JSON.stringify({"id" : id}),

            success: function(json) {

                $("#modal-title").text("Edit User");

                $("#myModal").modal({

                    show: 'false',

                    backdrop: 'static', 

                    keyboard: false

                });

                // console.log('get_user: ', json);

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

            $('#myModal').modal('hide');

            $.ajax({

                    type: "POST",

                    url: url,                                    

                    cache: false,                               

                    data: $("#fomrMasterUser").serialize(),

                    success: function(json) {



                        clearModal();

                        var obj = JSON.parse(json);

                        if (obj.rc === "0000") {

                            unsetLabelStatic("#fomrMasterUser");

                            notifikasi("success", obj.message);

                            getUser();

                        } else {

                            notifikasi("danger", obj.message);

                        }

                    }

                });

        }

    // }

}



function getUser(){

    $.ajax({

        type: "GET",

        url: base_url + "master_user/getUser",                                    

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