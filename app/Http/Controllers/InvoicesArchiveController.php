<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoices;

class InvoicesArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoices::onlyTrashed()->get(); //using (onlyTrashed) -> to get only softdeleted invoices (have date$time in deleted_at culomn) not hade forcedelete (null in  deleted_at)
        return view('invoices.invoices_archive' , compact('invoices'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->invoice_id;                           //using (withTrashed) -> to specfic deleted_at column where it have date&time
        Invoices::withTrashed()->where('id', $id)->restore(); //using (restore) -> to change deleted_at value from date&time => to null
        session()->flash('return' , "تم أستعادة الفاتوره من الأرشيف بنجاح");
        return redirect('/home/invoices');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $invoice = Invoices::withTrashed()->where('id', $id)->first();
        $invoice->forceDelete();
        session()->flash('delete' , 'تم حذف الفاتوره من الأرشيف بنجاح');
        return back();

    }
}
