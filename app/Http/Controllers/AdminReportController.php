<?php
namespace App\Http\Controllers;
use App\Expense;
use App\Invoice;
use App\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
class AdminReportController extends Controller
{
    /* view invoice report */
    public function invoiceReportIndex(Request $request, Invoice $invoice)
    {
        $invoice = $invoice->newQuery();
        $options['limit'] = $request->has('limit') ? $request->get('limit') : 10;
        $options['from_date'] = $request->has('from_date') ? $request->get('from_date') : "";
        $options['to_date'] = $request->has('to_date') ? $request->get('to_date') : "";
        $options['report_by'] = $request->has('report_by') ? $request->get('report_by') : "";
        if ($options['from_date'] != "") {
            /* if the request has from_date */
            $invoice->where('invoice_date', '>=', $options['from_date']);
        }
        if ($options['to_date'] != "") {
            /* if the request has to_date */
            $invoice->where('invoice_date', '<=', $options['to_date']);
        }
        if ($options['report_by'] == "1") {
            /* if the request is todays filter */
            $invoice->where('invoice_date', '=', Carbon::now()->toDateString());
        }
        if ($options['report_by'] == "2") {
            /* if the request has this week filter */
            $invoice->whereBetween('invoice_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        }
        if ($options['report_by'] == "3") {
            /* if the request has this month filter */
            $invoice->whereBetween('invoice_date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
        }
        if ($options['report_by'] == "4") {
            /* if the request hass this year filter */
            $invoice->whereBetween('invoice_date', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->get();
        }
        if ($options['limit'] != "all") {
            /*  if the no.of.records selection is all */
            $invoices = $invoice->latest()->paginate($options['limit']);
        } else {
            /*  display the records depends on no.of.selection */
            $limit = Invoice::count();
            $invoices = $invoice->latest()->paginate($limit);
        }
        if ($request->ajax()) {
            /* if the request is ajax request */
            return view('admin.reports.invoice-report-list', compact('invoices', 'options'));
        } else {
            /* if the request is not a ajax request */
            return view('admin.reports.invoice-report', compact('invoices', 'options'));
        }
    }
    /* view customer report */
    public function customerReportIndex(Request $request)
    {
        $options['report_by'] = $request->has('report_by') ? $request->get('report_by') : "";
        $customer = Customer::find($options['report_by']);
        if ($request->ajax()) {
            /* if the request is ajax request */
            return view('admin.reports.customer-report-list', compact('customer', 'options'));
        } else {
            /* if the request is not a ajax request */
            return view('admin.reports.customer-report', compact('customer', 'options'));
        }
    }

    public function ExpenseReportIndex()
    {
        $date = date('Y-m-d');
        $end_date = date('Y-m-d');
        $project_id = '';
        $category_id = '';
            $get_report = Expense::select("expenses.*", "expense_categories.name as expense_category", "expense_sub_categories.name as expense_sub_category",
                "customers.display_name as project_name")
                ->join("customers", "customers.id", "=", "expenses.customer_id")
                ->join("expense_categories", "expense_categories.id", "=", "expenses.expense_category_id")
                ->join("expense_sub_categories", "expense_sub_categories.id", "=", "expenses.expense_subcategory")
                ->where("date", date('Y-m-d'))
                ->get();
            //   return $get_report;


        return view("admin.reports.expense-report", compact('get_report','project_id','category_id', 'date', 'end_date'));

        }
    public function ExpenseReportFilter(Request $request)
    {

        $project_id='';
        if(isset($request->project))
        {
            $project_id = $request->project;
        }
        $date = date('Y-m-d');
        if(isset($request->date))
        {
            $date = $request->date;
        }
        $end_date = date('Y-m-d');
        if(isset($request->end_date))
        {
            $end_date = $request->end_date;
        }
        $category_id = '';
        if(isset($request->category))
        {
            $category_id = $request->category;
        }
        $get_report = Expense::select("expenses.*", "expense_categories.name as expense_category", "expense_sub_categories.name as expense_sub_category",
            "customers.display_name as project_name")
            ->join("customers", "customers.id", "=", "expenses.customer_id")
            ->join("expense_categories", "expense_categories.id", "=", "expenses.expense_category_id")
            ->join("expense_sub_categories", "expense_sub_categories.id", "=", "expenses.expense_subcategory")
            ->whereDate('date', '>=', $date)
            ->whereDate('date', '<=', $end_date)
            ->when($project_id, function ($query) use ($project_id) {
                return $query->where('expenses.customer_id',$project_id);
            })
            ->when($category_id, function ($query) use ($category_id) {
                return $query->where('expenses.expense_category_id',$category_id);
            })

            ->get();
        //   return $get_report;


        return view("admin.reports.expense-report", compact('get_report','project_id','category_id', 'date', 'end_date'));

    }
}
