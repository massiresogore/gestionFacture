<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function index()
    {
        return response()->json([
            "invoices"=> Invoice::all()
        ]);
    }

    public function findOne($id): \Illuminate\Http\JsonResponse
    {
        $invoice = Invoice::where('id', $id)->first();
        if($invoice === null )
        {
            return response()->json([
                'errors'=> 'Invoice with the given id does not exist'
            ]);
        }

        return response()->json([
            "product"=> $invoice
        ]);
    }

    public function delete($id)
    {
        //Find
        $invoice = Invoice::where('id', $id)->first();;

        if($invoice === null)
        {
            return response()->json([
                'errors'=> 'invoice with the given id, do not exist'
            ]);
        }

        Invoice::where('id', $id)->delete();

        //Supprime tous les enregistrement associé au models
        //Product::truncate();

        return response()->json([
            "product"=> "Delete invoice success"
        ]);
    }

    public function create(Request $request)
    {
        $isValid = $this->validateInvoice($request);
        if(!$isValid['isValid'] ) {
            return response()->json([
                'errors'=> $isValid['errors']
            ],400);
        }

        $invoice = Invoice::create([
            "reference"=>$request->input('reference'),
            "number" => $request->input('number'),
            "date" => $request->input('date'),
            "due_date" => $request->input('due_date'),
            "term_and_conditions" => $request->input('term_and_conditions'),
            "discount" => $request->input('discount'),
            "total" => $request->input('total'),
            "user_id" => $request->input('user_id'),
        ]);

        foreach ($request->input('product_items') as $item ){
            InvoiceProduct::create([
                "product_id"=> $item['id'],
                "invoice_id"=> $invoice->id,
                "quantity"=> $item['quantity'],
                "unit_price"=> $item['unit_price'],
            ]);
        }
        return response()->json([
            $invoice
        ],200);

    }


    public function update(Request $request, $id)
    {
        //Chercher d'abord si le produit avec cet id existe
        $invoices = Invoice::all();
        $invoice = $invoices->find($id);

        $isValid = $this->validateInvoice($request);

        if($invoice=== null || !$isValid['isValid'] )
        {
            return response()->json([
                'errors'=>  $isValid['errors'],
                'invoiceNotFound'=> $invoice === null ? 'Invoice not found' : false,

            ]);
        }

        //Updated
        $invoice->update($request->all());

        //On suprimme les produit liee à cette facture et on insert de nouveau produit a cette facture
        $invoice->deleteInvoiceProduct();

        foreach ($request->input('product_items') as $item ){
            InvoiceProduct::create([
                "product_id"=> $item['id'],
                "invoice_id"=> $invoice->id,
                "quantity"=> $item['quantity'],
                "unit_price"=> $item['unit_price'],
            ]);
        }

        return response()->json([
            'product_updated'=>  $invoices->find($id)
        ]);

    }


    public function validateInvoice($request): array
    {
        $validator = Validator::make($request->all(),[
            'reference'=> 'required',
            'number'=> 'required',
            'date'=> 'required|date',
            'due_date'=> 'required|date',
            'term_and_conditions'=> 'required|min:10',
            'discount'=> 'required|numeric',
            'total'=> 'required|numeric',
            'user_id'=> 'required|numeric',
            "product_items"=> 'required|array'

        ]);

        if ($validator->fails()){

            return [
                'isValid'=> false,
                'errors'=> $validator->messages()
            ];
        }
        return  [
            'isValid'=> true,
            'errors'=> null
        ];
    }

}
