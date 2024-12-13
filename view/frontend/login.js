
function test()
  {
    nom=document.getElementById("nom").value;
    prenom=document.getElementById("prenom").value;

    password=document.getElementById("password").value;

    category=document.getElementById("category").selectedIndex;
  
  if(nom.length==0)
  {
    alert("vous devez entrer un nom");
    return false;
  }
  if(prenom.length==0)
  {
    alert("vous devez entrer un prenom");
    return false;
  }
  if(password.length==0)
  {
    alert("vous devez entrer une mot de passe");
    return false;

  }

  



  }