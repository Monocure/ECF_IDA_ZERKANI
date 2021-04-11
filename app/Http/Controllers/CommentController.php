<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    //
    function addCritic(Request $req){
        $critic = new Comment;
        $critic->comment->$req->critic;
        $critic->grade->$req->grade;
        $critic->save();
    }
}
