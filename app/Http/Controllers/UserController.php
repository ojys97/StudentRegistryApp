<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\StudentSearchResource;
use App\Imports\StudentImport;
use App\Exports\StudentExport;
use Maatwebsite\Excel\Facades\Excel;


class UserController extends Controller
{   //register functions
    public function studentRegister(Request $request)
    {
        // $request->validate([
        //     'name' => 'required|string',
        //     'email' => 'required|string|email|unique:users',
        //     'password' => 'required|string|min:6',
        // ]);

        $student = new Student([
            'name' => $request->name,
            'email' => $request->email,
            'address' => "$request->address",
            'course' => "SE",
        ]);
        $student->save();

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'connectingID' => $student->id,
        ]);
        $user->save();

        return redirect()->route('home');
    }

    public function staffRegister(Request $request)
    {
        // $request->validate([
        //     'name' => 'required|string',
        //     'email' => 'required|string|email|unique:users',
        //     'password' => 'required|string|min:6',
        // ]);

        $staff = new Staff([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        $staff->save();

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'connectingID' => $staff->id,
        ]);
        $user->save();

        return redirect()->route('home');
    }


    //login functions 
    public function studentLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $student = User::
        where("email","=",$request->email)->
        first();

        if(!$student){
            return redirect()->back()->withErrors(['error' => 'We do not recognize your email!']);
        }
        else{
            if($student->role != 'student'){
                return redirect()->back()->withErrors(['error' => 'Your account does not have access to this page']);
            }
            else{
                if(Hash::check($request->password, $student->password)){
                    Auth::login($student);
                    $id = Auth::user()->id;
                    return redirect()->route('studenthome',['id' => $id]);
                }else{
                    return redirect()->back()->withErrors(['error' => 'Incorrect Password']);
                }
            }
        }
    }


    public function staffLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $staff = User::
        where("email","=",$request->email)->
        first();

        if(!$staff){
            return redirect()->back()->withErrors(['error' => 'We do not recognize your email!']);
        }
        else{
            if($staff->role != 'staff'){
                return redirect()->back()->withErrors(['error' => 'Your account does not have access to this page']);
            }
            else{
                if(Hash::check($request->password, $staff->password)){
                    Auth::login($staff);
                    $id = Auth::user()->id;
                    return redirect()->route('staffhome',['id' => $id]);
                  
                }else{
                    return redirect()->back()->withErrors(['error' => 'Incorrect Password']);
                }
            }
        }
    }
    public function search(Request $request)
{
    $searchQuery = $request->input('search');

    $results = Student::where('name', 'like', "%$searchQuery%")
                      ->orWhere('email', 'like', "%$searchQuery%")
                      ->select('name', 'address')
                      ->get();

    return response()->json(['results' => $results]);
}
    public function index()
{
    $students = Student::paginate(10); 

    return view('auth.staffhome', compact('students'));
}

public function import()
{
    try {
        if (request()->hasFile('file')) {
            $file = request()->file('file');
            // Continue with the import logic
            Student::importFromExcel($file);
        } else {
            return back()->with('error', 'No file uploaded.');
        }
        return redirect()->route('staffhome.index');
    } catch (\Exception $e) {
        return back()->with('error', 'An error occurred during import: ' . $e->getMessage());
    }
}


public function export()
{
    return Excel::download(new StudentExport,'student.xlsx');
}

public function importForDelete()
{
    $file=request()->file('file');
    Student::importFromExcel($file);
    $this->deleteIfExistsInCSV($file);
}

public function deleteIfExistsInCSV(Request $request)
{
    $file = $request->file('file');

    if ($file) {
        try {
            $importedData = Excel::toCollection(new StudentImport, $file)->first();

            foreach ($importedData as $row) {
                if (isset($row['email'])) {
                    $existingStudent = Student::where('email', $row['email'])->first();

                    if ($existingStudent) {
                        $existingStudent->delete();
                    }
                }
            }

            return back()->with('success', 'Deletion successful');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred during deletion: ' . $e->getMessage());
        }
    }

    return back()->with('error', 'No file uploaded for deletion.');
}
}
