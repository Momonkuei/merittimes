// http://stackoverflow.com/questions/1990512/add-comma-to-numbers-every-three-digits-using-jquery
// $("span.numbers").digits();
// 1000 => 1,000
$.fn.digits = function(){ 
    return this.each(function(){ 
        $(this).text( $(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") ); 
    })
}

