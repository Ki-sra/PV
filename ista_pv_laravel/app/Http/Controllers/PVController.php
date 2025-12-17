<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PV;
use App\Models\PVDocument;
use App\Models\StudentCopy;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Storage;

class PVController extends Controller
{
    public function __construct()
    {
        // Ensure authentication for relevant actions (assumes auth scaffolding exists)
        $this->middleware('auth')->except(['index','show']);
    }

    public function index(Request $request)
    {
        $query = PV::query();
        if ($request->filled('year')) {
            $query->where('year', $request->input('year'));
        }
        if ($request->filled('department')) {
            $query->where('department', 'like', '%'.$request->input('department').'%');
        }
        $pvs = $query->orderBy('year', 'desc')->paginate(20);
        return view('pvs.index', compact('pvs'));
    }

    public function show(PV $pv)
    {
        $documents = $pv->pvDocuments()->latest()->get();
        $copies = $pv->studentCopies()->latest()->get();
        return view('pvs.show', compact('pv','documents','copies'));
    }

    public function create()
    {
        return view('pvs.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'year' => 'required|integer',
            'level' => 'required|string',
            'department' => 'required|string',
            'group' => 'nullable|string',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:30720',
        ]);
        $data['created_by'] = $request->user()->id;
        $pv = PV::create($data);
        AuditLog::create(['user_id'=>$request->user()->id,'action'=>"created PV {$pv->id}"]);

        if ($request->hasFile('file')) {
            $path = $this->storePVFile($pv, $request->file('file'));
            PVDocument::create([
                'pv_id'=>$pv->id,
                'file_path'=>$path,
                'name'=>basename($path),
                'uploaded_by'=>$request->user()->id
            ]);
        }
        return redirect()->route('pvs.show', $pv->id)->with('success', 'PV created');
    }

    protected function storePVFile(PV $pv, $file)
    {
        $folder = "pvs/{$pv->year}/{$pv->level}/{$pv->department}/";
        $filename = time() . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $file->getClientOriginalName());
        $path = $file->storeAs($folder, $filename, 'public');
        return $path;
    }

    public function importForm()
    {
        return view('pvs.import');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:csv,xlsx,xls']);
        $file = $request->file('file');
        $path = $file->store('imports', 'local');
        AuditLog::create(['user_id'=>$request->user()->id,'action'=>"uploaded import $path"]);
        return back()->with('success', "File uploaded: $path");
    }

    public function uploadDocument(Request $request, PV $pv)
    {
        $this->authorize('update', $pv);
        $request->validate(['document'=>'required|file|mimes:pdf,jpg,jpeg,png|max:30720']);
        $path = $this->storePVFile($pv, $request->file('document'));
        $doc = PVDocument::create(['pv_id'=>$pv->id,'file_path'=>$path,'name'=>basename($path),'uploaded_by'=>$request->user()->id]);
        AuditLog::create(['user_id'=>$request->user()->id,'action'=>"uploaded document {$doc->id} for PV {$pv->id}"]);
        return back()->with('success','Document uploaded');
    }

    public function uploadStudentCopy(Request $request, PV $pv)
    {
        $this->authorize('update', $pv);
        $request->validate([
            'student_identifier'=>'required|string',
            'copy' => 'required|file|mimes:pdf,jpg,jpeg,png|max:30720',
            'copy_type' => 'required|in:control,efm'
        ]);
        $path = $this->storePVFile($pv, $request->file('copy'));
        $copy = StudentCopy::create([
            'pv_id'=>$pv->id,
            'student_identifier'=>$request->input('student_identifier'),
            'file_path'=>$path,
            'copy_type'=>$request->input('copy_type'),
            'uploaded_by'=>$request->user()->id
        ]);
        AuditLog::create(['user_id'=>$request->user()->id,'action'=>"uploaded student copy {$copy->id} for PV {$pv->id}"]);
        return back()->with('success','Student copy uploaded');
    }
}
