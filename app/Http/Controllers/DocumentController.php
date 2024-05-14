<?php

namespace App\Http\Controllers;
use Config;
use Illuminate\Http\Request;
use App\Models\EstateDoc;
use App\Models\Estate;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $estateId = $request->input('estateId');
        foreach ($request->file('docFile') as $index => $file) {
            $category = $request->input('docCategory')[$index];
            $name = $request->input('docName')[$index];
            $description = $request->input('docDescription')[$index];

            $formFolder = 'public/doc/estate_id/' . $estateId;
            Storage::makeDirectory($formFolder);
            $currentDateTime = date('YmdHsi');
            $uniqueFileName = $currentDateTime . '_' . $file->getClientOriginalName();

            $path = $file->storeAs($formFolder, $uniqueFileName);

            $estateDoc = new EstateDoc();
            $estateDoc->est_id = $estateId;
            $estateDoc->doc_category = $category;
            $estateDoc->doc_name = $name;
            $estateDoc->doc_description = $description;
            $estateDoc->doc_file = $path;
            $estateDoc->save();
        }

        return true;
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function docPermanent(Request $request)
    {
        $estateId = $request->input('estateId');
        $formFolder = 'public/doc/estate_id/' . $estateId;
        $docsData = $request->docs;
        foreach ($docsData as $doc) {
            $docFile = $doc['docFile'];
            $docCategory = $doc['docCategory'];
            $docId = $doc['docId'];

            if (isset($docFile) && $docFile != 'undefined') {
                if (isset($docId) && $docId != '') {
                    $updateDoc = EstateDoc::findOrFail($docId);
                    $getPathFile = $updateDoc->doc_file;
                    if (Storage::exists($getPathFile)) {
                        Storage::delete($getPathFile);

                        Storage::makeDirectory($formFolder);
                        $currentDateTime = date('YmdHsi');
                        $uniqueFileName = $currentDateTime . '_' . $docFile->getClientOriginalName();

                        $path = $docFile->storeAs($formFolder, $uniqueFileName);

                        $updateDoc->update([
                            'doc_file' => $path
                        ]);
                    }
                } else {

                    Storage::makeDirectory($formFolder);
                    $currentDateTime = date('YmdHsi');
                    $uniqueFileName = $currentDateTime . '_' . $docFile->getClientOriginalName();

                    $path = $docFile->storeAs($formFolder, $uniqueFileName);

                    $estateDoc = new EstateDoc();
                    $estateDoc->est_id = $estateId;
                    $estateDoc->doc_category = $docCategory;
                    $estateDoc->doc_file = $path;
                    $estateDoc->save();
                }
            }
        }

        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $estate = Estate::findOrFail($id);
        $estateName = $estate->est_name;
        $estateId = $id;
        $getAllDoc = EstateDoc::where('est_id', $id)->whereIn('doc_category', config::get('const.doc_categories'))->get();
        $getDocPayment = EstateDoc::where('est_id', $id)->where('doc_category', config::get('const.doc_payment_category'))->first();
        $getWarrantyPeriod = EstateDoc::where('est_id', $id)->where('doc_category', config::get('const.warranty_period_category'))->first();

        if (count($getAllDoc->toArray()) == 0) {
            return view('doc.doc', compact('estateId', 'estateName', 'getDocPayment', 'getWarrantyPeriod'));
        } else {
            return view('doc.edit', compact('estateId', 'estateName', 'getAllDoc', 'getDocPayment', 'getWarrantyPeriod'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $estateId = $request->input('estateId');
        $formFolder = 'public/doc/estate_id/' . $estateId;
        $docsData = $request->docs;
        foreach ($docsData as $doc) {

            $docFile = $doc['docFile'];
            $docCategory = $doc['docCategory'];
            $docName = $doc['docName'];
            $docDescription = $doc['docDescription'];
            $docId = $doc['docId'];

            if (isset($docId) && $docId != '') {
                if (isset($docFile) && $docFile != 'undefined') {
                    $updateDoc = EstateDoc::findOrFail($docId);
                    $getPathFile = $updateDoc->doc_file;
                    if (Storage::exists($getPathFile)) {
                        Storage::delete($getPathFile);

                        Storage::makeDirectory($formFolder);
                        $currentDateTime = date('YmdHsi');
                        $uniqueFileName = $currentDateTime . '_' . $docFile->getClientOriginalName();

                        $path = $docFile->storeAs($formFolder, $uniqueFileName);

                        $updateDoc->update([
                            'doc_name' =>  $docName,
                            'doc_category' => $docCategory,
                            'doc_description' => $docDescription,
                            'doc_file' => $path
                        ]);
                    }
                } else {
                    $updateDoc = EstateDoc::findOrFail($docId);
                    $updateDoc->update([
                        'doc_name' =>  $docName,
                        'doc_category' => $docCategory,
                        'doc_description' => $docDescription,
                    ]);
                }
            } else {
                Storage::makeDirectory($formFolder);
                $currentDateTime = date('YmdHsi');
                $uniqueFileName = $currentDateTime . '_' . $docFile->getClientOriginalName();

                $path = $docFile->storeAs($formFolder, $uniqueFileName);

                $estateDoc = new EstateDoc();
                $estateDoc->est_id = $estateId;
                $estateDoc->doc_category = $docCategory;
                $estateDoc->doc_name = $docName;
                $estateDoc->doc_description =  $docDescription;
                $estateDoc->doc_file = $path;
                $estateDoc->save();
            }
        }

        return true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $doc = EstateDoc::findOrFail($id);
        $getPathFile = $doc->doc_file;
        if (Storage::exists($getPathFile)) {
            Storage::delete($getPathFile);
        }
        $doc->delete();
        return true;
    }

}
