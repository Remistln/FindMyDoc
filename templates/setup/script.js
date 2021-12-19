
let existent_field = document.getElementById('existent_field');
let add_more_fields = document.getElementById('add_more_fields');
let remove_fields = document.getElementById('remove_fields');

add_more_fields.onclick = function(){
    let newField = document.createElement('div');
    newField.setAttribute('class','wrapper');
    existent_field.appendChild(newField);
}

remove_fields.onclick = function(){
    let field = existent_field.getElementsByClassName('existent_field');
    if(field.length > 0) {
        existent_field.removeChild(field[(field.length) - 1]);
    }
}