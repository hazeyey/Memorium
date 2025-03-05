function openViewDeceasedModal(id) {
    console.log("Function is working! ID:", id); 

    let modal = document.getElementById("viewDeceasedModal");
    if (!modal) {
        console.error("Modal not found!");
        return;
    }

    fetch(`view_deceased.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            console.log(data); 

            if (data.error) {
                alert(data.error);
                return;
            }

            document.getElementById("viewDeceasedId").textContent = data.deceased_id || "N/A";
            document.getElementById("viewFirstName").textContent = data.first_name || "N/A";
            document.getElementById("viewLastName").textContent = data.last_name || "N/A";
            document.getElementById("viewBirthDate").textContent = data.birth_date || "N/A";
            document.getElementById("viewDeathDate").textContent = data.death_date || "N/A";
            document.getElementById("viewObituary").textContent = data.obituary || "N/A";
            document.getElementById("viewGraveLocation").textContent = data.grave_location || "N/A";

            let certImg = document.getElementById("viewDeathCertificate");
            if (data.death_certificate) {
                certImg.src = data.death_certificate; 
                certImg.style.display = "block";
            } else {
                certImg.style.display = "none";
            }

            modal.style.display = "block";
        })
        .catch(error => console.error("Error fetching deceased data:", error));
}

document.querySelector(".close").addEventListener("click", function() {
    document.getElementById("viewDeceasedModal").style.display = "none";
});

window.onclick = function(event) {
    let modal = document.getElementById("viewDeceasedModal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
};


