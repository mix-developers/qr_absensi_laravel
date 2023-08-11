<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
@stack('js')
{{-- datatable  --}}
<script>
    // $(document).ready(function() {
    //     $('#datatable').DataTable({
    //         responsive: true,
    //         "language": {
    //             "lengthMenu": "Tampilkan _MENU_ ",
    //             "zeroRecords": "Maaf belum ada data",
    //             "info": "Tampilkan data _PAGE_ dari _PAGES_ total : _TOTAL_ data",
    //             "infoEmpty": "belum ada data",
    //             "infoFiltered": "(saring from _MAX_ total data)",
    //             "search": "Cari : ",
    //             "paginate": {
    //                 "previous": "Sebelumnya ",
    //                 "next": "Selanjutnya"
    //             }
    //         }
    //     });
    // });
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $('#dataTable').DataTable({
            responsive: true,
        });
    });
    $(document).ready(function() {
        $('#dataTable-export').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>
