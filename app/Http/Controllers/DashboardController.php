<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Resident;
use App\Models\Complaint;
use App\Models\DomesticHelp;
use App\Models\VendorVisit;
use App\Models\Visitor;
use App\Models\Vehicle;
use App\Models\Vendor;
use App\Models\VisitorPreapproval;
use App\Models\Notification;
use App\Models\Role;
use App\Models\Tower;
use App\Models\Floor;
use App\Models\Flat;
use App\Models\ParkingLot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Add this line to import DB facade

class DashboardController extends Controller
{
 
   
    public function index()
    {
         // Get the authenticated user's ID
         $userId = Auth::id();
        //  echo auth()->user()->role;
        
        $user = auth()->user();
    $roleName = strtolower(optional($user->roleMaster)->role_name);

    // ================= ADMIN =================
    if ($roleName === 'admin') {

      
        
               
                return view('dashboard', [
                'usersCount'        => User::count(),
                'residentsCount'    => Resident::count(),
                'complaintsCount'   => Complaint::count(),
                'domesticCount'     => DomesticHelp::count(),
                'vendorsCount'      => VendorVisit::count(),
                'visitorsCount'     => VisitorPreapproval::count(),
                    ]);
            
             }
             if ($roleName ==='resident') {

       $user = User::with(['tower', 'floor', 'flat', 'parking'])
                                    ->find(auth()->id());

    $todayVisitors = \App\Models\VisitorPreapproval::
        where('resident_id', $user->id)
        ->whereDate('visit_date', today())
        ->count();

    $recentVisitors = \App\Models\VisitorPreapproval::
        where('resident_id', $user->id)
        ->latest()
        ->take(5)
        ->get();

    return view('resident-dashboard', compact(
        'user',
        'todayVisitors',
        'recentVisitors'
    ));
}

           
             
//               if (auth()->user()->role == 'resident') {

//                         $user = User::with(['tower', 'floor', 'flat', 'parking'])
//                                     ->find(auth()->id());
                    
//                         $vehicleCount = Vehicle::where('resident_id', auth()->id())->count();
                    
//                         $complaintsCount = Complaint::where('resident_id', auth()->id())->count();
                    
//                         $domesticCount = DomesticHelp::where('resident_id', auth()->id())->count();
                    
//                         // $todayVisitors = Visitor::where('flat_id', $user->flat_id ?? 0)
//                         //                         ->whereDate('created_at', now())
//                         //                         ->count();
                    
//                         // $recentVisitors = Visitor::where('flat_id', $user->flat_id ?? 0)
//                         //                          ->latest()
//                         //                          ->take(5)
//                         //                          ->get();

//             return view('resident-dashboard', compact(
//                 'user',
//                 'vehicleCount',
//                 'complaintsCount',
//                 'domesticCount'
//                 // 'todayVisitors',
//                 // 'recentVisitors'
//             ));
// }

//if (auth()->user()->role == 'security') {

  //  return view('security-dashboard', [
        // 'pendingVisitors'   => Visitor::where('status', 'pending')->count(),
        // 'scheduledVisitors' => Visitor::whereDate('created_at', now())->count(),
        //'domesticHelps'     => DomesticHelp::where('status', 'present')->count(),
        //'vehiclesInside'    => Vehicle::where('status', 'inside')->count(),
        // 'activityLogs'      => Visitor::latest()->take(10)->get(),
        // 'alerts'            => Incident::latest()->take(5)->get()
   // ]);
//}

if ($roleName === 'security') {

    return view('security-dashboard', [
           // From visitor_preapprovals table
        'pendingVisitors' => VisitorPreapproval::where('status', 'pending')->count(),

        'checkedInVisitors' => VisitorPreapproval::where('status', 'used')->count(),

        // Preapproved visitors scheduled for today
        'vendorsScheduled' => VisitorPreapproval::whereDate('visit_date', today())->count(),

        // Actual visitors currently inside (from visitors table)
        'vendorsPresent' => VisitorPreapproval::where('status', 'inside')->count(),

        // Recent visitor activity logs
        'activityLogs' => VisitorPreapproval::latest()->take(10)->get(),
        
        // ADD THIS
    'unreadNotifications' => Notification::where('is_read', 0)->where('audience', 'security')->count(),
    'recentNotifications' => Notification::latest()->take(5)->get()
    ]);
}


             
             if ($roleName ==='tenant') {
                  
                 return view('tenant-dashboard'); 
            
                 
             }
             
             
              if ($roleName === 'vendor') {
                  
                 return view('vendor-dashboard'); 
            
                 
             }

             if ($roleName === 'visitor') {
                  
                 return view('visitor-dashboard'); 
            
                 
             }
             
             if ($roleName ==='tenant') {
                  
                 return view('tenant-dashboard'); 
            
                 
             }
             if ($roleName === 'domestichelp') {
                  
                 return view('domestic_help-dashboard'); 
            
                 
             }
             
              if ($roleName === 'housekeeping') {
                  
                 return view('housekeeping-dashboard'); 
            
                 
             }
    }
}
