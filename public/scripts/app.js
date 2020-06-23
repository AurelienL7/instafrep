document.addEventListener("DOMContentLoaded", function() {


    // Fonction permettant d'agrandir automatiquement la zone des textarea lorsque l'utilisateur entre un long texte

    const tx = document.getElementsByTagName('textarea');
    for (let i = 0; i < tx.length; i++) {
        tx[i].setAttribute('style', 'height:' + (tx[i].scrollHeight) + 'px;overflow-y:hidden;');
        tx[i].addEventListener("input", OnInput, false);
    }

    function OnInput() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    }


    var menu_profile = document.querySelector('#menu_profile');

    menu_profile.addEventListener("click", function(){

        var menu_profile_dropdown = document.querySelector('#menu_profile_dropdown');

        menu_profile_dropdown.classList.toggle('hidden')
    })

});

