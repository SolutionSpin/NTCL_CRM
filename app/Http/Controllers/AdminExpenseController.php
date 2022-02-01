<?php
namespace App\Http\Controllers;
use App\Expense;
use App\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
class AdminExpenseController extends Controller
{
    /* expense index*/
    public function expensesIndex(Request $request)
    {
        /* if the url has get method */
        $expenses = Expense::select("expenses.*", "expense_categories.name as expense_category", "expense_sub_categories.name as expense_sub_category", "customers.display_name as customer_name")
            ->join("expense_categories", "expense_categories.id","=","expenses.expense_category_id")
            -> join("expense_sub_categories", "expense_sub_categories.id","=","expenses.expense_subcategory")->
            join("customers", "customers.id","=","expenses.customer_id")
            ->orderby("id", "desc")
            ->paginate(15);

     //   var_dump($expenses); die;
        return view('admin.expense.index', compact('expenses'));
    }
    /* expense creation*/
    public function createExpense(Request $request)
    {
        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('admin.expense.create');
        } else {
            /* if the url has post method */
            $expense = new Expense();
            $expense->customer_id = $request->customer_id;
            $expense->expense_category_id = $request->expense_category_id;
            $expense->date = $request->date;
            $expense->amount = $request->amount;
            $expense->expense_subcategory = $request->expense_subcategory;
            $expense->note = $request->note;
            $expense->voucher = $request->voucher;
            $expense->save();
            return redirect('/admin/expenses')->with('message', 'Expense created Successfully.');
        }
    }
    /* destroy expense information*/
    public function destroyExpense($id)
    {
        $expense = Expense::find($id);
        $expense->delete();
        return redirect()->back()->with('message', 'Expense Destroyed Successfully');
    }
    /* Expense updation */
    public function updateExpense(Request $request, $id)
    {
        $expense = Expense::find($id);
        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('admin.expense.create', compact('expense'));
        } else {
            /* if the url has post method */
            $expense->customer_id = $request->customer_id;
            $expense->expense_category_id = $request->expense_category_id;
            $expense->date = $request->date;
            $expense->amount = $request->amount;
            $expense->expense_subcategory = $request->expense_subcategory;
            $expense->note = $request->note;
            $expense->voucher = $request->voucher;
            $expense->save();
            return redirect('/admin/expenses')->with('message', 'Expense Updated Successfully');
        }
    }


}
