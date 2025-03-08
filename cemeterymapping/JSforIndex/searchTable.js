function searchTable() {
    var input = document.getElementById("searchInput");
    var filter = input.value.toLowerCase().trim().split(" "); 
    var table = document.getElementById("deceasedTable");
    var tr = table.getElementsByTagName("tr");
    var graveMarkers = document.querySelectorAll('.grave');

    // Remove highlight from all grave markers
    graveMarkers.forEach(grave => grave.classList.remove("highlight-grave"));

    // If the search input is empty, show all rows and return
    if (input.value.trim() === "") {
        for (let i = 1; i < tr.length; i++) {
            tr[i].style.display = "";
        }
        return; 
    }

    // Loop through all table rows, hide those that don't match the search query
    for (let i = 1; i < tr.length; i++) { 
        let td = tr[i].getElementsByTagName("td");
        let found = false;

        let fullName = (td[1].textContent || td[1].innerText) + " " + (td[2].textContent || td[2].innerText);
        let location = td[6].textContent || td[6].innerText;
        let dateOfDeath = td[4].textContent || td[4].innerText;

        let searchableText = (fullName + " " + location + " " + dateOfDeath).toLowerCase();
        let matches = filter.every(part => searchableText.includes(part));

        if (matches) {
            found = true;
        }

        tr[i].style.display = found ? "" : "none";

        // If the row is found, check if the grave marker should be highlighted
        if (found) {
            graveMarkers.forEach(grave => {
                let graveName = grave.getAttribute("data-name").toLowerCase();
                let graveLocation = grave.getAttribute("data-location").toLowerCase();

                // Check if the grave marker matches the search criteria
                if (filter.every(part => graveName.includes(part) || graveLocation.includes(part))) {
                    grave.classList.add("highlight-grave");
                }
            });
        }
    }
}

