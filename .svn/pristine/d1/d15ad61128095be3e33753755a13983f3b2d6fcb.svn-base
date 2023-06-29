<?php

namespace App\Http\Controllers\Hub\Document;

use App\Enums\DocumentModulesType;
use App\Enums\RoleTypes;
use App\Http\Controllers\Controller;
use App\Models\Hub;
use App\Models\HubDocuments;
use App\Models\User;
use App\Traits\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    use Common;
    public function document($id = NULL)
    {
        try {
            $hub_id = $this->getRefId(Auth::user()->id, RoleTypes::Hub);
            $id = ($id ? $id : $hub_id);
            $bindDocuments = $this->getDocumentConfigsByModule(DocumentModulesType::Hub, $id);
            return view('hub.document.document', compact('bindDocuments', 'id'));
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }

    public function createDocuments(Request $request)
    {
        try {
            $hub = Hub::where('id', $request->hdId)->first();
            //Validate the documents for hub
            $is_valid = $this->validateUpdateDocuments($request, DocumentModulesType::Hub, $request->hdId);

            if ($is_valid !== true) {
                if ($is_valid->document_number == null || $is_valid->document_path == null) {
                    $notification = array(
                        'message' => $is_valid->documentType->documenttype_name . ' Required',
                        'alert-type' => 'error'
                    );
                    return redirect()->route('hubdocuments')->with($notification);
                }
            }

            $hub_documents = $this->getDocumentConfigsByModule(DocumentModulesType::Hub, $request->hdId);

            foreach ($hub_documents as $doc) {
                if ($request->hasFile('file_' . $doc->id)) {
                    @unlink($doc->hubDocuments->document_path);
                }
            }

            // Delete existing records
            HubDocuments::where('hub_id', $request->hdId)->delete();


            foreach ($hub_documents as $doc) {
                if ($request->hasFile('file_' . $doc->id)) {
                    $path = $request->file('file_' . $doc->id)->store('temp');
                    $file = $request->file('file_' . $doc->id);
                    $extension = $file->getClientOriginalExtension();
                    $fileName = $this->generateRandom(16) . '.' . $extension;
                }
                $doc_no = 'doc_' . $doc->id;
                $existingfile_path = 'hdDocumentImg_' . $doc->id;
                HubDocuments::create([
                    'hub_id' => $request->hdId,
                    'documenttype_id' => $doc->documenttype_id,
                    'documentmodule_id' => $doc->documentmodule_id,
                    'document_path' => ($request->hasFile('file_' . $doc->id)) ?
                        $this->fileUpload($file, 'upload/hubs/' . $hub->hub_code, $fileName)
                        : $request->$existingfile_path,
                    'document_number' => $request->$doc_no
                ]);
            }
            $notification = array(
                'message' => 'Hub Documents Updated Successfully',
                'alert-type' => 'success'
            );
            $authHubRedirectUrl = Auth::user()->role_id == RoleTypes::Hub ? 'authhubdocuments' : 'hubdocuments';
            return redirect()->route($authHubRedirectUrl)->with($notification);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, $request->method(), $e->getMessage(), Auth::user()->id, $request->ip(), gethostname());
        }
    }
}
