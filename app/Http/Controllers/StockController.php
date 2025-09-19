<?php

namespace App\Http\Controllers;

use App\Models\UStockSumOri;
use App\Models\UStockSum;
use App\Models\UStockMutationGlobal;
use App\Models\UStockMutationOri;
use Illuminate\Http\Request;
use DataTables;

class StockController extends Controller
{
    public function Allstock(){
      
        return view('stock.all_stock');
    }


    public function Getstock(Request $request){

        if ($request->ajax()) {     
            $items = UStockSum::with(['item.category', 'item.unit'])->get();
            return Datatables::of($items)
            ->addIndexColumn() 
            ->addColumn('category', function($row) {
                return $row->item->category->name;
            })
            ->addColumn('unit', function($row) {
                return $row->item->unit->unit_code;
            })
            ->addColumn('item_code', function($row) {
                return $row->item->item_code;
            })
            ->addColumn('item_name', function($row) {
                return $row->item->item_name;
            })
            ->addColumn('size', function($row) {
                return $row->size;
            })
            ->addColumn('color_code', function($row) {
                return $row->color_code;
            })
            ->addColumn('color_name', function($row) {
                return $row->color_name;
            })
            ->addColumn('stock', function($row) {
                return $row->stok;
            })
            ->make(true);
                 

        }

    }

    public function Getstockglobal(){
        $items =  UStockSum::with(['item.category', 'item.unit'])->get();
        return response()->json($items);
    }

    public function Allstockdetail(){
        return view('stock.all_stockdetail');
    }

    public function Getstockdetail(Request $request){

        if ($request->ajax()) {     
            $items = UStockSumOri::with(['item.category', 'item.unit','qrs'])->get();
            return Datatables::of($items)
            ->addIndexColumn() 
            ->addColumn('category', function($row) {
                return $row->item->category->name;
            })
            ->addColumn('original_no', function($row) {
                return $row->original_no;
            })

            ->addColumn('received_date', function($row) {
                return $row->qrs->received_date;
            })
            ->addColumn('supplier_name', function($row) {
                return $row->qrs->supplier_name;
            })
            ->addColumn('po', function($row) {
                return $row->qrs->po;
            })
            ->addColumn('batch', function($row) {
                return $row->qrs->batch;
            })
            ->addColumn('roll', function($row) {
                return $row->qrs->roll;
            })
            ->addColumn('gross_weight', function($row) {
                return $row->qrs->gross_weight;
            })
            ->addColumn('net_weight', function($row) {
                return $row->qrs->net_weight;
            })
            ->addColumn('basic_width', function($row) {
                return $row->qrs->basic_width;
            })
            ->addColumn('basic_grm', function($row) {
                return $row->qrs->basic_grm;
            })
     
            ->addColumn('unit', function($row) {
                return $row->item->unit->unit_code;
            })
            ->addColumn('item_code', function($row) {
                return $row->item->item_code;
            })
            ->addColumn('item_name', function($row) {
                return $row->item->item_name;
            })
            ->addColumn('size', function($row) {
                return $row->size;
            })
            ->addColumn('color_code', function($row) {
                return $row->color_code;
            })
            ->addColumn('color_name', function($row) {
                return $row->color_name;
            })
            ->addColumn('stock', function($row) {
                return $row->stok;
            })
            ->make(true);
                 

        }

    }
 
 

    public function Allstockmutation(){
        return view('stock.all_stockmutation');
    }


    public function Getstockmutation(Request $request){

        if ($request->ajax()) {     
            $items = UStockMutationGlobal::with(['item.category', 'item.unit'])->get();
            return Datatables::of($items)
            ->addIndexColumn() 
            ->addColumn('category', function($row) {
                return $row->item->category->name;
            })
            ->addColumn('unit', function($row) {
                return $row->item->unit->unit_code;
            })
            ->addColumn('tanggal', function($row) {
                return $row->tanggal;
            })
            ->addColumn('item_code', function($row) {
                return $row->item->item_code;
            })
            ->addColumn('item_name', function($row) {
                return $row->item->item_name;
            })
            ->addColumn('size', function($row) {
                return $row->size;
            })
            ->addColumn('color_code', function($row) {
                return $row->color_code;
            })
            ->addColumn('color_name', function($row) {
                return $row->color_name;
            })
            ->addColumn('in_qty', function($row) {
                return $row->in_qty;
            })
            ->addColumn('out_qty', function($row) {
                return $row->out_qty;
            })
            ->addColumn('return_qty', function($row) {
                return $row->return_qty;
            })
            ->addColumn('balance', function($row) {
                return $row->balance;
            })
            ->make(true);
                 

        }

    }

    public function Allstockmutationori(){
        return view('stock.all_stockmutationori');
    }



    public function Getstockmutationori(Request $request){

        if ($request->ajax()) {     
            $items = UStockMutationOri::with(['item.category', 'item.unit','qrs'])->get();
            return Datatables::of($items)
            ->addIndexColumn() 
            ->addColumn('category', function($row) {
                return $row->item->category->name;
            })
            
            ->addColumn('original_no', function($row) {
                return $row->original_no;
            })

            ->addColumn('received_date', function($row) {
                return $row->qrs->received_date;
            })
            ->addColumn('supplier_name', function($row) {
                return $row->qrs->supplier_name;
            })
            ->addColumn('po', function($row) {
                return $row->qrs->po;
            })
            ->addColumn('batch', function($row) {
                return $row->qrs->batch;
            })
            ->addColumn('roll', function($row) {
                return $row->qrs->roll;
            })
            ->addColumn('gross_weight', function($row) {
                return $row->qrs->gross_weight;
            })
            ->addColumn('net_weight', function($row) {
                return $row->qrs->net_weight;
            })
            ->addColumn('basic_width', function($row) {
                return $row->qrs->basic_width;
            })
            ->addColumn('basic_grm', function($row) {
                return $row->qrs->basic_grm;
            })
     
            ->addColumn('unit', function($row) {
                return $row->item->unit->unit_code;
            })
            ->addColumn('item_code', function($row) {
                return $row->item->item_code;
            })
            ->addColumn('item_name', function($row) {
                return $row->item->item_name;
            })
            ->addColumn('size', function($row) {
                return $row->size;
            })
            ->addColumn('tanggal', function($row) {
                return $row->tanggal;
            })
            ->addColumn('color_code', function($row) {
                return $row->color_code;
            })
            ->addColumn('color_name', function($row) {
                return $row->color_name;
            })
            ->addColumn('in_qty', function($row) {
                return $row->in_qty;
            })
            ->addColumn('out_qty', function($row) {
                return $row->out_qty;
            })
            ->addColumn('return_qty', function($row) {
                return $row->return_qty;
            })
            ->addColumn('balance', function($row) {
                return $row->balance;
            })
            ->make(true);
                 

        }

    }
 




}
