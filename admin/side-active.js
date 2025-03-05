document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".sidebar li a").forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault();

            let sectionId = this.getAttribute("data-section");

            document.querySelectorAll('.home-section, .grave-section, .deceased-section, .modal')
                .forEach(section => section.style.display = 'none');

            document.getElementById(sectionId).style.display = 'block';

            document.querySelectorAll(".sidebar li a").forEach(link => link.classList.remove("active"));

            this.classList.add("active");
        });
    });
});
