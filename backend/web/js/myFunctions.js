$('.modalButton').click(function (){
    $.get($(this).attr('data-href'), function(data) {
        $('#modal').modal('show').find('#modalContent').html(data)
    });
    return false;
});

function changeLang(evt, lang) {
    var i, tabcontent, tablinks;
    console.log('aaa')
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(lang).style.display = "block";
    evt.currentTarget.className += " active";

    return false;
}

