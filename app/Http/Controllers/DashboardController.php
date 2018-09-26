<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function dashboard(Request $request)
    {
        if($request->has('from_date')){
            $from = $request->from_date;
        }
        if($request->has('to_date')){
            $to = $request->to_date;
        }
        if($request->has('to_date') && $request->has('from_date') ){
            $openCases = Report::where('status','open')->whereBetween('updated_at',array($from,$to))->count();
            $closedCases = Report::where('status','closed')->whereBetween('updated_at',array($from,$to))->count();

        }else{
            $openCases = Report::where('status','open')->count();
            $closedCases = Report::where('status','closed')->count();
        }
//dd($openCases);

        return view('dashboard')->with([
            'openCases'=>$openCases,
            'closedCases'=>$closedCases,
        ]);
    }
}
