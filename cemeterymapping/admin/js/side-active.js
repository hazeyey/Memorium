document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".sidebar li a").forEach(link => {
        link.addEventListener("click", function (event) {
            let sectionId = this.getAttribute("data-section");

            // Only prevent default and toggle visibility if data-section exists
            if (sectionId) {
                event.preventDefault();

                let section = document.getElementById(sectionId);

                if (section) {
                    document.querySelectorAll('.home-section, .grave-section, .deceased-section, .modal')
                        .forEach(sec => sec.style.display = 'none');

                    section.style.display = 'block';

                    document.querySelectorAll(".sidebar li a").forEach(link => link.classList.remove("active"));
                    this.classList.add("active");
                }
            }
            // If no sectionId, allow normal page navigation
        });
    });
});