@push('stylesheets')
<x-stylesheet file="vendor_app/fontawesome/css/font-awesome.min.css" />
<x-stylesheet file="vendor_app/simple-line-icons/css/simple-line-icons.css" />
<x-stylesheet file="vendor_app/datatables-colvis/css/dataTables.colVis.css" />
<x-stylesheet file="vendor_app/datatables/media/css/dataTables.bootstrap.css" />
<x-stylesheet file="lib/sweetalert-4.1.9/sweetalert2.css" />
<x-stylesheet file="vendor_app/sweetalert/dist/sweetalert.css" />
@endpush
@push('scripts')
{{--Inclui os links para os arquivos js do servidor--}}
<x-script-src file="vendor_app/datatables/media/js/jquery.dataTables.min.js" />
<x-script-src file="vendor_app/datatables-colvis/js/dataTables.colVis.js" />
<x-script-src file="vendor_app/datatables/media/js/dataTables.bootstrap.js" />
<x-script-src file="vendor_app/datatables-buttons/js/dataTables.buttons.js" />
<x-script-src file="vendor_app/datatables-buttons/js/buttons.bootstrap.js" />
<x-script-src file="vendor_app/datatables-buttons/js/buttons.colVis.js" />
<x-script-src file="vendor_app/datatables-buttons/js/buttons.flash.js" />
<x-script-src file="vendor_app/datatables-buttons/js/buttons.html5.js" />
<x-script-src file="vendor_app/datatables-buttons/js/buttons.print.js" />
<x-script-src file="vendor_app/datatables-responsive/js/dataTables.responsive.js" />
<x-script-src file="vendor_app/datatables-responsive/js/responsive.bootstrap.js" />
@endpush
