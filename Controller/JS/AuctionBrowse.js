function FilterByCategory(category_id)
{
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
        {
            if(this.readyState==4 && this.status==200)
                {
                    let listings = JSON.parse(this.responseText);
                    RenderListings(listings);
                }
        }
    xhttp.open("GET", "../Controller/FilterListings.php?category_id="+category_id, true);
    xhttp.send();
}

let searchTimeout;
function OnSearchInput(val)
{
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(function()
        {
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function()
                {
                    if(this.readyState==4 && this.status==200)
                        {
                            let listings = JSON.parse(this.responseText);
                            RenderListings(listings);
                        }
                }
            xhttp.open("GET", "../Controller/SearchListings.php?q="+encodeURIComponent(val), true);
            xhttp.send();
        }, 300);
}

function RenderListings(listings)
{
    let container = document.getElementById("listings_container");
    if(listings.length==0)
        {
            container.innerHTML = "<tr><td colspan='7'>No active auctions found.</td></tr>";
            return;
        }
    let html = "";
    for(let i=0; i<listings.length; i++)
        {
            let l = listings[i];
            let img = l.image_path ? "<img src='../"+l.image_path+"' width='60' height='50'>" : "No Image";
            html += "<tr>";
            html += "<td>"+img+"</td>";
            html += "<td>"+l.title+"</td>";
            html += "<td>"+l.category_name+"</td>";
            html += "<td>$"+parseFloat(l.current_bid).toFixed(2)+"</td>";
            html += "<td>"+l.bid_count+"</td>";
            html += "<td><span data-end='"+l.end_datetime+"'></span></td>";
            html += "<td><a href='AuctionDetails.php?id="+l.id+"'><input type='button' value='View & Bid'></a></td>";
            html += "</tr>";
        }
    container.innerHTML = html;
    StartCountdowns();
}
