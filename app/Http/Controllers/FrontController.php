<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use DB;

class FrontController extends Controller
{
    public $blog_name = 'RivaBlog';
    public function getIndex(){
        $data['page_title'] = 'Home - Blog';
        $data['page_description'] = 'This is my simple blog ';
        $data['blog_name'] = $this->blog_name ;
        $data['categories'] = DB::table('categories')->get();
        
        
        $data['result'] = DB::table('posts')
        ->join('categories','categories.id','=','categories_id')
        ->join('cms_users','cms_users.id','=','cms_users_id')
        ->select('posts.*','categories.name as name_categories','cms_users.name as name_author')
        ->orderby('posts.id','desc')
        ->take(5)
        ->get();
        return view('home',$data);
    }
    
    public function getArticle($slug){
        $row = DB::table('posts')
        ->join('categories','categories.id','=','categories_id')
        ->join('cms_users','cms_users.id','=','cms_users_id')
        ->select('posts.*','categories.name as name_categories','cms_users.name as name_author')
        ->where('posts.slug',$slug)
        ->first();


        $comments = DB::table('comments_users')
        ->join('users', 'users.id', '=', 'comments_users.user_id')
        ->where('comments_users.post_id', $row->id)
        ->select('comments_users.*', 'users.name as users_name')
        ->leftJoin('replies', 'comments_users.id', '=', 'replies.comment_id')
        ->leftJoin('comment_likes', 'comments_users.id', '=', 'comment_likes.comment_id')
        ->leftJoin('comment_dislikes', 'comments_users.id', '=', 'comment_dislikes.comment_id')
        ->groupBy('comments_users.id', 'users.id','comments_users.user_id','comments_users.post_id','comments_users.content','comments_users.created_at','comments_users.updated_at','users.name')
        ->selectRaw('comments_users.*, users.name as users_name, COUNT(DISTINCT replies.id) as reply_count, COUNT(DISTINCT comment_likes.id) as like_count, COUNT(DISTINCT comment_dislikes.id) as dislike_count')
        ->get();

        $comments = $comments->map(function ($comment) {
            $comment->created_at = Carbon::parse($comment->created_at)->diffForHumans();
            return $comment;
        });

        $data['row'] = $row;
        $data['comments'] = $comments ?? [];
        $data['page_title'] = $row->title.'| RivaBlog';
        $data['page_description'] = \Illuminate\Support\str::limit(strip_tags($row->content),155);
        $data['blog_name'] = $this->blog_name ;
        $data['categories'] = DB::table('categories')->get();

        return view('detail',$data);
    }
    public function getCategory($id,$slug){
        $row = DB::table('categories')->where('id',$id)->first();

        $data['result'] = DB::table('posts')
        ->join('categories','categories.id','=','categories_id')
        ->join('cms_users','cms_users.id','=','cms_users_id')
        ->select('posts.*','categories.name as name_categories','cms_users.name as name_author')
        ->orderby('posts.id','desc')
        ->where('posts.categories_id',$id)
        ->paginate(5);

        $data['row'] = $row;
        $data['page_title'] = $row->name.'| category | RivaBlog';
        $data['page_description'] = $data['page_title'];
        $data['blog_name'] = $this->blog_name ;
        $data['categories'] = DB::table('categories')->get();
        $data['header_title'] = 'Category: '.$row->name;
        
        return view('lists',$data);
    }
    public function getLatest(){
  

        $data['result'] = DB::table('posts')
        ->join('categories','categories.id','=','categories_id')
        ->join('cms_users','cms_users.id','=','cms_users_id')
        ->select('posts.*','categories.name as name_categories','cms_users.name as name_author')
        ->orderby('posts.id','desc')
        ->paginate(5);

        $data['row'] = $row;
        $data['page_title'] = 'Latest | RivaBlog';
        $data['page_description'] = $data['page_title'];
        $data['blog_name'] = $this->blog_name ;
        $data['categories'] = DB::table('categories')->get();
        $data['header_title'] = 'Latest';
        
        return view('lists',$data);
    }
    public function getSearch(Request $req){
        
        if($req->get('q')=='') return redirect('/');

        $data['result'] = DB::table('posts')
        ->join('categories','categories.id','=','categories_id')
        ->join('cms_users','cms_users.id','=','cms_users_id')
        ->select('posts.*','categories.name as name_categories','cms_users.name as name_author')
        ->where('posts.title','like','%'.$req->get('q').'%')
        ->paginate(5);

        $data['row'] = $row;
        $data['page_title'] = 'Search'.$req->get('q').'| RivaBlog';
        $data['page_description'] = $data['page_title'];
        $data['blog_name'] = $this->blog_name ;
        $data['categories'] = DB::table('categories')->get();
        $data['header_title'] = 'Search  '.$req->get('q');
        
        return view('lists',$data);
    }
   
    
     
}
