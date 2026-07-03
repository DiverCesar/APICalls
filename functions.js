document.addEventListener("DOMContentLoaded", () => {
    const countryList = document.getElementById("countryList");
    const searchInput = document.getElementById("search");
    const tableRows = document.querySelectorAll("#universitiesTable tbody tr:not(#emptyStateRow)");
    const noResults = document.getElementById("noResults");

    fetch("https://restcountries.com/v3.1/all?fields=name")
        .then(response => response.json())
        .then(data => {
            const countries = data.map(item => item.name.common).sort();
            
            countries.forEach(country => {
                const option = document.createElement("option");
                option.value = country;
                countryList.appendChild(option);
            });
        })
        .catch(error => {
            console.error("Data fetch error:", error);
        });

    if (searchInput && tableRows.length > 0) {
        searchInput.addEventListener("keyup", function () {
            const filter = searchInput.value.toLowerCase();
            let visibleCount = 0;

            tableRows.forEach(row => {
                const text = row.innerText.toLowerCase();
                if (text.includes(filter)) {
                    row.style.display = "";
                    visibleCount++;
                } else {
                    row.style.display = "none";
                }
            });
            
            if (noResults) {
                noResults.style.display = visibleCount === 0 ? "block" : "none";
            }
        });
    }
});
