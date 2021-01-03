var hash = location.hash.substring(1).split("&");
var result = {};
    
for (var i = 0; i < hash.length; i++) {
    var element = hash[i].split("=");
    result[element[0]] = element[1];
};

result = "<pre>" + JSON.stringify(result, null, 4) + "</pre>";
document.write(result);