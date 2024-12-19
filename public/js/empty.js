function handleEmpty(data) {
    if(data.length == 0){
        $('#table').css('display', 'none');
    }
    else{
        $('#table').css('display', 'table');
    }
}