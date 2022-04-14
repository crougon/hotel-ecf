window.onload = () => {
    // Gestion des boutons supprimer
    const links = document.querySelectorAll("[data-delete]")
    
    // loop sur links
    for (const link of links) {
        link.addEventListener("click", function(e){
            e.preventDefault()

            // confirmation
            if(confirm("Voulez-vous supprimer cette image ?")){
                fetch(this.getAttribute("href"), {
                    method: "DELETE",
                    headers: {
                        'X-Requested-With' : "XMLHttpRequest",
                        "Content-Type" : "application/json"
                    },
                    body: JSON.stringify({"_token": this.dataset.token})
                }).then(
                    response => response.json()
                ).then(data => {
                    if(data.success)
                        this.parentElement.remove()
                    else
                        alert(data.error)    
                }).then$(data).ajaxStop(function() {
                    setInterval(function() {
                        location.reload();
                    }, 3000);
                }).catch(e =>alert(e))
                
            }
        })
    }

    
}