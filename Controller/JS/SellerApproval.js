function ApproveSeller(user_id,rowid)
{
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200)
        {
            let response=JSON.parse(this.responseText);
            if(response.ok)
                {
                    document.getElementById("status"+rowid).innerHTML="Approved";
                    document.getElementById("action"+rowid).innerHTML="Done";
                }
                else{
                    alert(response.message);
                }
        }
    }
        xhttp.open("POST", "../Controller/ApproveSeller.php", true);
        xhttp.setRequestHeader("content-type","application/x-www-form-urlencoded");
        xhttp.send("user_id="+user_id);
}

function RejectSeller(user_id,rowid)
{
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200)
        {
            let response=JSON.parse(this.responseText);
            if(response.ok)
                {
                    document.getElementById("row"+rowid).remove();
                }
                else{
                    alert(response.message);
                }
        }
    }
        xhttp.open("POST", "../Controller/RejectSeller.php", true);
        xhttp.setRequestHeader("content-type","application/x-www-form-urlencoded");
        xhttp.send("user_id="+user_id);
}
