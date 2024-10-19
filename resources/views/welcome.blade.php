<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERD Generator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        header {
            background: #007BFF;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        h1 {
            margin: 0;
        }
        h3 {
            margin: 10px 0 20px;
            font-weight: 300;
        }
        img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
        form {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .table {
            margin-bottom: 15px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            transition: background 0.3s;
        }
        .table:hover {
            background-color: #f1f1f1;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            background: #28a745;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.3s;
        }
        button:hover {
            background: #218838;
        }
        #add-table {
            background: #007BFF;
        }
        #add-table:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <h1>ERD Generator</h1>
        <h3>For Example</h3>
    </header>
    <img src="{{ asset('assets/images/erd.png') }}" alt="ERD Image">
    <form action="/generate-erd" method="POST">
        @csrf
        <div id="tables">
            <div class="table">
                <h2>Table</h2>
                <label for="table0-name">Name: <input id="table0-name" type="text" name="tables[0][name]" required></label>
                <label for="table0-fields">Fields (comma-separated): <input id="table0-fields" type="text" name="tables[0][fields]" required></label>
                <label for="table0-relations">Relations (comma-separated, optional): <input id="table0-relations" type="text" name="tables[0][relations]"></label>
            </div>
        </div>
        <button type="button" id="add-table">Add Table</button>
        <button type="submit">Generate ERD</button>
    </form>

    <script>
        document.getElementById('add-table').addEventListener('click', function() {
            const tablesDiv = document.getElementById('tables');
            const tableCount = tablesDiv.children.length;
            const newTable = `
                <div class="table">
                    <h2>Table</h2>
                    <label for="table${tableCount}-name">Name: <input id="table${tableCount}-name" type="text" name="tables[${tableCount}][name]" required></label>
                    <label for="table${tableCount}-fields">Fields (comma-separated): <input id="table${tableCount}-fields" type="text" name="tables[${tableCount}][fields]" required></label>
                    <label for="table${tableCount}-relations">Relations (comma-separated, optional): <input id="table${tableCount}-relations" type="text" name="tables[${tableCount}][relations]"></label>
                </div>
            `;
            tablesDiv.insertAdjacentHTML('beforeend', newTable);
        });
    </script>
</body>
</html>
