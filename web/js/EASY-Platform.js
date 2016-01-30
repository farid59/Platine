$(document).ready(function(){
    $("th[data-sortby]").each(function(){
        $(this).click(function(){
            var sortby = $(this).attr("data-sortby");
            var order = (
                $(this).hasClass("sorting_asc") ? "DESC" :
                $(this).hasClass("sorting_desc") ? "" : "ASC"
            );

            var orderByIsSet = false;
            var orderIsSet = false;

            var origin = window.location.origin;
            var path = window.location.pathname;
            var paramsString = window.location.search.substr(1);

            var paramsSplits = paramsString.split("&");
            var params = [];

            if (paramsString !== "") {
                for (index in paramsSplits) {
                    if ((paramsSplits[index].split('=')[0] !== "orderby") && (paramsSplits[index].split('=')[0] !== "order")) {
                        var param = {
                            "name" : paramsSplits[index].split('=')[0],
                            "value": paramsSplits[index].split('=')[1]
                        }
                        params.push(param);
                    }
                }
            }

            if (order !== "") {
                params.push({"name" : "orderby", "value" : sortby});
                params.push({"name" : "order", "value" : order});
            }

            var newLocation = origin+path+"?";

            for (index in params) {
                var param = params[index];

                newLocation += param.name+"="+param.value;
                if (index < params.length-1) {
                    newLocation += "&";
                }
            }

            window.location.replace(newLocation);
        })
    })
});