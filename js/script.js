document.addEventListener("DOMContentLoaded", function () {
    // Get all tab elements
    var tabElements = document.querySelectorAll('a[data-bs-toggle="tab"]');

    // Set the active tab in local storage when a tab is clicked
    tabElements.forEach(function (tabElement) {
        tabElement.addEventListener("click", function (e) {
            localStorage.setItem("activeTab", e.target.getAttribute("href"));
        });
    });

    // Check if there's a saved tab
    var activeTab = localStorage.getItem("activeTab");
    if (activeTab) {
        var tab = new bootstrap.Tab(
            document.querySelector(`a[href="${activeTab}"]`)
        );
        tab.show();
    }
});

document.getElementById("uploadButton").addEventListener("click", function () {
    document.getElementById("fileToUpload").click();
});

document.getElementById("fileToUpload").addEventListener("change", function () {
    if (this.value) {
        document.getElementById("uploadForm").submit();
    }
});

document.getElementById("deleteButton").addEventListener("click", function () {
    document.getElementById("deleteForm").submit();
});

