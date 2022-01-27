<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Garment;
use App\Calldetails;
use Exception;
use Auth;
use DB;
use Illuminate\Pagination\Paginator;

class CallcenterController extends Controller
{   
    /******* gat all call ****/
    public function getAllCall(){
        
        $garments = Garment::paginate(10);

        // $garments = DB::table("garments")
        //             ->leftjoin('call_details', 'garments.id', '=', 'call_details.customer_id')
        //             ->select('garments.*')
        //             ->where('call_details.call_status', '!=', 'Complete')
        //             ->paginate(10);

        //return view('callcenter.allCall');

        return view('callcenter.index', compact('garments'));
    }

    //response garment data to ajax request
    public function getGarmentDetails(Request $request){
        $id = $request->id;
        $qry = "SELECT * FROM `garments` WHERE id = ".$id;
        $data = DB::select($qry);
        if ($data) {
            return json_encode($data);
        } else {
            return json_encode("No data Found");
        }
        
    }

    //store call summary
    public function store_call_data(Request $request){

        try {

            DB::beginTransaction();

            $date_time = null;
            if($request->reschedule_date){
                $date_time = $request->reschedule_date.' '.$request->reschedule_time;
            }

            $visit_date = null;
            if($request->visit_date){
                $visit_date = $request->visit_date.' '.$request->visit_time;
            }

            $customer_id = $request->customer_id;

            //save call history 
            $data = new Calldetails();
            //$data = Calldetails::firstOrNew(array('customer_id' => $customer_id ));
            $data->tc_code = $request->tc_code;
            $data->call_summary = $request->call_summary;
            $data->call_status = $request->call_status;
            $data->rescheduale_time = $date_time;
            $data->qc_visit = $request->qc_visit;
            $data->visit_date = $visit_date;
            $data->customer_id = $customer_id;
            $data->google_form_query = $request->google_form_query;
            $data->whatsapp_no = $request->whatsapp_no;
            $data->created_by = Auth::user()->id;
            $data->save();

            //upadte garments table
            $garment =  Garment::findOrFail($customer_id);
            $garment->tc_code = $request->tc_code;
            $garment->call_summary = $request->call_summary;
            $garment->call_status = $request->call_status;
            $garment->rescheduale_time = $date_time;
            $garment->qc_visit = $request->qc_visit;
            $garment->visit_date = $visit_date;
            $garment->email = $request->email;
            $garment->google_form_query = $request->google_form_query;
            $garment->whatsapp_no = $request->whatsapp_no;
            $garment->save();

            DB::commit();

            return json_encode("success");

        } catch (Exception $exception) {

            DB::rollBack();
        }

        

    }

    
    /******* gat pending call data ****/
    public function getPendingCall(Request $request){

        $maxPage = 10;
        
        $qry = "SELECT * FROM (
            SELECT * FROM `garments` 
            WHERE call_status IN ('Swiched Off','Ringing No Response'))as t";
        $query = DB::select($qry);

        $garments = new Paginator($query, $maxPage);  
        //$garment = $this->arrayPaginator($query, $request);  

        // $garments = DB::table("garments")
        //             ->where('call_status', '!=', 'Complete')
        //             ->paginate(10);

        // $qry1 = "SELECT * FROM (
        //     SELECT *, TIMESTAMPDIFF(MINUTE, NOW(), rescheduale_time) AS dt FROM `garments` 
        //     WHERE call_status = 'Call Back' ) AS a WHERE dt < 120
        //     UNION 
        //     SELECT *, TIMESTAMPDIFF(MINUTE, NOW(), rescheduale_time) AS dt FROM `garments` 
        //     WHERE call_status IN ('Pending')";
        

        $qry1 = "SELECT * FROM (
            SELECT *, TIMESTAMPDIFF(MINUTE, NOW(), rescheduale_time) AS dt FROM `garments` 
            WHERE call_status = 'Call Back' ) AS a WHERE dt < 120
            UNION 
            SELECT *, TIMESTAMPDIFF(MINUTE, NOW(), rescheduale_time) AS dt FROM `garments` 
            WHERE call_status IN ('Pending') limit 10";

        $query1 = DB::select($qry1);

        $pendingCall = $query1;

        //$pendingCall = new Paginator($query1, $maxPage); 
        
        return view('callcenter.pending_call', compact('garments'), compact('pendingCall'));
    }

    
    // get processed call
    public function getPrecessedCall(Request $request){

        $garments = DB::table("garments")
                    ->where('call_status', '!=', 'Pending')
                    ->paginate(10);
        
        return view('callcenter.processed_call', compact('garments'));
    }

    public function arrayPaginator($array, $request)
    {
        $page = Input::get('page', 1);
        $perPage = 10;
        $offset = ($page * $perPage) - $perPage;

        return new LengthAwarePaginator(array_slice($array, $offset, $perPage, true), count($array), $perPage, $page,
            ['path' => $request->url(), 'query' => $request->query()]);
    }


    /******* QC Visit ****/
    public function getPendingQcVisit(){

        $garments = DB::table("garments")
                    ->where('qc_visit', '=', 'Yes')
                    ->where('qc_visit_status', '=', 'Pending')
                    ->paginate(10);
        
        return view('callcenter.qc_visit', compact('garments'));
    }

    //update qc visit status
    public function store_qc_visit_data(Request $request){
        try {

            DB::beginTransaction();

            $customer_id = $request->customer_id;

            //upadte garments table
            $garment =  Garment::findOrFail($customer_id);
            $garment->qc_visit_status = $request->qc_visit_status;
            $garment->save();

            DB::commit();

            return json_encode("success");

        } catch (Exception $exception) {

            DB::rollBack();
        }
    }


    public function fatch_all_call(Request $request){
        //dd($request->project_id);
        if (request()->ajax()) {
            // $where = "";
            // $start_date =  isset($request->start_date) ? $request->start_date.' 00:00:01' : "-1";
            // $end_date = isset($request->end_date) ? $request->end_date.' 23:59:59' : "-1";
            // $project_id = isset($request->project_id) ? $request->project_id : "-1";

            $query = "SELECT * FROM (
                SELECT *, TIMESTAMPDIFF(MINUTE, NOW(), rescheduale_time) AS dt FROM `garments` 
                WHERE call_status = 'Rescheduale' ) AS a WHERE dt < 120
                UNION 
                SELECT *, TIMESTAMPDIFF(MINUTE, NOW(), rescheduale_time) AS dt FROM `garments` 
                WHERE call_status <> 'Complete' AND call_status <> 'Rescheduale' ";

            
            // if (!empty($project_id) && $project_id !='-1') {
            //     $where .= " AND a.project_id = '{$project_id}' ";
            // }

            // if ( (!empty($start_date) && $start_date !='-1' ) && (!empty($end_date) && $end_date !='-1' ) ) {
            //     $where .= " AND a.created_at BETWEEN '{$start_date}' AND '{$end_date}' ";
            // }
            
            // $final_qry = $query.$where;

            $final_qry = $query;

            $stocks = DB::select($final_qry);

            return datatables()->of($stocks)
                ->addColumn('action', function ($row) {
                    $btn = '<button class="btn btn-sm admin-submit-btn-grad text-white" onclick="load_garment(' . $row->id . ')"><i class="fas fa-eye"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);

        }
        return view('callcenter.allCall');
    }

    public function fatch_process_call(){
        if (request()->ajax()) {

            $query = "SELECT * FROM `garments` WHERE call_status != 'Pending'";


            $final_qry = $query;

            $stocks = DB::select($final_qry);

            return datatables()->of($stocks)
                ->addColumn('action', function ($row) {
                    $btn = '<button class="btn btn-sm admin-submit-btn-grad text-white" onclick="load_garment(' . $row->id . ')"><i class="fas fa-eye"></i></button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);

        }
        return view('callcenter.pending_call');
    }
}
