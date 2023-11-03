<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UlbRegistration;
use App\Models\StatePortalReg;
use App\Models\DistrictPortalReg;
use App\Models\District;
use App\Models\NagarNigam;
use App\Models\SambhagData;
use App\Models\NagarPalika;
use App\Models\NagarPanchayat;
use App\Models\UserDocument;
use App\Models\VerificationLog;
use Hash;
use Session;
use Illuminate\Support\Facades\Log;

class CustomAuthController extends Controller
{
    public function index()
    {
        // Session::flush();
        return view('auth.login');
    }
    public function registration()
    {
        return view('auth.registration');
    }
    public function registerUser(Request $request)
    {
        $users = User::where('id', Session::get('id'))->first();
        $sambhags = SambhagData::all();
        $districts = District::all();
        $nagarnigam = NagarNigam::all();
        $data = [
            'user' => $users,
            'sambhags' => $sambhags,
            'districts' => $districts,
            'nagarnigam' => $nagarnigam,
        ];

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5',
        ]);

        // Create a new user record with the password hashed using md5
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Use md5 to hash the password
        ]);

        // Attempt to log in the newly registered user with md5-hashed password
        if (\Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return view('auth.dashboard', compact('data'));
        } else {
            // Registration succeeded, but login failed
            // Handle this case accordingly, e.g., redirect to login with an error message
            echo md5($request->password);
            die();
            return redirect('login')->with('fail', 'Login failed after registration');
        }
    }

    // public function loginUser(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     $user = User::where('email', $request->email)->first();

    //     if ($user) {
    //         Session::put('id', $user->id);
    //         $hashedPassword = md5($request->password);
    //         if (Session::has('id') && $hashedPassword === $user->password) {
    //             $data = [];

    //             // if (Session::has('loginId')) {
    //             $user = User::where('id', Session::get('id'))->first();
    //             $sambhags = SambhagData::all(); // Retrieve all Sambhags
    //             $districts = District::all(); // Retrieve all Districts
    //             $nagarnigam = NagarNigam::all();
    //             $data = [
    //                 'user' => $user,
    //                 'sambhags' => $sambhags,
    //                 'districts' => $districts,
    //                 'nagarnigam' => $nagarnigam,
    //             ];
    //             // Check the user's role and redirect accordingly
    //             if ($user->role_id === 1) {
    //                 // ULB-specific logic
    //                 return view('auth.dashboard', compact('data'));
    //             } elseif ($user->role_id === 2) {
    //                 // State Portal-specific logic
    //                 echo 'ULB DASh';
    //             } elseif ($user->role_id === 'district') {
    //                 // District Portal-specific logic
    //                 return view('district.dashboard');
    //             } else {
    //                 return back()->with('fail', 'Invalid role');
    //             }
    //         } else {
    //             return back()->with('fail', 'Password does not match');
    //         }
    //     } else {
    //         return back()->with('fail', 'This email is not registered.');
    //     }
    // }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (\Auth::attempt($request->only('email', 'password'))) {
            return redirect('dashboard');
        }

        return redirect('login')->with(['fail' => 'Login details are not valid']);
    }

    public function logout()
    {
        \Session::flush();
        \Auth::logout();
        return redirect('/');
    }

    public function getDistricts($sambhagId)
    {
        $districts = District::where('sambhag_id', $sambhagId)->get();
        return response()->json($districts);
    }

    public function getNagarNigam($districtId)
    {
        $nagarnigam = NagarNigam::where('dist_id', $districtId)->get();
        return response()->json($nagarnigam);
    }

    public function getNagarPalika($districtId)
    {
        $nagarnigam = NagarPalika::where('dist_id', $districtId)->get();
        return response()->json($nagarnigam);
    }

    public function getNagarPanchayat($districtId)
    {
        $nagarnigam = NagarPanchayat::where('dist_id', $districtId)->get();
        return response()->json($nagarnigam);
    }

    public function dashboard()
    {
        $data = [];

        // if (Session::has('loginId')) {
        $user = User::where('id', Session::get('loginId'))->first();
        $sambhags = SambhagData::all(); // Retrieve all Sambhags
        $districts = District::all(); // Retrieve all Districts
        $nagarnigam = NagarNigam::all();
        $data = [
            'user' => $user,
            'sambhags' => $sambhags,
            'districts' => $districts,
            'nagarnigam' => $nagarnigam,
        ];

        // }

        return view('auth.dashboard', compact('data'));
    }

    public function generateDummyData()
    {
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'june', 'july', 'aug', 'sept', 'oct', 'nov', 'dec'];
        $salesData = [];

        foreach ($months as $month) {
            $salesData[] = [
                'month' => $month,
                'sales' => rand(100, 1000), // Generate random sales data for each month
            ];
        }

        return $salesData;
    }
    public function showChart(Request $request)
    {
        $salesData = $this->generateDummyData();

        return view('auth.chart', compact('salesData'));
    }

    public function ulbRegistration()
    {
        return view('auth.ulbregistration');
    }
    public function registerUlb(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'mobile' => 'required',
            'ulbdivision' => 'required',
        ]);

        $ulb = new UlbRegistration();
        $ulb->ulbcode = $request->ulbcode;
        $ulb->name = $request->name;
        $ulb->email = $request->email;
        $ulb->password = Hash::make($request->password);
        $ulb->mobile = $request->mobile;
        $ulb->ulbdivision = $request->ulbdivision;
        $res = $ulb->save();
        if ($res) {
            return back()->with('success', 'You have registered successfully');
        } else {
            return back()->with('fail', 'Something wrong');
        }
    }
    public function ulbList()
    {
        $ulblist = UlbRegistration::paginate(10);
        return view('auth.ulblist', ['ulblist' => $ulblist]);
    }
    public function ulbLogin()
    {
        return view('auth.ulblogin');
    }
    public function loginUlb(Request $request)
    {
        // $ulblist = UlbRegistration::get();
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $ulb = UlbRegistration::where('email', '=', $request->email)->first();

        if ($ulb) {
            $hashedPassword = Hash::check($request->password);

            if ($hashedPassword === $ulb->password) {
                $request->session()->put('loginId', $ulb->ulbcode);
                $ulblist = UlbRegistration::where('email', $request->email)->get(); // Fetch ulb list for the logged-in user
                return view('auth.ulblist', ['ulblist' => $ulblist]);
            } else {
                return back()->with('fail', 'Password does not match');
            }
        } else {
            return back()->with('fail', 'This email is not registered.');
        }
    }
    //State Portal Registration and Login Module
    public function stateportalreg()
    {
        return view('auth.stateportalregistration');
    }

    public function registerStatePortal(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'mobile' => 'required',
        ]);

        $spuser = new StatePortalReg();
        $spuser->name = $request->name;
        $spuser->email = $request->email;
        $spuser->password = md5($request->password); // Use MD5 hashing (not recommended for security)
        $spuser->mobile = $request->mobile;
        $res = $spuser->save();

        if ($res) {
            return back()->with('success', 'You have registered successfully');
        } else {
            return back()->with('fail', 'Something wrong');
        }
    }
    public function stateportallogin()
    {
        return view('auth.stateportallogin');
    }
    public function loginStatePortal(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $stateuser = StatePortalReg::where('email', '=', $request->email)->first();

        if ($stateuser) {
            $hashedPassword = md5($request->password);

            if ($hashedPassword === $stateuser->password) {
                $request->session()->put('loginId', $stateuser->id);
                return 'State Portal Dashboard';
            } else {
                return back()->with('fail', 'Password does not match');
            }
        } else {
            return back()->with('fail', 'This email is not registered.');
        }
    }

    public function generateRandomCaptcha()
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $length = 6; // Change this to your desired CAPTCHA code length
        $captcha = '';

        for ($i = 0; $i < $length; $i++) {
            $captcha .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $captcha;
    }

    //District Portal
    public function distportalreg()
    {
        return view('auth.districtregistration');
    }

    public function registerDistPortal(Request $request)
    {
        $request->validate([
            // 'name' => 'required',
            // 'email' => 'required|email|unique:user',
            // 'password' => 'required',
            // 'mobile' => 'required'
        ]);

        $dpuser = new DistrictPortalReg();
        $dpuser->name = $request->name;
        $dpuser->email = $request->email;
        $dpuser->password = md5($request->password); // Use MD5 hashing (not recommended for security)
        $dpuser->mobile = $request->mobile;
        $res = $dpuser->save();

        if ($res) {
            return back()->with('success', 'You have registered successfully');
        } else {
            return back()->with('fail', 'Something wrong');
        }
    }

    public function distportallogin()
    {
        return view('auth.districtlogin');
    }

    public function loginDistPortal(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $distuser = DistrictPortalReg::where('email', '=', $request->email)->first();

        if ($distuser) {
            $hashedPassword = md5($request->password);

            if ($hashedPassword === $distuser->password) {
                $request->session()->put('loginId', $distuser->id);
                return 'District Portal Dashboard';
            } else {
                return back()->with('fail', 'Password does not match');
            }
        } else {
            return back()->with('fail', 'This email is not registered.');
        }
    }

    //For Reset Password
    public function showPasswordResetForm()
    {
        return view('auth.PasswordReset');
    }

    public function resetPassword(Request $request)
    {
        // Validate the request and identify the Admin using the provided email
        $request->validate([
            'admin_email' => 'required|email',
            'new_password' => 'required',
            'g-recaptcha-response' => 'required|recaptcha_v3:login,0.5',
        ]);
        $admin = User::where('email', $request->admin_email)
            ->where('role_id', 1)
            ->first();
        // dd($request->admin_email); // Debug the email being used in the query
        print $admin;
        die();
        if ($admin) {
            // Set the new password
            $admin->password = Hash::make($request->new_password);
            $admin->save();
            // Optionally, send an email to the Admin informing them of the password change
            return redirect('dashboard/passwordreset')->with('success', 'Password changed successfully.');
        } else {
            return redirect('dashboard/passwordreset')->with('error', 'Admin not found.');
        }
    }

    //upload document
    public function doocUploadForm()
    {
        return view('auth.UploadDocument');
    }

    public function docUpload(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx|max:2048', // Adjust the rules as needed
        ]);

        if ($request->file('document')->isValid()) {
        $document = new UserDocument();
        $document->user_id = auth()->user()->id; // Assuming you have user authentication
        $document->document_name = $request->file('document')->getClientOriginalName();
        $document->document_path = $request->file('document')->store('documents'); // Store in the 'documents' directory

        $document->save();
        return back()->with('success', 'File uploaded successfully');
        }
        else{
            return back()->with('fail', 'File upload failed');
        }
    }

    public function showVerificationForm($id)
{

    $document = UserDocument::findOrFail($id);
    return view('auth.Verify', ['document' => $document]);
}
public function verifyDocument(Request $request, $id)
{
    $document = UserDocument::findOrFail($id);
    $status = $request->input('status');

    $document->status = $status;
    $document->save();

    $verificationLog = new VerificationLog;
    $verificationLog->document_id = $document->id;
    $verificationLog->admin_id = auth()->user()->id; // Assuming you have an admin authentication
    $verificationLog->status = $status;
    $verificationLog->save();

    return back()->with('success', 'Document verified successfully');
}
}
