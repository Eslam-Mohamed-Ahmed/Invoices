@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div>
                <a href="{{ url('/home/invoices') }}">
                    <h4 class="content-title mb-0 my-auto"> الفواتير </h4>
                </a>
            </div>
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">تفاصيل الفاتوره رقم</h4><span
                    class="text-danger  mt-1 tx-13 mr-2 mb-0">{{ $invoices->invoice_number }}</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">

            <div class="mb-3 mb-xl-0">
                <div class="btn-group dropdown">
                    <button type="button" class="btn btn-primary">14 Aug 2019</button>
                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                        id="dropdownMenuDate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuDate"
                        data-x-placement="bottom-end">
                        <a class="dropdown-item" href="#">2015</a>
                        <a class="dropdown-item" href="#">2016</a>
                        <a class="dropdown-item" href="#">2017</a>
                        <a class="dropdown-item" href="#">2018</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
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
    <!-- row -->
    <div class="row">
        <div class="panel panel-primary tabs-style-2">
            <div class=" tab-menu-heading">
                <div class="tabs-menu1">
                    <!-- Tabs -->
                    <ul class="nav panel-tabs main-nav-line">
                        <li><a href="#invoice" class="nav-link active" data-toggle="tab">معلومات الفاتوره</a></li>
                        <li><a href="#details" class="nav-link" data-toggle="tab">حالات الدفع</a></li>
                        <li><a href="#attachments" class="nav-link" data-toggle="tab">المرفقات</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body tabs-menu-body main-content-body-right border">
                <div class="tab-content">

                    <div class="tab-pane active" id="invoice">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="table key-buttons text-md-nowrap" data-page-length ='50'>
                                    <tbody class="text-center">
                                        <tr>
                                            <th class="border-bottom-0 ">تاريخ الفاتوره </th>
                                            <td class="text-primary">{{ $invoices->invoice_Date }}</td>
                                            <th class="border-bottom-0 "> تاريخ الأستحقاق</th>
                                            <td class="text-primary">{{ $invoices->Due_date }}</td>
                                        </tr>

                                        <tr>
                                            <th class="border-bottom-0 ">المنتج</th>
                                            <td class="text-primary">{{ $invoices->product }}</td>
                                            <th class="border-bottom-0 "> القسم</th>
                                            <td class="text-primary">{{ $invoices->section->section_name }}</td>
                                        </tr>
                                        <tr>
                                            <th class="border-bottom-0 ">مبلغ التحصيل</th>
                                            <td class="text-primary">{{ $invoices->Amount_collection }}</td>
                                            <th class="border-bottom-0 ">الخصم</th>
                                            <td class="text-primary">{{ $invoices->Discount }}</td>
                                        </tr>
                                        <tr>
                                            <th class="border-bottom-0 "> نسبة الضريبه</th>
                                            <td class="text-primary">{{ $invoices->Rate_VAT }}</td>
                                            <th class="border-bottom-0"> قيمة الضريبه </th>
                                            <td class="text-primary">{{ $invoices->Value_VAT }}</td>
                                        </tr>
                                        <tr>
                                            <th class="border-bottom-0 "> الأجمالى</th>
                                            <td class="text-primary">{{ $invoices->Amount_collection }}</td>
                                        
                                            <th class="border-bottom-0 ">  حالة الفاتوره الحاليه</th>
                                            @if ($invoices->Value_Status == 1)
                                            <td> <span class="bg-success text-light  p-2 rounded-sm">
                                                {{ $invoices->Status }}
                                                </span>
                                            </td>
                                            @elseif($invoices->Value_Status == 2)
                                            <td><span class="bg-danger text-light  p-2 rounded-sm">
                                                {{ $invoices->Status }}
                                                </span>
                                            </td>
                                            @else
                                            <td><span class="bg-orange text-light p-2  rounded-sm">
                                                {{ $invoices->Status }}
                                                </span>
                                            </td>
                                            @endif
                                                
                                            
                                        </tr>
                                        <tr>

                                            <th class="border-bottom-0"> ملاحظات</th>
                                            <td class="text-primary">{{ $invoices->note }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="details">

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example1" class="table key-buttons text-md-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">#</th>
                                            <th class="border-bottom-0">المنتج</th>
                                            <th class="border-bottom-0">القسم</th>
                                            <th class="border-bottom-0">حاله الدفع</th>
                                            <th class="border-bottom-0">تاريخ الدفع</th>
                                            <th class="border-bottom-0">تاريخ الأضافه</th>
                                            <th class="border-bottom-0">المستخدم</th>
                                            <th class="border-bottom-0">ملاحظات</th>




                                        </tr>
                                    </thead>
                                    <tbody class="text-center">

                                        <?php $x = 0; ?>
                                        @foreach ($details as $det)
                                            <?php $x++; ?>
                                            <tr>

                                                <td>{{ $x }}</td>
                                                <td>{{ $det->product }}</td>
                                                <td>{{ $invoices->section->section_name }}</td>

                                                @if ($det->Value_Status == 1)
                                                    <td class="bg-success text-light rounded-sm">{{ $det->Status }}</td>
                                                @elseif($det->Value_Status == 2)
                                                    <td class="bg-danger text-light rounded-sm">{{ $det->Status }}</td>
                                                @else
                                                    <td class="bg-orange text-light rounded-sm">{{ $det->Status }}</td>
                                                @endif
                                                
                                                <td>{{ $det->Payment_Date }}</td>
                                                <td>{{ $invoices->created_at }}</td>
                                                <td>{{ $det->user }}</td>
                                                <td>{{ $det->note }}</td>

                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--المرفقات-->
                    <div class="tab-pane" id="attachments">
                        <div class="card-body">


                            <div class="card-body">
                                <p class="text-danger">* صيغة المرفق pdf, jpeg , png , jpg , bmp , mp4 </p>
                                <h5 class="card-title">اضافة مرفقات</h5>
                                <form method="post" action="{{ url('invoiceAttachments') }}"
                                    enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" name="file_name"
                                            required>
                                        <input type="hidden" id="customFile" name="invoice_number"
                                            value="{{ $invoices->invoice_number }}">
                                        <input type="hidden" id="invoice_id" name="invoice_id"
                                            value="{{ $invoices->id }}">
                                        <label class="custom-file-label" for="customFile">حدد
                                            المرفق</label>
                                    </div><br><br>
                                    <button type="submit" class="btn btn-primary btn-sm "
                                        name="uploadedFile">تاكيد</button>
                                </form>
                            </div>

                            <br>

                            <div class="table-responsive">
                                <table id="example1" class="table key-buttons text-md-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">#</th>
                                            <th class="border-bottom-0">أسم الملف</th>
                                            <th class="border-bottom-0">قام بالأضافه</th>
                                            <th class="border-bottom-0">تاريخ الأضافه</th>
                                            <th class="border-bottom-0">العمليات</th>




                                        </tr>
                                    </thead>
                                    <tbody class="text-center">

                                        <?php $x = 0; ?>
                                        @foreach ($attachments as $att)
                                            <?php $x++; ?>
                                            <tr>

                                                <td>{{ $x }}</td>
                                                <td>{{ $att->file_name }}</td>
                                                <td>{{ $att->Created_by }}</td>
                                                <td>{{ $att->created_at }}</td>
                                                <td colspan="2">

                                                    <a class="btn btn-outline-success btn-sm"
                                                        href="{{ url('View_file') }}/{{ $invoices->invoice_number }}/{{ $att->file_name }}"
                                                        role="button"><i class="fas fa-eye"></i>&nbsp;
                                                        عرض</a>

                                                    <a class="btn btn-outline-info btn-sm"
                                                        href="{{ url('download') }}/{{ $invoices->invoice_number }}/{{ $att->file_name }}"
                                                        role="button"><i class="fas fa-download"></i>&nbsp;
                                                        تحميل</a>

                                                    <button class="btn btn-outline-danger btn-sm" data-toggle="modal"
                                                        data-name="{{ $att->file_name }}"
                                                        data-number="{{ $att->invoice_number }}"
                                                        data-id="{{ $att->id }}"
                                                        data-target="#delete">حذف</button>



                                                </td>

                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
    <!-- delete -->
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
                <form action="{{ route('delete_file') }}" method="post">
                    @method('delete')

                    {{ csrf_field() }}

                    <div class="modal-body">
                        <p class="text-center">
                        <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
                        </p>

                        <input type="hidden" name="id_file" id="id" value="">
                        <input type="hidden" name="file_name" id="name" value="">
                        <input type="hidden" name="invoice_number" id="number" value="">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
    <!-- Container closed -->
</div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Jquery.mCustomScrollbar js-->
    <script src="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- Internal Input tags js-->
    <script src="{{ URL::asset('assets/plugins/inputtags/inputtags.js') }}"></script>
    <!--- Tabs JS-->
    <script src="{{ URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
    <script src="{{ URL::asset('assets/js/tabs.js') }}"></script>
    <!--Internal  Clipboard js-->
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>
    <!-- Internal Prism js-->
    <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>

    <script>
        $('#delete').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var number = button.data('number')
            var modal = $(this)

            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name').val(name);
            modal.find('.modal-body #number').val(number);
        })
    </script>
@endsection
