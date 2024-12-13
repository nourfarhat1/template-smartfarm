/*function tester_reclamation()
{
  nom=document.getElementById("first_name").value;
  last_name=document.getElementById("last_name").value;
  email=document.getElementById("email").value;
  subject=document.getElementById("subject").value;
  message=document.getElementById("message").value;
  if(nom.length==0)
  {
    alert("Vous devez entrez un nom");
  }
  if(last_name.length==0)
    {
      alert("Vous devez entrez un nom");
    }
  if(email.length==0)
  {
    alert("Vous devez entrez un email");
    return 0;
  }
  if(subject.length==0)
  {
    alert("Vous devez entrez un subject");
    return 0;
  }
  if(message=="")
  {
    alert("Vous devez entrez un message");
    return 0;
  }

}
*/
function tester()
 {
   nom=document.getElementById("nom").value;
   nom=document.getElementById("prenom").value;
   email=document.getElementById("email").value;
   subject=document.getElementById("subject").value;
   message=document.getElementById("message").value;
   if(nom.length==0)
   {
     alert("Vous devez entrez un nom");
   }
   if(email.length==0)
   {
     alert("Vous devez entrez un email");
     return 0;
   }
   if(subject.length==0)
   {
     alert("Vous devez entrez un subject");
     return 0;
   }
   if(message=="")
   {
     alert("Vous devez entrez un message");
     return 0;
   }
 
 }/*  
function CheckPasswordStrength(password)
 {
  var password_strength = document.getElementById("password");

  email=document.getElementById("email").value;
  //tester email
  if(email=="")
{
  alert("vous devez entrer correctement un email");
  return false;
}
  
  //if textBox is empty
  if(password.length==0){
    alert("mot de passe est vide ");
      password_strength.innerHTML = "";
      return false;
  }

  //Regular Expressions
  var regex = new Array();
  regex.push("[A-Z]"); //For Uppercase Alphabet
  regex.push("[a-z]"); //For Lowercase Alphabet
  regex.push("[0-9]"); //For Numeric Digits
  regex.push("[$@$!%*#?&]"); //For Special Characters

  var passed = 0;

  //Validation for each Regular Expression
  for (var i = 0; i < regex.length; i++) {
      if(new RegExp (regex[i]).test(password))
      {
          passed++;
      }
  }

  //Validation for Length of Password
  if(passed > 2 && password.length > 8){
      passed++;
  }

  //Display of Status
  var color = "";
  var passwordStrength = "";
  switch(passed){
      case 0:
      case 1:
          passwordStrength = "Password is Weak.";
          color = "Red";
          break;
      case 2:
          passwordStrength = "Password is Good.";
          color = "darkorange";
          break;
      case 3:
      case 4:
          passwordStrength = "Password is Strong.";
          color = "Green";
          break;
      case 5:
          passwordStrength = "Password is Very Strong.";
          color = "darkgreen";
          break;
  }
  password_strength.innerHTML = passwordStrength;
  password_strength.style.color = color;
}
*/

function evaluatePasswordStrength(password) {
  let strength = 0;

  // Define the strength criteria
  if (password.length >= 8) strength++; // Minimum length
  if (/[A-Z]/.test(password)) strength++; // Contains uppercase letter
  if (/[0-9]/.test(password)) strength++; // Contains number
  if (/[@$!%*?&]/.test(password)) strength++; // Contains special character

  return strength;
}

function displayPasswordStrength(strength) {
  const strengthDisplay = document.getElementById("password-strength");

  // Display password strength
  if (strength === 0) {
      strengthDisplay.innerHTML = "";
      strengthDisplay.className = "strength";
  } else if (strength === 1) {
      strengthDisplay.innerHTML = "Weak Password";
      strengthDisplay.className = "strength weak";
  } else if (strength === 2) {
      strengthDisplay.innerHTML = "Medium Password";
      strengthDisplay.className = "strength medium";
  } else if (strength >= 3) {
      strengthDisplay.innerHTML = "Strong Password";
      strengthDisplay.className = "strength strong";
  }
}
function tester_signup()
{
   password = document.getElementById("password").value;
   strengthDisplay = document.getElementById("password-strength");
  
  nom=document.getElementById("nom").value;
  email=document.getElementById("email").value;
  role=document.getElementById("role").selectedIndex;
  prenom=document.getElementById("prenom").value;
  if(nom=="")
    {
      alert("vous devez entrez correctement NOM");
      return false;
    } 
    if(prenom=="")
      {
        alert("vous devez entrez correctement prenom");
        return false;
      } 
  if(email=="")
    {
      alert("vous devez entrez correctement email");
      return false;
    } 
    if(prenom=="")
      {
        alert("vous devez entrez correctement prenom");
        return false;
      } 
// Define the strength criteria
displayPasswordStrength(strength);

      if(role==0)
      {
        alert("vous devez entrez correctement votre role" );
        return false;
      }

  
}
