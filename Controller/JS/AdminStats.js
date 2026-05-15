function LoadAdminStats()
{
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
        {
            if(this.readyState==4 && this.status==200)
                {
                    let response = JSON.parse(this.responseText);
                    if(!response.ok){ return; }

                    document.getElementById("stat_active").innerHTML = response.stats.active_auctions;
                    document.getElementById("stat_ended").innerHTML = response.stats.ended_auctions;
                    document.getElementById("stat_bids").innerHTML = response.stats.total_bids;
                    document.getElementById("stat_highest").innerHTML = "$"+parseFloat(response.stats.highest_sale).toFixed(2);

                    let ctx = document.getElementById("topCategoriesChart");
                    if(ctx && response.labels.length > 0)
                        {
                            new Chart(ctx, {
                                type: "bar",
                                data: {
                                    labels: response.labels,
                                    datasets: [{
                                        label: "Completed Auctions",
                                        data: response.data,
                                        backgroundColor: ["#004aad","#0066cc","#3399ff","#66b3ff","#99ccff"]
                                    }]
                                },
                                options: {
                                    indexAxis: "y",
                                    responsive: true,
                                    plugins: { legend: { display: false } },
                                    scales: { x: { beginAtZero: true } }
                                }
                            });
                        }
                    else if(ctx)
                        {
                            ctx.parentElement.innerHTML = "<p>No ended auctions yet.</p>";
                        }
                }
        }
    xhttp.open("GET", "../Controller/AdminStats.php", true);
    xhttp.send();
}

window.onload = function(){ LoadAdminStats(); };
