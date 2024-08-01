<?php

namespace App\Http\Controllers;

use App\Models\Invoices_attachments;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use File;
use Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class InvoicesAttachmentsController extends Controller
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
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $request->validate([
        'file_name' => 'required|mimes:pdf,jpeg,png,jpg,bmp,mp4'
       ],[
        'file_name'=> 'صيغة المرفق يجب ان تكون   pdf, jpeg , png , jpg , bmp , mp4',
       ]);

       //get image name
       $image = $request->file('file_name');
       $file_name = $image->getClientOriginalName();

       //put in database
       $att = new Invoices_attachments();
       $att->file_name = $file_name;                      //-> .jpg , png
       $att->invoice_number = $request->invoice_number;  //-> رقم الفاتوره
       $att->invoice_id = $request->invoice_id;          //-> الفاتوره id 
       $att->Created_by = Auth::user()->name;            //->  اسم المستخدم 

       $att->save();

        // move pic
        $imageName = $request->file_name->getClientOriginalName();
        $request->file_name->move(public_path('Attachments/'. $request->invoice_number), $imageName);
    
        //make message and return back
        session()->flash('Add', 'تم اضافة المرفق بنجاح');
        return back();


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoices_attachments  $invoices_attachments
     * @return \Illuminate\Http\Response
     */
    public function show(Invoices_attachments $invoices_attachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoices_attachments  $invoices_attachments
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoices_attachments $invoices_attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoices_attachments  $invoices_attachments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoices_attachments $invoices_attachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoices_attachments  $invoices_attachments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $invoices = Invoices_attachments::findOrFail($request->id_file);
        $file_deleted = $invoices->delete();
        if($file_deleted){
            Storage::disk('public_uploads')->delete($request->invoices_number.'/'.$request->file_name);
        }
        session()->flash('delete' , 'تم حذف المرفق بنجاح');
        return back();
    }
    // public function open_file($invoices_number , $file_name)
    // {
    //     $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix( $invoices_number .'/'. $file_name);
    //     return response()->file($files);
    // }

    // public function open_file($invoices_number , $file_name)
    // {
    //     $files = public_path('/Attachments'.'/'.$invoices_number.'/'.$file_name);
    //     return response()->open($files);
    // }

   

    // public function open_file($invoices_number , $file_name)
    // {
    //     if(File::isFile($f))
    // {
    //     $f = public_path('/Attachments'.'/'.$invoices_number.'/'.$file_name);
    //     $response = response()->make($f, 200);
    //     $response->header('Content-Type', 'application/pdf');
    //     return $response;
    // }
    
    }
