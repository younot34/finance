"use strict";

document.getElementById('add-resep-button').addEventListener('click', function() {
    var container = document.getElementById('resep-container');
    var newRow = document.createElement('div');
    newRow.className = 'form-row';
    newRow.innerHTML = `
        <div class="form-group col-md-3">
            <label>Resep Terverifikasi Double Check</label>
            <input type="number" name="resep_terverifikasi[]" class="form-control">
        </div>
        <div class="form-group col-md-3">
            <label>Resep High Alert</label>
            <input type="number" name="resep_high_alert[]" class="form-control">
        </div>
        <div class="form-group col-md-1">
            <button type="button" class="btn btn-danger btn-sm" onclick="removeResepRow(this)">Hapus</button>
        </div>
    `;
    container.appendChild(newRow);
});

function removeResepRow(button) {
    button.closest('.form-row').remove();
}
