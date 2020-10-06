<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment1;
use App\Models\Comment2;
use App\Models\Comment3;
use App\Models\Comment4;
use App\Models\Comment5;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_by = $request->sort_by ?? 'rating';
        $sort_dir = $request->sort_dir ??'desc';

        $comments = Comment1::with(['comments','user'])->where('post_id', $request->post_id)->orderBy($sort_by, $sort_dir )->get();
        return json_encode($comments);
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
        $post_id = $request->postId;
        $text = $request->text;
        $parent_id= $request->parentCommentId;
        $table_id = $request->parentTableId+1;
        $user_id = Auth::id() ?? 1;
        
        if($post_id){
            $comment = new Comment1;
            $comment->user_id = $user_id;
            $comment->text = $text;
            $comment->post_id = $post_id;
            $result = $comment->save();
            if($result){
                return json_encode(['stored'=>true, 'storedTableId'=>$table_id]);
            }else{
                return json_encode(['stored'=>false, 'errorMessage'=>'Try again!']);
            }     
        }

        switch($table_id){
            case 2: $comment = new Comment2;
        break;
            case 3: $comment = new Comment3;
        break;
            case 4: $comment = new Comment4;
        break;
            case 5: $comment = new Comment5;
        break;
            default: return json_encode(['error'=>'Unknown table '.$table_id]);
        }
        $comment->user_id = $user_id;
        $comment->parent_id = $parent_id;
        $comment->text = $text;
        $result = $comment->save();
        if($result){
            return json_encode(['stored'=>true, 'storedTableId'=>$table_id]);
        }else{
            return json_encode(['stored'=>false, 'errorMessage'=>'Try again!']);
        }

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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id=null)
    {
        $comment_id = $request->comment_id;
        $table_id = $request->table_id;
        $type = $request->type;
        switch($table_id){
            case 1: $comment = Comment1::where('id', $comment_id)->first();
        break;
            case 2: $comment = Comment2::where('id', $comment_id)->first();
        break;
            case 3: $comment = Comment3::where('id', $comment_id)->first();
        break;
            case 4: $comment = Comment4::where('id', $comment_id)->first();
        break;
            case 5: $comment = Comment5::where('id', $comment_id)->first();
        break;
            default: return json_encode(['error'=>'Unknown table '.$table_id]);
        }
        $comment->timestamps = false;
        $type == 'like'? $comment->rating++ : $comment->rating--;
        $comment->save();
        return json_encode(['updated'=>true, 'updatedCommentId'=>$comment_id, 'updatedTableId'=>$table_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
