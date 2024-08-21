<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;


use App\Models\Invoices;
use App\Models\Sections;
use App\Models\Invoices_Details;
use App\Models\Products;
use App\Models\Invoices_attachments;
use App\Models\User;
use App\Notifications\SendInvoice;

class InvoicesController extends Controller
{
  
    public function index()
    {

        $sections = Sections::all();
        $invoices = Invoices::all();
        return view('invoices.invoices', compact('invoices' ,'sections'));
    }


    public function create()
    {
        $products= Products::all();
        $sections = Sections::all();
        return view('invoices.create', compact('sections' , 'products'));
    }

   


    public function store(Request $request)
    {
        Invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->invoice_Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);

        $invoice_id = Invoices::latest()->first()->id;
        Invoices_Details::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        if ($request->hasFile('pic')) {

            $invoice_id = Invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new Invoices_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }


        //send invoice to user email when store invoice
        $user = User::first();
        // $email = $user->email;
        // $invoices = Invoices::latest()->first();
        // Notification::send($user, new SendInvoice($invoice_id));
        // $user->email->notify(new SendInvoice($invoice_id));

        // Notification::route('mail' , 'eslamxxx555xxx@gmail.com')
        //              ->notify(new SendInvoice($invoice_id));


        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return back();
    }

    public function print_invoice($id){
         $invoice = Invoices::where('id' , $id)->first();
         return view('invoices.print_invoice' , compact('invoice'));
    }
    
  
    public function show($id)
    {
        $invoice = Invoices::where('id', $id)->first();
        return view('invoices.status_update', compact('invoice'));
    }

 
    public function edit($id)
    {
        $invoices = invoices::where('id', $id)->first();
        $sections = sections::all();
        return view('invoices.edit_invoice', compact('sections', 'invoices'));
    }

    public function invoicesPaid(){
        $invoices = Invoices::where('Value_Status' , 1)->get();
        return view('invoices.invoices_paid' , compact('invoices'));
    }

    public function invoicesUnPaid(){
        $invoices = Invoices::where('Value_Status' , 2)->get();
        return view('invoices.invoices_unpaid' , compact('invoices'));
    }

    public function invoicesPartial(){
        $invoices = Invoices::where('Value_Status' , 3)->get();
        return view('invoices.invoices_Partial' , compact('invoices'));
    }

   
//Update Invoice & Invoices Table
    public function update(Request $request)
    {

        $invoices = invoices::findOrFail($request->invoice_id);
        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,
        ]);

        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return redirect('/home/invoices');
    }

//Update Status in Invoices & Invoices_details Tables
    public function StatusUpdate(Request $request , $id){
       $invoice = Invoices::findOrFail($id);
       if($request->Status === "مدفوعة"){

        $invoice->update([
            'Value_Status' => 1  ,
            'Status' => $request->Status,
            'Payment_Date' => $request->Payment_Date
        ]);

        Invoices_Details::create([
            'id_Invoice' => $request->invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->pro,
            'Section' => $request->Section,
            'Status' => $request->Status,
            'Value_Status' => 1,
            'note' => $request->note,
            'Payment_Date' => $request-> Payment_Date ,
            'user' => (Auth::user()->name),
        ]);

     }else{

        $invoice->update([
            'Value_Status' => 3 ,
            'Status' => $request->Status,
            'Payment_Date' => $request->Payment_Date
        ]);

        Invoices_Details::create([
            'id_Invoice' => $request->invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->pro,
            'Section' => $request->Section,
            'Status' => $request->Status,
            'Value_Status' => 3,
            'note' => $request->note,
            'Payment_Date' => $request-> Payment_Date ,
            'user' => (Auth::user()->name),
        ]);
       }
       session()->flash('Status_Update' , 'تم تعديل حالة الفاتوره بنجاح');
       return redirect('/home/invoices');

    // return $request->invoice_number;

    
}

// auto choose product whin select section if created_invoice
    public function getproducts($id)
    {
        $products = DB::table('Products')->where("section_id", $id)->pluck("product_name" , 'id');
        
        return json_encode($products);
    }

//Archive & Delete invoice
     public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $invoices = Invoices::where('id', $id)->first();
        $attachments = Invoices_attachments::where('invoice_id', $id)->first();

        
        $id_page =$request->id_page;
        
        
        
        
        if (!$id_page == 2) {  
            
            if (!empty($attachments->invoice_number)) {
                
                Storage::disk('uploads')->deleteDirectory($attachments->invoice_number);
            }

            $invoices->forceDelete(); //delete from ui & database
            session()->flash('delete' , 'تم حذف الفاتوره بنجاح');
            return back();

        }

        else {

            $invoices->delete(); //soft delete from ui only
            session()->flash('archive' , 'تم أرشفة الفاتوره بنجاح');
            return back();
        }


    }

    


    
}
    




