<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Email;
use Illuminate\Support\Facades\DB;
use Auth;


class MailController extends Controller
{
    public function send_mail(Request $request){
        $user = Auth::guard('api')->user();
        $email = new Email;
        $email->subject = $request->subject;
        $email->body = $request->body;
        $email->sender_id = $user->id;
        $reciver_id = DB::table('users')->select('id')->where('email',$request->reciver_mail)->first();
        if(is_null($reciver_id)){
            return response()->json([
                'error' => true
            ]);
        }else{
            $email->reciver_id = DB::table('users')->select('id')->where('email',$request->reciver_mail)->first()->id;
        }
        $email->save();
        $cc = $request->cc;
        if(isset($cc)){
            $processedcc = str_replace(",", " ", $cc);
            $ccs = explode(" ", $processedcc);
            foreach($ccs as $data){
                if($data!=null || $data!=" "){

                    $email_id=DB::table('users')->select('id')->where('email',$data)->first()->id;
                    if(is_null($email_id)){
                        return response()->json([
                            'error' => true
                        ]);
                    }else{
                        DB::table('email_cc')->insert(['user_id'=>$email_id,'email_id'=>$email->id]);
                    }
                }
            }
        }
        $bcc = $request->bcc;
        if(isset($bcc)){
            $processedcc = str_replace(",", " ", $bcc);
            $bccs = explode(" ", $processedcc);
            foreach($bccs as $data){
                if($data!=null || $data!=" "){
                    $email_id=DB::table('users')->select('id')->where('email',$data)->first()->id;
                    if(is_null($email_id)){
                        return response()->json([
                            'error' => true
                        ]);
                    }else{
                    DB::table('email_bcc')->insert(['user_id'=>$email_id,'email_id'=>$email->id]);
                }
                }
            }
        }
        $attachments=$request->attachments;
        if(isset($attachments)){
            foreach($attachments as $file){
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('upload', $fileName, 'public');
                move_uploaded_file($file->getRealPath(), $filePath);
                $attachment = new Attachment;
                $attachment->file_name=$fileName;
                $attachment->file_path=$filePath;
                $attachment->email_id = $email->id;
                $attachment->save();
            }
        }
        return 1;
    }
    public function sent_mail(Request $request){
        $user = Auth::guard('api')->user();
        $emails = DB::table('emails')->select("users.email","emails.email_id","emails.subject","emails.body","emails.created_at")->leftJoin('users','users.id','emails.reciver_id')
            ->where('sender_id',$user->id)
            ->orderByDesc('emails.email_id')
            ->cursorPaginate();
        $photo = DB::table('userPhotos')->select('file_path','file_name')->join('users','users.id','userPhotos.user_id')
        ->where('userPhotos.user_id',$user->id)->first();
        return response()->json([
            'success' => true,
            "mails"=>$emails,
            "user"=>$user,
            "photo"=>$photo
        ]);   
    }

    public function dashboard(Request $request){
        $user = Auth::guard('api')->user();
        $emails = DB::table('emails')->select("users.email","emails.email_id","emails.subject","emails.body","emails.created_at")
            ->leftJoin('users','users.id','emails.sender_id')
            ->leftJoin('email_cc','email_cc.email_id','emails.email_id')
            ->leftJoin('email_bcc','email_bcc.email_id','emails.email_id')
            ->where('reciver_id',$user->id)
            ->orWhere('email_cc.user_id',$user->id)
            ->orWhere('email_bcc.user_id',$user->id)
            ->orderByDesc('emails.email_id')->cursorPaginate();
        $photo = DB::table('userPhotos')->select('file_path','file_name')->join('users','users.id','userPhotos.user_id')
            ->where('userPhotos.user_id',$user->id)->first();
        return response()->json([
            'success' => true,
            'user' => $user,
            'emails' => $emails,
            'photo' => $photo
        ]);
        
    }

    public function mailDetails($id){

            $user = Auth::guard('api')->user();
            $email = DB::table('emails')
            ->select("users.email","emails.email_id","emails.subject","emails.body","emails.created_at")
            ->join('users','users.id','emails.sender_id')
            ->where('emails.email_id',$id)
            ->first();
            $attachemts = DB::table('attachments')->where('email_id',$id)->get();
            $photo = DB::table('userPhotos')->select('file_path','file_name')->leftJoin('users','users.id','userPhotos.user_id')
            ->where('userPhotos.user_id',$user->id)->first();
            $cc = DB::table('email_cc')->select("users.email")->leftJoin('users','users.id','email_cc.user_id')->where('email_cc.email_id',$email->email_id)->get();
            $bcc = DB::table('email_bcc')->select("users.email")->leftJoin('users','users.id','email_bcc.user_id')->where('email_bcc.email_id',$email->email_id)->get();
            return response()->json([
                'success' => true,
                'user' => $user,
                'id'=>$id,
                'email' => $email,
                'photo' => $photo,
                'cc' => $cc,
                'bcc' =>$bcc,
                'attachments' => $attachemts
            ]);
        
    }
    
    public function sentMailDetails($id){
            $user =  Auth::guard('api')->user();
            $email = DB::table('emails')
            ->select("users.email","emails.email_id","emails.subject","emails.body","emails.created_at")
            ->join('users','users.id','emails.reciver_id')
            ->where('emails.email_id',$id)
            ->first();
            $attachemts = DB::table('attachments')->where('email_id',$id)->get();
            $photo = DB::table('userPhotos')->select('file_path','file_name')->join('users','users.id','userPhotos.user_id')
            ->where('userPhotos.user_id',$user->id)->first();
            $cc = DB::table('email_cc')->select("users.email")->leftJoin('users','users.id','email_cc.user_id')->where('email_cc.email_id',$email->email_id)->get();
            $bcc = DB::table('email_bcc')->select("users.email")->leftJoin('users','users.id','email_bcc.user_id')->where('email_bcc.email_id',$email->email_id)->get();
            return response()->json([
                'success' => true,
                'user' => $user,
                'id'=>$id,
                'email' => $email,
                'cc' => $cc,
                'bcc' =>$bcc,
                'photo' => $photo,
                'attachments' => $attachemts
            ]);
        
    }
}
