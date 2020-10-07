<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $post_id = $request->post_id;
        $sort_by = $request->sort_by ?? 'rating';
        $sort_dir = $request->sort_dir ??'desc';

        $comm = Comment::with(['comments','user'])->where('post_id', $post_id)->orderBy($sort_by, $sort_dir )->get();
        $this->setDepth($comm);        
        return json_encode($comm);
    }

    private function setDepth($comments, $depth=0){
        $depth++;
        if(count($comments)>0) {
            foreach($comments as $item){
                $item['depth'] = $depth;
                if($item['comments']){
                    $this->setDepth($item['comments'], $depth);
                }
                else {
                    $item['depth'] = $depth;
                    return $item;
                }
            }
        }
        return $comments;
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
        $parent_id= $request->parentCommentId;
        $text = $request->text;
        $user_id = Auth::id() ?? 1;
        
        $comment = new Comment;
        $comment->user_id = $user_id;
        $comment->text = $text;
        $comment->post_id = $post_id;
        $comment->parent_id = $parent_id;
        $result = $comment->save();
        if($result){
            return json_encode(['stored'=>true]);
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
        $comment  = Comment::where('id', $comment_id)->first();
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
