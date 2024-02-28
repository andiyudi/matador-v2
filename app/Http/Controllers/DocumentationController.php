<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentationController extends Controller
{
    public function basedOnValue ()
    {
        return view ('documentation.value.index');
    }

    public function basedOnDivision ()
    {
        return view ('documentation.division.index');
    }

    public function basedOnApproval ()
    {
        return view ('documentation.approval.index');
    }

    public function basedOnRequest ()
    {
        return view ('documentation.request.index');
    }

    public function basedOnCompare ()
    {
        return view ('documentation.compare.index');
    }
}
