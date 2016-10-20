<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Post;

use Laracasts\Flash\Flash;

use Illuminate\Support\Facades\Auth;



class PostController extends Controller
{

	public function showPost() 

	{

			$posts = Post::all();
			$posts = Post::orderBy('created_at', 'DESC')->get();
			return view('home', ['posts' => $posts]);

	}


	public function getDeletePost($post_id)

	{

		$post = Post::where('id', $post_id)->first();

		//check if user is auth for deleting its own post
		if(Auth::user() != $post->user) {
				return redirect()->back();
		}

		$post->delete();
		Flash::error('You have successfully deleted the message!!');
		return redirect()->route('home');
		
	}


    public function postCreatePost(Request $request)

    {
    	//validation
    	$this->validate($request, [

    		'body' => 'required|max:1000'

    		]);


    	$post = new Post();
    	$post->body = $request['body'];
    	if ($request->user()->posts()->save($post)) {

    		Flash::success('You have successfully posted the message!!');
    		
    	}

    	return redirect()->route('home');
    }


    	    public function postSaveAccount(Request $request)
    {
        $this->validate($request, [
           'first_name' => 'required|max:120'
        ]);

        $user = Auth::user();
        $old_name = $user->first_name;
        $user->first_name = $request['first_name'];
        $user->update();
        $file = $request->file('image');
        $filename = $request['first_name'] . '-' . $user->id . '.jpg';
        $old_filename = $old_name . '-' . $user->id . '.jpg';
        $update = false;
        if (Storage::disk('local')->has($old_filename)) {
            $old_file = Storage::disk('local')->get($old_filename);
            Storage::disk('local')->put($filename, $old_file);
            $update = true;
        }
        if ($file) {
            Storage::disk('local')->put($filename, File::get($file));
        }
        if ($update && $old_filename !== $filename) {
            Storage::delete($old_filename);
        }
        return redirect()->route('account');
    }


    	public function getAccount()

    	{
    		return view('account', ['user' => Auth::user()]);

    	}

    	public function getUserImage($filename)

    	{

    		$file = Storage::disk('local')->get($filename);
    		return new Response($file, 200);

    	}


}
