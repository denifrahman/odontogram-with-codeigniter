var table_user;
app_print_pasien = {
	init: function () {
		loaded();
	}
}

var loaded = function(){

    $.ajax({
        type: "GET",
        url: base_url + "rawat_history/printPasien/"+id_to_print+"/print",                                    
        cache: false,                               
        success: function(json) {
            if (json) {
               $("#div_detail_print").html(json);

               setTimeout(
                function() {
                    Popup($("#div_detail_print").html());
                }, 1000);
            } else {
                notifikasi("danger", "Gagal Print Pasien");
            }
        }
    });

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

function btnPrintPasien() {
    Popup($("#div_detail_print").html());
}

function printPasien(elem)
{
    $.ajax({
        type: "GET",
        url: base_url + "rawat_history/printPasien/"+elem+"/print",                                    
        cache: false,                               
        success: function(json) {
            if (json) {
               Popup(json);
            } else {
                notifikasi("danger", "Gagal Print Pasien");
            }
        }
    });
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