<!DOCTYPE html>
<html>
<head>
    <title>Search and Display Data</title>
</head>
<body>
    <h1>Search Data</h1>
    <form id="search-form">
        <label for="search-input">Search:</label>
        <input type="text" id="search-input" placeholder="Enter a search term">
        <input type="submit" value="Search">
    </form>

    <h2>Search Results</h2>
    <table id="result-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Age</th>
                <!-- Add more table headers as needed -->
            </tr>
        </thead>
        <tbody id="table-body">
            <!-- Table rows will be added here dynamically -->
        </tbody>
    </table>
</body>
</html>
<script type="text/javascript">
    // Sample data
const data = [
    { name: 'John', age: 30 },
    { name: 'Alice', age: 25 },
    { name: 'Bob', age: 35 },
    // Add more data as needed
];

// Function to filter and display search results
function searchAndDisplayData(searchTerm) {
    const tableBody = document.getElementById('table-body');
    tableBody.innerHTML = '';

    const results = data.filter(item => item.name.toLowerCase().includes(searchTerm.toLowerCase()));

    if (results.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="2">No results found</td></tr>';
    } else {
        results.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `<td>${item.name}</td><td>${item.age}</td>`;
            tableBody.appendChild(row);
        });
    }
}

// Event listener for form submission
document.getElementById('search-form').addEventListener('submit', function (e) {
    e.preventDefault();
    const searchTerm = document.getElementById('search-input').value;
    searchAndDisplayData(searchTerm);
});

</script>