var xhr = new XMLHttpRequest();
var result,final = [];
xhr.onreadystatechange = function(){
    if(xhr.readyState == 4){
        result = xhr.responseText;

}
xhr.open('GET', 'http://localhost/phpTest/api/json/countries.php', true)
xhr.send()
result = JSON.parse(result)
result = JSON.parse(result)
var  keys = new Object.keys(result);
keys.forEach((elt)=>{
    final.push(result[elt])
})