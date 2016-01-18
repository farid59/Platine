$(document).ready(function(){
    $("th[data-sortby]").each(function(){
        $(this).click(function(){
            var sortby = $(this).attr("data-sortby");
            var order = ($(this).hasClass("sorting_asc") ? "DESC" : "ASC");

            var orderByIsSet = false;
            var orderIsSet = false;

            var origin = window.location.origin;
            var path = window.location.pathname;
            var paramsString = window.location.search.substr(1);

            var paramsSplits = paramsString.split("&");
            var params = [];

            for (index in paramsSplits) {
                var param = {
                    "name" : paramsSplits[index].split('=')[0],
                    "value": paramsSplits[index].split('=')[1]
                }

                if (paramsSplits[index].split('=')[0] === "orderby") {
                    param["value"] = sortby;
                    orderByIsSet = true;
                }
                else if (paramsSplits[index].split('=')[0] === "order") {
                    param["value"] = order;
                    orderIsSet = true;
                }

                params.push(param);
            }

            if (!orderByIsSet) {
                params.push({"name" : "orderby", "value" : sortby});
                orderByIsSet = true;
            }

            if (!orderIsSet) {
                params.push({"name" : "order", "value" : order});
                orderIsSet = true;
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