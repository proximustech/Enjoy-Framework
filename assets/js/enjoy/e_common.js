

function euiOpenWindow(window){

    if ($('#'+window).data("kendoWindow")) {
        $('#'+window).data("kendoWindow").open();
    }

}

function loadAjaxContent(url,container){

    $.ajax({
        url: url,
        type: "GET",
        dataType: "html" ,

    }).done( function( result ) { 
        if (container !== "") {
            $('#'+container).html(result);
        }
    }); 
}

function RemoveRougeChar(convertString){
    
    if(convertString.substring(0,1) == ","){
        return convertString.substring(1, convertString.length)            
    }
    return convertString;
    
}

$(document).ready(function(){

    $('.eui_textBox.number').on('keyup focus',function(event){
        // skip for arrow keys
        if(event.which >= 37 && event.which <= 40){
            event.preventDefault();
        }
        var $this = $(this);

        //var numArray=num.match(/(\d+)(\.\d+)?/);
        var numArray=$this.val().split(".");

        var firstNum = numArray[0].replace(/,/gi, "").split("").reverse().join("");

        secondNum="";
        if(numArray.length==2)secondNum='.'+numArray[1];

        var num2 = RemoveRougeChar(firstNum.replace(/(.{3})/g,"$1,").split("").reverse().join(""));

        // the following line has been simplified. Revision history contains original.
        $this.val(num2+secondNum);
    });

});
