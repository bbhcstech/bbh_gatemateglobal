<?php 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Resident;
use App\Models\Role;
use App\Models\Document;
use App\Models\ProfilePicture;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * List users (Admin only)
     */
    public function index()
    {
        // Simple role check (NO middleware)
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
       $users = User::with('roleMaster','profilePicture', 'document')
             ->whereNotIn('role_id', [1, 2])
             ->where('deleted_status', 0) // if exists
             ->orderBy('id', 'desc')
             ->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show create user form
     */
    public function create()
    {
       
        // if (auth()->user()->role !== 'admin') {
        //     abort(403);
        // }

        // $roles = [
        //     'admin' => 'Admin',
        //     'resident' => 'Resident',
        //     'security' => 'Security',
        //     'tenant' => 'Tenant',
        //     'vendor' => 'Vendor',
        //     'visitor' => 'Visitor',
        //     'domestic_help' => 'Domestic Help',
        //     'housekeeping' => 'Housekeeping',
        // ];

        $roles = Role::get();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store user (static password)
     */
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'name'  => 'required|string|max:255',
            'mobile' => 'required|mobile|unique:users,mobile',
            'role'  => 'required|string',
        ]);

        User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'mobile'         => $request->mobile,
            'role'          => $request->role,
            'password'      => Hash::make('Password@123'), // 🔐 static password
            'otp_verified'  => 1,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Deactivate / Activate user
     */
   public function toggleStatus(User $user)
{
    if ($user->approval_status !== 'approved') {
        return back()->with('error', 'Only approved users can be activated');
    }

    $user->update([
        'is_active' => $user->is_active === 'active' ? 'inactive' : 'active'
    ]);

    return back()->with('success', 'User status updated');
}

 public function approve(User $user)
{
    if ($user->approval_status === 'approved') {
        return back()->with('info', 'User already approved');
    }

    DB::transaction(function () use ($user) {

        $user->update([
            'approval_status' => 'approved',
            'is_active' => 'active',
        ]);

        $user->resident()->firstOrCreate(
            ['user_id' => $user->id],
            [
                'name'     => $user->name,
                'tower_id' => $user->tower_id,
                'floor_id' => $user->floor_id,
                'flat_id'  => $user->flat_id,
                'flat_no'  => optional($user->flat)->flat_no,
                'floor'    => optional($user->floor)->name,
                'phone'    => $user->mobile,
                'email'    => $user->email,
                'type'     => 'owner',
            ]
        );
    });

    return back()->with('success', 'User approved successfully');
}


public function reject(User $user)
{
    DB::transaction(function () use ($user) {

        // Update user status
        $user->update([
            'approval_status' => 'rejected',
            'is_active' => 'inactive',
        ]);

        // Remove resident if exists (reverse approve)
        if ($user->resident) {
            $user->resident->delete();
        }
    });

    return back()->with('success', 'User rejected successfully');
}


public function show($id)
{
    $user = User::with(['tower','floor','flat','parking','roleMaster','profilePicture', 'document'])->findOrFail($id);

    return view('admin.users.show', compact('user'));
}
public function documents()
{
    return $this->hasMany(Document::class, 'user_id', 'id')
                ->where('deleted_status', 0)
                ->where('activity_status', 1);
}

}
