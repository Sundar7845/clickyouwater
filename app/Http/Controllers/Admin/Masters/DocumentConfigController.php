<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Enums\DocumentModulesType;
use App\Enums\MenuPermissionType;
use App\Http\Controllers\Controller;
use App\Models\DeliveryPeopleDocuments;
use App\Models\DocumentConfig;
use App\Models\DocumentModules;
use App\Models\DocumentType;
use App\Models\EmployeeDocuments;
use App\Models\HubDocuments;
use App\Models\LogisticPartnerDocuments;
use App\Models\ManufacturerDocuments;
use App\Traits\Common;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DocumentConfigController extends Controller
{
    use Common;
    public function documentConfig()
    {
        try {
            $document = DocumentConfig::get();
            $documenttype = DocumentType::select('document_types.*')
                ->leftJoin('document_configs', 'document_configs.documenttype_id', 'document_types.id')
                ->whereNull('document_configs.id')
                ->whereNull('deleted_at')
                ->groupBy('document_types.id')
                ->get();
            $documentModule = DocumentModules::get();
            return view('admin.masters.document_configuration.document_config', compact('document', 'documenttype', 'documentModule'));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function addDocumentConfig(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'ddlDocumentType' => [
        //         'required',
        //         Rule::unique('document_configs', 'documenttype_id')->ignore($request->hdDocumentTypeId, 'documenttype_id'),
        //     ],
        // ], [
        //     'ddlDocumentType.unique' => 'Document Type Name already exists.'
        // ]);
        // if ($validator->fails()) {
        //     return redirect()->back()->withInput()->withErrors($validator);
        // }

        DB::beginTransaction();
        try {
            // dd($request->all());
            $data = $request->all();
            if ($request->hdDocumentTypeId == Null) {
                DocumentConfig::where('documenttype_id', $request->ddlDocumentType)->delete();
                foreach ($data['chkModuleName'] as $value) {
                    $chkMandatory = isset($request->chkMandatory[$value]) ? $request->chkMandatory[$value] : 0;
                    DocumentConfig::create([
                        'documenttype_id' => $request->ddlDocumentType,
                        'documentmodule_id' => $value,
                        'is_mandatory' => $chkMandatory,
                        'is_active' => 1
                    ]);
                }

                DB::commit();
                $notification = array(
                    'message' => 'Documentconfig Created Successfully',
                    'alert-type' => 'success'
                );
            } else {
                foreach ($data['chkModuleName'] as $value) {
                    $chkMandatory = isset($request->chkMandatory[$value]) ? $request->chkMandatory[$value] : 0;
                    DocumentConfig::updateOrCreate([
                        'documenttype_id' => $request->hdDocumentTypeId,
                        'documentmodule_id' => $value,
                    ], [
                        'is_mandatory' => $chkMandatory,
                        'is_active' => 1
                    ]);

                    DocumentConfig::whereNotIn('documentmodule_id', $data['chkModuleName'])
                        ->where('documenttype_id', $request->hdDocumentTypeId)
                        ->delete();
                }

                DB::commit();
                $notification = array(
                    'message' => 'Documentconfig Updated Successfully',
                    'alert-type' => 'success'
                );
            }

            return redirect()->route('documentconfig')->with($notification);
        } catch (\Exception $e) {
            DB::rollback();
            $notification = array(
                'message' => 'Document Config Not Created!',
                'alert-type' => 'error'
            );
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());

            return redirect()->route('documentconfig')->with($notification);
        }
    }


    public function deleteDocumentConfig($id)
    {
        DB::beginTransaction();
        try {
            $deliveryPeopleDocumentsCount = DeliveryPeopleDocuments::where('documenttype_id', $id)
                ->where('documentmodule_id', DocumentModulesType::DeliveryPerson)->get()->count();
            $hubDocumentsCount = HubDocuments::where('documenttype_id', $id)
                ->where('documentmodule_id', DocumentModulesType::Hub)->get()->count();
            $employeeDocumentsCount = EmployeeDocuments::where('documenttype_id', $id)
                ->where('documentmodule_id', DocumentModulesType::Employee)->get()->count();
            $manufacturerDocumentsCount = ManufacturerDocuments::where('documenttype_id', $id)
                ->where('documentmodule_id', DocumentModulesType::Manufacturer)->get()->count();
            $logisticDocumentsCount = LogisticPartnerDocuments::where('documenttype_id', $id)
                ->where('documentmodule_id', DocumentModulesType::Logistic)->get()->count();

            if (
                $deliveryPeopleDocumentsCount == 0
                && $hubDocumentsCount == 0
                && $employeeDocumentsCount == 0
                && $manufacturerDocumentsCount == 0
                && $logisticDocumentsCount == 0
            ) {
                DocumentConfig::where('documenttype_id', $id)->delete();
                $notification = array(
                    'message' => 'Documentconfig Deleted Successfully',
                    'alert' => 'success'
                );
                DB::commit();
                return response()->json([
                    'responseData' => $notification
                ]);
            } else {
                $notification = array(
                    'message' => 'Documentconfig Could Not Be Deleted!',
                    'alert' => 'error'
                );
                return response()->json([
                    'responseData' => $notification
                ]);
            }
        } catch (QueryException $e) {
            DB::rollback();
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Documentconfig Could Not Be Deleted!',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }

    public function getDocumentConfigById($id, $type)
    {
        try {
            $document = DocumentConfig::select('document_configs.*', 'document_modules.module_name', 'document_types.documenttype_name')
                ->join('document_modules', 'document_modules.id', 'document_configs.documentmodule_id')
                ->join('document_types', 'document_types.id', 'document_configs.documenttype_id')
                // ->where('document_configs.id',$id)
                ->where('document_configs.documenttype_id', $type)
                ->get();
            $documenttype = DocumentType::select('id', 'documenttype_name')->where('id', $type)->get();
            return response()->json([
                'document' => $document,
                'documenttype' => $documenttype
            ]);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function getDocumentConfigData()
    {
        try {
            $document = DocumentConfig::select(
                'document_configs.*',
                'document_types.documenttype_name',
                'employee_documents.documenttype_id as emp_documenttype_id',
                'hub_documents.documenttype_id as hub_documenttype_id',
                'logistic_partner_documents.documenttype_id as lp_documenttype_id',
                'manufacturer_documents.documenttype_id as mf_documenttype_id'
            )
                ->join('document_types', 'document_types.id', 'document_configs.documenttype_id')
                ->leftJoin('delivery_people_documents', 'delivery_people_documents.documenttype_id', 'document_types.id')
                ->leftJoin('employee_documents', 'employee_documents.documenttype_id', 'document_types.id')
                ->leftJoin('hub_documents', 'hub_documents.documenttype_id', 'document_types.id')
                ->leftJoin('logistic_partner_documents', 'logistic_partner_documents.documenttype_id', 'document_types.id')
                ->leftJoin('manufacturer_documents', 'manufacturer_documents.documenttype_id', 'document_types.id')
                ->whereNull('document_types.deleted_at')
                ->groupBy('document_configs.documenttype_id')
                ->get();

            return datatables()->of($document)
                ->addColumn('action', function ($row) {
                    $html = "";
                    if ($this->isUserHavePermission(MenuPermissionType::Edit)) {
                        $html = '<i class="text-primary ti ti-pencil me-1"
                onclick="doEdit(' . $row->id . ',' . $row->documenttype_id . ');"></i> ';
                    }
                    if (
                        $this->isUserHavePermission(MenuPermissionType::Delete) &&
                        $row->emp_documenttype_id == null &&
                        $row->hub_documenttype_id == null &&
                        $row->lp_documenttype_id == null &&
                        $row->mf_documenttype_id == null
                    ) {
                        $html .= '<i class="text-danger ti ti-trash me-1" id="confrim-color(' . $row->id . ')"
                onclick="showDelete(' . $row->documenttype_id . ');"></i>';
                    }
                    return $html;
                })->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function activeStatus($id, $status)
    {
        try {
            DocumentConfig::where('documenttype_id', $id)->update([
                'is_active' => $status
            ]);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
