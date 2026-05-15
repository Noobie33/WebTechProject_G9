function CancelListing(listing_id, rowNum)
{
    if(!confirm("Are you sure you want to cancel this listing?")){ return; }

    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
        {
            if(this.readyState==4 && this.status==200)
                {
                    let response = JSON.parse(this.responseText);
                    if(response.ok)
                        {
                            document.getElementById("status"+rowNum).innerHTML = "<span style='color:orange'>Cancelled</span>";
                            document.getElementById("cancel_btn"+rowNum).style.display = "none";
                            document.getElementById("edit_btn"+rowNum).style.display = "none";
                            alert("Listing cancelled successfully");
                        }
                    else
                        {
                            alert(response.message);
                        }
                }
        }
    xhttp.open("POST", "../Controller/CancelListing.php", true);
    xhttp.setRequestHeader("content-type","application/x-www-form-urlencoded");
    xhttp.send("listing_id="+listing_id);
}
