<!-- jQuery -->
<script src="{{ url('assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ url('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ url('assets/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ url('assets/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ url('assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ url('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ url('assets/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ url('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ url('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ url('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ url('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ url('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ url('assets/dist/js/adminlte.js') }}"></script>
<!-- Sweet Alert 2 -->
{{--<script src="{{ url('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>--}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="{{ url('js/app.js') }}"></script>
<!-- Notifications -->
<script src="https://js.pusher.com/6.0/pusher.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script>
    $(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showCloseButton: true,
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 6000,
            onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        Echo.private('App.User.{{ Auth::user()->id }}')
            .notification((notification) => {
                if(notification.type == "notifications") {
                    let icon = null;
                    if(notification.notification_type != '{{ \App\Notifications\GenericNotification::TYPE_DEFAULT }}') {
                        icon = notification.notification_type;
                    }

                    Toast.fire({
                        icon: notification.notification_type,
                        title: notification.title,
                        text: notification.message,
                    })
                    console.log(notification);
                    append_notification(notification);
                    new Audio('{{ url('assets/sounds/ding.mp3') }}').play();
                }
            });

        $('#navbar-notifications > a').click(function (){
            let obj = $(this);
            $.ajax({
                type: "POST",
                url: '{{ route('studio.notifications.read') }}',
                data: null,
                success: function(){
                    let notification_counter = obj.find('span');
                    if(!notification_counter.hasClass('d-none')) notification_counter.addClass('d-none');
                }
            });
        });

        function append_notification(data){
            let notification_counter = $('#navbar-notifications > a > span');
            let notification_html = '<a href="#" class="dropdown-item">';
            if(data.title != null) notification_html += '<p class="text-left font-weight-bold">' + data.title + '</p>';
            if(data.message != null) notification_html += '<p class="text-left">' + data.message + '</p>';
            notification_html += '<p class="text-right text-muted text-xs"><small class="badge badge-success"><i class="far fa-bell"></i> New</small></p>';
            notification_html += '</a><div class="dropdown-divider"></div>';
            $('#navbar-notifications > div > div:eq(0)').after(notification_html);

            // Show notifications
            if(notification_counter.hasClass('d-none')) {
                notification_counter.removeClass('d-none');
                notification_counter.text('1');
            } else {
                notification_counter.text(parseInt(notification_counter.text()) + 1);
            }
        }
    });
</script>
@if(Session::has('extra_scripts'))
    {!! Session::get('extra_scripts') !!}}
@endif
@stack('scripts')

