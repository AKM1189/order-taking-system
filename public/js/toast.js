window.onload = (event) => {
    var myAlert =document.getElementById('toastNotice');//select id of toast
    if($('#noti').text()){
    var bsAlert = new bootstrap.Toast(myAlert, {
                    animation: true,
                    autohide: true,
                    delay: 5000,
                });//inizialize it

    bsAlert.show();//show it
}
}