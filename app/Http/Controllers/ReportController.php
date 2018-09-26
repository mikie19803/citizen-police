<?php

namespace App\Http\Controllers;

use App\Category;
use App\CollaboratorRequest;
use App\Comment;
use App\DocumentUpload;
use App\Location;
use App\Mail\SendCollaborationInvitation;
use App\OfficerReport;
use App\Report;
use App\User;
use App\UserReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use PhpParser\Node\Expr\Cast\Double;


class ReportController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth')->only(['index']);
        $this->middleware('admin')->only(['getOfficersCases','getAllReports']);
    }

    public function index()
    {
        $user = Auth::user();
        if($user->isCitizen){
            $reports = Auth::user()->reportedCases()->orderby('created_at', 'desc')->get();
            $header = 'Complains';
        }else if($user->isOfficer){
            $reports = Auth::user()->assignedCases()->orderby('created_at', 'desc')->get();
            $header = 'My Assigned Cases.';

        }
        return view('reports.index')->with([
            'reports' => $reports,
            'header'=>$header
        ]);
    }

    public function getOfficersCases($id = null)
    {
        if($id ==null){
            $user = Auth::user();
            $header = 'Cases assigned to me.';

        }else{
            $user = User::find($id);
            $header = 'Cases assigned to '.$user->name;
        }
        $reports = $user->assignedCases()->orderby('created_at', 'desc')->get();
        return view('reports.officer-index')->with([
            'reports' => $reports,
            'header'=>$header
        ]);
    }

    public function getAllReports(Request $request)
    {
        $q = new GeneralController();

        $query = Report::query();
        if($request->has('status') && strcasecmp(trim($request->status),'')!=0){
            $status = $request->status;
                 $query->ofStatus($status);

                $name = $this->getStatusForUser($status);


                $header = $name.' Cases';


        }else{
            $header='All Cases';
        }
        $reports = $query->orderby('created_at', 'desc')->paginate($q->paginate);
        return view('reports.all-index')->withReports($reports)->withHeader($header);
    }

    public function create()
    {
        $categories = Category::active()->pluck('category', 'id');
        return view('reports.create')->with([
            'categories' => $categories,
        ]);

    }

    public function store(Request $request)
    {
        $code = $this->generateReportCode();

        if (Auth::guest()) {
            $attachCode = $this->generateReportAttachCode();
        } else {
            $attachCode = null;
        }
        $request->merge([
            'status' => 'open',
            'code' => $code,
            'state' => 'new',
            'attach_code' => $attachCode
        ]);
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $request->merge([
                'reported_by' => Auth::user()->id
            ]);
        } else {
            $user_id = null;
        }

        $report = Report::create($request->all());
//        $report->citizens()->attach([$user_id]);


        //Upload Documents

        $files = Input::file('document_file');

        if ($files != null) {
            foreach ($files as $key => $file) {
                $filename = date('y-m-d H_i_s') . "." . pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
                $file->move(public_path('documents/'), $filename);
//                  $file->move(('../../one/documents/'), $filename);

                $doc = new DocumentUpload();
                $doc->report_id = $report->id;
                $doc->uploaded_by = $user_id;
                $doc->path = $filename;
                $doc->save();


            }
        }
        $message = "Your Report has been sent successfully. You can track the status of your report with code ".$code.".";
        $redirectTo = '/report';
        if (Auth::guest()) {
            $message .= "You are currently not signed in and your report is tagged as anonymous. However you can add this report to your account when you sign in with this secret code - " . $attachCode;
            $redirectTo = '/report/create';
        }


        Session::flash('success', $message);
        return redirect($redirectTo);

    }

    public function show(Request $request, $id) // id is report code
    {

        $report = Report::where('code', $id)->first();

        //check if its an invitation link and if it has been processed or not
        if ($request->has('invitation')) {
            $count = CollaboratorRequest::where([
                'report_id' => $report->id,
                'inviteTo' => Auth::user()->id
            ])->count();
            if ($count < 1) {
                return redirect('/report/' . $id);
            }
        }


        if ($report != null) {
            $documents = $report->uploadedDocuments()->orderBy('created_at', 'desc')->get();
            $comments = $report->comments()->orderBy('created_at', 'desc')->get();
            //            $documents = DocumentUpload::where('report_id', $id)->orderBy('created_at', 'desc')->get();
//            $comments = Comment::where('report_id',$id)->orderBy('created_at','desc')->get();
            return view('reports.show')->with([
                'report' => $report,
                'documents' => $documents,
                'comments' => $comments,
            ]);
        }
        return view('reports.show')->with([
            'report' => $report,
        ]);

    }

    public function update($id)//report code
    {

        $q = new GeneralController();

        $r = Report::where([
            'code' => $id
        ])->first();
        $reportId = $r->id;

        $userId = Auth::user()->id;
        $files = Input::file('document_file');
        if ($files != null) {
            foreach ($files as $key => $file) {
                $filename = date('y-m-d H_i_s') . "." . pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
                $file->move(public_path('documents/'), $filename);
                $doc = new DocumentUpload();
                $doc->report_id = $reportId;
                $doc->uploaded_by = $userId;
                $doc->path = $filename;
                $doc->save();
            }
        }
        Session::flash('success', 'Files have been uploaded');
        return redirect()->back();


    }

    public function getLocations(Request $request)
    {
        $data = Location::select("location as name")->where("location", "LIKE", "%{$request->input('query')}%")->get();
        return response()->json($data);
    }

    public function generateReportCode()
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        $check = false;
        //Check if code exists in db;
        while ($check == false) {
            $code = substr(str_shuffle($chars), 0, 5);
            $count = Report::where('code', $code)->count();
            if ($count > 0) {
                $check = false;
            } else {
                $check = true;
            }

        }
        return $code;


    }

    public function generateReportAttachCode() //this code is entered so that anonymous user can attach case to account
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        return substr(str_shuffle($chars), 0, 4);
    }

    public function postComment(Request $request)
    {


        $q = new GeneralController();

        $comment = nl2br($request->comment);
        $reportId = $request->report_id;


        if (Auth::check()) {
            $user = Auth::user();
            $name = $user->name;
            $role = $user->role;
            $userId = $user->id;

            if ($user->is_citizen && $user->ofIsCollaborator($reportId)) {
                $bg = 'bg-info';
                $icon = 'fa fa-user';
                $div = $q->citizenCommentBackground;
            } else if ($user->is_officer && $user->ofIsCaseOfficer($reportId)) {

                $bg = 'bg-success';
                $icon = 'fa fa-shield';
                $div = $q->officerCommentBackground;
            } else {
                return 2; //cannot post comment
            }

            $c = Comment::create([
                'report_id' => $reportId,
                'user_id' => $userId,
                'comment' => $comment
            ]);


            $now = Carbon::parse($c->created_at);
            $time = $now->format('g:i a');
            $date = $now->format('d M, Y');

        } else {
            return 0; //not authentitcated
        }

        return " <li>
                            <time class='cbp_tmtime' datetime='2017-05-17T03:45'>
                                <span class='mtime'>$time</span>
                                <span class='mtime'>$date</span>
                            </time>
                            <div class='cbp_tmicon $bg'>
                                <i class='$icon'></i>
                            </div>
                            <div class='cbp_tmlabel' style='background-color:$div'>
                                <h2><a href='#'>$name</a> </h2>
                                <p>
                                $comment
                                </p>
                            </div>
                        </li>";
    }

    public function addCollaborator(Request $request, $addBy)
    {

        $formdata = $request->formdata;
        $formArray = $resultsArray = array();
        parse_str($formdata, $formArray);
        $value = $formArray['value'];
        $reportId = $request->report_id;
        $inviteFrom = Auth::user()->name;
        $inviteFromId = Auth::user()->id;


        if ($addBy == 'id') {//add by account number
            $user = User::where('account_no', $value)->isConfirmed()->first();
        } else if ($addBy == 'number') {
            $user = User::where('number', $value)->isConfirmed()->first();

        } else if ($addBy == 'email') {
            $user = User::where('email', $value)->isConfirmed()->first();

        } else {
            array_push($resultsArray, ['code' => 0]);
            return json_encode($resultsArray);
        }
        if ($user != null && $user->count() > 0) {

            // check if invitation already exists

            $count = CollaboratorRequest::where([
                'inviteTo' => $user->id,
                'report_id' => $reportId,
            ])->count();

            if ($count > 0) { //if invitation exists, return
                array_push($resultsArray, ['code' => 3]);
                return json_encode($resultsArray);
            }


            //check if person is already a collaborator

            $count2 = UserReport::where([
                'user_id' => $user->id,
                'report_id' => $reportId,
            ])->count();

            if ($count2 > 0) { //if invitation exists, return
                array_push($resultsArray, ['code' => 4]);
                return json_encode($resultsArray);
            }



            $result = $this->sendCollaboratorInvitationNotification($user, $inviteFrom);
            if ($result == 1) {
                $this->insertInvitationToDb($inviteFromId, $user, $reportId);
                array_push($resultsArray, ['code' => 1, 'name' => $user->name]);
                return json_encode($resultsArray);
            } else {
                array_push($resultsArray, ['code' => 0]);
                return json_encode($resultsArray);
            }
        } else {
            array_push($resultsArray, ['code' => 2]);
            return json_encode($resultsArray);
        }


    }

    public function sendCollaboratorInvitationNotification(User $user, $inviteFrom)
    {
        if ($user->email != null) {
            try {
                Mail::to($user->email, $user->name)->queue(new SendCollaborationInvitation($user->name, $inviteFrom));


                return 1;


            } catch (\Exception $e) {
                Log::info('Collaborator invite email failed ' . $user->email);
                return 2;

            }
        } else if ($user->phone != null) {
            //send notification
            //add to db
        }
    }

    public function attachToAccount(Request $request)
    {
        $formArray = array();
        parse_str($request->formdata, $formArray);
        $reportId = $request->report_id;
        $code = $formArray['code'];
        if (Auth::guest()) {
            return 2;
        } else {
            $userId = Auth::user()->id;
        }
        $report = Report::where('attach_code', $code)->first();
        if ($report == null) {
            return 3;
        }
        $report->reported_by = $userId;
        $report->attach_code = null;
        $report->save();



        $userReport = UserReport::firstOrCreate([
            'user_id'=>$userId,
            'report_id'=>$report->id
        ]);

//        $userReport = UserReport::where([
//            'report_id' => $report->id,
//            'user_id' => null,
//        ])->first();
//        $userReport->user_id = $userId;
//        $userReport->save();
        return 1;

    }

    /**
     * @param $inviteFromId
     * @param $user
     * @param $reportId
     */
    public function insertInvitationToDb($inviteFromId, $user, $reportId)
    {
        $collaborator = new CollaboratorRequest();
        $collaborator->inviteFrom = $inviteFromId;
        $collaborator->inviteTo = $user->id;
        $collaborator->report_id = $reportId;
        $collaborator->save();
    }

    public function processInvitation(Request $request) //Accept or decline invitation
    {
        $reportId = $request->report_id;
        $userId = Auth::user()->id;
        $action = $request->action;

        if (strcasecmp($action, 'accept') == 0) {

            $r = UserReport::firstOrCreate([
                'user_id' => $userId,
                'report_id' => $reportId
            ]);


            CollaboratorRequest::where([
                'inviteTo' => $userId,
                'report_id' => $reportId
            ])->delete();

            $message = "Invitation has been accepted.";

        } else if (strcasecmp($action, 'decline') == 0) {
            CollaboratorRequest::where([
                'inviteTo' => $userId,
                'report_id' => $reportId
            ])->delete();
            $message = "Invitation has been declined.";
        }
        return $message;
    }

    public function test()
    {
        $user = Auth::user();
        $a = $user->ofIsCit(9);
//        $a = $user->first()->is_citizen(3);
        echo 'result of iscitizen is ' . $a . "<br/>";
        echo 'test function';
    }

    public function getStatusForUser($status)
    {
        if(strcasecmp($status,'open')==0){
            return 'Open';
        }else if(strcasecmp($status,'closed')==0){
            return 'Closed';
        }
    }

    public function assignOfficersToCase(Request $request)
    {
        $idArray = $request->id_array;
        $reportId = $request->report_id;
        foreach ($idArray as $row)
        {
             $charges[] = [
                'user_id' => $row,
                'report_id' => $reportId,
                 'created_at'=>Carbon::now()

            ];
        }

        OfficerReport::insert($charges);
     }

    public function unassignOfficer(Request $request)
    {
        $officerId = $request->officer_id;
        $reportId = $request->report_id;

        $report = OfficerReport::where([
            'user_id'=>$officerId,
            'report_id'=>$reportId
        ]);
        if($report!=null){
            $report->delete();
        }

     }

    public function getCaseOfficers($id)
    {
        $report = Report::find($id);
        $officers = User::where('role','officer')->get(['id','name']);
        $assignedOfficers = $report->officers;
        return view('reports.assign-officer')->with([
           'report'=>$report,
            'officers'=>$officers,
            'assignedOfficers'=>$assignedOfficers
        ]);

    }

    public function verifyAssignedOfficer(Request $request){
        $userid = $request->user_id;
        $reportid = $request->report_id;
        $count = OfficerReport::where([
            'user_id'=>$userid,
            'report_id'=>$reportid
        ])->count();
        if($count>0){
            return 0;
        }else{
            return 1;
        }
    }

    public function findByCode(Request $request)
    {
        $code = $request->code;
        return redirect('report/'.$code);
    }

    public function closeCase($id)
    {
        $report = Report::find($id);
        if($report!=null){
            $report->status = 'closed';
            $report->save();
        }
    }




}
