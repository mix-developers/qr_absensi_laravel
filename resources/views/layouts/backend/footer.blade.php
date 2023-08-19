<script src="{{ asset('admin_theme') }}/assets/js/vendor-all.min.js"></script>
<script src="{{ asset('admin_theme') }}/assets/js/plugins/bootstrap.min.js"></script>
<script src="{{ asset('admin_theme') }}/assets/js/plugins/feather.min.js"></script>
<script src="{{ asset('admin_theme') }}/assets/js/pcoded.min.js"></script>
<script src="{{ asset('admin_theme') }}/assets/js/highlight.min.js"></script>
<script src="{{ asset('admin_theme') }}/assets/js/plugins/clipboard.min.js"></script>
<script src="{{ asset('admin_theme') }}/assets/js/uikit.min.js"></script>

<script src="{{ asset('admin_theme') }}/assets/js/plugins/jquery.dataTables.min.js"></script>
<script src="{{ asset('admin_theme') }}/assets/js/plugins/dataTables.bootstrap4.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!-- notification Js -->
<script src="{{ asset('admin_theme') }}/assets/js/plugins/bootstrap-notify.min.js"></script>
{{-- <script src="{{ asset('admin_theme') }}/assets/js/pages/ac-notification.js"></script> --}}

<!-- select2 Js -->
<script src="{{ asset('admin_theme') }}/assets/js/plugins/select2.full.min.js"></script>
<!-- form-select-custom Js -->
<script src="{{ asset('admin_theme') }}/assets/js/pages/form-select-custom.js"></script>

@stack('js')

<script>
    // DataTable start
    $('.lara-dataTable').DataTable();
    // DataTable end
</script>


@if (Session::has('success'))
    <script>
        function notify(title, message, from, align, icon, type, animIn, animOut) {
            $.notify({
                icon: icon,
                title: title,
                message: message,
                url: ''
            }, {
                element: 'body',
                type: type,
                allow_dismiss: true,
                placement: {
                    from: from,
                    align: align
                },
                offset: {
                    x: 30,
                    y: 30
                },
                spacing: 10,
                z_index: 999999,
                delay: 2500,
                timer: 1000,
                url_target: '_blank',
                mouse_over: false,
                animate: {
                    enter: animIn,
                    exit: animOut
                },
                icon_type: 'class',
                template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                    '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                    '<span data-notify="icon"></span> ' +
                    '<div data-notify="title"><b>{1}</b></div> ' +
                    '<span data-notify="message">{2}</span>' +
                    '<div class="progress" data-notify="progressbar">' +
                    '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                    '</div>' +
                    '<a href="{3}" target="{4}" data-notify="url"></a>' +
                    '</div>'
            });
        };

        var title = 'Sukses';
        var message = "{{ Session::get('success') }}";
        var nFrom = $(this).attr('data-from');
        var nAlign = $(this).attr('data-align');
        var nIcons = $(this).attr('data-notify-icon');
        var nType = 'success';
        var nAnimIn = 'animated bounceInRight';
        var nAnimOut = 'animated bounceOutRight';
        notify(title, message, nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
    </script>
@endif

{{-- <div class="pct-customizer">
<div href="#!" class="pct-c-btn">
    <button class="btn btn-light-danger" id="pct-toggler">
        <i data-feather="settings"></i>
    </button>
    <button class="btn btn-light-primary" data-toggle="tooltip" title="Document" data-placement="left">
        <i data-feather="book"></i>
    </button>
    <button class="btn btn-light-success" data-toggle="tooltip" title="Buy Now" data-placement="left">
        <i data-feather="shopping-bag"></i>
    </button>
    <button class="btn btn-light-info" data-toggle="tooltip" title="Support" data-placement="left">
        <i data-feather="headphones"></i>
    </button>
</div>
<div class="pct-c-content ">
    <div class="pct-header bg-primary">
        <h5 class="mb-0 text-white f-w-500">Nextro Customizer</h5>
    </div>
    <div class="pct-body">
        <h6 class="mt-2"><i data-feather="credit-card" class="mr-2"></i>Header settings</h6>
        <hr class="my-2">
        <div class="theme-color header-color">
            <a href="#!" class="" data-value="bg-default"><span></span><span></span></a>
            <a href="#!" class="" data-value="bg-primary"><span></span><span></span></a>
            <a href="#!" class="" data-value="bg-danger"><span></span><span></span></a>
            <a href="#!" class="" data-value="bg-warning"><span></span><span></span></a>
            <a href="#!" class="" data-value="bg-info"><span></span><span></span></a>
            <a href="#!" class="" data-value="bg-success"><span></span><span></span></a>
            <a href="#!" class="" data-value="bg-dark"><span></span><span></span></a>
        </div>
        <h6 class="mt-4"><i data-feather="layout" class="mr-2"></i>Sidebar settings</h6>
        <hr class="my-2">
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="cust-sidebar">
            <label class="custom-control-label f-w-600 pl-1" for="cust-sidebar">Light Sidebar</label>
        </div>
        <div class="custom-control custom-switch mt-2">
            <input type="checkbox" class="custom-control-input" id="cust-sidebrand">
            <label class="custom-control-label f-w-600 pl-1" for="cust-sidebrand">Color Brand</label>
        </div>
        <div class="theme-color brand-color d-none">
            <a href="#!" class="active" data-value="bg-primary"><span></span><span></span></a>
            <a href="#!" class="" data-value="bg-danger"><span></span><span></span></a>
            <a href="#!" class="" data-value="bg-warning"><span></span><span></span></a>
            <a href="#!" class="" data-value="bg-info"><span></span><span></span></a>
            <a href="#!" class="" data-value="bg-success"><span></span><span></span></a>
            <a href="#!" class="" data-value="bg-dark"><span></span><span></span></a>
        </div>
    </div>
</div>
</div> --}}
<script>
    // header option
    $('#pct-toggler').on('click', function() {
        $('.pct-customizer').toggleClass('active');

    });
    // header option
    $('#cust-sidebrand').change(function() {
        if ($(this).is(":checked")) {
            $('.theme-color.brand-color').removeClass('d-none');
            $('.m-header').addClass('bg-dark');
        } else {
            $('.m-header').removeClassPrefix('bg-');
            $('.m-header > .b-brand > .logo-lg').attr('src', 'assets/images/logo-dark.svg');
            $('.theme-color.brand-color').addClass('d-none');
        }
    });
    // Header Color
    $('.brand-color > a').on('click', function() {
        var temp = $(this).attr('data-value');
        // $('.header-color > a').removeClass('active');
        // $('.pcoded-header').removeClassPrefix('brand-');
        // $(this).addClass('active');
        if (temp == "bg-default") {
            $('.m-header').removeClassPrefix('bg-');
        } else {
            $('.m-header').removeClassPrefix('bg-');
            $('.m-header > .b-brand > .logo-lg').attr('src', 'assets/images/logo.svg');
            $('.m-header').addClass(temp);
        }
    });
    // Header Color
    $('.header-color > a').on('click', function() {
        var temp = $(this).attr('data-value');
        // $('.header-color > a').removeClass('active');
        // $('.pcoded-header').removeClassPrefix('brand-');
        // $(this).addClass('active');
        if (temp == "bg-default") {
            $('.pc-header').removeClassPrefix('bg-');
        } else {
            $('.pc-header').removeClassPrefix('bg-');
            $('.pc-header').addClass(temp);
        }
    });
    // sidebar option
    $('#cust-sidebar').change(function() {
        if ($(this).is(":checked")) {
            $('.pc-sidebar').addClass('light-sidebar');
            $('.pc-horizontal .topbar').addClass('light-sidebar');
            // $('.m-header > .b-brand > .logo-lg').attr('src', 'assets/images/logo-dark.svg');
        } else {
            $('.pc-sidebar').removeClass('light-sidebar');
            $('.pc-horizontal .topbar').removeClass('light-sidebar');
            // $('.m-header > .b-brand > .logo-lg').attr('src', 'assets/images/logo.svg');
        }
    });
    $.fn.removeClassPrefix = function(prefix) {
        this.each(function(i, it) {
            var classes = it.className.split(" ").map(function(item) {
                return item.indexOf(prefix) === 0 ? "" : item;
            });
            it.className = classes.join(" ");
        });
        return this;
    };

    $(".delete-button").on('click', function(e) {
        e.preventDefault();
        let form = $(this).parents('form');

        swal.fire({
            title: 'Apakah Anda yakin ingin menghapus data ini?',
            text: 'Data yang dihapus tidak bisa dikembalikan',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batalkan'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit()

                swal.fire(
                    'Dikonfirmasi!',
                    'Data akan dihapus.',
                    'success'
                )
            }
        })
    })
</script>
