<?php

namespace App\Http\Controllers\Admin\Masters;

use App\Enums\DocumentModulesType;
use App\Enums\MenuPermissionType;
use App\Enums\RoleTypes;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Asset;
use App\Models\AssetType;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Country;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\EmployeeAssets;
use App\Models\EmployeeDocuments;
use App\Models\State;
use App\Models\User;
use App\Traits\Common;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    use Common;
    public function employee($id = NULL)
    {
        try {
            $country = $this->getCountries();
            $states = $this->getStates();
            $designation = Designation::where('is_active', 1)->whereNull('deleted_at')->get();
            $departments = Department::where('is_active', 1)->whereNull('deleted_at')->get();
            $assets = Asset::whereNull('deleted_at')->get();
            $assettype = AssetType::whereNull('deleted_at')->get();
            $roles = $this->getRolesForDropDown();
            $user = $this->getUserRolesForDropDown();
            $employee_assets = null;
            $employees = null;
            $bindDocuments = $this->getDocumentConfigsByModule(DocumentModulesType::Employee, $id);
            if ($bindDocuments->isEmpty()) {
                $bindDocuments = $this->getDocumentsByModule(DocumentModulesType::Employee);
            }
            if ($id) {
                $employees = Employee::find($id);
                $employee_user_id = User::where('ref_id', $id)->where('role_id', $employees->role_id)->pluck('id')->first();
                $employee_assets = EmployeeAssets::find($id);
                $states = $this->getStates();
                $assets = Asset::whereNull('deleted_at')->get();
                $assettype = AssetType::whereNull('deleted_at')->get();
                //office assets
                $officeassets = EmployeeAssets::select('employee_assets.*', 'asset_types.asset_type', 'assets.asset_name')
                    ->join('asset_types', 'asset_types.id', 'employee_assets.asset_type_id')
                    ->join('assets', 'assets.id', 'employee_assets.asset_id')
                    ->where('employee_id', $id)
                    ->whereNull('asset_types.deleted_at')
                    ->whereNull('assets.deleted_at')
                    ->get();
                $permanent_city = $this->getCities($employees->permanent_state_id);
                $permanent_area = $this->getAreas($employees->permanent_city_id);
                $comm_city = $this->getCities($employees->comm_state_id);
                $comm_area = $this->getAreas($employees->comm_city_id);
                $manExample = $employees->employee_code;
                return view('admin.masters.employee.edit_employee', compact('bindDocuments', 'assettype', 'country', 'manExample', 'designation', 'departments', 'user', 'employees', 'states', 'permanent_city', 'permanent_area', 'comm_area', 'comm_city', 'roles', 'states', 'assets', 'employee_assets', 'officeassets', 'employee_user_id'));
            }
            $manExample = $this->getAutoGeneratedCode(DocumentModulesType::Employee);
            return view('admin.masters.employee.employee', compact('bindDocuments', 'country', 'designation', 'departments', 'user', 'employees', 'manExample', 'roles', 'states', 'assets', 'employee_assets', 'assettype'));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function employeeList()
    {
        try {
            $employees = DB::table('employees')
                ->join('departments', 'departments.id', '=', 'employees.department_id')
                ->join('designations', 'designations.id', '=', 'employees.designation_id')
                ->select('employees.id', 'employees.employee_code', 'employees.employee_name', 'employees.mobile1', 'employees.email1', 'departments.department_name', 'designations.designation_name')
                ->whereNull('employees.deleted_at')
                ->whereNull('departments.deleted_at')
                ->whereNull('designations.deleted_at')
                ->get();
            return view('admin.masters.employee.employee_list', compact('employees'));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function employeeCreate(Request $request)
    {
        DB::beginTransaction();

        try {
            $validator = Validator::make($request->all(), [
                'txtEmployeeName'         =>  'required',
                'txtFatherSpouseName'     =>  'required',
                'rdGender'                =>  'required',
                'rdMarital'                =>  'required',
                'dtdob'                   =>  'required',
                'txtNationality'          =>  'required',
                // 'txtNationalityStatus'    =>  'required',
                'txtPerMobile' => [
                    'required', 'numeric', 'digits:10',
                    Rule::unique('employees', 'personal_mobile'),
                ],
                'email1' => [
                    'required', 'email',
                    Rule::unique('employees', 'email1'),
                ],
                // 'email2' => [
                //     'required', 'email',
                //     Rule::unique('employees', 'email2'),
                // ],
                'fileProfileImg'          =>  'required',
                'ddlCommState'            =>  'required',
                'ddlCommCity'             =>  'required',
                'ddlCommArea'             =>  'required',
                'txtCommAddress'          =>  'required',
                'txtCommPincode'          =>  'required',
                'ddlPermState'            =>  'required',
                'ddlPermCity'             =>  'required',
                'ddlPermArea'             =>  'required',
                'txtPermAddress'          =>  'required',
                'txtPermPincode'          =>  'required',
                'txtMobile1' => [
                    'required', 'numeric', 'digits:10',
                    Rule::unique('employees', 'mobile1'),
                ],
                'txtRelation1'            =>  'required',
                'txtMobile2' => [
                    'required', 'numeric', 'digits:10',
                    Rule::unique('employees', 'mobile2'),
                ],
                'txtRelation2'            =>  'required',
                // 'numPrevCompanyExp'       =>  'required',
                // 'txtPrevCompanyName'      =>  'required',
                // 'txtPrevCompanyRef'       =>  'required',
                'txtAccountName'          =>  'required',
                'txtAccountNumber'        =>  'required',
                'txtBankName'             =>  'required',
                'txtBranchName'           =>  'required',
                'txtBranchIfsc'           =>  'required',
                'txtEmployeeCode'         =>  'required',
                'ddlDepartment'           =>  'required',
                'ddlDesignation'          =>  'required',
                // 'ddlReportingTo'          =>  'required',
                'ddlRoleName'             =>  'required',
                'txtPackage'              =>  'required',
                'dtDateOfJoin'            =>  'required',
                // 'CompanyMailId' => [
                //     'email',
                //     Rule::unique('employees', 'company_mail_id'),
                // ],
                // 'txtCompanyMobile' => [
                //     'numeric', 'digits:10',
                //     Rule::unique('employees', 'company_mobile_no'),
                // ],
                // 'txtOriginalGiven'        =>  'required',
                // 'ddlOriginalReceived'     =>  'required',
                // 'ddlOriginalsVerified'    =>  'required',
            ], [
                'txtPerMobile.unique' => 'Personal mobile already exists.',
                // 'txtOfficialMobile' => 'official mobile already exists.',
                'email1' => 'Personal email already exists.',
                // 'email2' => 'official email already exists.',
                'txtMobile1' => 'Mobile 1 already exists.',
                'txtMobile2' => 'Mobile 2 already exists.',
                // 'CompanyMailId' => 'Company Mail Id already exists.',
                // 'txtCompanyMobile' => 'Company Mobile already exists.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            //Create New Area Or Get Area ID
            $communicationArea_id = $this->getOrCreateAreaId($request->ddlCommArea, $request->ddlCommState, $request->ddlCommCity);
            $permanentArea_id = $this->getOrCreateAreaId($request->ddlPermArea, $request->ddlPermState, $request->ddlPermCity);

            //Validate the documents for Employee
            $is_valid = $this->validateDocuments($request, DocumentModulesType::Employee);

            if (isset($is_valid->documentType->documenttype_name)) {
                $notification = array(
                    'message' => $is_valid->documentType->documenttype_name . ' Required',
                    'alert-type' => 'error'
                );
                return redirect()->route('employee')->with($notification);
            }

            $data = [
                'employee_code' => $request->txtEmployeeCode,
                'employee_name' => $request->txtEmployeeName,
                'father_spouse_name' => $request->txtFatherSpouseName,
                'gender' => $request->rdGender,
                'marital_status' => $request->rdMarital,
                'dob' => $request->dtdob,
                'nationality' => $request->txtNationality,
                'nationality_status' => $request->txtNationalityStatus,
                'personal_mobile' => $request->txtPerMobile,
                'personal_email' => $request->email1,
                // 'official_email' => $request->email2,
                'permanent_address' => $request->txtPermAddress,
                'permanent_area_id' => $permanentArea_id,
                'permanent_city_id' => $request->ddlPermCity,
                'permanent_state_id' => $request->ddlPermState,
                'permanent_pincode' => $request->txtPermPincode,
                'comm_address' => $request->txtCommAddress,
                'comm_area_id' => $communicationArea_id,
                'comm_city_id' => $request->ddlCommCity,
                'comm_state_id' => $request->ddlCommState,
                'comm_pincode' => $request->txtCommPincode,
                'mobile1' => $request->txtMobile1,
                'relationship1' => $request->txtRelation1,
                'mobile2' => $request->txtMobile2,
                'relationship2' => $request->txtRelation2,
                'email1' => $request->email1,
                // 'email2' => $request->email2,
                'prev_company_exp_yrs' => $request->numPrevCompanyExp,
                'prev_company_name' => $request->txtPrevCompanyName,
                'prev_company_ref_by' => $request->txtPrevCompanyRef,
                'bank_name' => $request->txtBankName,
                'account_name' => $request->txtAccountName,
                'account_number' => $request->txtAccountNumber,
                'branch_name' => $request->txtBranchName,
                'ifsc_code' => $request->txtBranchIfsc,
                'department_id' => $request->ddlDepartment,
                'designation_id' => $request->ddlDesignation,
                'reporting_to' => $request->ddlReportingTo,
                'role_id' => $request->ddlRoleName,
                'package' => $request->txtPackage,
                'date_of_join' => $request->dtDateOfJoin,
                'company_mail_id' => $request->CompanyMailId,
                'company_mobile_no' => $request->txtCompanyMobile,
                'originals_given_by' => $request->txtOriginalGiven,
                'originals_verified_by' => $request->ddlOriginalsVerified,
                'authorised_by' => $request->ddlOriginalReceived,
                'is_active' => 1,
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now()
            ];
            $last_inserted_employee_id = DB::table('employees')->insertGetId($data);

            if ($request->hasFile('fileProfileImg')) {
                $path = $request->file('fileProfileImg')->store('temp');
                $file = $request->file('fileProfileImg');
                $extension = $file->getClientOriginalExtension();
                $fileName = $this->generateRandom(16) . '.' . $extension;

                Employee::findorfail($last_inserted_employee_id)->update([
                    'profile_img' => $this->fileUpload($file, 'upload/employees/' . $request->txtEmployeeCode, $fileName),
                ]);
            }

            $documents = $this->getDocumentsByModule(DocumentModulesType::Employee);

            //Create Employee documents in create mode
            $this->createEmployeeDocuments($request, $documents, $last_inserted_employee_id);

            //Increase Employeelive count in settings table
            $this->updateLiveCount(DocumentModulesType::Employee, 1);

            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            //Create Employee Office Assets
            $assettype = $request->tabAssetTypeName;
            $asset = $request->tabAssetName;
            $issuedby = $request->tabIssuedBy;
            $authorisedby = $request->tabAuthorisedBy;

            if ($assettype != null) {

                if (
                    count($assettype) == count($asset) &&
                    count($asset) == count($issuedby) &&
                    count($issuedby) == count($authorisedby)
                ) {
                    $data = [];

                    for ($i = 0, $count = count($assettype); $i < $count; $i++) {
                        $data[] = [
                            "employee_id" => $last_inserted_employee_id,
                            "asset_type_id" => $assettype[$i],
                            "asset_id" => $asset[$i],
                            "issued_by" => $issuedby[$i],
                            "authorised_by" => $authorisedby[$i]
                        ];
                    }

                    EmployeeAssets::insert($data);
                }
            }
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            //Create Employee user account for login
            $this->createUser(
                $request->txtPerMobile,
                $request->email1,
                $request->txtPerMobile,
                $last_inserted_employee_id,
                $request->txtEmployeeName,
                $request->txtPerMobile,
                $request->ddlRoleName,
                1,
                Auth::user()->id
            );

            DB::commit();
            $notification = array(
                'message' => 'Employee Created Successfully',
                'alert-type' => 'success'
            ); // Commit the transaction
            return redirect()->route('employee-list')->with($notification);
        } catch (\Exception $e) {
            DB::rollback();
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert-type' => 'warning'
            );
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
            return redirect()->route('employee')->with($notification);
            // Roll back the transaction if an error occurs
        }
    }

    private function createEmployeeDocuments($request, $documents, $employee_id)
    {
        DB::beginTransaction();
        try {
            foreach ($documents as $doc) {
                if ($request->hasFile('file_' . $doc->id)) {
                    $path = $request->file('file_' . $doc->id)->store('temp');
                    $file = $request->file('file_' . $doc->id);
                    $extension = $file->getClientOriginalExtension();
                    $fileName = $this->generateRandom(16) . '.' . $extension;
                }
                $doc_no = 'doc_' . $doc->id;
                $existingfile_path = 'hdDocumentImg_' . $doc->id;
                $documentPath = null;
                if ($request->hasFile('file_' . $doc->id)) {
                    $documentPath = $this->fileUpload($file, 'upload/Employees/' . $request->txtEmployeeCode, $fileName);
                } elseif ($request->$existingfile_path != null) {
                    $documentPath = $request->$existingfile_path;
                }

                if ($documentPath !== null) {
                    EmployeeDocuments::create([
                        'employee_id' => $employee_id,
                        'documenttype_id' => $doc->documenttype_id,
                        'documentmodule_id' => $doc->documentmodule_id,
                        'document_path' => $documentPath,
                        'document_number' => $request->$doc_no
                    ]);
                }
            }
            DB::commit(); // Commit the transaction
        } catch (\Exception $e) {
            DB::rollback(); // Roll back the transaction if an error occurs
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
        }
    }

    public function employeeUpdate(Request $request)
    {
        DB::beginTransaction();

        try {
            $validator = Validator::make($request->all(), [
                'txtEmployeeName'         =>  'required',
                'txtFatherSpouseName'     =>  'required',
                'rdGender'                =>  'required',
                'dtdob'                   =>  'required',
                'txtNationality'          =>  'required',
                // 'txtNationalityStatus'    =>  'required',
                'txtPerMobile' => [
                    'required',
                    'numeric',
                    'digits:10',
                    Rule::unique('employees', 'personal_mobile')->ignore($request->hdEmployeeId),
                ],
                'email1' => [
                    'required',
                    'email',
                    Rule::unique('employees', 'email1')->ignore($request->hdEmployeeId),
                ],
                // 'email2' => [
                //     'required',
                //     'email',
                //     Rule::unique('employees', 'email2')->ignore($request->hdEmployeeId),
                // ],
                'ddlCommState'            =>  'required',
                'ddlCommCity'             =>  'required',
                'ddlCommArea'             =>  'required',
                'txtCommAddress'          =>  'required',
                'txtCommPincode'          =>  'required',
                'ddlPermState'            =>  'required',
                'ddlPermCity'             =>  'required',
                'ddlPermArea'             =>  'required',
                'txtPermAddress'          =>  'required',
                'txtPermPincode'          =>  'required',
                'txtMobile1' => [
                    'required',
                    'numeric',
                    'digits:10',
                    Rule::unique('employees', 'mobile1')->ignore($request->hdEmployeeId),
                ],
                'txtRelation1'            =>  'required',
                'txtMobile2' => [
                    'required',
                    'numeric',
                    'digits:10',
                    Rule::unique('employees', 'mobile2')->ignore($request->hdEmployeeId),
                ],
                'txtRelation2'            =>  'required',
                // 'numPrevCompanyExp'       =>  'required',
                // 'txtPrevCompanyName'      =>  'required',
                // 'txtPrevCompanyRef'       =>  'required',
                'txtAccountName'          =>  'required',
                'txtAccountNumber'        =>  'required',
                'txtBankName'             =>  'required',
                'txtBranchName'           =>  'required',
                'txtBranchIfsc'           =>  'required',
                // 'fileAadhar'              =>  'required',
                // 'filePan'                 =>  'required',
                // 'filePassport'            =>  'required',
                'txtEmployeeCode'         =>  'required',
                'ddlDepartment'           =>  'required',
                'ddlDesignation'          =>  'required',
                // 'ddlReportingTo'          =>  'required',
                'ddlRoleName'             =>  'required',
                'txtPackage'              =>  'required',
                'dtDateOfJoin'            =>  'required',
                // 'CompanyMailId' => [
                //     'email',
                //     Rule::unique('employees', 'company_mail_id')->ignore($request->hdEmployeeId),
                // ],
                // 'txtCompanyMobile' => [
                //     'numeric',
                //     'digits:10',
                //     Rule::unique('employees', 'company_mobile_no')->ignore($request->hdEmployeeId),
                // ],
                // 'txtOriginalGiven'        =>  'required',
                // 'ddlOriginalReceived'     =>  'required',
                // 'ddlOriginalsVerified'    =>  'required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            //Create New Area Or Get Area ID
            $communicationArea_id = $this->getOrCreateAreaId($request->ddlCommArea, $request->ddlCommState, $request->ddlCommCity);
            $permanentArea_id = $this->getOrCreateAreaId($request->ddlPermArea, $request->ddlPermState, $request->ddlPermCity);

            //Validate the documents for hub
            $is_valid = $this->validateUpdateDocuments($request, DocumentModulesType::Employee, $request->hdEmployeeId);

            if ($is_valid !== true) {
                if (isset($is_valid->document_number) || isset($is_valid->document_path)) {
                    $notification = array(
                        'message' => $is_valid->documentType->documenttype_name . ' Required',
                        'alert-type' => 'error'
                    );
                    return redirect()->route('employeex', $request->hdEmployeeId)->with($notification);
                }
            }

            $oldImage = $request->hdEmployeeImg;
            if ($request->hasFile('fileProfileImg')) {
                @unlink($oldImage);
                $path = $request->file('fileProfileImg')->store('temp');
                $files = $request->file('fileProfileImg');
                $extensions = $files->getClientOriginalExtension();
                $fileNames = $this->generateRandom(16) . '.' . $extensions;
            }
            Employee::where("id", $request->hdEmployeeId)->update([
                'employee_code' => $request->txtEmployeeCode,
                'employee_name' => $request->txtEmployeeName,
                'father_spouse_name' => $request->txtFatherSpouseName,
                'gender' => $request->rdGender,
                'marital_status' => $request->rdMarital,
                'profile_img' => ($request->hasFile('fileProfileImg')) ? $this->fileUpload($request->file('fileProfileImg'), 'upload/employees/' . $request->txtEmployeeCode, $fileNames) : $oldImage,
                'dob' => $request->dtdob,
                'nationality' => $request->txtNationality,
                'nationality_status' => $request->txtNationalityStatus,
                'personal_mobile' => $request->txtPerMobile,
                'personal_email' => $request->email1,
                // 'official_email' => $request->email2,
                'permanent_address' => $request->txtPermAddress,
                'permanent_area_id' => $permanentArea_id,
                'permanent_city_id' => $request->ddlPermCity,
                'permanent_state_id' => $request->ddlPermState,
                'permanent_pincode' => $request->txtPermPincode,
                'comm_address' => $request->txtCommAddress,
                'comm_area_id' => $communicationArea_id,
                'comm_city_id' => $request->ddlCommCity,
                'comm_state_id' => $request->ddlCommState,
                'comm_pincode' => $request->txtCommPincode,
                'relationship1' => $request->txtRelation1,
                'mobile1' => $request->txtMobile1,
                'mobile2' => $request->txtMobile2,
                'relationship2' => $request->txtRelation2,
                'email1' => $request->email1,
                // 'email2' => $request->email2,
                'prev_company_exp_yrs' => $request->numPrevCompanyExp,
                'prev_company_name' => $request->txtPrevCompanyName,
                'prev_company_ref_by' => $request->txtPrevCompanyRef,
                'bank_name' => $request->txtBankName,
                'account_name' => $request->txtAccountName,
                'account_number' => $request->txtAccountNumber,
                'branch_name' => $request->txtBranchName,
                'ifsc_code' => $request->txtBranchIfsc,
                'department_id' => $request->ddlDepartment,
                'designation_id' => $request->ddlDesignation,
                'reporting_to' => $request->ddlReportingTo,
                'role_id' => $request->ddlRoleName,
                'package' => $request->txtPackage,
                'date_of_join' => $request->dtDateOfJoin,
                'company_mail_id' => $request->CompanyMailId,
                'company_mobile_no' => $request->txtCompanyMobile,
                'originals_given_by' => $request->txtOriginalGiven,
                'originals_verified_by' => $request->ddlOriginalsVerified,
                'authorised_by' => $request->ddlOriginalReceived,
                'is_active' => 1,
                'updated_by' => Auth::user()->id
            ]);

            $documents = $this->getDocumentConfigsByModule(DocumentModulesType::Employee, $request->hdEmployeeId);

            $nullDocuments = $this->getDocumentsByModule(DocumentModulesType::Employee);

            foreach ($documents as $doc) {
                if ($request->hasFile('file_' . $doc->id)) {
                    @unlink($doc->document_path);
                }
            }

            EmployeeDocuments::where('employee_id', $request->hdEmployeeId)->delete();

            //update employee documents in edit mode
            $this->createEmployeeDocuments($request, $documents == null ? $documents : $nullDocuments, $request->hdEmployeeId);

            EmployeeAssets::where('employee_id', $request->hdEmployeeId)->delete();

            //Create Employee Office Assets
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $assettype = $request->tabAssetTypeName;
            $asset = $request->tabAssetName;
            $issuedby = $request->tabIssuedBy;
            $authorisedby = $request->tabAuthorisedBy;

            if (
                is_array($assettype) && is_array($asset) &&
                is_array($issuedby) && is_array($authorisedby) &&
                count($assettype) === count($asset) &&
                count($asset) === count($issuedby) &&
                count($issuedby) === count($authorisedby)
            ) {
                $data = [];

                for ($i = 0, $count = count($assettype); $i < $count; $i++) {
                    $data[] = [
                        "employee_id" => $request->hdEmployeeId,
                        "asset_type_id" => $assettype[$i],
                        "asset_id" => $asset[$i],
                        "issued_by" => $issuedby[$i],
                        "authorised_by" => $authorisedby[$i]
                    ];
                }

                EmployeeAssets::insert($data);
            }
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            //Update Employee Login Account For Driver
            $this->updateUser(
                $request->txtPerMobile,
                $request->email1,
                $request->txtPerMobile,
                $request->hdEmployeeId,
                $request->txtEmployeeName,
                $request->txtPerMobile,
                $request->ddlRoleName,
                1,
                Auth::user()->id,
                $request->hdEmployeeUserId
            );

            DB::commit(); // Commit the transaction
            $notification = array(
                'message' => 'Employee Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('employee-list')->with($notification);
        } catch (\Exception $e) {
            DB::rollback();
            $notification = array(
                'message' => 'Something Went Wrong!',
                'alert-type' => 'warning'
            );
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
            return redirect()->route('employee', $request->hdEmployeeId)->with($notification);
            // Roll back the transaction if an error occurs
        }
    }

    public function getEmployeeData()
    {
        try {
            $employee = Employee::select('employees.*', 'departments.department_name', 'designations.designation_name', 'employee_documents.document_path')
                ->join('departments', 'departments.id', 'employees.department_id')
                ->join('designations', 'designations.id', 'employees.designation_id')
                ->leftjoin('employee_documents', 'employee_documents.employee_id', 'employees.id')
                ->whereNull('employees.deleted_at')
                ->whereNull('departments.deleted_at')
                ->whereNull('designations.deleted_at')
                ->groupBy('employees.id')
                ->get();

            return datatables()->of($employee)
                ->addColumn('action', function ($row) {
                    $html = "";
                    if ($this->isUserHavePermission(MenuPermissionType::Edit)) {
                        $html = '<a href="/employee/' . $row->id . '"><i class="text-primary ti ti-pencil me-1"
                ></i></a>';
                    }
                    //     if ($this->isUserHavePermission(MenuPermissionType::Delete)) {
                    //         $html .= '<i class="text-danger ti ti-trash me-1" id="confrim-color(' . $row->id . ')"
                    // onclick="showDelete(' . $row->id . ');"></i>';
                    //     }
                    return $html;
                })->toJson();
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function deleteEmp($id)
    {
        DB::beginTransaction();
        try {
            $employee = Employee::findorfail($id);
            $employeeUser = User::where('mobile', $employee->personal_mobile)->first();
            if (!$employeeUser) {
                $employee->delete();
                $employee->update([
                    'deleted_by' => Auth::user()->id
                ]);

                $notification = array(
                    'message' => 'Employee Deleted Successfully',
                    'alert' => 'success'
                );

                DB::commit();
            } else {
                $notification = array(
                    'message' => 'Employee Could Not Be Deleted',
                    'alert' => 'error'
                );
            }
            return response()->json([
                'responseData' => $notification
            ]);
        } catch (QueryException $e) {
            DB::rollBack();
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
            $notification = array(
                'message' => 'Employee could not be deleted',
                'alert' => 'error'
            );
            return response()->json([
                'responseData' => $notification
            ]);
        }
    }

    public function activeStatus($id, $status)
    {
        DB::beginTransaction();
        try {
            Employee::findorfail($id)->update([
                'is_active' => $status,
                'updated_by' => Auth::user()->id
            ]);
            //In active user account
            if ($status == 0) {
                $role_id = Employee::where('id', $id)->pluck('role_id')->first();
                $this->inactiveUser($id, $role_id);
            } else {
                $role_id = Employee::where('id', $id)->pluck('role_id')->first();
                $this->activeUser($id, $role_id);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function getAssetName(Request $request)
    {
        try {
            $assetData = Asset::where("asset_type_id", $request->Asset_type_id)
                ->whereNull('assets.deleted_at')
                ->get();
            return response()->json($assetData);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
        }
    }

    public function employeeDocument($id)
    {
        try {
            $documentTitle = $this->documentTitle(DocumentModulesType::Employee);
            $documents = $this->documentByUsers(DocumentModulesType::Employee, $id);
            $documentmodule_id = DocumentModulesType::Employee;
            $employeeDetails = Employee::with('area', 'city', 'state')
                ->where('id', $id)
                ->first();

            $userCode = $employeeDetails->employee_code;
            $userName = $employeeDetails->employee_name;
            $userMobile = $employeeDetails->personal_mobile;
            $userActiveStatus = $employeeDetails->is_active;
            $userAddress = $employeeDetails->comm_address . ','
                . $employeeDetails->area->area_name . ','
                . $employeeDetails->city->city_name . ','
                . $employeeDetails->state->state_name . '-'
                . $employeeDetails->comm_pincode;
            return view('admin.documents.documents', compact(
                'documents',
                'documentTitle',
                'documentmodule_id',
                'userCode',
                'userName',
                'userMobile',
                'userAddress',
                'userActiveStatus'
            ));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, "GET", $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function verifyDocument($id, $status)
    {
        try {
            $this->updateDocumentVerification(DocumentModulesType::Employee, $id, $status);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'POST', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
