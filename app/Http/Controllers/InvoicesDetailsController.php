<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Invoices_Details;
use App\Models\Invoices;
use App\Models\Invoices_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoices_Details  $invoices_Details
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $invoices = Invoices::where('id' , $id)->first();
        $details = Invoices_Details::where('id_invoice' , $id)->get();
        $attachments = Invoices_attachments::where('invoice_id' , $id)->get();

       return view('invoices.invoices_details' , compact('invoices' , 'details' , 'attachments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoices_Details  $invoices_Details
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoices_Details $invoices_Details)
    {
        //
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoices_Details  $invoices_Details
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoices_Details $invoices_Details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoices_Details  $invoices_Details
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        // $id = $request->id_file;
        // $invoices = Invoices_attachments::where('invoice_id', $id)->first();

        $invoices = Invoices_attachments::findOrFail($request->id_file);
        $invoices->delete();
        Storage::disk('uploads')->delete($request->invoice_number.'/'.$request->file_name);
        session()->flash('delete' , 'تم حذف المرفق بنجاح');
        return back();
        // return request();
    }

     public function get_file($invoices_number , $file_name)
    {
        $files = public_path('/Attachments'.'/'.$invoices_number.'/'.$file_name);
        return Response()->download($files);
    }

    public function open_file($invoices_number , $file_name)
    {
        $files = public_path('/Attachments'.'/'.$invoices_number.'/'.$file_name);
        return Response()->open($files);
    }
   
    
}
