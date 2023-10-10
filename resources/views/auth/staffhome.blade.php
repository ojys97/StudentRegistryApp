<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STAFF HOME</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        #search-container {
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #search-form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button[type="submit"] {
            background-color: blue;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h1>Staff Home</h1>
<h2>Search for Student Information</h2>

<div id="search-container">
    <form method="GET" id="search-form">
        <div>
            <label for="search">Search by Name or Email:</label>
            <input type="text" name="search" id="search" required>
        </div>
        <button type="submit">Search</button>
    </form>
    <div id="search-results">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody id="search-results-body">
            <!-- Results will be displayed here -->
        </tbody>
    </table>
    <div id="pagination-links">
        <!-- Pagination links will be displayed here -->    
    </div>
</div>


    <form method="POST" action="{{ route('staffhome.import', ['page' => request()->input('page')]) }}" enctype="multipart/form-data"id="import-form">
    @csrf
    <div class="form-group">
        <label for="file">Select File (CSV/Excel):</label>
        <input type="file" name="file" id="file" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Import Students</button>
</form>

<div id="delete-container">
    <form method="POST" action="{{ route('staffhome.delete') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="delete-file">Select CSV File for Deletion:</label>
            <input type="file" name="delete-file" id="delete-file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-danger">Delete Students</button>
    </form>
</div>


<table class="table table-bordered mt-4">
    <tr>
        <th colspan="4">
            List Of Students
            <a class="btn btn-danger float-end" href="{{ route('staffhome.export') }}">Export User Data</a>
        </th>
    </tr>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Address</th>
        <th>Course</th>
    </tr>
    @foreach($students as $student)
    <tr>
        <td>{{ $student->name }}</td>
        <td>{{ $student->email }}</td>
        <td>{{ $student->address }}</td>
        <td>{{ $student->course }}</td>
    </tr>
    @endforeach
</table>
{{$students->links()}}
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Search Form Submit
        $('#search-form').submit(function (e) {
            e.preventDefault();

            var searchQuery = $('#search').val();
            $.ajax({
                url: "/staffhome/get",
                method: 'GET',
                data: { search: searchQuery },
                success: function (response) {
                    var resultsDiv = $('#search-results');
                    resultsDiv.empty();

                    if (response.results && response.results.length > 0) {
                        $.each(response.results, function (index, result) {
                            resultsDiv.append('<p>Name: ' + result.name + '<br>Address: ' + result.address + '</p>');
                        });
                    } else {
                        resultsDiv.append('<p>No results found.</p>');
                    }
                },
                error: function () {
                    console.error('Error occurred during search.');
                }
            });
        });

        // Delete Form Submit
        $('#delete-container form').submit(function (e) {
            e.preventDefault();

            var formData = new FormData($(this)[0]);

            $.ajax({
                url: "{{ route('staffhome.delete') }}",
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    alert('Deletion successful');
                },
                error: function () {
                    alert('Error occurred during deletion');
                }
            });
        });

        // Import Form Submit
        $('#import-form').submit(function (e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('staffhome.import') }}",
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log(response);
                    $('#import-result').html('<div class="alert alert-success">Import successful!</div>');
                },
                error: function (xhr, status, error) {
                    console.error('Error occurred during import:', status, error);
                    $('#import-result').html('<div class="alert alert-danger">Error during import.</div>');
                }
            });
        });
    });
</script>

</body>
</html>
