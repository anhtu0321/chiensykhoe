// Xử lý dropdow cho user trên header
var ulDropdow = document.getElementsByClassName('header__dropdow-ul')[0];
var userDropdow = document.getElementsByClassName('header__user-dropdow')[0];

document.addEventListener('click', function(e) {
    if (!userDropdow.contains(event.target)) {
        ulDropdow.style.display = "none";
    }
});

userDropdow.addEventListener('click', function() {
    if ((ulDropdow.style.display == 'none') || ulDropdow.style.display == '') {
        ulDropdow.style.display = "block";
    } else if (ulDropdow.style.display == "block") {
        ulDropdow.style.display = "none";
    }
});
// end...