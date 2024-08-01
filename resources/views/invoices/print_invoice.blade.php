@extends('layouts.master')
@section('css')
 <style>
    @media print {
        #print_Button {
            display: none;
        }
    }
 </style>
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/  معاينة طباعة الفاتورة</span>
						</div>
					</div>
				
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row row-sm">
					<div class="col-md-12 col-xl-12">
						<div class=" main-content-body-invoice" id="print">
							<div class="card card-invoice">
								<div class="card-body">
                                    <div class="invoice-header">
                                        <h1 class="invoice-title">فاتورة تحصيل</h1>
                                        <div class="billed-from">
                                            <h6>BootstrapDash, Inc.</h6>
                                            <p>201 Something St., Something Town, YT 242, Country 6546<br>
                                                Tel No: 324 445-4544<br>
                                                Email: youremail@companyname.com</p>
                                        </div><!-- billed-from -->
                                    </div><!-- invoice-header -->
									<div class="row mg-t-20">	
										<div class="col-md">
											<label class="tx-gray-600">معلومات الفاتورة</label>
											<p class="invoice-info-row"><span>رقم الفاتوره:</span> <span>{{$invoice->invoice_number}}</span></p>
											<p class="invoice-info-row"><span>تاريخ الأصدار:</span> <span>{{$invoice->invoice_Date}}</span></p>
											<p class="invoice-info-row"><span>تاريخ الأستحقاق:</span> <span>{{$invoice->Due_date}}</span></p>
											<p class="invoice-info-row"><span>القسم:</span> <span>{{$invoice->section->section_name}}</span></p>
										</div>
									</div>
									<div class="table-responsive mg-t-40">
										<table class="table table-invoice border ">
											<thead>
												<tr>
                                                    <th class="tx-right"> المنتج</th>
													<th class="tx-right">مبلغ التحصيل</th>
													<th class="tx-right">مبلغ العموله</th>
													<th class="tx-right">الأجمالى</th>
												</tr>
											</thead>
											<tbody>
                                                @php
                                                    $total = $invoice->Amount_collection + $invoice->Amount_Commission
                                                @endphp
												<tr>
                                                    <td>{{$invoice->product}}</td>
													<td>{{$invoice->Amount_collection}}</td>
													<td>{{$invoice->Amount_Commission}}</td>
													<td>{{$total}}</td>
												</tr>

                                                <tr>
                                                    <td><label class="tx-gray-600">ملخص الفاتورة</label></td>
												</tr>

												<tr>
													<td class="tx-right">الأجمالى</td>
													<td class="tx-right" colspan="2">{{$total}}</td>
												</tr>
												<tr>
													<td class="tx-right">نسبة الضريبه</td>
													<td class="tx-right" colspan="2">{{$invoice->Rate_VAT}}</td>
												</tr>
												<tr>
													<td class="tx-right">قيمة الخصم</td>
													<td class="tx-right" colspan="2">{{$invoice->Discount}}</td>
												</tr>
												<tr>
													<td class="tx-right tx-uppercase tx-bold tx-inverse">الأجمالى شامل الضريبه</td>
													<td class="tx-right" colspan="2">
														<h4 class="tx-primary tx-bold">${{$invoice->Total}}</h4>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
									<hr class="mg-b-40">
									
									<button class="btn btn-danger float-left mt-3 mr-2" id="print_Button" onclick = "printDiv()">
										<i class="mdi mdi-printer ml-1"></i>طباعه
                                    </button>
									
								</div>
							</div>
						</div>
					</div><!-- COL-END -->
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>

<script type="text/javascript">
    function  printDiv(){
        document.getElementById('print').innerHtml;
        window.print();
        location.reload();
    }
</script>
@endsection