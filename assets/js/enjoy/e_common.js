

function loadAjaxContent(url,container){

    $.ajax({
        url: url,
        type: "GET",
        dataType: "html" ,

    }).done( function( result ) { 
        $('#'+container).html(result);
    }); 
}  