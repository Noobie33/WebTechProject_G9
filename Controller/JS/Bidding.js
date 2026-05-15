function PlaceBid(listing_id)
{
    let amount = document.getElementById("bid_amount").value;
    let msgEl = document.getElementById("bid_message");

    if(amount=="" || amount<=0)
        {
            msgEl.innerHTML = "<span style='color:red'>Please enter a valid bid amount</span>";
            return;
        }

    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
        {
            if(this.readyState==4 && this.status==200)
                {
                    let response = JSON.parse(this.responseText);
                    if(response.ok)
                        {
                            msgEl.innerHTML = "<span style='color:green'>Bid placed successfully!</span>";
                            document.getElementById("current_bid_display").innerHTML = "$"+parseFloat(response.new_bid).toFixed(2);
                            document.getElementById("bid_count_display").innerHTML = response.bid_count;
                            document.getElementById("bid_amount").value = "";

                            let historyBody = document.getElementById("bid_history_body");
                            if(historyBody)
                                {
                                    let newRow = historyBody.insertRow(0);
                                    newRow.innerHTML = "<td>"+response.bidder_name+"</td><td>$"+parseFloat(response.new_bid).toFixed(2)+"</td><td>"+response.bid_time+"</td>";
                                }
                        }
                    else
                        {
                            msgEl.innerHTML = "<span style='color:red'>"+response.message+"</span>";
                        }
                }
        }
    xhttp.open("POST", "../Controller/PlaceBid.php", true);
    xhttp.setRequestHeader("content-type","application/x-www-form-urlencoded");
    xhttp.send("listing_id="+listing_id+"&amount="+amount);
}
