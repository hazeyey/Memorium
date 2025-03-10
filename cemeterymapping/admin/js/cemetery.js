document.addEventListener("DOMContentLoaded", function () {
    // ==============================
    // MODAL HANDLING FOR EDIT GRAVE
    // ==============================
    const editGraveButtons = document.querySelectorAll(".editGraveBtn");
    const editGraveModal = document.getElementById("editGraveModal");
    const closeButtons = document.querySelectorAll(".close");

    editGraveButtons.forEach(button => {
        button.addEventListener("click", function () {
            document.querySelector("input[name='grave_id']").value = this.dataset.id;
            document.querySelector("input[name='section']").value = this.dataset.section;
            document.querySelector("input[name='block_number']").value = this.dataset.block;
            document.querySelector("input[name='lot_number']").value = this.dataset.lot;

            editGraveModal.style.display = "block";
        });
    });

    // ==============================
    // MODAL HANDLING FOR EDIT DECEASED
    // ==============================
    const editDeceasedButtons = document.querySelectorAll(".editDeceasedBtn");
    const editDeceasedModal = document.getElementById("editDeceasedModal");

    editDeceasedButtons.forEach(button => {
        button.addEventListener("click", function () {
            document.getElementById("editDeceasedId").value = this.getAttribute("data-id");
            document.getElementById("editFirstName").value = this.getAttribute("data-firstname");
            document.getElementById("editLastName").value = this.getAttribute("data-lastname");
            document.getElementById("editBirthDate").value = this.getAttribute("data-birthdate");
            document.getElementById("editDeathDate").value = this.getAttribute("data-deathdate");
            document.getElementById("editObituary").value = this.getAttribute("data-obituary");

            editDeceasedModal.style.display = "block";
        });
    });

    // ==============================
    // GENERAL MODAL OPENING & CLOSING
    // ==============================
    function openModal(modalId) {
        let modal = document.getElementById(modalId);
        if (modal) modal.style.display = "block";
    }

    function closeModal(modal) {
        modal.style.display = "none";
    }

    document.getElementById("openAddGrave").addEventListener("click", () => openModal("addGraveModal"));
    document.getElementById("openAddDeceased").addEventListener("click", () => openModal("addDeceasedModal"));

    closeButtons.forEach(button => {
        button.addEventListener("click", function () {
            closeModal(this.closest(".modal"));
        });
    });

    window.addEventListener("click", function (event) {
        document.querySelectorAll(".modal").forEach(modal => {
            if (event.target === modal) closeModal(modal);
        });
    });

    // ==============================
    // DISPLAY STATUS MESSAGES BASED ON URL PARAMETERS
    // ==============================
    const statusMessages = {
        "status=addGraveSuccess": "addGraveSuccess",
        "status=addGraveFailed": "addGraveFailed",
        "status=addDeceasedSuccess": "addDeceasedSuccess",
        "status=addDeceasedFailed": "addDeceasedFailed",
        "status=graveNotExist": "graveNotExist",
        "status=editGraveSuccess": "editGraveSuccess",
        "status=editDeceasedSuccess": "editDeceasedSuccess",
        "status=deleteGraveSuccess": "deleteGraveSuccess",
        "status=deleteGraveFailed": "deleteGraveFailed",
        "status=deleteDeceasedSuccess": "deleteDeceasedSuccess",
        "status=uploadFailed": "uploadFailed",
        "status=invalidFileType": "invalidFileType"
    };

    // SHOW STATUS POP-UP BASED ON URL PARAMETERS
    const urlParams = new URLSearchParams(window.location.search);
    for (const key in statusMessages) {
        if (urlParams.toString().includes(key)) {
            document.getElementById(statusMessages[key]).style.display = "block";
            break; // Stop checking after the first match
        }
    }

    // REMOVE STATUS FROM URL AFTER 3 SECONDS
    setTimeout(() => {
        window.history.replaceState(null, null, window.location.pathname);
    }, 3000);
});

// ==============================
// SECTION NAVIGATION
// ==============================
function showSection(sectionId) {
    document.querySelectorAll('.home-section, .grave-section, .deceased-section, .modal').forEach(section => {
        section.style.display = 'none';
    });
    document.getElementById(sectionId).style.display = 'block';
}



// ==============================
// SEARCH FUNCTIONALITY
// ==============================
function searchTable() {
    var input = document.getElementById("searchInput");
    var filter = input.value.toLowerCase().split(" ");
    var table = document.getElementById("deceasedTable");
    var tr = table.getElementsByTagName("tr");

    for (var i = 1; i < tr.length; i++) {
        var td = tr[i].getElementsByTagName("td");
        let found = false;
        let fullName = (td[1].textContent || td[1].innerText) + " " + (td[2].textContent || td[2].innerText);

        let matches = filter.every(part => fullName.toLowerCase().includes(part));
        if (matches) found = true;

        tr[i].style.display = found ? "" : "none";
    }
}

// ==============================
// DELETE POP-UP MESSAGE FOR GRAVE
// ==============================
let deleteId = null;

function openDeleteGraveModal(id) {
    deleteId = id;
    document.getElementById("deleteModal").style.display = "block";
}

function closeDeleteGraveModal() {
    document.getElementById("deleteModal").style.display = "none";
}

function confirmDeleteGraveModal() {
    if (deleteId) {
        window.location.href = "delete_grave.php?id=" + deleteId;
    }
}

// ==============================
// DELETE POP-UP MESSAGE FOR DECEASED
// ==============================
let deleteDeceasedId = null;

function openDeleteDeceasedModal(id) {
    deleteDeceasedId = id;
    document.getElementById("deleteModal2").style.display = "block";
}

function closeDeleteDeceasedModal() {
    document.getElementById("deleteModal2").style.display = "none";
}

function confirmDeleteDeceasedModal() {
    if (deleteDeceasedId) {
        window.location.href = "delete_deceased.php?id=" + deleteDeceasedId;
    }
}

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("log_out").addEventListener("click", function() {
      
        localStorage.clear();
        sessionStorage.clear();

        window.location.href = "admin-login.php";  
    });
});










