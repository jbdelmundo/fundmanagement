<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Aysem;
use App\Department;
use App\AccountTransactions;
use App\Account;
use Illuminate\Support\Facades\DB;

class UsageStatisticsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $user = Auth::user();
        $departments = Department::all();
        $new = null;
        $active_department_id = $request->session()->get('active_dept_id');
        $usagestatistics = DB::table('usagestatistics')->where('department_id', $active_department_id)->get(); //all usage statistics with dept = active dept
        //dd($usagestatistics);
        return view('usagestatistics.show', compact('new','usagestatistics','eresource','user', 'departments','active_department_id'));
    }

    public function buildChart(Request $request)
    {

        $user = Auth::user();
        $departments = Department::all();
        
        $active_department_id = $request->session()->get('active_dept_id');
        $usagestatistics = DB::table('usagestatistics')->where('department_id', $active_department_id)->get();
        $data = DB::table('usagestatistics')->select('month', 'year', 'usage')->where('eresource_id', $request->eresource_id)->get();

        //dd($data);

        //return redirect()->back();


        $usageTable = \Lava::DataTable();  // Lava::DataTable() if using Laravel

        $usageTable->addNumberColumn('Month')
                    ->addNumberColumn('Usage');

        foreach($data as $d){
            $usageTable->addRow([
                $d->month,
                $d->usage
            ]);
        }

        
        $chart = \Lava::LineChart('MyStocks', $usageTable);
        $new = \Lava::render('LineChart', 'MyStocks', 'try');
        return view('usagestatistics.show', compact('usagestatistics','eresource','user', 'departments','active_department_id','new'));
    }
    
}