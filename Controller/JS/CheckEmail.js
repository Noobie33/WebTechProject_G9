function CheckEmail()
{
    let email = document.getElementById("email").value;
    let responseArea = document.getElementById("emailresponse");

    if(email=="")
        {
            responseArea.innerHTML="";
            return;
        }

    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200)
        {
            responseArea.innerHTML=this.responseText;

            if(this.responseText=="Email Available")
                {
                    responseArea.style.color="green";
                }
                else{
                    responseArea.style.color="red";
                }
        }
    }
        xhttp.open("POST", "../Controller/CheckEmail.php", true);
        xhttp.setRequestHeader("content-type","application/x-www-form-urlencoded");
        xhttp.send("email="+email);
}