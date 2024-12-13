function tester()
{
  nom=document.getElementById("name").value;
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

}