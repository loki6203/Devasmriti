<?php


namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Commonreturn as CommonreturnResource;
use App\Models\Image;

class ImageController extends Controller
{
	public function upload(Request $request,$id=0){
        $data=array();
        $message='';
        $success=1;
        $validator = Validator::make($request->all(), [
            'image_type' => 'required'
        ]);
        if ($validator->fails()) {
            $message = 'Please enter all (*) fields';
            $success=0;
        }else{
            try{
                $file = @$request->file('file');
                if ($file != '' && $file != null && $file != 'undefined') {
                    if (!file_exists(public_path($request->input('image_type')))){
                        mkdir(public_path($request->input('image_type')),0777,true);
                    }
                    $destinationPath = public_path($request->input('image_type'));
                    $url = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                    $file->move($destinationPath,$url);
                    $orgname = $file->getClientOriginalName();
                    $data = new Image();
                    $data->url          = $url;
                    $data->domain       = url('/');
                    $data->image_type   = $request->input('image_type');
                    $data->name         = $orgname;
                    $data->save();
                }else{
                    $success=0;
                    $message = "Uploading failed try again";
                }
            } catch (\Exception $ex) {
                $message =  ERRORMESSAGE($ex->getMessage());
            }
        }
        $resp = array('success'=>$success,'message'=>$message,'data'=>$data);
        return new CommonreturnResource($resp);
    }
}
