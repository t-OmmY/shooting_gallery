$(document).ready(function(){
    $('.isValid').click(function () {
        var fields = $('form').find('input', 'select', 'textarea');
        var valid = true;
        for (var i = 0; i<fields.length; i++){
            valid = valid && (fields[i].value !=='');
        }
        if (!valid){
            alert ('Impossible operation because of an empty field')
        }
        return valid;
    });

});

var n=2;
function plus(){
    newDiv = document.createElement('div');
    newDiv.innerHTML+='<h4>hit '+n+':</h4>X: <input type=number id="id'+n+'" name="hit_'+n+'[x]"><br>Y: <input type=number id="id'+n+'" name="hit_'+n+'[y]">';
    var addPlace = document.getElementById('divf');
    addPlace.appendChild(newDiv);
    n++;

}

function minus(){
    var deletePlace = document.getElementById('divf');
    deletePlace.removeChild(newDiv);
    n--;
}
