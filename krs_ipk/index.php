<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data KRS dan IPK Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        #searchForm {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        label {
            font-size: 14px;
            color: #555;
            text-align: left;
        }
        input[type="text"],
        input[type="number"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
        }
        button {
            padding: 10px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
        #result {
            margin-top: 20px;
            text-align: left;
        }
        #krsTable {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        #krsTable th, #krsTable td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        #krsTable th {
            background-color: #007bff;
            color: white;
        }
        #krsTable tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        p {
            margin: 8px 0;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Cari Data KRS dan IPK Mahasiswa</h2>
        <form id="searchForm">
            <label for="nim">NIM:</label>
            <input type="text" id="nim" name="nim" required>
            
            <label for="semester">Semester:</label>
            <input type="number" id="semester" name="semester" required>
            
            <button type="button" onclick="fetchData()">Cari</button>
        </form>

        <div id="result" style="display: none;">
            <h3>Data KRS dan IPK</h3>
            <table id="krsTable">
                <thead>
                    <tr>
                        <th>Kode Mata Kuliah</th>
                        <th>Nama Mata Kuliah</th>
                        <th>SKS</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <p id="ips">IPS: </p>
            <p id="ipk">IPK: </p>
        </div>
    </div>

    <script>
        function fetchData() {
            const nim = document.getElementById('nim').value;
            const semester = document.getElementById('semester').value;

            fetch(`http://127.0.0.1:8001/krs?nim=${nim}&semester=${semester}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayData(data.data);
                    } else {
                        alert('Data tidak ditemukan');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function displayData(data) {
            const tableBody = document.querySelector('#krsTable tbody');
            tableBody.innerHTML = ''; // Clear previous data

            data.krs.forEach(item => {
                const mataKuliah = item.mata_kuliah || {};
                const row = `<tr>
                    <td>${mataKuliah.id_mk || '-'}</td>
                    <td>${mataKuliah.nama_mk || '-'}</td>
                    <td>${mataKuliah.sks || '-'}</td>
                    <td>${item.nilai}</td>
                </tr>`;
                tableBody.innerHTML += row;
            });

            document.getElementById('ips').textContent = `IPS: ${data.ips}`;
            document.getElementById('ipk').textContent = `IPK: ${data.ipk}`;
            document.getElementById('result').style.display = 'block';
        }
    </script>
</body>
</html>
