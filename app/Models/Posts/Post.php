<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'post_title',
        'post',
    ];

    public function user(){
        return $this->belongsTo('App\Models\Users\User');
    }

    public function  likedPosts(){
        return $this->belongsToMany('App\Models\Users\User','likes','like_post_id','like_user_id')->withPivot('id');
    }

    public function postComments(){
        return $this->hasMany('App\Models\Posts\PostComment','post_id');
    }

    public function subCategories(){
        // リレーションの定義
    }

    // コメント数
    public function commentCounts(){
        return $this
        ->postComments()
        ->count();
    }

    public function likeCounts(){
        return like::where('like_post_id',$this->id)->count();
    }
}
