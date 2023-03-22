// On récupère la route actuelle
const currentRoute = window.location.pathname;
console.log(currentRoute);

// On récupère le bouton d'upload

const btnUpload=document.getElementById("uploadAvatar");
btnUpload.addEventListener("click",lanceParcourir,false);

// on récupère le champ d'upload

if (currentRoute === '/register') {
    // On ajoute le code pour la soumission de formulaire d'inscription
    var fileUpload=document.getElementById("registration_form_avatarFile");
  }
else if (currentRoute.startsWith('/profil/modifier/')) {
    // On ajoute le code pour la soumission de formulaire de modification de profil
    var fileUpload=document.getElementById("user_avatarFile");
}

fileUpload.addEventListener("change",afficheAvatar,false);

// On récupère le champs img qui affiche l'image
const avatarAffichee=document.getElementById("avatarAffichee");

//Fonction qui se lance quand on clique sur le bouton
function lanceParcourir() {
    fileUpload.click();
}

function afficheAvatar(){
    const imageChargee=this.files[0];
    console.log(imageChargee);
    const urlImageChargee=URL.createObjectURL(imageChargee);
    avatarAffichee.setAttribute("src", urlImageChargee);
}

console.log("test");