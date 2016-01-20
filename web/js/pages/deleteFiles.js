$(document).ready(function(){
    $(".btn-setting").each(function(){
        $(this).click(function(){
            var atag = $(this);
            $.ajax({
                url    : atag.attr("href"),
                method : "GET",
                success: function(data) {
                    $("#place_delete_form").empty();
                    $("#place_delete_form").append(data);
                    console.log("terminé");
                }
            })
        })
    });
});