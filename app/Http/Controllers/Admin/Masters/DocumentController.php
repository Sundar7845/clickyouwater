<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Enums\MenuPermissionType;
use App\Http\Controllers\Controller;
use App\Models\DocumentType;
use App\Traits\Common;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DocumentController extends Controller
{
    use Common;
    public function documentType()
    {
        try {
            return view('admin.masters.document.document');
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function addDocumentType(Request $request)
    {
        $request->validate([
            'txtDocumenttypeName' => [
                'required',
                Rule::unique('document_types', 'documenttype_name')->whereNull('deleted_at')->ignore($request->hdDocumentTypeNameId),
            ],
        ], [
            'txtDocumenttypeName.unique' => 'Document type name already exists.',
        ]);


        DB::beginTransaction();
        try {

            if ($request->hdDocumentTypeNameId == null) {
                DocumentType::create([
                    'documenttype_name' => $request->txtDocumenttypeName,
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now()
                ]);
                $notification = array(
                    'message' => 'Document Type Created Successfully',
                    'alert-type' => 'success'
                );
            } else {
                DocumentType::findorfail($request->hdDocumentTypeNameId)->update([
                    'documenttype_name' => $request->txtDocumenttypeName,
                    'updated_by' => Auth::user()->id
                ]);
                $notification = array(
                    'message' => 'Document Type Updated Successfully',
                    'alert-type' => 'success'
                );
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $notification = array(
                'message' => 'Document Type Not Created!',
                'alert-type' => 'error'
            );
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
        }
        return redirect()->route('documenttype')->with($notification);
    }

    public function deleteDocumentType($id)
    {
        DB::beginTransaction();
        try {
            $documentType = DocumentType::findorfail($id);
            $documentType->delete();
            $documentType->update([
                'deleted_by' => Auth::user()->id
            ]);

            $notification = array(
                'message' => 'Document Type Deleted Successfully',
                'alert' => 'success'
            );
            DB::commit();
            return response()->json([
                'responseData' => $notification
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Document type could not be deleted',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }

    public function getDocumentTypeById($id)
    {
        try {
            $document = DocumentType::where('id', $id)->whereNull('deleted_at')->first();
            return response()->json([
                'document' => $document
            ]);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function getDocumentTypeData()
    {
        try {
            $document = DocumentType::select('document_types.id', 'document_types.documenttype_name', 'document_configs.documenttype_id')
                ->leftJoin('document_configs', 'document_configs.documenttype_id', 'document_types.id')
                ->whereNull('document_types.deleted_at')
                ->groupBy('document_types.id')
                ->get();
            // dd($document);
            return datatables()->of($document)
                ->addColumn('action', function ($row) {
                    $html = "";
                    if ($this->isUserHavePermission(MenuPermissionType::Edit)) {
                        $html = '<i class="text-primary ti ti-pencil me-1"
                onclick="doEdit(' . $row->id . ');"></i> ';
                    }
                    if ($this->isUserHavePermission(MenuPermissionType::Delete) && $row->documenttype_id == null) {
                        $html .= '<i class="text-danger ti ti-trash me-1" id="confrim-color(' . $row->id . ')" 
                onclick="showDelete(' . $row->id . ');"></i>';
                    }
                    return $html;
                })->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
