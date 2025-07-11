<script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
<script>
    if (document.getElementById("default-table") && typeof simpleDatatables.DataTable !== 'undefined') {
        const dataTable = new simpleDatatables.DataTable("#default-table", {
            searchable: true,
            perPageSelect: false,
            paging: true,
            perPage: 5,
            labels: {
                placeholder: "Cari",
                perPage: "{select} baris per halaman",
                noRows: "Tidak ada hasil yang ditemukan",
                info: "Menampilkan halaman {page} dari {pages}",
            },
        });
    }
</script>
