function DeleteCategory(cat_id)
{
    if(!confirm("Delete this category?")){ return; }

    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
        {
            if(this.readyState==4 && this.status==200)
                {
                    let response = JSON.parse(this.responseText);
                    if(response.ok)
                        {
                            document.getElementById("cat_row_"+cat_id).remove();
                            alert("Category deleted");
                        }
                    else
                        {
                            alert(response.message);
                        }
                }
        }
    xhttp.open("POST", "../Controller/CategoryController.php", true);
    xhttp.setRequestHeader("content-type","application/x-www-form-urlencoded");
    xhttp.send("action=delete&category_id="+cat_id);
}
