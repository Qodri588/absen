<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Report</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma/css/bulma.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <style>
    textarea {
      resize: none;
      overflow: hidden;
      min-height: 150px; /* Tinggi minimum */
    }
  </style>
</head>
<body class="has-background-light py-5">
  <div class="container">
    <div class="box">
      <h1 class="title is-4 has-text-centered">Report Kunjungan</h1>
      
      <!-- Form Nama SPV -->
      <div class="field">
        <label class="label">Nama SPV</label>
        <div class="control">
          <input type="text" id="spvName" class="input" placeholder="Masukkan nama SPV">
        </div>
      </div>

      <!-- Form Tanggal -->
      <div class="field">
        <label class="label">Tanggal</label>
        <div class="control">
          <input type="text" id="visitDate" class="input" placeholder="Pilih tanggal">
        </div>
      </div>

      <!-- Area Dinamis -->
      <div id="dynamicArea"></div>

      <!-- Tombol Add/Remove -->
      <div class="field is-grouped mt-4">
        <div class="control">
          <button id="addButton" class="button is-primary">Tambah</button>
        </div>
        <div class="control">
          <button id="removeButton" class="button is-warning">Remove</button>
        </div>
      </div>

      <!-- Tombol Submit -->
      <div class="field mt-4">
        <button id="submitButton" class="button is-success is-fullwidth">Submit</button>
      </div>

      <!-- Output -->
      <div class="field mt-4">
        <label class="label">Hasil Report</label>
        <textarea id="outputText" class="textarea is-fullwidth" placeholder="Hasil akan muncul di sini..."></textarea>
      </div>
      
      <!-- Tombol Copy -->
      <div class="field mt-2">
        <button id="copyButton" class="button is-info is-fullwidth">Copy to Clipboard</button>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
    // Inisialisasi Flatpickr
    flatpickr("#visitDate", {
      dateFormat: "d - m - Y", // Format tanggal sesuai permintaan
    });

    // Variabel global
    const dynamicArea = document.getElementById('dynamicArea');
    const addButton = document.getElementById('addButton');
    const removeButton = document.getElementById('removeButton');
    const submitButton = document.getElementById('submitButton');
    const copyButton = document.getElementById('copyButton');
    const outputText = document.getElementById('outputText');
    let formCount = 0;

    // Fungsi Tambah Form
    addButton.addEventListener('click', () => {
      formCount++;
      const formGroup = document.createElement('div');
      formGroup.classList.add('box', 'mb-4');
      formGroup.setAttribute('id', `formGroup-${formCount}`);
      formGroup.innerHTML = `
        <div class="field">
          <label class="label">Nama MR</label>
          <div class="control">
            <input type="text" id="mrName-${formCount}" class="input" placeholder="Masukkan nama MR">
          </div>
        </div>
        <div class="field">
          <label class="label">Hasil Kunjungan</label>
          <div class="control">
            <textarea id="realization-${formCount}" class="textarea" placeholder="Masukkan hasil kunjungan"></textarea>
          </div>
        </div>
      `;
      dynamicArea.appendChild(formGroup);
    });

    // Fungsi Hapus Form
    removeButton.addEventListener('click', () => {
      if (formCount > 0) {
        const formGroup = document.getElementById(`formGroup-${formCount}`);
        dynamicArea.removeChild(formGroup);
        formCount--;
      }
    });

    // Fungsi Submit
    submitButton.addEventListener('click', () => {
      const spvName = document.getElementById('spvName').value.trim();
      const visitDate = document.getElementById('visitDate').value.trim();
      let report = `*Report Kunjungan SPV ${spvName} - Tanggal ${visitDate}*\n\n`;

      for (let i = 1; i <= formCount; i++) {
        const mrName = document.getElementById(`mrName-${i}`).value.trim();
        let realization = document.getElementById(`realization-${i}`).value.trim();

        // Menghapus semua teks sebelum "*Pagi s/d Siang:*"
        const index = realization.indexOf("*Pagi s/d Siang:*");
        if (index !== -1) {
          realization = realization.substring(index); // Hanya menyisakan bagian mulai dari "*Pagi s/d Siang:*"
        }

        if (mrName && realization) {
          report += `\n*${mrName}*\n${realization}\n`;
        }
      }

      outputText.value = report.trim();
      adjustTextareaHeight(outputText); // Menyesuaikan tinggi textarea output
    });

    // Fungsi Copy ke Clipboard
    copyButton.addEventListener('click', () => {
      outputText.select();
      document.execCommand('copy');
      alert('Teks berhasil disalin ke clipboard!');
    });

    // Penyesuaian tinggi textarea input
    document.addEventListener('input', (e) => {
      if (e.target.tagName === 'TEXTAREA') {
        e.target.style.height = 'auto';
        e.target.style.height = `${e.target.scrollHeight}px`;
      }
    });

    // Menyesuaikan tinggi textarea output agar menyesuaikan dengan panjang teks
    function adjustTextareaHeight(textarea) {
      textarea.style.height = 'auto'; // Reset tinggi
      textarea.style.height = `${textarea.scrollHeight}px`; // Atur tinggi sesuai konten
    }
  </script>
</body>
</html>