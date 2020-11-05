<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Dotenv\Validator;
use App\Http\Resources\post as PostResource ;
use App\Http\Controllers\Api\BaseController as BaseController;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts=Post::all();
        return  $this->sendResonse(PostResource::collection($posts),
            'All posts send'
        );
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
      $input=$request->all();
      $validator=Validator::make($input,[
          'title'=>'required',
          'detail'=>'required',
          'name'=>'required',
      ]);

        if ($validator->fails()) {
            return $this->sendError('please validate error', $validator->errors());
        }
          $post=Post::create($input);
        return $this->sendResponse(new ProductResource($post), 'post created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $post=Post::find($id);
        if (is_null($post)) {
            return $this->sendError('post not found ');
        }
        return $this->sendResponse(new ProductResource($post), 'post found successfully');
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
    public function update(Request $request, Post $post)
    {
        $input=$request->all();
        $validator=Validator::make($input,[
            'title'=>'required',
            'detail'=>'required',
            'name'=>'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('please validate error', $validator->errors());
        }
        $post->name=$input['name'];
        $post->detail=$input['detail'];
        $post->title=$input['title'];
        return $this->sendResponse(new ProductResource($post), 'updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return $this->sendResponse(new ProductResource($post), 'deleted successfully');

    }
}
