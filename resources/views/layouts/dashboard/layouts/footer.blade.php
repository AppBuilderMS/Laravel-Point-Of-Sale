<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2022
        <a href="https://github.com/AppBuilderMS">AppBuilder.MS</a>.</strong> All rights
    reserved.
</footer>

</div><!--end of wrapper-->

{{--<!-- jQuery 3 -->--}}
<script src="{{ asset('dashboard_files/js/jquery.min.js') }}"></script>

{{--<!-- Bootstrap 3.3.7 -->--}}
<script src="{{ asset('dashboard_files/js/bootstrap.min.js') }}"></script>

{{--icheck--}}
<script src="{{ asset('dashboard_files/plugins/icheck/icheck.min.js') }}"></script>

{{--<!-- FastClick -->--}}
<script src="{{ asset('dashboard_files/js/fastclick.js') }}"></script>

{{--<!-- AdminLTE App -->--}}
<script src="{{ asset('dashboard_files/js/adminlte.min.js') }}"></script>

{{--ckeditor standard--}}
<script src="{{ asset('dashboard_files/plugins/ckeditor/ckeditor.js') }}"></script>

{{--jquery number--}}
<script src="{{ asset('dashboard_files/js/jquery.number.min.js') }}"></script>

{{--print this--}}
<script src="{{ asset('dashboard_files/js/printThis.js') }}"></script>

{{--morris --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="{{ asset('dashboard_files/plugins/morris/morris.min.js') }}"></script>

{{--custom js--}}
<script src="{{ asset('dashboard_files/js/custom/image_preview.js') }}"></script>
<script src="{{ asset('dashboard_files/js/custom/order.js') }}"></script>

{{--app functions scripts--}}
<script>
    $(document).ready(function() {
        //delete confirmation with noty
        $('.delete').click(function(e){
            var that = $(this)
            e.preventDefault();

            var n = new Noty({
                text: "@lang('site.confirm_delete')",
                type: "warning",
                killer: true,
                buttons: [

                    Noty.button("@lang('site.yes')", 'btn btn-success mr-2', function () {
                        that.closest('form').submit();
                    }),

                    Noty.button("@lang('site.no')", 'btn btn-primary mr-2', function () {
                        n.close();
                    }),
                ]
            });

            n.show();
        });

        //image preview
        $('.image').change(function() {
            if (this.files && this.files[0]) { //use this as js not $(this) as jquery to apply on global scope
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.image-preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(this.files[0]);
            }
        });

        //ckeditor
        CKEDITOR.config.language = "{{app()->getLocale()}}"

    });
</script>
@stack('scripts')
</body>
</html>
