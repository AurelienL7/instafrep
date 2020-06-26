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


    // SCROLL REVEAL
    ScrollReveal().reveal('.scroll-reveal', { delay: 250, reset: true });


    // UPVOTE COLOR CHANGE

    const voteArrowUp = document.querySelector('.vote-arrow-up');
    const arrowUp = document.querySelector('#noun_up_1920769');
    const voteArrowDown = document.querySelector('.vote-arrow-down');
    const arrowDown = document.querySelector('#noun_down_1920769');

    // Up
    voteArrowUp.addEventListener("click", function(){

        arrowUp.classList.toggle('vote-arrow-active');
        arrowDown.classList.remove('vote-arrow-active');
    })

    // Down
    voteArrowDown.addEventListener("click", function(){

        arrowDown.classList.toggle('vote-arrow-active');
        arrowUp.classList.remove('vote-arrow-active');

    })


    /*
       --------------
       LIKE SYSTEM
       --------------
     */

    // on écoute la liste de posts
    const $posts = document.querySelectorAll('article.post')

    // on écoute le clic sur la liste de posts
    for(const $post of $posts){

        $post.addEventListener("click", function(e){

            e.preventDefault();

            if(
                e.target.closest('a').classList.contains('app-like-btn') ||
                e.target.classList.contains('app-like-btn')
            ){
                const id = $post.dataset.post_id;
                console.log(id)
            }
        })
    }

    // on vérifie si on a cliqué sur un bouton de type "like"

    // si oui, on like le post
});

