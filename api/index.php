<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CSV Embedding</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
  <div class="row">
    <div class="col">
      <h2>CSV Data</h2>
      <!-- Search Form -->
      <div class="mb-3">
        <input class="form-control" id="searchInput" type="text" placeholder="Search...">
      </div>
      <!-- CSV Table -->
      <div class="table-responsive">
        <table id="csvTable" class="table table-striped table-bordered">
          <!-- CSV Data will be inserted here -->
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
  // Function to load CSV data into table
  function loadCSV(csvPath) {
    $.ajax({
      url: csvPath,
      dataType: "text",
      success: function(data) {
        var csvData = processData(data);
        populateTable(csvData);
      }
    });
  }

  // Function to process CSV data
  function processData(csvData) {
    var lines = csvData.split("\n");
    var result = [];
    var headers = lines[0].split(",");
    for (var i = 1; i < lines.length; i++) {
      var obj = {};
      var currentline = lines[i].split(",");
      for (var j = 0; j < headers.length; j++) {
        obj[headers[j]] = currentline[j];
      }
      result.push(obj);
    }
    return result;
  }

  // Function to populate table with CSV data
  function populateTable(data) {
    var table = document.getElementById("csvTable");
    var searchInput = document.getElementById("searchInput");
    var html = "<thead><tr>";
    for (var key in data[0]) {
      html += "<th>" + key + "</th>";
    }
    html += "</tr></thead><tbody>";
    for (var i = 0; i < data.length; i++) {
      html += "<tr>";
      for (var key in data[0]) {
        html += "<td>" + data[i][key] + "</td>";
      }
      html += "</tr>";
    }
    html += "</tbody>";
    table.innerHTML = html;

    // Add event listener for search
    searchInput.addEventListener("keyup", function() {
      var filter = searchInput.value.toUpperCase();
      var rows = table.getElementsByTagName("tr");
      for (var i = 0; i < rows.length; i++) {
        var cells = rows[i].getElementsByTagName("td");
        var found = false;
        for (var j = 0; j < cells.length && !found; j++) {
          var cell = cells[j];
          if (cell) {
            var textValue = cell.textContent || cell.innerText;
            if (textValue.toUpperCase().indexOf(filter) > -1) {
              found = true;
            }
          }
        }
        if (found) {
          rows[i].style.display = "";
        } else {
          rows[i].style.display = "none";
        }
      }
    });
  }

  // Load CSV data when page loads
  $(document).ready(function() {
    loadCSV("https://docs.google.com/spreadsheets/d/e/2PACX-1vSbDCILGg_a4IEP9K_TKu9JY89SoUSVHgWnSdCd16TECSuOtZjLHHa9vy_bCTGtLfM3a3QvfOEFqZr5/pub?gid=142307183&single=true&output=csv");
  });
</script>

</body>
</html>
