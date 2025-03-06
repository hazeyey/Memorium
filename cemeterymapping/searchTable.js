
    function searchTable() {
        var input = document.getElementById("searchInput");
        var filter = input.value.toLowerCase().trim().split(" "); // Trim to avoid empty spaces
        var table = document.getElementById("deceasedTable");
        var tr = table.getElementsByTagName("tr");
        var graveMarkers = document.querySelectorAll('.grave');

        // Remove all previous highlights
        graveMarkers.forEach(grave => grave.classList.remove("highlight-grave"));

        // If search is empty, show all rows and stop highlighting
        if (input.value.trim() === "") {
            for (let i = 1; i < tr.length; i++) {
                tr[i].style.display = "";
            }
            return; // Exit function early to prevent unnecessary highlighting
        }

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

            // Highlight only the matching grave
            if (found) {
                graveMarkers.forEach(grave => {
                    let graveName = grave.getAttribute("data-name").toLowerCase();
                    if (filter.every(part => graveName.includes(part))) {
                        grave.classList.add("highlight-grave");

                        // Remove highlight after 5 seconds
                        setTimeout(() => {
                            grave.classList.remove("highlight-grave");
                        }, 5000);
                    }
                });
            }
        }
    }
