//console.error('je suis là'); console error = console log

const { async } = require("regenerator-runtime");

//on recupere tous les toggle HTML
const switchs = document.querySelectorAll('input[data-actif-id]'); //switchs est une constante dans laquelle on a stocker tous le tableau doggles

// On parcour le tableau des switchs et pour chaque élémenton écoute le click
switchs.forEach((element) => {      //fonction fléché => fonction qu'on ne nomme pas et qu'on utilise que dans la boucle foreach.
    element.addEventListener('click', (event) => {      //  element.addEventListener on ecoute l'evenement click 
        //console.error(event.target); Surla console on voit sur quel boggle on a cliqué.
        // const articelId = event.target.getAttribute('data-actif-id'); 2 solutions
        // OU
        const articleId = event.target.dataset.actifId;

        switchVisibility(articleId);
    });
});

async function switchVisibility(id) {       //fonction executé en arriére plan asynchrone 
    const response = await fetch(`/admin/article/switch/${id}`);
     //   ``= altgr7 2fois
    if (response.status < 200 || response.status > 299) {            // si reponse inferrieur 200 et superrieur 299 erreur
        console.error(response);
    }

}