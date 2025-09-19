<?php

namespace App\Http\Controllers;

use App\Models\UStockSumOriRelax;
use App\Models\UStockSumRelax;
use App\Models\UStockMutationGlobalRelax;
use App\Models\UStockMutationOriRelax;
use Illuminate\Http\Request;
use DataTables;

class StockRelaxController extends Controller
{
    public function Allstockrelax(){
      
        return view('stockrelax.all_stockrelax');
    }


    public function Getstockrelax(Request $request){

        if ($request->ajax()) {     
            $items = UStockSumRelax::with(['item.category', 'item.unit'])->get();
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

    public function Allstockrelaxdetail(){
        return view('stockrelax.all_stockdetailrelax');
    }

    public function Getstockrelaxdetail(Request $request){

        if ($request->ajax()) {     
            $items = UStockSumOriRelax::with(['item.category', 'item.unit','qrs'])->get();
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
 


    public function Allstockrelaxmutation(){
        return view('stockrelax.all_stockrelaxmutation');
    }


    public function Getstockrelaxmutation(Request $request){

        if ($request->ajax()) {     
            $items = UStockMutationGlobalRelax::with(['item.category', 'item.unit'])->get();
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

    public function Allstockrelaxmutationori(){
        return view('stockrelax.all_stockrelaxmutationori');
    }



    public function Getstockrelaxmutationori(Request $request){

        if ($request->ajax()) {     
            $items = UStockMutationOriRelax::with(['item.category', 'item.unit','qrs'])->get();
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
