<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Realisasi MR</title>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.51.5/dist/full.css" rel="stylesheet" type="text/css" />
    <style>
        body {
            font-size: 14px;
        }
        .input, .btn {
            font-size: 14px;
        }
        pre {
            white-space: pre-wrap;
            word-wrap: break-word;
            font-size: 14px;
        }
        .form-item {
            padding: 5px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            margin-bottom: 8px;
            background-color: #f9fafb;
        }
        .form-item:nth-child(odd) {
            background-color: #e0f7fa;
        }
        .form-item:nth-child(even) {
            background-color: #fff3e0;
        }
        input {
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
    </style>
</head>
<body class="bg-gray-100 p-2 sm:p-4">

    <div class="max-w-full sm:max-w-4xl mx-auto bg-white p-4 rounded shadow-md">
        <h1 class="text-lg font-bold mb-4 text-center">Form Hasil Realisasi MR</h1>
        <form id="mrForm" class="space-y-4">
            <!-- Lokasi -->
            <div class="grid grid-cols-1 gap-2">
                <label class="block text-sm font-medium">Lokasi</label>
                <input type="text" name="lokasi" class="input input-bordered w-full" required>
            </div>

            <!-- Tanggal -->
            <div class="grid grid-cols-1 gap-2">
                <label class="block text-sm font-medium">Tanggal</label>
                <input type="text" name="tanggal" id="tanggal" class="input input-bordered w-full" required>
            </div>

            <!-- Pagi s/d Siang -->
            <div class="grid grid-cols-1 gap-2">
                <label class="block text-sm font-medium">Pagi s/d Siang</label>
                <div id="pagiSiangContainer" class="space-y-2"></div>
                <button type="button" onclick="addField('pagiSiangContainer')" class="btn btn-outline btn-sm w-full">+ Tambah</button>
            </div>

            <!-- Sore s/d Malam -->
            <div class="grid grid-cols-1 gap-2">
                <label class="block text-sm font-medium">Sore s/d Malam</label>
                <div id="soreMalamContainer" class="space-y-2"></div>
                <button type="button" onclick="addField('soreMalamContainer')" class="btn btn-outline btn-sm w-full">+ Tambah</button>
            </div>

            <button type="submit" class="btn btn-primary w-full">Submit</button>
        </form>

        <!-- Output hasil Markdown -->
        <div id="outputContainer" class="mt-4 hidden bg-gray-50 p-3 rounded shadow-md">
            <h2 class="text-sm font-bold">Hasil Markdown:</h2>
            <pre id="outputText" class="mt-2 bg-white p-2 rounded border"></pre>
            <button onclick="copyToClipboard()" class="btn btn-secondary btn-sm w-full mt-2">Copy to Clipboard</button>
        </div>
    </div>

    <script>
        // Integrasi Flatpickr
        flatpickr("#tanggal", {
            dateFormat: "Y-m-d",
        });

        // Fungsi untuk menambahkan field dinamis
        function addField(containerId) {
            const container = document.getElementById(containerId);
            const div = document.createElement("div");
            div.classList.add("form-item", "flex", "flex-col", "sm:flex-row", "gap-2");
            div.innerHTML = `
                <input type="text" name="${containerId}User[]" placeholder="User" class="input input-bordered w-full" required>
                <input type="text" name="${containerId}Result[]" placeholder="Hasil" class="input input-bordered w-full" required>
                <button type="button" class="btn btn-error btn-xs sm:w-auto w-full" onclick="removeField(this)">Hapus</button>
            `;
            container.appendChild(div);
        }

        // Fungsi untuk menghapus field
        function removeField(button) {
            button.parentElement.remove();
        }

        // Fungsi untuk mengirim data tanpa reload halaman
        document.getElementById('mrForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah reload halaman

            const formData = new FormData(this);

            fetch('process.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                // Tampilkan hasil di bawah formulir
                document.getElementById('outputContainer').classList.remove('hidden');
                document.getElementById('outputText').textContent = data;
            })
            .catch(error => console.error('Error:', error));
        });

        // Fungsi untuk menyalin teks ke clipboard
        function copyToClipboard() {
            const text = document.getElementById('outputText').textContent;
            navigator.clipboard.writeText(text).then(() => {
                alert("Text berhasil disalin ke clipboard!");
            });
        }
    </script>
</body>
</html>