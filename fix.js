
let allDegrees = [];
let userHollandCode = "";
let topLetter = "";

document.addEventListener("DOMContentLoaded", () => {
    // Determine user's recommended Holland Code if they took the assessment
    try {
        const scores = JSON.parse(localStorage.getItem("talunton_scores"));
        if (scores) {
            const sortedTraits = Object.keys(scores).sort((a, b) => scores[b] - scores[a]);
            userHollandCode = sortedTraits.slice(0, 3).join("");
            topLetter = sortedTraits[0];
        }
    } catch (e) {}

    fetch("get_degrees.php")
        .then(response => response.json())
        .then(data => {
            allDegrees = data;
            renderDegrees("all");
        })
        .catch(error => {
            console.error("Error fetching degrees:", error);
            document.getElementById("degree-list").innerHTML = "<p class=\"text-center text-red-500 py-8\">Failed to load degree programs. Please check database connection.</p>";
        });
});

function renderDegrees(filterCategory) {
    const listContainer = document.getElementById("degree-list");
    listContainer.innerHTML = "";

    let filteredDegrees = filterCategory === "all" 
        ? [...allDegrees]
        : allDegrees.filter(d => d.category === filterCategory);

    if (filteredDegrees.length === 0) {
        listContainer.innerHTML = "<p class=\"text-center text-gray-500 py-8\">No degree programs found for this category.</p>";
        return;
    }

    // Sort so recommended degrees are at the top
    if (topLetter) {
        filteredDegrees.sort((a, b) => {
            const aIsRec = a.holland_code.startsWith(topLetter) ? 1 : 0;
            const bIsRec = b.holland_code.startsWith(topLetter) ? 1 : 0;
            return bIsRec - aIsRec;
        });
    }

    filteredDegrees.forEach(degree => {
        let badgeClass = "bg-gray-100 text-gray-800";
        if (degree.category === "engineering") badgeClass = "bg-orange-100 text-orange-800";
        if (degree.category === "health") badgeClass = "bg-blue-100 text-blue-800";
        if (degree.category === "business") badgeClass = "bg-yellow-100 text-yellow-800";
        if (degree.category === "education") badgeClass = "bg-pink-100 text-pink-800";
        if (degree.category === "arts") badgeClass = "bg-purple-100 text-purple-800";

        const isRecommended = topLetter && degree.holland_code.startsWith(topLetter);
        
        let html = `
            <div class="degree-card bg-white p-6 rounded-2xl border ${isRecommended ? "border-emerald-400 bg-emerald-50" : "border-gray-100"} shadow-sm hover:shadow-md transition flex flex-col md:flex-row items-start md:items-center justify-between gap-6 cursor-pointer relative" data-category="${degree.category}">
                ${isRecommended ? `<div class="absolute -top-3 left-6 bg-emerald-500 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest shadow-sm">? Recommended Match</div>` : ""}
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1">${degree.title}</h3>
                    <p class="text-sm text-gray-500 mb-3">${degree.description}</p>
                    <div class="flex gap-2">
                        <span class="${badgeClass} text-[10px] font-bold px-2 py-1 rounded">${degree.holland_code} Profile</span>
                        <span class="bg-gray-100 text-gray-600 text-[10px] font-bold px-2 py-1 rounded">View details & colleges</span>
                    </div>
                </div>
                <a href="details.html?id=${degree.id}" class="w-full md:w-auto ${isRecommended ? "bg-emerald-600 hover:bg-emerald-700 text-white border-transparent" : "bg-white border border-gray-300 text-gray-700 hover:bg-gray-50"} text-sm font-bold py-2.5 px-6 rounded transition text-center inline-block">View Details</a>
            </div>
        `;
        listContainer.insertAdjacentHTML("beforeend", html);
    });
}

function filterDegrees(e, category) {
    const buttons = document.querySelectorAll(".filter-btn");
    buttons.forEach(btn => {
        btn.className = "filter-btn bg-gray-100 text-gray-600 hover:bg-gray-200 px-4 py-2 rounded-full text-xs font-bold transition";
    });
    e.currentTarget.className = "filter-btn active bg-gray-900 text-white px-4 py-2 rounded-full text-xs font-bold transition";
    renderDegrees(category);
}

