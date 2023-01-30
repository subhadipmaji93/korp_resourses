
(function ($) {
    "use strict";


    // Mineral Weight calculation
    $(document).ready(function(){
        $("#floatingMineralWeight").keyup(function(){
            var gw = parseFloat($('#floatingTotalWeight').val()) || 0;
            var tw = parseFloat($('#floatingTareWeight').val()) || 0;
            var mw = parseFloat(gw - tw).toFixed(3);
            $("#floatingMineralWeight").val(mw);
        });
    });
    

    // Sidebar Toggler
    $('.sidebar-toggler').click(function () {
        $('.sidebar, .content').toggleClass("open");
        return false;
    });


    // Calender
    $('#calender').datetimepicker({
        inline: true,
        format: 'YYYY-MM-DD'
    });

})(jQuery);


// login password toggle
function togglePass() {
    var x = document.getElementById('loginPassword');
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
}

