@extends('layouts.master')

@section('title')
    قائمة الفواتير
@stop

@section('css')
 <!-- Internal Data table css -->
 <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
 <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
 <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
 <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
 <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
 <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
 <!--Internal   Notify -->
 <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">قائمةالفواتير</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection




@section('content')
    <!-- row opened -->
    <div class="row">

        @if (session()->has('archive'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('archive') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

        @if (session()->has('delete'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ session()->get('delete') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session()->has('Status_Update'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Status_Update') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if (session()->has('edit'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('edit') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if (session()->has('return'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('return') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <!--display invoices-->
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="col-sm-6 col-md-4 col-xl-3">
                        <a href="/home/invoices/create" class="modal-effect btn btn-outline-primary btn-block"
                            data-effect="effect-scale">أضافة فاتوره</a>
                    </div>
                </div>

             

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">رقم الفاتوره</th>
                                    <th class="border-bottom-0">تاريخ الفاتوره</th>
                                    <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                    <th class="border-bottom-0">المنتج</th>
                                    <th class="border-bottom-0">القسم</th>
                                    <th class="border-bottom-0">مبلغ التحصيل</th>
                                    <th class="border-bottom-0">الخصم</th>
                                    <th class="border-bottom-0">نسبة الضريبه</th>
                                    <th class="border-bottom-0">قيمة الضريبه</th>
                                    <th class="border-bottom-0">الاجمالى</th>
                                    <th class="border-bottom-0">الحاله</th>
                                    <th class="border-bottom-0">ملاحظات</th>
                                    <th class="border-bottom-0">العمليات</th>





                                </tr>
                            </thead>
                            <tbody class="text-center">

                                <?php $x = 0; ?>
                                @foreach ($invoices as $invoice)
                                    <?php $x++; ?>
                                    <tr>

                                        <td>{{ $x }}</td>
                                        <td>{{ $invoice->invoice_number }}</td>
                                        <td>{{ $invoice->invoice_Date }}</td>
                                        <td>{{ $invoice->Due_date }}</td>
                                        <td>{{ $invoice->product }}</td>
                                        <td>
                                            <a
                                                href="{{ url('InvoicesDetails') }}/{{ $invoice->id }}">{{ $invoice->section->section_name }}</a>
                                        </td>
                                        <td>{{ $invoice->Amount_collection }}</td>
                                        <td>{{ $invoice->Discount }}</td>
                                        <td>{{ $invoice->Value_VAT }}</td>
                                        <td>{{ $invoice->Rate_VAT }}</td>
                                        <td>{{ $invoice->Total }}</td>
                                        <td>
                                            @if ($invoice->Value_Status === 1)
                                                <span class="bg-success p-1 text-light rounded-sm">{{ $invoice->Status }}</span>
                                            @elseif($invoice->Value_Status === 2)
                                                <span class="bg-danger p-1 text-light rounded-sm">{{ $invoice->Status }}</span>
                                            @else
                                                <span class="bg-warning p-1 text-light rounded-sm">{{ $invoice->Status }}</span>
                                            @endif

                                        </td>

                                        <td>{{ $invoice->note }}</td>
                                    
                                                    <td>
                                                        <div class="dropdown">
                                                            <button aria-expanded="false" aria-haspopup="true"
                                                                class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                                type="button">العمليات<i class="fas fa-caret-down ml-1"></i>
                                                            </button>

                                                            <div class="dropdown-menu tx-13">
                                                                    <a class="dropdown-item"
                                                                        href=" {{ url('/home/invoices/edit_invoice') }}/{{ $invoice->id }}">
                                                                        تعديل
                                                                        الفاتورة
                                                                    </a>
            
                                                                    <a class="dropdown-item" href="#" data-id="{{$invoice->id}}"
                                                                        data-toggle="modal" data-target="#delete"><i
                                                                            class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;
                                                                            حذف
                                                                        الفاتورة
                                                                    </a>
            
                                                                    <a class="dropdown-item"
                                                                        href="{{ URL::route('Status_show', [$invoice->id]) }}"><i
                                                                            class=" text-success fas
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                fa-money-bill"></i>&nbsp;&nbsp;تغير
                                                                        حالة
                                                                        الدفع</a>
            
                                                                    <a class="dropdown-item" href="#archive" data-id="{{ $invoice->id }}"
                                                                        data-toggle="modal" data-target="#archive"><i
                                                                            class="text-warning fas fa-exchange-alt"></i>&nbsp;&nbsp;نقل الي
                                                                        الارشيف</a>
            
                                                                    <a class="dropdown-item" href="print_invoice/{{ $invoice->id }}"><i
                                                                            class="text-success fas fa-print"></i>&nbsp;&nbsp;طباعة
                                                                        الفاتورة
                                                                    </a>
                                                            </div>
                                                        </div>
            
                                                    </td>


                                                </div>
                                            </div>

                                        </td>

                                        <!-- modal مع ال  id مسار ال  => from (button) to (script model) to (hidden input) to (controller)-->


                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->

        <!--div-->

    </div>
    <!-- /row -->

     <!--delete invoice modal-->
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form action="invoices/destroy" method="post">
                 @method('delete')
                 @csrf

                 <div class="modal-body">
                     هل انت متاكد من حذف الفاتوره ؟
                     <input type="hidden" name="invoice_id" id="invoice_id" value="">
                 </div>

                 <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                     <button type="submit" class="btn btn-danger">تاكيد</button>
                 </div>
             </form>
         </div>
     </div>
    </div>

    <!--archive invoice modal-->
    <div class="modal fade" id="archive" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <form action="invoices/destroy" method="post">
                 @method('delete')
                 @csrf

                 <div class="modal-body">
                     سيتم أرشفة الفاتوره ؟
                     <input type="hidden" name="invoice_id" id="id" value="">
                     <input type="hidden" name="id_page" id="id_page" value="2">

                 </div>

                 <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                     <button type="submit" class="btn btn-danger">تاكيد</button>
                 </div>
             </form>
         </div>
     </div>
    </div>
    
@endsection


@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>

    <!--Delete-->
    <script>
        $('#delete').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })
    </script>


    <!--Archive-->
    <script>
        $('#archive').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id').val(invoice_id);
        })

    </script>

    <!--update-->
    <script>
        $('#update').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_number = button.data('invoice_number')
            var invoice_id = button.data('invoice_id')
            var date = button.data('date')
            var due = button.data('due')
            var pro = button.data('product')

            var name = button.data('name')
            var section_id = button.data('section_id')
            var id = button.data('id')
            var commission = button.data('commission')
            var collection = button.data('collection')

            var discount = button.data('discount')
            var value = button.data('value')
            var rate = button.data('rate')
            var total = button.data('total')
            var notes = button.data('notes')


            var modal = $(this)

            modal.find('.modal-body #number').val(invoice_number);
            modal.find('.modal-body #id').val(invoice_id);
            modal.find('.modal-body #date').val(date);
            modal.find('.modal-body #due').val(due);
            modal.find('.modal-body #pro').val(pro);

            modal.find('.modal-body #name').val(name);
            modal.find('.modal-body #section').val(section_id);
            modal.find('.modal-body #id').val(id);

            modal.find('.modal-body #collection').val(collection);
            modal.find('.modal-body #commission').val(commission);
            modal.find('.modal-body #discount').val(discount);
            modal.find('.modal-body #value').val(value);
            modal.find('.modal-body #rate').val(rate);
            modal.find('.modal-body #total').val(total);
            modal.find('.modal-body #notes').val(notes);



        })
    </script>

    <script>
        $(document).ready(function() {
            $('select[name="Section"]').on('change', function() {
                var SectionId = $(this).val();
                if (SectionId) {
                    $.ajax({
                        url: "{{ URL::to('section') }}/" + SectionId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="product"]').empty();
                            $.each(data, function(value) {
                                $('select[name="product"]').append('<option value="' +
                                    value + '">' + value + '</option>');
                            });
                        },
                    });

                } else {
                    console.log('AJAX load did not work');
                }
            });

        });
    </script>

    <script>
        function myFunction() {

            var Amount_Commission = parseFloat(document.getElementById("Amount_Commission").value);
            var Discount = parseFloat(document.getElementById("Discount").value);
            var Rate_VAT = parseFloat(document.getElementById("Rate_VAT").value);
            var Value_VAT = parseFloat(document.getElementById("Value_VAT").value);

            var Amount_Commission2 = Amount_Commission - Discount;


            if (typeof Amount_Commission === 'undefined' || !Amount_Commission) {

                alert('يرجي ادخال مبلغ العمولة ');

            } else {
                var intResults = Amount_Commission2 * Rate_VAT / 100;

                var intResults2 = parseFloat(intResults + Amount_Commission2);

                sumq = parseFloat(intResults).toFixed(2);

                sumt = parseFloat(intResults2).toFixed(2);

                document.getElementById("Value_VAT").value = sumq;

                document.getElementById("Total").value = sumt;

            }

        }
    </script>


@endsection
